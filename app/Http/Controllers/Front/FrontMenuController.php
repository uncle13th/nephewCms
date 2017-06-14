<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Logic\Front\FrontMenuLogic;
use Illuminate\Http\Request;
use App\Http\Logic\User\USerLogic;

class FrontMenuController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /*
     * 查看角色信息
     */
    public function show(Request $request)
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

        $logic = FrontMenuLogic::getInstance();
        $header_menus = $logic->getFrontMenus(1);
        $footer_menus = $logic->getFrontMenus(2);
//        print_r($footer_menus);exit;

        return view('home.menu', ['menu_type'=>$menu_type, 'h_menus'=>$header_menus, 'f_menus'=>$footer_menus]);
    }

    /*
     * 保存菜单信息
     */
    public function save(Request $request)
    {
        $inputs = $request->input();
        $logic = FrontMenuLogic::getInstance();
        $result =$logic->saveData($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除菜单
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $logic = FrontMenuLogic::getInstance();
        $result = $logic->deleteData($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }
}
