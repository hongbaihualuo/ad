<?php
namespace app\api\service;

use think\Session;

class SendService extends Common {

    const msg_appid = 'C94364327';
    const msg_appkey = '4aa9c616609e90d7040581d14ee5241f';
    const msg_send_time = 50;
    const msg_send_num = 5;
    const msg_black_time = 600;
    const msg_url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
    const msg_send_limit = 1;

    /**
     * 发送短信
     */
    public function send_msg($mobile,$msg)
    {

        $target = self::msg_url;
        $re = $this->sms_safe();
        if ($re) return $this->cjson(1,'$re');

        $content = $msg ;
        $post_data = "account=".self::msg_appid ."&password=".self::msg_appkey ."&mobile=".$mobile."&content=".rawurlencode($content);
        $gets = $this-> xml_to_array($this->post($post_data, $target));
        if ($gets['SubmitResult']['code']==2) {
            Session::set('msg_send_time',time());
            Session::set('msg_send_num',Session::get('msg_send_num')+1);
            return $this->cjson(0,'发送成功');
        } else {
            return $this->cjson(1,'发送失败');
        }

    }

    //请求数据到短信接口，检查环境是否 开启 curl init。
    private function post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    //将 xml数据转换为数组格式。
    private function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this-> xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    //防止恶意攻击
    private function sms_safe(){
        if(self::msg_send_limit == 1){
            return;
        }
        if (!empty(Session::get('msg_send_black')) && Session::get('msg_send_black') + self::msg_black_time > time()) {
            return '操作频繁,请'.ceil((Session::get('msg_send_black') + self::msg_black_time - time())/60).'分钟后重试';
        }

        if (empty(Session::get('msg_send_num'))) {
            Session::set('msg_send_num',1);
        }

        if(!empty(Session::get('msg_send_time')) && Session::get('msg_send_time') + self::msg_send_time > time()){
            return '操作频繁,请'.(Session::get('msg_send_time') + self::msg_send_time - time()).'秒后重试';
        }

        if (Session::get('msg_send_num') > self::msg_send_num) {
            Session::set('msg_send_black',time());
            Session::delete('msg_send_num');
            Session::delete('msg_send_time');
            return '发送次数超过限制';
        }
    }
}