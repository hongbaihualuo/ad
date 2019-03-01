<?php
namespace app\admin\service;


use app\admin\model\CommentTemplet;
use app\admin\model\User;
use app\admin\model\Video;
use app\admin\model\VideoComment;

class VideoService extends Common
{
    /**
     * 视频搜索
     */
    public function videos_search(){

        $search['title'] = input('title');
        $search['account'] = input('account');
        $search['start'] = input('start');
        $search['end'] = input('end');

        $where = '1 = 1';
        if ($search['title']) $where .= " and a.title like '%{$search['title']}%'";
        if ($search['account']) $where .= " and u.username = '{$search['account']}'";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";

        $video = new Video();
        $list = $video->get_video($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $video->get_video_count($where);
        $data['search'] = $search;

        return $data;
    }

    /**
     * 视频添加修改
     */
    public function videos_save()
    {
        $id = input('id');

        $data = [
            'title'  => input('title'),
            'url'  => input('video'),
            'good'  => input('good'),
            'bad'  => input('bad'),
            'send_num'  => input('send'),
            'add_time' => date('Y-m-d H:i:s'),
            'status'  => input('status') == 0 ? input('status') : 1
        ];

        if (!$data['url']) return $this->cjson(1,'视频上传失败！');
        if (!$data['title'] ) return $this->cjson(1,'标题不能为空！');
        if (!input('account') ) return $this->cjson(1,'用户名不能为空！');

        $user = new User();
        $video = new Video();

        $check_user = $user->get_user("username = '".(input('account'))."'",1);
        if (count($check_user) <= 0 ) return $this->cjson(1,'该账号不存在！');
        $data['user_id'] = $check_user[0]['user_id'];

        if($id){
            $video->save($data,['video_id' => $id]);

            $this->add_log(2,'视频修改',"修改了{$data['title']}的信息");
            return $this->cjson(0,'');

        } else {
            $video->save($data);
            $this->add_log(1,'添加视频',"添加了{$data['title']}视频");
            return $this->cjson(0,'');
        }

    }

    /**
     * 视频状态切换
     */
    public function videos_onoff()
    {
        $id = input('id');
        $status = input('status') == 0 ? input('status') : 1;
        $video = new Video();

        if($video->save(['status'=>$status],['video_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 视频删除
     */
    public function video_delete()
    {
        $id = input('id/a');

        if (Video::destroy($id)) {
            $this->add_log(3,'删除视频',"删除视频");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 评论搜索
     */
    public function comment_search(){

        $search['title'] = input('title');
        $search['account'] = input('account');
        $search['start'] = input('start');
        $search['end'] = input('end');

        $where = '1 = 1';
        if ($search['title']) $where .= " and v.title = '%{$search['title']}%'";
        if ($search['account']) $where .= " and u.username = '{$search['account']}'";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";

        $videoComment = new VideoComment();
        $list = $videoComment->get_Comment($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $videoComment->get_Comment_count($where);
        $data['search'] = $search;

        return $data;
    }

    /**
     * 评论添加
     */
    public function comment_add()
    {
        $id = input('id');
        $num = input('num');

        $video = new Video();
        $commentTemplet = new CommentTemplet();
        $videoComment = new VideoComment();
        $user = new User();

        $check = $video->get_video("video_id = '{$id}'",1);
        if (count($check)<=0) return $this->cjson(1,'找不到相应视频！');

        $templet = $commentTemplet->get_templet('',500,0,'a.content');
        $user = $user->get_user('is_robot = 1',500,0,'a.user_id');
        if (count($templet) <= $num) return $this->cjson(1,'对应的模板不够！');
        if (count($user) <= 0) return $this->cjson(1,'未找到机器人账号！');

        $random_keys=array_rand($templet,$num);

        $data = [];
        foreach($random_keys as $k=>$v) {
            $key = array_rand($user,1);
            $data[$k]['user_id'] = $user[$key]['user_id'];
            $data[$k]['video_id'] = $id;
            $data[$k]['content'] = $templet[$v]['content'];
            $data[$k]['add_time'] = date('Y-m-d H:i:s');
        }

        if ($videoComment->saveAll($data)) {
            $this->add_log(1,'批量添加评论',"添加的视频为{$check[0]['title']}");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'修改失败');
        }
    }

    /**
     * 评论修改
     */
    public function comment_edit()
    {
        $id = input('id');
        $title = input('title');

        $data = [
            'content'  => input('content'),
        ];

        if (!$data['content']) return $this->cjson(1,'评论内容不能为空！');

        $videoComment = new VideoComment();
        $result = $videoComment->save($data,['id' => $id]);

        if ($result) {
            $this->add_log(2,'评论修改',"修改了{$title}的信息");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'修改失败');
        }
    }

    /**
     * 评论删除
     */
    public function comment_delete()
    {
        $id = input('id/a');

        if (VideoComment::destroy($id)) {
            $this->add_log(3,'删除评论',"删除评论");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 模板添加
     */
    public function templet_add()
    {
        $data = [
            'content'  => input('content'),
        ];
        if (!$data['content']) return $this->cjson(1,'评论模板内容不能为空！');

        $commentTemplet = new CommentTemplet();
        $result = $commentTemplet->save($data);

        if ($result) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'修改失败');
        }
    }

    /**
     * 模板删除
     */
    public function templet_delete()
    {
        $id = input('id/a');

        if (CommentTemplet::destroy($id)) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }
}