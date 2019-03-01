<?php
namespace app\api\model;

use think\Model;

class Video extends Model
{

    /**
     * 获取用户
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_video($where='',$num=6,$page=0,$field='a.*,u.username,count(vc.id) as comment_num,count(uc.id) as collet_num')
    {
        $this->field($field)->alias('a')
            ->join('ac_user u','a.user_id = u.user_id','LEFT')
            ->join('ac_video_comment vc','vc.video_id = a.video_id','LEFT')
            ->join('ac_user_collet uc','uc.user_id = a.user_id','LEFT')
            ->where($where)->order('a.video_id desc,a.good desc,a.bad asc');

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
    public function get_video_count($where)
    {
        $count = $this->alias('a')
            ->join('ac_user u','a.user_id = u.user_id','LEFT')
            ->where($where)->count();
        return $count;
    }

}