<?php
namespace app\api\model;

use think\Model;

class UserCollet extends Model
{

    /**
     * 获取收藏
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_collet($where='',$num=6,$page=0,$field='a.*,v.title,u.nickname')
    {
        $this->field($field)->alias('a')
            ->join('ac_video v','a.video_id = v.video_id','LEFT')
            ->join('ac_user u','a.user_id = u.user_id','LEFT')
            ->where($where)->order('a.id desc');

        if (!$page) {
            $list = $this->limit($num)->select();
        } else {
            $list = $this->paginate($num,false,['query'=>$_REQUEST]);
        }

        return $list;
    }

    /**
     * 获取收藏总记录数
     * @return int|string
     */
    public function get_collet_count($where)
    {
        $count = $this->alias('a')
            ->join('ac_video v','a.video_id = v.video_id','LEFT')
            ->join('ac_user u','a.user_id = u.user_id','LEFT')
            ->where($where)->count();
        return $count;
    }

}