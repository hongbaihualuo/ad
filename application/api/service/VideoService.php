<?php
namespace app\api\service;


use app\api\model\User;
use app\api\model\Video;
use app\api\model\VideoComment;

class VideoService extends Common
{
    /**
     * 视频搜索
     */
    public function videos_search(){

        $search['title'] = input('title');
        $search['nickname'] = input('nickname');
        $search['user_id'] = input('user_id');
        $search['start'] = input('start');
        $search['end'] = input('end');

        $where = '1 = 1';
        if ($search['title']) $where .= " and a.title like '%{$search['title']}%'";
        if ($search['nickname']) $where .= " and u.nickname = '{$search['nickname']}'";
        if ($search['user_id']) $where .= " and u.user_id = {$search['user_id']}";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";

        $video = new Video();
        $list = $video->get_video($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $video->get_video_count($where);

        return $this->cjson(0,'请求成功',$data);
    }

    /**
     * 视频添加
     */
    public function videos_add()
    {

        $sfile = new FileService();
        $video = $sfile->upload_video_one();
        if(!$video) return $this->cjson(1,'视频上传失败！');

        $data = [
            'title'  => input('title'),
            'url'  => $video,
            'user_id'  => input('user_id'),
            'add_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['url']) return $this->cjson(1,'视频上传失败！');
        if (!$data['title'] ) return $this->cjson(1,'标题不能为空！');

        $video = new Video();

        if ($video->save($data)) {
            return $this->cjson(0,'添加成功');
        } else {
            return $this->cjson(1,'添加失败');
        }

    }

    /**
     * 视频修改
     */
    public function videos_edit()
    {
        $id = input('video_id');

        $data = [
            'title'  => input('title'),
        ];

        if (!Video::get(['video_id'=>$id,'user_id'=>input('user_id')]))  return $this->cjson(1,'未找到该视频！');
        if (!$data['title'] ) return $this->cjson(1,'标题不能为空！');

        $video = new Video();

        if ($video->save($data,['video_id' => $id])){
            return $this->cjson(0,'修改成功');
        } else {
            return $this->cjson(1,'修改失败');
        }

    }

    /**
     * 视频删除
     */
    public function videos_delete()
    {
        $id = input('video_id');
        if (!Video::get(['video_id'=>$id,'user_id'=>input('user_id')]))  return $this->cjson(1,'未找到该视频！');
        if (Video::destroy($id)) {
            return $this->cjson(0,'删除成功');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 评论搜索
     */
    public function comment_search(){
        $user_id = input('user_id');
        $video_id = input('video_id');

        $where = "1 = 1";
        if ($user_id)  $where .= " and u.user_id = {$user_id}";
        if ($video_id) $where .= " and v.video_id = {$video_id}";

        $videoComment = new VideoComment();
        $list = $videoComment->get_comment($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $videoComment->get_comment_count($where);

        return $this->cjson(0,'获取成功',$data);
    }

    /**
     * 评论添加
     */
    public function comment_add()
    {
        $user_id = input('user_id');
        $video_id = input('video_id');
        $parent_id = input('parent_id');
        $content = input('content');

        $video = new Video();
        $videoComment = new VideoComment();

        $check = $video->get_video("video_id = '{$video_id}'",1);
        if (count($check)<=0) return $this->cjson(1,'找不到相应视频！');

        $data = [
            'user_id' => $user_id,
            'video_id' => $video_id,
            'parent_id' => $parent_id,
            'content' => $content,
            'add_time' => date('Y-m-d H:i:s')
        ];

        if ($videoComment->save($data)) {
            return $this->cjson(0,'添加成功');
        } else {
            return $this->cjson(1,'添加失败');
        }
    }

    /**
     * 评论修改
     */
    public function comment_edit()
    {
        $id = input('comment_id');

        $data = [
            'content'  => input('content'),
        ];

        if (!$data['content']) return $this->cjson(1,'评论内容不能为空！');

        $videoComment = new VideoComment();
        if (!$videoComment->get(['id'=>$id,'user_id'=>input('user_id')]))  return $this->cjson(1,'未找到该评论！');

        $result = $videoComment->save($data,['id' => $id]);

        if ($result) {
            return $this->cjson(0,'删除成功');
        } else {
            return $this->cjson(1,'修改失败');
        }
    }

    /**
     * 评论删除
     */
    public function comment_delete()
    {
        $id = input('comment_id');
        if (!VideoComment::get(['id'=>$id,'user_id'=>input('user_id')]))  return $this->cjson(1,'未找到该评论！');
        if (VideoComment::destroy($id)) {
            return $this->cjson(0,'删除成功');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }
}