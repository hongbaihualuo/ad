<?php
namespace app\api\controller;

use app\api\model\UserCollet;
use app\api\service\Common;
use app\api\service\MemberService;
use app\api\service\VideoService;
use think\Controller;

class User extends Common{

    /**
     * 赞，踩，转发
     */
    public function good_bad_send()
    {
        $video_id = input('video_id');
        $type = is_numeric(input('type')) ? input('type') : 1 ;

        $smember = new MemberService();
        if ($type == 2) {
            $data = $smember->add_bad($video_id);
        } else if ($type == 3) {
            $data = $smember->add_send($video_id);
        } else {
            $data = $smember->add_good($video_id);
        }
        die($data);
    }

    /**
     * 用户信息
     */
    public function get_userinfo()
    {
        $smember = new MemberService();
        $data = $smember->member_search(input('user_id'));
        die($data);
    }

    /**
     * 修改用户信息
     */
    public function userinfo_edit()
    {
        $smember = new MemberService();
        $data = $smember->member_edit();
        die($data);
    }

    /**
     * 修改用户头像
     */
    public function edit_userhead()
    {
        $smember = new MemberService();
        $data = $smember->member_img(input('user_id'));
        die($data);
    }

    /**
     * 获取用户视频
     */
    public function get_user_video()
    {
        $svideo = new VideoService();
        $data = $svideo->videos_search();
        die($data);
    }

    /**
     * 用户视频添加
     */
    public function user_video_add()
    {
        $svideo = new VideoService();
        $data = $svideo->videos_add();
        die($data);
    }

    /**
     * 用户视频修改
     */
    public function user_video_edit()
    {
        $svideo = new VideoService();
        $data = $svideo->videos_edit();
        die($data);
    }

    /**
     * 用户视频删除
     */
    public function user_video_delete()
    {
        $svideo = new VideoService();
        $data = $svideo->videos_delete();
        die($data);
    }

    /**
     * 获取用户评论
     */
    public function get_user_comment()
    {
        $svideo = new VideoService();
        $data = $svideo->comment_search();
        die($data);
    }

    /**
     * 用户评论添加
     */
    public function user_comment_add()
    {
        $svideo = new VideoService();
        $data = $svideo->comment_add();
        die($data);
    }

    /**
     * 用户评论修改
     */
    public function user_comment_edit()
    {
        $svideo = new VideoService();
        $data = $svideo->comment_edit();
        die($data);
    }

    /**
     * 用户评论删除
     */
    public function user_comment_delete()
    {
        $svideo = new VideoService();
        $data = $svideo->comment_delete();
        die($data);
    }

    /**
     * 用户收藏
     */
    public function get_user_collet()
    {
        $smember = new MemberService();
        $data = $smember->collet_search();
        die($data);
    }

    /**
     * 添加收藏
     */
    public function user_collet_add()
    {
        $smember = new MemberService();
        $data = $smember->collet_add();
        die($data);
    }

    /**
     * 收藏删除
     */
    public function user_collet_delete()
    {
        $smember = new MemberService();
        $data = $smember->collet_delete();
        die($data);
    }
}