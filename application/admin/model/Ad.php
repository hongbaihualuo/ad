<?php
namespace app\admin\model;

use think\Model;

class Ad extends Model
{

    /**
     * 获取广告
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_ad($where='',$num=6,$page=0,$field='a.*,t.link,at.templet_title')
    {
        $this->field($field)->alias('a')
            ->join('ac_ad_type t','t.type_id = a.type_id','LEFT')
            ->join('ac_ad_templet at','t.templet_id = at.templet_id,','LEFT')
            ->where($where)->order('a.ad_id desc');

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
    public function get_ad_count($where='')
    {
        return $this->alias('a')
            ->join('ac_ad_type t','t.type_id = a.type_id','LEFT')
            ->join('ac_ad_templet at','t.templet_id = at.templet_id,','LEFT')
            ->where($where)->count();
    }

}