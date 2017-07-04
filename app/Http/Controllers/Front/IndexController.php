<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Logic\Front\IndexLogic;
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


        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getHeaderMenu($lang);
        $footer_menus = $logic->getFooterMenu($lang);
//        print_r($header_menus);
//        print_r($footer_menus);exit;

        //获取网站支持的语言列表
        $system_lang = config('app.system_lang');
//        print_r($system_lang);exit;

        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
        );
        return view('front.index', $data);
    }


}
