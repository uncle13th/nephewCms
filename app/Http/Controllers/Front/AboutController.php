<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Logic\Pages\AboutLogic;
use App\Http\Logic\System\FrontMenuLogic;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    public function __construct()
    {
    }

    /*
     * 展示关于我们页面
     */
    public function showAbout(Request $request)
    {
        //获取语言
        $lang = $this->getFrontLanguage($request);

        //获取导航菜单
        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getHeaderMenu($lang);
        $footer_menus = $logic->getFooterMenu($lang);

        //获取网站支持的语言列表
        $system_lang = config('app.system_lang');

        //获取关于我们区域的内容
        $aboutLogic = AboutLogic::getInstance();
        $content = $aboutLogic->getAboutContent($lang);

        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
            'type' => 1,
            'data' => $content,
        );
        return view('front.about', $data);
    }

    /*
     * 展示联系我们页面
     */
    public function showConnect(Request $request)
    {
        //获取语言
        $lang = $this->getFrontLanguage($request);

        //获取导航菜单
        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getHeaderMenu($lang);
        $footer_menus = $logic->getFooterMenu($lang);

        //获取网站支持的语言列表
        $system_lang = config('app.system_lang');

        //获取联系我们区域的内容
        $aboutLogic = AboutLogic::getInstance();
        $content = $aboutLogic->getConnectContent($lang);

        $data = array(
            'lang' => $lang,
            'header_menu' => $header_menus,
            'footer_menus' => $footer_menus,
            'system_lang' => $system_lang,
            'type' => 2,
            'data' => $content,
        );
        return view('front.about', $data);
    }
}
