<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\NewsCase;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CasesController extends Controller
{
    /** @var User */
    private $user;

    /** @var Company */
    private $company;

    /** @var NewsCase */
    private $newsCase;

    private $pagination = 10;

    /**
     * UserController Consturctor
     *
     * @param User $user
     * @param Company $company
     * @param NewsCase $newsCase
     */
    public function __construct(User $user, Company $company, NewsCase $newsCase)
    {
        $this->user     = $user;
        $this->company  = $company;
        $this->newsCase = $newsCase;
    }

    /**
     * Cases listing
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->isCompanyAdmin()) {
            $cases = $this->company->getCompanyCasesOfUser(Auth::Id())->where('flag', NewsCase::FLAG_IN_ANALYSIS)->paginate($this->pagination);
        } else {
            $cases = $this->newsCase->where('flag', NewsCase::FLAG_IN_ANALYSIS)->paginate($this->pagination);
        }

        $grid = new \Datagrid($cases, $request->get('f', []));
        $grid
            ->setColumn('id', 'Id')
            ->setColumn('title', 'Title', [
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route("cases.info", $row->id) . '" data-tooltip="'.$row->title.'">' . $value . '</a>';
                },
            ])
            ->setColumn('company', 'Company',[
                    'refers_to'   => 'User.Company.name'
            ])
            ->setColumn('fakeCount', 'Fake', [
                'wrapper' => function ($value, $row) {
                    return $row->getData()->results()->where('flag', NewsCase::FLAG_FAKE)->count();
                },
            ])
            ->setColumn('trustedCount', 'Trusted', [
                'wrapper' => function ($value, $row) {
                    return $row->getData()->results()->where('flag', NewsCase::FLAG_TRUSTED)->count();
                },
            ])
            ->setColumn('created_at', 'Created At')
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route("cases.flag", [$row->id, 'flag' => NewsCase::FLAG_TRUSTED]) . '" data-tooltip="Flag Trusted" class="btn btn-xs"><span class="fa fa-flag trusted_button" aria-hidden="true"></span></a>
                            <a href="' . route("cases.flag", [$row->id, 'flag' => NewsCase::FLAG_FAKE]) . '" data-tooltip="Flag Fake" class="btn btn-xs"><span class="fa fa-flag fake_button" aria-hidden="true"></span></a>';
                },
            ]);

        return view('Admin.cases.index', ['grid' => $grid, 'title' => 'News']);
    }

    /**
    * Show the case info
    *
    * @param int $id
    * @return Response
    */
    public function caseInfo($id)
    {
        $case = $this->newsCase->findorFail($id);
        return view('Admin.cases.info', ['case' => $case]);
    }

    /**
     * Trusted Cases listing
     *
     * @param Request $request
     * @return Response
     */
    public function trustedCases(Request $request)
    {
        if (Auth::user()->isCompanyAdmin()) {
            $cases = $this->company->getCompanyCasesOfUser(Auth::Id())->where('flag', NewsCase::FLAG_TRUSTED)->paginate($this->pagination);
        } else {
            $cases = $this->newsCase->where('flag', NewsCase::FLAG_TRUSTED)->paginate($this->pagination);
        }

        $grid = new \Datagrid($cases, $request->get('f', []));
        $grid
            ->setColumn('id', 'Id')
            ->setColumn('title', 'Title', [
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route("cases.info", $row->id) . '" data-tooltip="'.$row->title.'">' . $value . '</a>';
                },
            ])
            ->setColumn('company', 'Company',[
                    'refers_to'   => 'User.Company.name'
            ])
            ->setColumn('keywords', 'Keywords')
            ->setColumn('created_at', 'Created At');

        return view('Admin.cases.index', ['grid' => $grid, 'title' => 'Trusted News']);
    }

    /**
     * Fake Cases listing
     *
     * @param Request $request
     * @return Response
     */
    public function fakeCases(Request $request)
    {
        if (Auth::user()->isCompanyAdmin()) {
            $cases = $this->company->getCompanyCasesOfUser(Auth::Id())->where('flag', NewsCase::FLAG_FAKE)->paginate($this->pagination);
        } else {
            $cases = $this->newsCase->where('flag', NewsCase::FLAG_FAKE)->paginate($this->pagination);
        }

        $grid = new \Datagrid($cases, $request->get('f', []));
        $grid
            ->setColumn('id', 'Id')
            ->setColumn('title', 'Title', [
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route("cases.info", $row->id) . '" data-tooltip="'.$row->title.'">' . $value . '</a>';
                },
            ])
            ->setColumn('company', 'Company',[
                    'refers_to'   => 'User.Company.name'
            ])
            ->setColumn('keywords', 'Keywords')
            ->setColumn('created_at', 'Created At');

        return view('Admin.cases.index', ['grid' => $grid, 'title' => 'Fake News']);
    }

    /**
     * Fake Cases listing
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function flagCase(Request $request, $id)
    {
        $case = $this->newsCase->findorFail($id);
        $case->flag = $request->get('flag');
        $case->save();

        return redirect()->back()
            ->with('success', "News has marked {$request->get('flag')} news!");
    }

}
