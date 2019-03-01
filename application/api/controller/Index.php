<?php
namespace app\api\controller;


use app\api\service\VideoService;

class Index
{
    public function video_list()
    {
        $svideo = new VideoService();
        $list = $svideo->videos_search();
        die($list);
    }

    public function video_comment()
    {
        $svideo = new VideoService();
        $list = $svideo->comment_search();
        die($list);
    }
}
