<?php
namespace app\admin\model;

use think\Model;

class Manage extends Model
{

    /**
     * 获取管理员
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_manager($where='',$num=6,$page=0,$field='a.*,mg.manage_group_name,mg.manage_group_right')
    {
        $this->field($field)->alias('a')
            ->join('ac_manage_group mg','a.manage_group_id = mg.manage_group_id','LEFT')
            ->where($where)->order('a.manage_id desc');

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
    public function get_manager_count($where)
    {
        return $this ->join('ac_manage_group mg','a.manage_group_id = mg.manage_group_id','LEFT')->alias('a')->where($where)->count();
    }

}