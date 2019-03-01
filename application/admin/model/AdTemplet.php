<?php
namespace app\admin\model;

use think\Model;

class AdTemplet extends Model
{

    /**
     * 获取广告模板
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_templet($where='',$num=6,$page=0,$field='a.*')
    {
        $this->field($field)->alias('a')->where($where)->order('a.templet_id desc');

        if (!$page) {
            $list = $this->limit($num)->select();
        } else {
            $list = $this->paginate($num,false,['query'=>$_REQUEST]);
        }

        return $list;
    }

    /**
     * 获取总记录数
     * @return int|string
     */
    public function get_templet_count($where='')
    {
        return $this->alias('a')
            ->where($where)->count();
    }

}