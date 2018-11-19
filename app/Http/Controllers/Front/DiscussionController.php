<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\NewsCase;
use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreDiscussion;

class DiscussionController extends Controller
{
    /** @var NewsCase */
    private $case;

    /** @var Discussion */
    private $discussion;

    /** Cache Expirty time */
    private $cacheExpiryTime;

    /**
    * Create a new controller instance.
    *
    * @param Case $case
    * @param Discussion $discussion
    * @return void
    */
    public function __construct(NewsCase $case, Discussion $discussion)
    {
        $this->middleware('auth:front');

        $this->case = $case;
        $this->discussion = $discussion;
        $this->cacheExpiryTime = now()->addMinutes(60);
    }

    /**
     * Case Discussion
     *
     * @param int $id
     * @return Response
     */
    public function discussion($id)
    {
        $sectionId = NewsCase::SECTION_DISCUSSION;
        $case = $this->case->findorFail($id);
        $discussions = $case->discussions()->get();

        return view('Front.sections.discussions', ['case' => $case, 'sectionId' => $sectionId, 'discussions' => $discussions]);
    }

    /**
     * Case Discussion save
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function discussionSave(StoreDiscussion $request, $id)
    {
        $case = $this->case->findorFail($id);

        $this->discussion->message = $request->get('message');
        $this->discussion->user()->associate(Auth::user());
        $this->discussion->case()->associate($case);
        $this->discussion->save();

        return redirect()->back()->with('success','Message sent!');
    }
}
