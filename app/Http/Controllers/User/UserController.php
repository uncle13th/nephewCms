<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Logic\User\RoleLogic;
use Illuminate\Http\Request;
use App\Http\Logic\User\UserLogic;

class UserController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /*
     * 展示用户列表
     */
    public function getList(Request $request)
    {
        $inputs = $request->input();
//
        $logic = UserLogic::getInstance();
        if(!empty($inputs['id'])){
            $data = $logic->getUserListById($inputs['id']);
        }else if(!empty($inputs['username'])){
            $data = $logic->getUserListByUserName($inputs['username']);
        }else if(!empty($inputs['nickname'])){
            $data = $logic->getUserListByNickName($inputs['nickname']);
        }else{
            $data = $logic->getUserList();
        }
//
//        $menuLoigc = MenuLogic::getInstance();
//        $menus = $menuLoigc->getAvaliableList();

        //获取角色信息
        $roleLogic = RoleLogic::getInstance();
        $roles = $roleLogic->getAllRoles();
        $menus = [];
//print_r($roles);exit;
        $pageIndex = 2001;  //页面索引，管理后台左侧菜单使用

        $data = array(
            'users' => $data,
            'roles' => $roles,
            'menus' => $menus,
            'pageIndex' => $pageIndex,
        );

        return view('home.user', $data);
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
        $logic = UserLogic::getInstance();
        $result =$logic->saveUser($inputs);
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
        $user_id = $request->input('id');
        $logic = UserLogic::getInstance();
        $result =$logic->deleteUser($user_id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }
}
