<?php
namespace App\Http\Logic\User;

use App\Http\Logic\BaseLogic;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\User\UserModel;

class UserLogic extends BaseLogic
{
    //获取用户信息
    public function getUserInfo($role_id){


        //1.获取用户所属角色



        return true;
    }

    /**
     * 获取用户列表
     * @return mixed
     */
    public function getUserList(){
        $model = UserModel::instance();
        return $model->getUserList();
    }

    /**
     * 根据用户id获取用户列表
     * @param int $user_id 用户id
     * @return mixed
     */
    public function getUserListById($user_id){
        $model = UserModel::instance();
        return $model->getUserListById($user_id);
    }

    /**
     * 根据用户名查询用户列表
     * @param string $username 用户名
     * @return mixed
     */
    public function getUserListByUserName($username){
        $model = UserModel::instance();
        return $model->getUserListByUserName($username);
    }

    /**
     * 根据昵称模糊查询用户列表
     * @param string $nickname 昵称
     * @return mixed
     */
    public function getUserListByNickName($nickname){
        $model = UserModel::instance();
        return $model->getUserListByNickName($nickname);
    }

    /**
     * 保存用户信息（支持新增用户和修改用户）
     * @param array $params 用户信息数组
     * @return bool
     */
    public function saveUser($params){

        if(empty($params) || (!isset($params['id']) && empty($params['username'])) || empty($params['nickname'])
            || !isset($params['status']) || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1))
            || (!isset($params['id']) && empty($params['password'])) || $params['role_id'] < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'nickname' => trim($params['nickname']),
            'role_id' => intval($params['role_id']),
            'status' => intval($params['status']),
        );

        //头像
        if(isset($params['img'])){
            $data['img'] = trim($params['img']);
        }

        $model = UserModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateUser($data);
            if(!$result){
                $this->errorCode = 30002;
                $this->errorMessage = '用户修改失败！';
                return false;
            }
        }else{
            $data['username'] = trim($params['username']);
            $data['password'] = trim($params['password']);
            $result = $model->addUser($data);
            if(!$result){
                $this->errorCode = 30001;
                $this->errorMessage = '用户添加失败！';
                return false;
            }
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
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = UserModel::instance();
        if(!$model->deleteUser($user_id)){
            $this->errorCode = 30003;
            $this->errorMessage = '用户删除失败！';
            return false;
        }
        return true;
    }
}