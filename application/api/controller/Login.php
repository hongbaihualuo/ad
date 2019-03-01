<?php
namespace app\api\controller;

use app\api\service\LoginService;
use app\api\service\MemberService;
use think\Controller;

class Login extends Controller{

    /**
     * 验证码
     */
    public function msg_send()
    {
        $slogin = new LoginService();
        $data = $slogin->login_sendmsg();
        die($data);
    }

    /**
     * 登录处理
     */
    public function login_check()
    {
        $slogin = new LoginService();
        $data = $slogin->login_check();
        die($data);
    }

    /**
     * 注册处理
     */
    public function reg_check()
    {
        $smember = new MemberService();
        $data = $smember->member_add();
        die($data);
    }
}