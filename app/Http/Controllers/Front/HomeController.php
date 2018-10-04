<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo Auth::id();
        die;
        return view('Front.home');
    }

    /**
     * Front is the guard for front.
     * @return mixed
     */
    protected function guard()
    {
        return auth()->guard('front');
    }
}
