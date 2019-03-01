<?php
namespace app\admin\service;

use app\admin\model\Manage;
use think\Session;

class LoginService extends Common {

    public function login_check(){

        $account = input('username');
        $password = input('password');

        if (!$account) return $this->cjson(1,'账号不能为空');
        if (!$password) return $this->cjson(1,'密码不能为空');

        $manage = new Manage();

        $check = $manage->get_manager("manage = '{$account}'",1);
        if ($check[0]['status'] == 1) return $this->cjson(1,'账号已停用！');
        if (count($check) <= 0 ) return $this->cjson(1,'账号或密码不正确！');
        if (!password_verify($password,$check[0]['password'])) return $this->cjson(1,'账号或密码不正确！');

        Session::set('manage_id',$check[0]['manage_id']);
        Session::set('manage',$check[0]['manage']);
        Session::set('right',explode(',',$check[0]['manage_group_right']));

        $this->add_log(0,'登录',"登录");

        return $this->cjson(0,'',url('index/index'));
    }
}