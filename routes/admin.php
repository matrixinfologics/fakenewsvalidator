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

Route::get('/login', 'LoginController@showLogin')->name('admin.login');
Route::post('/login', 'LoginController@doLogin')->name('admin.login');
Route::get('/logout', 'LoginController@doLogout')->name('admin.logout');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
});
