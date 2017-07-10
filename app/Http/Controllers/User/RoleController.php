<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Logic\System\MenuLogic;
use Illuminate\Http\Request;
use App\Http\Logic\User\RoleLogic;

class RoleController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /*
     * 展示角色列表
     */
    public function getList(Request $request)
    {
        $inputs = $request->input();

        $logic = RoleLogic::getInstance();
        if(!empty($inputs['id'])){
            $data = $logic->getRoleListById($inputs['id']);
        }else if(!empty($inputs['name'])){
            $data = $logic->getRoleListByName($inputs['name']);
        }else{
            $data = $logic->getRoleList();
        }

        $menuLoigc = MenuLogic::getInstance();
        $menus = $menuLoigc->getAvaliableList();

        $pageIndex = 2001;  //页面索引，管理后台左侧菜单使用

        $data = array(
            'roles' => $data,
            'menus' => $menus,
            'pageIndex' => $pageIndex,
        );
        return view('home.role', $data);
    }

    /*
     * 查看角色信息
     */
    public function show()
    {
        return view('home.role');
    }

    /*
     * 保存角色信息
     */
    public function save(Request $request)
    {
        $inputs = $request->input();
        $logic = RoleLogic::getInstance();
        $result =$logic->saveRole($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除角色
     */
    public function delete(Request $request)
    {
        $role_id = $request->input('id');
        $logic = RoleLogic::getInstance();
        $result =$logic->deleteRole($role_id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }
}
