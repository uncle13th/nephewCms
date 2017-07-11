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
     * 展示产品列表页
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

    /*
     * 展示产品信息页
     */
    public function showInfo(Request $request)
    {
        $id = max(0, intval($request->input('id')));
        if($id < 1){
            //跳转到404页面
        }

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

        //获取展示的产品
        $product_info = $productLogic->getAvailableProductInfo($id);
        if(empty($product_info)){
            //跳转到404页面
        }
        $product_type = $product_info['type'];
        $type_name = '';
        foreach($product_types as $type){
            if($type['id'] == $product_type){
                $type_name = $type['name'];
                break;
            }
        }

        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
            'product_type' => $product_type,
            'type_name' => $type_name,
            'product_types' => $product_types,
            'product_info' => $product_info,
        );
        return view('front.product', $data);
    }
}
