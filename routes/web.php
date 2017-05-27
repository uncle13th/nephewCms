<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/home', 'HomeController@index')->name('home');
//Route::group(['middleware' => 'auth', 'prifix' => '/home'], function () {
//    Route::get('/', function () {
        // 使用 Auth 中间件
//    });
//    Route::get('/', 'HomeController@index')->name('home');
//    Route::get('user/profile', function () {
//         使用 Auth 中间件
//    });
//});

Route::get('/password/reset', 'Auth\PasswordController@showResetFrom');
Route::post('/password/reset', 'Auth\PasswordController@reset');