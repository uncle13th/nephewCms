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

    //页面管理--展示首页管理页面
    Route::get('/home/index', 'Pages\IndexController@showIndexPage');
    //页面管理--首页管理--保存配置信息
    Route::put('/home/index/config', 'Pages\IndexController@saveIndexConfig');


    //页面管理--首页管理--保存数据（新增/编辑轮播图）
    Route::post('/home/banner', 'Pages\IndexController@saveBanner');
    //页面管理--首页管理--删除轮播图
    Route::delete('/home/banner', 'Pages\IndexController@deleteBanner');
    //页面管理--首页管理--修改轮播图顺序
    Route::put('/home/banner', 'Pages\IndexController@sortBanners');
    //页面管理--首页管理--修改轮播图的图片
    Route::put('/home/banner/image', 'Pages\IndexController@updateBannerImage');


    //页面管理--产品类型管理--打开展示页面
    Route::get('/home/product/type', 'Pages\ProductController@showTypePage');
    //页面管理--产品类型管理--保存类型信息--新增或修改
    Route::post('/home/product/type', 'Pages\ProductController@saveProductType');
    //页面管理--产品类型管理--修改产品类型的顺序
    Route::put('/home/product/type', 'Pages\ProductController@sortProductType');
    //页面管理--产品类型管理--删除产品类型
    Route::delete('/home/product/type', 'Pages\ProductController@deleteProductType');

    //页面管理--产品列表
    Route::get('/home/product/list', 'Pages\ProductController@showListPage');
    //页面管理--产品列表--保存产品排序
    Route::put('/home/product/list', 'Pages\ProductController@sortProductList');
    //页面管理--产品列表--删除产品
    Route::delete('/home/product/list', 'Pages\ProductController@deleteProduct');
    //页面管理--产品列表--打开产品详情页（新增或修改产品信息）
    Route::get('/home/product/info', 'Pages\ProductController@showInfoPage');
    //页面管理--产品列表--保存产品信息（新增或修改产品信息）
    Route::post('/home/product/info', 'Pages\ProductController@saveProduct');


    //页面管理--关于我们
    Route::get('/home/about', 'Pages\AboutController@showAboutPage');
    //页面管理--关于我们--保存信息--新增或修改
    Route::post('/home/about', 'Pages\AboutController@saveAboutInfo');
    //页面管理--关于我们--修改排序顺序
    Route::put('/home/about', 'Pages\AboutController@sortAboutList');
    //页面管理--关于我们--删除关于我们页面
    Route::delete('/home/about', 'Pages\AboutController@deleteAboutInfo');

    //页面管理--联系我们
    Route::get('/home/connect', 'Pages\AboutController@showConnectPage');
    //页面管理--联系我们--保存信息--新增或修改
    Route::post('/home/connect', 'Pages\AboutController@saveConnectInfo');
    //页面管理--联系我们--修改排序顺序
    Route::put('/home/connect', 'Pages\AboutController@sortConnectList');
    //页面管理--联系我们--删除关于我们页面
    Route::delete('/home/connect', 'Pages\AboutController@deleteConnectInfo');
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

    //展示导航菜单列表
    Route::get('front_menu', 'System\FrontMenuController@show');
    //保存导航菜单信息
    Route::post('front_menu', 'System\FrontMenuController@save');
    //删除导航菜单
    Route::delete('front_menu', 'System\FrontMenuController@delete');
    //修改导航菜单信息（排序）
    Route::put('front_menu', 'System\FrontMenuController@sort');
});

/****************************************  前端网站路由  ****************************************/

Route::get('/', 'Front\IndexController@show');


Route::get('/about', function(){
    return view('front.about');
});

Route::get('/product/list', 'Front\ProductController@showList');

Route::get('/product/info', 'Front\ProductController@showInfo');

//Route::group(['prefix' => '/product'], function () {
//
//});