<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Requests\Front\UpdateCase;
use App\Http\Controllers\Controller;
use Auth;
use Mapper;
use Cache;
use App\NewsCase;
use App\CaseResult;
use App\Company;
use App\Setting;
use App\CaseSectionResult;
use App\Classes\TwitterManager;
use App\Classes\TwitterUser;
use App\Classes\TineyeApi;
use Illuminate\Database\Eloquent\Collection;

class CasesController extends Controller
{
    /** @var NewsCase */
    private $case;

    /** @var Company */
    private $company;

    /** @var Setting */
    private $settings;

    /** @var TwitterManager */
    private $twitterManager;

    private $pagination = 10;

    /**
     * Create a new controller instance.
     *
     * @param Case $case
     * @param Company $company
     * @param TwitterManager $twitterManager
     * @param Setting $settings
     * @return void
     */
    public function __construct(NewsCase $case, Company $company, TwitterManager $twitterManager, Setting $settings)
    {
       $this->middleware('auth:front');

       $this->case = $case;
       $this->company = $company;
       $this->twitterManager = $twitterManager;
       $this->settings = $settings;
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
     * Flag a case
     *
     * @param Request $request
     * @param int $caseId
     * @return boolean
     */
    public function flagCase(Request $request, $caseId){
        $caseSectionResult = new CaseResult;
        $caseSectionResult->flag = $request->get('flag');

        $case = $this->case->findorFail($caseId);
        $caseSectionResult->case()->associate($case);
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

        $cases = $cases->orderBy('flag')->paginate($this->pagination);
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

        $location = '';
        $tweetImage = isset($tweet->entities->media[0]->media_url) ? $tweet->entities->media[0]->media_url : null;
        if($tweet->user->location != '') {
            $location = $tweet->user->location;
        } else {
            $location = isset($tweet->place->full_name) && $tweet->place->full_name != '' ? $tweet->place->full_name : '';
        }

        $this->case->title = $request->get('title');
        $this->case->url = rtrim($request->get('url'),"/");
        $this->case->keywords = $request->get('keywords');
        $this->case->tweet_id = $tweet->id;
        $this->case->tweet_image = $tweetImage;
        $this->case->tweet_author = $tweet->user->screen_name;

        $latitude = null;
        $longitude = null;

        if($tweet->place != '') {
            $geo = $this->twitterManager->getGeo($tweet->place->id);
            $latitude = $geo['latitude'];
            $longitude = $geo['longitude'];
        } else if($location != ''){
            try{
                $geo = Mapper::location($location);
                $location = $geo->getAddress();
                $latitude = $geo->getLatitude();
                $longitude = $geo->getLongitude();
            } catch(\Exception $e){
                $latitude = null;
                $longitude = null;
            }
        }

        $this->case->location = $location;
        $this->case->latitude = $latitude;
        $this->case->longitude = $longitude;

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
            $sectionId = NewsCase::SECTION_INFO;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if(!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getTweetPreview($case->url));
            }

            $tweetPreview = Cache::get($cacheKey);

            return view('Front.sections.info', ['case' => $case, 'sectionId' => $sectionId, 'tweetPreview' => $tweetPreview]);
        } catch(\Exception $e){
            return redirect('/')
                            ->with('error', $e->getMessage())
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
            $sectionId = NewsCase::SECTION_POST_ANALYSIS;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();
            if(!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getTweetPreview($case->url));
            }

            $tweetPreview = Cache::get($cacheKey);

            return view('Front.sections.analysis', ['case' => $case, 'sectionId' => $sectionId, 'tweetPreview' => $tweetPreview]);
        } catch(\Exception $e){
            return redirect('/')
                            ->with('error', 'Invalid Tweet, Please try again.')
                            ->withInput();
        }
    }


    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function authorPosts(Request $request, $id)
    {
        try{
            $sectionId = NewsCase::SECTION_AUTHOR_LATEST_POSTS;
            $case = $this->case->findorFail($id);
            $this->setTwitterConfig();

            $duration = $request->has('duration')? $request->get('duration'): 'month';

            $cacheKey = "{$sectionId}{$id}{$duration}";
            if(!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getAuthorPosts($case->tweet_author, $duration));
            }

            $authorPosts = Cache::get($cacheKey);

            return view('Front.sections.authorposts', ['case' => $case, 'sectionId' => $sectionId, 'duration' => $duration, 'authorPosts' => $authorPosts]);
        } catch(\Exception $e){
            return redirect()->back()
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
        try{
            $sectionId = NewsCase::SECTION_POST_GEO_LOCATION;
            $case = $this->case->findorFail($id);

            if($case->latitude == null || $case->longitude == null) {
                return redirect()->back()
                            ->with('error', 'Location is not correct of this case')
                            ->withInput();
            }

            Mapper::map($case->latitude, $case->longitude);

            return view('Front.sections.geolocation', ['case' => $case, 'sectionId' => $sectionId]);
        } catch(\Exception $e){
            return redirect()->back()
                            ->with('error', $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Similar Posts
     *
     * @param int $id
     * @return Response
     */
    public function similarPosts($id)
    {
        try{
            $sectionId = NewsCase::SECTION_SIMILAR_POSTS;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if(!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getSimilarPosts($case));
            }

            $similarPosts = Cache::get($cacheKey);

            return view('Front.sections.similarposts', ['case' => $case, 'sectionId' => $sectionId, 'similarPosts' => $similarPosts]);
        } catch(\Exception $e){
            return redirect()->back()
                            ->with('error', 'Invalid Tweet, Please try again.')
                            ->withInput();
        }
    }

    /**
     * Posts from same area
     *
     * @param int $id
     * @return Response
     */
    public function sameAreaPosts($id)
    {
        try{
            $sectionId = NewsCase::SECTION_SIMILAR_POSTS_SAME_AREA;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if(!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getSameAreaPosts($case));
            }

            $sameAreaPosts = Cache::get($cacheKey);

            return view('Front.sections.sameareaposts', ['case' => $case, 'sectionId' => $sectionId, 'sameAreaPosts' => $sameAreaPosts]);
        } catch(\Exception $e){
            return redirect()->back()
                            ->with('error', $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Author Profile
     *
     * @param int $id
     * @return Response
     */
    public function authorProfile($id)
    {
        $sectionId = NewsCase::SECTION_AUTHOR_PROFILE;
        $cacheKey = "{$sectionId}{$id}";
        $case = $this->case->findorFail($id);
        $screen_name = $case->tweet_author;

        $config = $this->company->getCompanyTwitterDetails();
        $twitter_user = new TwitterUser($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['secret'], $screen_name);

        if(!Cache::has($cacheKey)) {
            Cache::forever($cacheKey, $twitter_user->getUserStatistics());
        }

        $stats = Cache::get($cacheKey);

        return view('Front.sections.authorprofile', ['case' => $case, 'sectionId' => $sectionId, 'stats' => $stats]);
    }

    /**
     * Image Search
     *
     * @param int $id
     * @return Response
     */
    public function imageSearch($id)
    {
        try{
            $sectionId = NewsCase::SECTION_IMAGE_SEARCH;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            if ($case->tweet_image == null)
                throw new \Exception("Tweet has no image!");

            if(!Cache::has($cacheKey)) {
                $tineyeApi = new TineyeApi(
                        $this->settings->getSettingValueByKey(Setting::TYPE_TINEYE_PRIVATE_KEY),
                        $this->settings->getSettingValueByKey(Setting::TYPE_TINEYE_PUBLIC_KEY)
                    );
                $data = $tineyeApi->searchImageUrl($case->tweet_image);
                Cache::forever($cacheKey, $data);
            }

            $data = Cache::get($cacheKey);

            return view('Front.sections.imagesearch', ['case' => $case, 'sectionId' => $sectionId, 'data' => $data]);
        } catch(\Exception $e){
            return redirect()->back()
                            ->with('error', $e->getMessage())
                            ->withInput();
        }

    }

    /**
     * Source Cross Check
     *
     * @param int $id
     * @return Response
     */
    public function sourceCrossCheck($id)
    {
        $sectionId = NewsCase::SECTION_SOURCE_CROSSS_CHECKING;
        $case = $this->case->findorFail($id);

        $fakeCount = $case->results()->where('flag', NewsCase::FLAG_FAKE)->count();

        return view('Front.sections.source-cross', ['case' => $case, 'sectionId' => $sectionId, 'fakeCount' => $fakeCount]);
    }

    /**
    * Case Results
    *
    * @param int $id
    * @return Response
    */
    public function results($id)
    {
        $case = $this->case->findorFail($id);
        $sections = $this->case->getSections();

        return view('Front.sections.results', ['case' => $case, 'sections' => $sections]);
    }

    /**
    * Related Cases
    *
    * @param int $id
    * @return Response
    */
    public function relatedCases($id)
    {
        $case = $this->case->findorFail($id);
        $relatedCases = $this->case
                            ->where(function ($query) use ($case) {
                                $query->where('title', 'like', '%'.$case->title.'%')
                                      ->orWhere('keywords', 'like', '%'.$case->title.'%')
                                      ->orWhere('title', 'like', '%'.$case->keywords.'%')
                                      ->orWhere('keywords', 'like', '%'.$case->keywords.'%');
                            })
                            ->where('id', '!=', $id)
                            ->take(3)
                            ->get();

        return view('Front.sections.related-cases', ['case' => $case, 'relatedCases' => $relatedCases]);
    }

    /**
    * Clear Cache
    *
    * @return Response
    */
    public function clearCache($key)
    {
        Cache::forget($key);
        return redirect()->back();
    }


}
