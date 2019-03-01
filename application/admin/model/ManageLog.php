<?php
namespace app\admin\model;

use think\Model;

class ManageLog extends Model
{

    /**
     * 获取管理员日志
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_log($where='',$num=6,$page=0,$field='a.*,m.manage,m.real_name')
    {
        $this->field($field)->alias('a')
            ->join('ac_manage m','a.manage_id = m.manage_id','LEFT')
            ->where($where)->order('a.manage_log_id desc');

        if (!$page) {
            $list = $this->limit($num)->select();
        } else {
            $list = $this->paginate($num,false,['query'=>$_REQUEST]);
        }

        return $list;
    }

    /**
     * 获取日志总记录数
     * @return int|string
     */
    public function get_log_count($where='')
    {
        return $this->alias('a')->join('ac_manage m','a.manage_id = m.manage_id','LEFT')->where($where)->count();
    }

}