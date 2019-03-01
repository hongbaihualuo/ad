<?php
namespace app\admin\service;

use app\admin\model\ManageLog;
use think\Session;

class Common
{

    public function _initialize()
    {

    }

    /**
     * 返回数据转换
     */
    public function cjson($code, $msg = '', $url = '')
    {
        $data = ['code' => $code, 'msg' => $msg, 'url' => $url];
        return json_encode($data, true);
    }

    /**
     * 添加管理员日志
     */
    public function add_log($type, $title, $content)
    {
        $manageLog = new ManageLog();
        $data = [
            'title'=>$title,
            'content'=>$content,
            'type'=>$type,
            'manage_id'=>Session::get('manage_id'),
            'ip'=>request()->ip(),
            'add_time'=>date('Y-m-d H:i:s')
        ];
        $manageLog->save($data);
    }

}