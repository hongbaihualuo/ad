<?php
namespace app\admin\service;

use think\Request;

class FileService extends Common {

    /**
     * 单个图片上传
     * @return string
     */
    public function upload_one(){

        $file = request()->file('file');// 获取表单提交过来的文件

        $error = $_FILES['file']['error'];
        if($error) $this->cjson(1,'上传失败');

        //上传的时候的原文件名
        $dir = config('upload_path');

        if (!is_dir($dir['img'])) mkdir($dir['img'],0777,true);
        $info = $file->move($dir['img']);

        //获取文件的全路径
        $imgurl = substr(str_replace('\\', '/', $info->getPathname()),1);

        $this->add_log(1,'上传文件',"文件路径:".$imgurl);
        return $this->cjson(0,$imgurl);
    }

    /**
     * 单个视频上传
     * @return string
     */
    public function upload_video_one(){

        $file = request()->file('file');// 获取表单提交过来的文件

        $error = $_FILES['file']['error'];
        if($error) $this->cjson(1,'上传失败');

        //上传的时候的原文件名
        $dir = config('upload_path');

        if (!is_dir($dir['video'])) mkdir($dir['video'],0777,true);
        $info = $file->move($dir['video']);

        //获取文件的全路径
        $imgurl = substr(str_replace('\\', '/', $info->getPathname()),1);

        $this->add_log(1,'上传文件',"文件路径:".$imgurl);
        return $this->cjson(0,$imgurl);
    }
}