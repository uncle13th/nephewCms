<?php
namespace App\Http\Logic\User;

use App\Http\Logic\BaseLogic;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\User\RoleModel;

class RoleLogic extends BaseLogic
{
    //获取角色信息
    public function getRole($role_id){


        //1.获取用户所属角色



        return true;
    }

    /**
     * 获取所有可用的角色
     * @return array
     */
    public function getAllRoles(){
        $model = RoleModel::instance();
        $data = $model->getAllRoles();
        if(!$data){
            return array();
        }
        foreach($data as $item){
            $roles[$item['id']] = $item;
        }

        return $roles;
    }

    /**
     * 获取角色列表
     * @return mixed
     */
    public function getRoleList(){
        $model = RoleModel::instance();
        return $model->getRoleList();
    }

    /**
     * 根据角色id获取角色列表
     * @param int $role_id 角色id
     * @return mixed
     */
    public function getRoleListById($role_id){
        $model = RoleModel::instance();
        return $model->getRoleListById($role_id);
    }

    /**
     * 根据角色名称模糊查询角色列表
     * @param string $name 角色名称
     * @return mixed
     */
    public function getRoleListByName($name){
        $model = RoleModel::instance();
        return $model->getRoleListByName($name);
    }

    /**
     * 保存角色信息（支持新增角色和修改角色）
     * @param array $params 角色信息数组
     * @return bool
     */
    public function saveRole($params){

        if(empty($params) || empty($params['name']) || empty($params['menu']) || !isset($params['status'])
            || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1))){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        //去到有问题的元素
        foreach($params['menu'] as $menu_id => $val){
            if(is_null($val)){
                continue;
            }
            $menus[$menu_id] = $val;
        }

        $data = array(
            'name' => $params['name'],
            'status' => intval($params['status']),
            'menu_ids' => json_encode($menus),
        );

        $model = RoleModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateRole($data);
            if(!$result){
                $this->errorCode = 20002;
                $this->errorMessage = '角色修改失败！';
                return false;
            }

        }else{
            $result = $model->addRole($data);
            if(!$result){
                $this->errorCode = 20001;
                $this->errorMessage = '角色添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除角色
     * @param int $role_id 角色id
     * @return bool
     */
    public function deleteRole($role_id){
        if(!is_numeric($role_id) || $role_id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = RoleModel::instance();
        if(!$model->deleteRole($role_id)){
            $this->errorCode = 20003;
            $this->errorMessage = '角色删除失败！';
            return false;
        }
        return true;
    }
}