<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\NewsCase;

class CasesController extends Controller
{

    /** @var NewsCase */
    private $case;

    private $pagination = 10;
    /**
     * Create a new controller instance.
     *
     * @param Case $case
     * @return void
     */
    public function __construct(NewsCase $case)
    {
       $this->middleware('auth:front');
       $this->case = $case;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cases = $this->case->paginate($this->pagination);
        return view('Front.index', ['cases' => $cases]);
    }

}
