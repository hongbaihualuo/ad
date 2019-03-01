<?php
namespace app\admin\model;

use think\Model;

class ManageGroup extends Model
{

    /**
     * 获取管理员
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_group($where='',$num=6,$page=0,$field='*')
    {
        $this->field($field)->alias('a')->where($where)->order('a.manage_group_id desc');

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
    public function get_group_count($where='')
    {
        return $this->alias('a')->where($where)->count();
    }

}