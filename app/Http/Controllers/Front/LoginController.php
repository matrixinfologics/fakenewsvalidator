<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class LoginController extends Controller
{
    /**
     * LoginController constructor
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'doLogout']);
    }
    /**
     * Display Login form
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('Front.login');
    }

    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|min:3',
        );

        $validator = Validator::make($credentials, $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to(route('login'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            if ($this->guard()->attempt($credentials)) {

                if ($this->guard()->user()->status == 0) {
                    $this->guard()->logout();
                    return Redirect::to(route('login'))
                        ->withErrors('This user account is inactive.')
                        ->withInput($request->except('password'));
                }

                return redirect()->intended('/');
            } else {
                return Redirect::to(route('login'))
                    ->withErrors('Invalid Credentials, Please try again.')
                    ->withInput($request->except('password'));
            }
        }
    }

    /**
     * Logout the admin User
     *
     * @return \Illuminate\Http\Response
     */
    public function doLogout()
    {
        $this->guard()->logout();
        return Redirect::to(route('login'));
    }

    /**
     * Front is the guard for front.
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('front');
    }
}
