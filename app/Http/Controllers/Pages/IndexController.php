<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Logic\Pages\IndexLogic;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showIndexPage(Request $request)
    {
        $inputs = $request->input();
        if(empty($inputs) ||empty($inputs['menu_type'])){
            $menu_type = 1;
        }else{
            $menu_type = intval($inputs['menu_type']);
            if($menu_type < 1){
                $menu_type = 1;
            }
        }

        $logic = IndexLogic::getInstance();
        //1.获取轮播图
        $banners = $logic->getAllBanners();
//        print_r($banners);exit;
        //2.获取产品类型
//        $product_types = $logic->getAllProductTypes();
//        print_r($product_types);exit;
        //3.获取产品列表
//        $product_list = $logic->getProductList();
//        print_r($product_list);exit;

        //2.获取配置信息

        $banner_num = 10;
        $index_product_num = 8;

        $data = array(
            'menu_type' => $menu_type,
            'f_menus' => [],
            'h_menus' => [],
            'banners' => $banners,
            'banner_num' => $banner_num,
            'index_product_num' => $index_product_num,
        );
        return view('home.pages.index', $data);
    }
}
