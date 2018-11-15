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

Route::group(['prefix' => 'password'], function () {
    // Reset request email
    $this->get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.forgot');
    $this->post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    // Reset form
    $this->get('reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('reset', 'ResetPasswordController@reset')->name('password.update');
});


Route::group(['middleware' => ['auth:front', 'front']], function () {
    Route::get('/', 'CasesController@index')->name('cases');

    Route::get('/new', 'CasesController@newCase')->name('newcase');
    Route::post('/new', 'CasesController@storeCase')->name('newcase');

    Route::post('/section-flag/{section}/{case}', 'CasesController@flagCaseBySection')->name('section-flag');
    Route::post('/flag-case/{case}', 'CasesController@flagCase')->name('flag-case');

    Route::get('/info/{case}', 'CasesController@caseInfo')->name('caseinfo');
    Route::get('/analysis/{case}', 'CasesController@postAnalysis')->name('analysis');
    Route::get('/author-posts/{case}', 'CasesController@authorPosts')->name('author-posts');
    Route::get('/post-location/{case}', 'CasesController@geoLocationMap')->name('post-location');
    Route::get('/similar-posts/{case}', 'CasesController@similarPosts')->name('similar-posts');
    Route::get('/samearea-posts/{case}', 'CasesController@sameAreaPosts')->name('samearea-posts');
    Route::get('/author-profile/{case}', 'CasesController@authorProfile')->name('author-profile');
    Route::get('/image-search/{case}', 'CasesController@imageSearch')->name('image-search');
    Route::get('/source-cross-check/{case}', 'CasesController@sourceCrossCheck')->name('source-cross');
    Route::get('/results/{case}', 'CasesController@results')->name('results');
    Route::get('/related/{case}', 'CasesController@relatedCases')->name('related');
    Route::get('/cache/{key}', 'CasesController@clearCache')->name('cache');
    Route::get('/discussions/{case}', 'DiscussionController@discussion')->name('discussions');
    Route::post('/discussions/{case}', 'DiscussionController@discussionSave')->name('discussions');

    Route::get('/edit/{case}', 'CasesController@editCase')->name('editcase');
    Route::post('/edit/{case}', 'CasesController@updateCase')->name('editcase');
});
