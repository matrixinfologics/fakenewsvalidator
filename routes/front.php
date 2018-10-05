<?php

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
| Here is where you can register front routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "front" middleware group. Now create something great!
|
*/

// Login/Logout Routes
Route::get('/login', 'LoginController@showLogin')->name('login');
Route::post('/login', 'LoginController@doLogin')->name('login');
Route::get('/logout', 'LoginController@doLogout')->name('logout');

Route::group(['middleware' => ['auth:front', 'front']], function () {
    Route::get('/', 'HomeController@index');
});
