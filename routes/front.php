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

    Route::post('/section-flag/{section}/{case}', 'CasesController@flagCaseBySection')->name('section-flag');

    Route::get('/info/{case}', 'CasesController@caseInfo')->name('caseinfo');
    Route::get('/analysis/{case}', 'CasesController@postAnalysis')->name('analysis');
    Route::get('/author-posts/{case}', 'CasesController@authorPosts')->name('author-posts');
    Route::get('/post-location/{case}', 'CasesController@geoLocationMap')->name('post-location');

    Route::get('/edit/{case}', 'CasesController@editCase')->name('editcase');
    Route::post('/edit/{case}', 'CasesController@updateCase')->name('editcase');
});
