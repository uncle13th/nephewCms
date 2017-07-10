<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Logic\Pages\IndexLogic;
use App\Http\Logic\Pages\ProductLogic;
use App\Http\Logic\System\FrontMenuLogic;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
    }

    /*
     * 展示列表页
     */
    public function showList(Request $request)
    {
        $type = max(0, intval($request->input('type')));

        //获取语言
        $lang = $this->getFrontLanguage($request);

        //获取导航菜单
        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getHeaderMenu($lang);
        $footer_menus = $logic->getFooterMenu($lang);

        //获取网站支持的语言列表
        $system_lang = config('app.system_lang');


        //获取产品类型
        $productLogic = ProductLogic::getInstance();
        $product_types = $productLogic->getAvailableProductTypes($lang);
//print_r($product_types);//exit;

        //获取展示的产品
        $product_list = $productLogic->getAvailableProductList($type, $lang);

        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
            'type' => $type,
            'product_types' => $product_types,
            'product_list' => $product_list,
        );
        return view('front.list', $data);
    }


}
