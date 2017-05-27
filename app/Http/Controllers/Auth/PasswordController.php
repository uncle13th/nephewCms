<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Model\User\UserModel;

class PasswordController extends Controller
{

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 展示密码修改界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetFrom(){
        return view('auth.passwords.reset');
    }

    /**
     * 修改密码
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request){

        $rules = [
            'password_origin' => 'required',
            'password' => 'required|confirmed|min:6',
        ];

        $messages = [
            'password_origin.required' => '旧密码不能为空!',
            'password.required' => '新密码不能为空!',
            'password.min' => '新密码长度不能小于6!',
            'password.confirmed' => '新密码和确认密码不相等!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        //字段类型等验证失败
        if ($validator->fails()) {
            return redirect('password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        //验证旧密码
        $password_origin = $request->input('password_origin');
        $user = Auth::user();
        if(!password_verify($password_origin, $user['password'])){
            $validator->errors()->add('password_origin', '旧密码错误!');
            return redirect('password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        //修改密码
        $user_id = $user['id'];
        $password = $request->input('password');
        $model = UserModel::getInstance();
        if(!$model->updatePassword($user_id, $password)){
            $validator->errors()->add('password', '密码更新失败!');
            return redirect('password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        return redirect('/home');
    }



}
