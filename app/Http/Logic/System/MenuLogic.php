<?php
namespace App\Http\Logic\System;

use App\Http\Logic\BaseLogic;
use App\Http\Model\system\MenuModel;
use Illuminate\Support\Facades\Auth;

class MenuLogic extends BaseLogic
{

    //获取管理后台用户的菜单
    public function getUserMenu($user_id){

        //1.获取用户所属角色


        //2.获取角色角色的菜单



        return true;
    }

    /**
     * 获取有效的菜单
     * @return mixed
     */
    public function getAvaliableList(){

        $model = MenuModel::instance();
        $data = $model->getAvaliableList();
        if(!$data){
            return array('*');
        }

        $menus = array();
        foreach($data as $item){
            if($item['pid'] == 0){
                $menus[$item['id']]['info'] = $item;
            }else{
                $menus[$item['pid']]['children'][] = $item;
            }
        }
        return $menus;
    }
}