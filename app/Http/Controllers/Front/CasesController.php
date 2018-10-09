<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Controllers\Controller;
use Auth;
use App\NewsCase;
use App\Company;
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
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $cases = $this->case->paginate($this->pagination);
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

        $this->case->title = $request->get('title');
        $this->case->url = rtrim($request->get('url'),"/");
        $this->case->keywords = $request->get('keywords');
        $this->case->tweet_id = $tweet->id;
        $this->case->location = $tweet->user->location;

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
                            ->with('error', 'Invalid Tweet URL, Please try again.')
                            ->withInput();
        }
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
}
