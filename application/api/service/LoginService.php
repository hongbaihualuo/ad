<?php
namespace app\api\service;

use app\admin\model\User;
use app\api\model\UserLogin;
use think\Session;

class LoginService extends Common {

    /**
     * 获取登录验证码
     */
    public function login_sendmsg()
    {
        $mobile = input('mobile');
        if (empty($mobile)) return $this->cjson(1,'手机号码不能为空');

        $preg = "/^1[3456789]\d{9}$/";
        if (!preg_match($preg, $mobile)) return $this->cjson(1,'手机号码不正确');

        $rand = rand(1000,9999);
        $msg = "您的验证码是：{$rand}。请不要把验证码泄露给其他人。";
        Session::set('mobile',$mobile);
        Session::set('mobile_code',$rand);
        Session::set('mobile_code_time',time());
        $ssend = new SendService();
        return $ssend->send_msg($mobile,$msg);
    }

    /**
     * 登录数据处理
     * @return string
     */
    public function login_check(){

        $mobile = input('mobile');
        $code = input('code');

        if (!$mobile) return $this->cjson(1,'手机号不能为空');
        if ($mobile != Session::get('mobile')) return $this->cjson(1,'请使用发送验证码的手机号登录');
        if (!$code) return $this->cjson(1,'验证码不能为空');
        if (time()-Session::get('mobile_code_time') > 600) return $this->cjson(1,'验证码错误');
        if ($code != Session::get('mobile_code')) return $this->cjson(1,'验证码错误');

        $user = new User();
        $userLogin = new UserLogin();

        $check = $user->get_user("mobile = '{$mobile}'",1,0,'a.user_id,a.nickname,a.img,a.status');
        if ($check[0]['status'] == 1) return $this->cjson(1,'账号已停用！');
        if (count($check) <= 0 ) return $this->cjson(1,'账号不存在！');

        $token = password_hash($mobile,PASSWORD_DEFAULT);

        $user->save(['last_ip'=>request()->ip(),'last_time'=>date('Y-m-d H:i:s')],["user_id"=>$check[0]['user_id']]);
        $data = [
            'user_id' => $check[0]['user_id'],
            'token' => $token,
            'add_time' => date('Y-m-d H:i:s')
        ];
        $check_login = $userLogin->get(["user_id"=>$check[0]['user_id']]);
        if ($check_login) {
            $userLogin->save($data,['user_id'=>$check[0]['user_id']]);
        } else {
            $userLogin->save($data);
        }

        return $this->cjson(0,'登录成功',['token'=>$token,'list'=>$check[0]]);
    }
}