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



//Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    //控制面板
    Route::get('/home', 'Home\HomeController@index')->name('home');
    //修改密码窗口
    Route::get('/password/reset', 'Auth\PasswordController@showResetFrom');
    //提交修改密码
    Route::post('/password/reset', 'Auth\PasswordController@reset');
});

/**
 * 角色管理
 */
Route::group(['middleware' => 'auth', 'prefix' => '/home/role'], function () {
    //角色列表
    Route::get('/list', 'User\RoleController@getList');
    //角色信息
    Route::get('/', 'User\RoleController@show');
    //保存角色信息（新增或修改）
    Route::post('/', 'User\RoleController@save');
    //删除角色
    Route::delete('/', 'User\RoleController@delete');
});

/**
 * 用户管理
 */
Route::group(['middleware' => 'auth', 'prefix' => '/home/user'], function () {
    //用户列表
    Route::get('/list', 'User\UserController@getList');
    //用户信息
    Route::get('/', 'User\UserController@show');
    //保存用户信息（新增或修改）
    Route::post('/', 'User\UserController@save');
    //删除用户
    Route::delete('/', 'User\UserController@delete');
});

/**
 * 系统配置管理
 */
Route::group(['middleware' => 'auth', 'prefix' => '/home'], function () {
    //文件管理
    Route::get('file', function(){
        return view('home.file');
    });
    //导航菜单管理
//    Route::get('menu', function(){
//        return view('home.menu');
//    });

    //展示导航菜单列表
    Route::get('front_menu', 'Front\FrontMenuController@show');
    //保存导航菜单信息
    Route::post('front_menu', 'Front\FrontMenuController@save');
    //删除导航菜单
    Route::delete('front_menu', 'Front\FrontMenuController@delete');
    //修改导航菜单信息（排序）
    Route::put('front_menu', 'Front\FrontMenuController@sort');
});

/****************************************  前端网站路由  ****************************************/

Route::get('/', function () {
    return view('front.index');
});

Route::get('/about', function(){
    return view('front.about');
});

Route::get('/product/list', function(){
    return view('front.list');
});

Route::get('/product', function(){
    return view('front.product');
});

//Route::group(['prefix' => '/product'], function () {
//
//});