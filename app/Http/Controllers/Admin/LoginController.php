<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('admin.guest', ['except' => 'doLogout']);
    }
    /**
     * Display Login form
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('Admin.login');
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
            return Redirect::to(route('admin.login'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            if (Auth::attempt($credentials)) {

                if (Auth::user()->status == 0) {
                    Auth::logout();
                    return Redirect::to(route('admin.login'))
                        ->withErrors('This user account is inactive.')
                        ->withInput($request->except('password'));
                }

                Auth::login(Auth::user(), true);
                return redirect(route('dashboard'));
            } else {
                return Redirect::to(route('admin.login'))
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
        Auth::logout();
        return Redirect::to(route('admin.login'));
    }
}
