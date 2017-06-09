<?php

namespace App\Http\Model\User;

use App\Http\Model\BaseModel;


class UserModel extends BaseModel
{

    protected $table = 'users';

    /*
     * 页面条数
     */
    public $per_page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nickname', 'email', 'password', 'role_id', 'img', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 更新用户密码
     * @param int $user_id 用户id
     * @param string $password 用户密码
     * @return bool
     */
    public function updatePassword($user_id, $password){
        $model = $this->find($user_id);
        if(is_null($model)){
            return false;
        }

        $data['password'] = bcrypt($password);
        if(!$model->update($data)){
            return false;
        }

        return true;
    }

    /**
     * 获取用户列表
     * @return mixed
     */
    public function getUserList(){
        $model = $this->where('status', '!=' , -1)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 根据用户id获取用户列表
     * @param int $user_id 用户id
     * @return mixed
     */
    public function getUserListById($user_id){
        $model = $this->where('status', '!=', -1)->where('id', $user_id)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 根据用户名查询用户列表
     * @param string $username 用户名
     * @return mixed
     */
    public function getUserListByUserName($username){
        $model = $this->where('status', '!=', -1)->where('username', 'regexp', $username)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 根据昵称模糊查询用户列表
     * @param string $nickname 昵称
     * @return mixed
     */
    public function getUserListByNickName($nickname){
        $model = $this->where('status', '!=', -1)->where('nickname', 'regexp', $nickname)->orderBy('id', 'desc')->paginate($this->per_page);
        return $model;
    }

    /**
     * 新增用户
     * @param array $data 用户信息数组
     * @return bool|array
     */
    public function addUser($data){
        if(empty($data) || empty($data['username']) || empty($data['nickname']) || !isset($data['status'])
            || empty($data['password']) || $data['role_id'] < 1){
            return false;
        }

        //判断名字是否被使用了
        $num = $this->where('username', $data['username'])->where('status', '!=', -1)->count();
        if($num > 0){
            return false;
        }

        $data['password'] = bcrypt($data['password']);  //加密
        $model = new static($data);
        if(!$model->save()){
            return false;
        }
        return $model->toArray();
    }

    /**
     * 更新用户信息
     * @param array $data 用户信息数组
     * @return bool|array
     */
    public function updateUser($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['nickname']) || !isset($data['status'])
            || $data['role_id'] < 1){
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
     * 删除用户
     * @param int $user_id 用户id
     * @return bool
     */
    public function deleteUser($user_id){
        if(!is_numeric($user_id) || $user_id < 1){
            return false;
        }

        $model = $this->where('id', $user_id)->where('status', '!=', -1)->first();
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
