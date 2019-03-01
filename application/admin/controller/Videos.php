<?php
namespace app\admin\controller;

use app\admin\model\CommentTemplet;
use app\admin\model\Video;
use app\admin\model\VideoComment;
use app\admin\service\FileService;
use app\admin\service\VideoService;

class Videos extends Common{

    /**
     * 视频列表页 （service层）
     * @return mixed
     */
    public function videos(){
        $svideos = new VideoService();
        $data = $svideos->videos_search();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 添加视频 （model层）
     */
    public function videos_add(){

        if (request()->isAjax()) {
            $svideos = new VideoService();
            $data = $svideos->videos_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 修改视频 （service层）
     */
    public function videos_edit(){

        if (request()->isAjax()) {
            $svideos = new VideoService();
            if (input('onoff')) {
                $data = $svideos->videos_onoff();
            } else {
                $data = $svideos->videos_save();
            }
            die($data);
        }

        $id = input('id');

        $video = new Video();

        $detail = $video->get_video("a.video_id = {$id}",1);
        if (count($detail)<=0)$this->error('未找到相应视频');

        $this->assign('detail',$detail[0]);
        return $this->fetch();
    }

    /**
     * 视屏上传
     */
    public function upload_video()
    {
        $sfile = new FileService();
        $data = $sfile->upload_video_one();
        die($data);
    }

    /**
     * 删除视频 （service层）
     */
    public function videos_delete()
    {
        $svideos = new VideoService();
        $data = $svideos->video_delete();
        die($data);
    }

    /**
     * 评论列表页 （service层）
     * @return mixed
     */
    public function comment(){
        $svideos = new VideoService();
        $data = $svideos->comment_search();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 添加评论 （model层）
     */
    public function comment_add(){

        if (request()->isAjax()) {
            $svideos = new VideoService();
            $data = $svideos->comment_add();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 修改评论 （service层）
     */
    public function comment_edit(){

        if (request()->isAjax()) {
            $svideos = new VideoService();
            $data = $svideos->comment_edit();
            die($data);
        }

        $id = input('id');

        $videoComment = new VideoComment();

        $detail = $videoComment->get_Comment("a.id = {$id}",1);
        if (count($detail)<=0)$this->error('未找到相应评论');

        $this->assign('detail',$detail[0]);
        return $this->fetch();
    }

    /**
     * 删除视频 （service层）
     */
    public function comment_delete()
    {
        $svideos = new VideoService();
        $data = $svideos->comment_delete();
        die($data);
    }

    /**
     * 模板列表页
     * @return mixed
     */
    public function templet(){
        $commentTemplet = new CommentTemplet();
        $list = $commentTemplet->get_templet('',10,1);
        $page = $list->render();
        $count = $commentTemplet->get_templet_count('');

        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('count',$count);
        return $this->fetch();
    }

    /**
     * 添加模板
     */
    public function templet_add(){

        if (request()->isAjax()) {
            $svideos = new VideoService();
            $data = $svideos->templet_add();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 删除模板（service层）
     */
    public function templet_delete()
    {
        $svideos = new VideoService();
        $data = $svideos->templet_delete();
        die($data);
    }
}