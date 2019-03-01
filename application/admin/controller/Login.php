<?php
namespace app\admin\controller;

use app\admin\service\LoginService;
use think\Controller;
use think\Session;

class Login extends Controller{

    /**
     * 登录页
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 登录处理
     */
    public function login_check(){
        $slogin = new LoginService();
        $data = $slogin->login_check();
        die($data);
    }

    /**
     * 退出登录
     */
    public function login_out(){
        Session::start();
        Session::destroy();
        $this->redirect(url('login/index'));
    }
}