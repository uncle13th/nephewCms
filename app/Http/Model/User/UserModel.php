<?php

namespace App\Http\Model\User;

use App\Http\Model\BaseModel;


class UserModel extends BaseModel
{

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nickname', 'email', 'password',
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
}
