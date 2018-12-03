<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
 */

// Login/Logout Routes
Route::get('/login', 'LoginController@showLogin')->name('admin.login');
Route::post('/login', 'LoginController@doLogin')->name('admin.login');
Route::get('/logout', 'LoginController@doLogout')->name('admin.logout');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    // Users Management
    Route::get('users/delete/{user}', 'UserController@delete')->name('users.delete');
    Route::get('users/status/{user}', 'UserController@changeStatus')->name('users.status');
    Route::resource('users', 'UserController');
    //Company management
    Route::get('companies/delete/{id}', 'CompanyController@delete')->name('companies.delete');
    Route::get('companies/users/{id}', 'CompanyController@users')->name('companies.users');
    Route::resource('companies', 'CompanyController');
    //Cases management
    Route::get('cases/', 'CasesController@index')->name('cases.index');
    Route::get('cases/trusted', 'CasesController@trustedCases')->name('cases.trusted');
    Route::get('cases/fake', 'CasesController@fakeCases')->name('cases.fake');
    Route::get('cases/flagcase/{case}', 'CasesController@flagCase')->name('cases.flag');
    Route::get('cases/info/{case}', 'CasesController@caseInfo')->name('cases.info');
    // Settings
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
    Route::get('/clear-cache', 'SettingController@clearCache')->name('clearcache');

});
