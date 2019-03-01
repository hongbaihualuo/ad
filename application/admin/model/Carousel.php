<?php
namespace app\admin\model;

use think\Model;

class Carousel extends Model
{

    /**
     * 获取轮播图
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_carousel()
    {
        return  $this->order('is_show asc,carousel_id desc')->paginate(10,false);
    }

    /**
     * 获取总记录数
     * @return int|string
     * @throws \think\Exception
     */
    public function get_carousel_count()
    {
        return $this->order('is_show asc,carousel_id desc')->count();
    }

}