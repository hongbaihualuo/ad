<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{

    /**
     * 获取用户
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_user($where='',$num=6,$page=0,$field='a.*,ui.*,ut.type_name')
    {
        $this->field($field)->alias('a')
            ->join('ac_user_info ui','a.user_id = ui.user_id','LEFT')
            ->join('ac_user_type ut','a.user_type = ut.user_type_id','LEFT')
            ->where($where)->order('a.user_id desc');

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
    public function get_user_count($where)
    {
        $count = $this->alias('a')
            ->join('ac_user_info ui','a.user_id = ui.user_id','LEFT')
            ->join('ac_user_type ut','a.user_type = ut.user_type_id','LEFT')
            ->where($where)->count();
        return $count;
    }

}