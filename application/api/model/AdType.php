<?php
namespace app\api\model;

use think\Model;

class AdType extends Model
{

    /**
     * 获取广告类型
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_type($where='',$num=6,$page=0,$field='a.*,t.templet_title')
    {
        $this->field($field)->alias('a')
            ->join('ac_ad_templet t','t.templet_id = a.templet_id','LEFT')
            ->where($where)->order('a.type_id desc');

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
    public function get_type_count($where='')
    {
        return $this->alias('a')
            ->join('ac_ad_templet t','t.templet_id = a.templet_id','LEFT')
            ->where($where)->count();
    }

}