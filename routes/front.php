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
    Route::get('/', 'CasesController@index')->name('cases');

    Route::get('/new', 'CasesController@newCase')->name('newcase');
    Route::post('/new', 'CasesController@storeCase')->name('newcase');

    Route::get('/info/{case}', 'CasesController@caseInfo')->name('caseinfo');

    Route::get('/edit/{case}', 'CasesController@editCase')->name('editcase');
    Route::post('/edit/{case}', 'CasesController@updateCase')->name('editcase');
});
