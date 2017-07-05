<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Logic\Pages\IndexLogic;
use App\Http\Logic\Pages\ProductLogic;
use App\Http\Logic\System\FrontMenuLogic;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function __construct()
    {
    }

    /*
     * 展示首页页面内容
     */
    public function show(Request $request)
    {
        //获取语言
        $lang = $this->getFrontLanguage($request);

        //获取导航菜单
        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getHeaderMenu($lang);
        $footer_menus = $logic->getFooterMenu($lang);

        //获取网站支持的语言列表
        $system_lang = config('app.system_lang');

        //获取首页配置信息




        //获取轮播图信息
        $indexLogic = IndexLogic::getInstance();
        $banners = $indexLogic->getIndexBanners($lang);

        //获取首页展示的产品类型
        $productLogic = ProductLogic::getInstance();
        $product_types = $productLogic->getIndexProductTypes($lang);



        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
            'banners' => $banners,
            'product_types' => $product_types,
        );
        return view('front.index', $data);
    }


}
