<?php
namespace app\admin\model;

use think\Model;

class UserType extends Model
{

    /**
     * 获取用户类型
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_type()
    {
        return $this->where(" status = 0")->order('user_type_id desc')->select();
    }

    /**
     * 获取所有用户类型
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_all_type()
    {
        return $this->order('user_type_id desc')->select();
    }

}