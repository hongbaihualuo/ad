<?php
namespace app\api\controller;

use app\api\model\User;
use app\api\model\UserLogin;
use think\Controller;

class Common extends Controller{

    public function _initialize()
    {
        $token = input('token');
        $user_id = input('user_id');

        $userLogin = new UserLogin();

        if ($userLogin->get(['token'=>$token,'user_id'=>$user_id])) {
            die($this->cjson(2,'登录信息失效，请重新登录！'));
        }

        $userInfo = User::get($user_id);

        if (!$userInfo || $userInfo['status'] == 1) {
            die($this->cjson(2,'登录信息失效，此账号已停用！'));
        }
    }

    /**
     * 返回数据转换
     */
    public function cjson($code,$msg=null,$data = null)
    {
        $data = ['code' => $code,'msg'=>$msg, 'data' => $data];
        return json_encode($data, true);
    }
}