<?php
namespace app\admin\model;

use think\Model;

class Seo extends Model
{

    /**
     * 获取轮播图
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_seo()
    {
        return  $this->order('seo_id desc')->paginate(10,false,['query'=>$_REQUEST]);
    }

    /**
     * 获取总记录数
     * @return int|string
     * @throws \think\Exception
     */
    public function get_seo_count()
    {
        return $this->count();
    }

}