<?php

namespace App\Http\Model\User;

use App\Http\Model\BaseModel;


class RoleModel extends BaseModel
{

    protected $table = 'roles';
    public $per_page = 10;

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取角色列表
     * @return mixed
     */
    public function getRoleList(){
        $model = $this->where('status', '!=' , -1)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 根据角色id获取角色列表
     * @param int $role_id 角色id
     * @return mixed
     */
    public function getRoleListById($role_id){
        $model = $this->where('status', '!=', -1)->where('id', $role_id)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 根据角色名称模糊查询角色列表
     * @param string $name 角色名称
     * @return mixed
     */
    public function getRoleListByName($name){
        $model = $this->where('status', '!=', -1)->where('name', 'regexp', $name)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 新增角色
     * @param array $data 角色信息数组
     * @return bool|array
     */
    public function addRole($data){
        if(empty($data) || empty($data['name']) || empty($data['menu_ids']) || !isset($data['status'])){
            return false;
        }

        //判断名字是否被使用了
        $num = $this->where('name', $data['name'])->where('status', '!=', -1)->count();
        if($num > 0){
            return false;
        }

        $model = new static($data);
        if(!$model->save()){
            return false;
        }
        return $model->toArray();
    }

    /**
     * 新增角色
     * @param array $data 角色信息数组
     * @return bool|array
     */
    public function updateRole($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['name']) || empty($data['menu_ids'])
            || !isset($data['status'])){
            return false;
        }

        //判断名字是否被其他角色使用了
        $num = $this->where('name', $data['name'])->where('id', '!=', $data['id'])->where('status', '!=', -1)->count();
        if($num > 0){
            return false;
        }

        $model = $this->where('id', $data['id'])->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        if(!$model->update($data)){
            return false;
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
            return false;
        }

        $model = $this->where('id', $role_id)->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        $data['status'] = -1;
        if(!$model->update($data)){
            return false;
        }

        return true;
    }
}
