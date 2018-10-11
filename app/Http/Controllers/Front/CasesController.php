<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Requests\Front\UpdateCase;
use App\Http\Controllers\Controller;
use Auth;
use Mapper;
use App\NewsCase;
use App\Company;
use App\CaseSectionResult;
use App\Classes\TwitterManager;

class CasesController extends Controller
{
    /** @var NewsCase */
    private $case;

    /** @var Company */
    private $company;

    /** @var TwitterManager */
    private $twitterManager;

    private $pagination = 10;
    /**
     * Create a new controller instance.
     *
     * @param Case $case
     * @param TwitterManager $twitterManager
     * @return void
     */
    public function __construct(NewsCase $case, Company $company, TwitterManager $twitterManager)
    {
       $this->middleware('auth:front');

       $this->case = $case;
       $this->company = $company;
       $this->twitterManager = $twitterManager;
    }

    /**
     * Set Twitter config details
     *
     * @return none
     */
    public function setTwitterConfig(){
        $config = $this->company->getCompanyTwitterDetails();
        $this->twitterManager->setConfig($config);
    }

    /**
     * Set Twitter config details
     *
     * @param int $tweetId
     * @return boolean
     */
    public function isUniqueTweet($tweetId){
        $tweetCount = $this->case->where('tweet_id', $tweetId)->count();

        if($tweetCount < 1) {
            return true;
        }
        return false;
    }

    /**
     * Flag a case from section
     *
     * @param Request $request
     * @param int $sectionId
     * @param int $caseId
     * @return boolean
     */
    public function flagCaseBySection(Request $request, $sectionId, $caseId){
        $caseSectionResult = new CaseSectionResult;
        $caseSectionResult->case_id = $caseId;
        $caseSectionResult->section_id = $sectionId;
        $caseSectionResult->flag = $request->get('flag');

        $caseSectionResult->user()->associate(Auth::user());
        $caseSectionResult->save();

        return redirect()->back()
            ->with('success','Case Flaged successfully!');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cases = $this->case;
        // Search Case
        if($request->has('s')) {
            $search = $request->get('s');
            $cases = $cases->where('title','LIKE',"%{$search}%");
        }

        $cases = $cases->paginate($this->pagination);
        return view('Front.index', ['cases' => $cases]);
    }

    /**
     * Show the new case form
     *
     * @return Response
     */
    public function newCase()
    {
        return view('Front.newcase');
    }

     /**
    * Store case in database
    *
    * @param StoreCase $request
    * @return Response
    */
    public function storeCase(StoreCase $request)
    {
        // Set Twitter config
        $this->setTwitterConfig();

        // Verify Tweet
        $url = explode('/', rtrim($request->get('url'),"/"));
        $tweetId = end($url);
        $tweet = $this->twitterManager->verifyTweet($tweetId);

        if(!$tweet){
            return redirect()->back()
                        ->with('error', 'Invalid Tweet URL, Please try again.')
                        ->withInput();
        }
        // Check tweet is unique
        if(!$this->isUniqueTweet($tweet->id)) {
            return redirect()->back()
                        ->with('error', 'Tweet is already exist, Please try again.')
                        ->withInput();
        }

        $this->case->title = $request->get('title');
        $this->case->url = rtrim($request->get('url'),"/");
        $this->case->keywords = $request->get('keywords');
        $this->case->tweet_id = $tweet->id;
        $this->case->location = $tweet->user->location;
        $this->case->tweet_author = $tweet->user->screen_name;

        // Assign user to case
        $this->case->user()->associate(Auth::user());

        $this->case->save();

        return redirect(route('caseinfo', $this->case->id))
            ->with('success','Case created successfully!');
    }

    /**
     * Show the case info
     *
     * @param int $id
     * @return Response
     */
    public function caseInfo($id)
    {
        try{
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();
            $tweetPreview = $this->twitterManager->getTweetPreview($case->url);

            return view('Front.sections.info', ['case' => $case, 'tweetPreview' => $tweetPreview]);
        } catch(\Exception $e){
            return redirect('/')
                            ->with('error', 'Something went wrong! Please try again.')
                            ->withInput();
        }
    }

    /**
     * Show the Edit case form
     *
     * @param int $id
     * @return Response
     */
    public function editCase($id)
    {
        $case = $this->case->findorFail($id);
        return view('Front.editcase', ['case' => $case]);
    }

    /**
    * Update case in database
    *
    * @param UpdateCase $request
    * @param int $id
    * @return Response
    */
    public function updateCase(UpdateCase $request, $id)
    {
        $case = $this->case->findorFail($id);
        $case->title = $request->get('title');
        $case->keywords = $request->get('keywords');

        $case->save();

        return redirect(route('caseinfo', $case->id))
            ->with('success','Case updated successfully!');
    }

    /**
     * Post Analysis Section
     *
     * @param int $id
     * @return Response
     */
    public function postAnalysis($id)
    {
        try{
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();
            $tweetPreview = $this->twitterManager->getTweetPreview($case->url);

            return view('Front.sections.analysis', ['case' => $case, 'tweetPreview' => $tweetPreview]);
        } catch(\Exception $e){
            return redirect('/')
                            ->with('error', 'Invalid Tweet, Please try again.')
                            ->withInput();
        }
    }


    /**
     * Author Latest Posts
     *
     * @param int $id
     * @return Response
     */
    public function authorPosts($id)
    {
        try{
            $sectionId = NewsCase::SECTION_AUTHOR_LATEST_POSTS;
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();
            $authorPosts = $this->twitterManager->getAuthorPosts($case->tweet_author);

            return view('Front.sections.authorposts', ['case' => $case, 'sectionId' => $sectionId, 'authorPosts' => $authorPosts]);
        } catch(\Exception $e){
            return redirect('/')
                            ->with('error', 'Invalid Tweet, Please try again.')
                            ->withInput();
        }
    }

    /**
     * Geo Location map
     *
     * @param int $id
     * @return Response
     */
    public function geoLocationMap($id)
    {
        $sectionId = NewsCase::SECTION_AUTHOR_LATEST_POSTS;
        $case = $this->case->findorFail($id);

        $location = Mapper::location($case->location);

        Mapper::map($location->getLatitude(), $location->getLongitude());

        return view('Front.sections.geolocation', ['case' => $case, 'sectionId' => $sectionId]);
    }



}
