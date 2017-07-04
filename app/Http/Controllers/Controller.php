<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //获取语言
    public function getFrontLanguage(Request $request){
        //1.获取网站默认的语言
        $default_lang = env('front_lang', 'zh_cn');

        //1.获取配置好的语言列表（网站支持哪些语言）
        $system_lang = config('app.system_lang');
        if(empty($system_lang)){
            return $default_lang;
        }

        //2.获取cookie中配置的语言
        $cookie_lang = $request->cookie('lang');

        //3.获取参数中的lang
        $input_lang = trim($request->input('lang'));
        if(empty($input_lang) && empty($cookie_lang)){
            return $default_lang;
        }

        //4.如果参数的和cookie的一致，则返回
        if(!empty($input_lang) && !empty($cookie_lang) && $input_lang == $cookie_lang){
            return $input_lang;
        }

        //5、如果有lang参数且为配置里支持的语言，且和cookie的不一样，则设置cookie
        if(array_key_exists($input_lang, $system_lang) && $cookie_lang != $input_lang){
            //设置cookie,30天有效期
            Cookie::queue('lang', $input_lang, 60*24*30);
            return $input_lang;
        }

        //6、如果cookie的语言不为空，且为支持的语言，则返回
        if(!empty($cookie_lang) && array_key_exists($cookie_lang, $system_lang)){
            return $cookie_lang;
        }

        //7、cookie没有设置支持的语言，参数也没有附带支持的语言
        return $default_lang;
    }

    //设置语言
    public function setFrontLanguage(Request $request){

    }
}
