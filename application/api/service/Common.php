<?php
namespace app\api\service;

class Common
{

    public function _initialize()
    {

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