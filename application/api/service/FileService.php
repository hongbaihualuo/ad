<?php
namespace app\api\service;

use think\image\Exception;
use think\Request;

class FileService extends Common {

    /**
     * 单个图片上传
     * @return string
     */
    public function upload_one(){
        try{
            $file = request()->file('file');// 获取表单提交过来的文件
            if(!is_array($file)) return false;
            $error = $_FILES['file']['error'];
            if($error) return false;

            //上传的时候的原文件名
            $dir = config('upload_path');

            if (!is_dir($dir['img'])) mkdir($dir['img'],0777,true);
            $info = $file->move($dir['img']);

            //获取文件的全路径
            $imgurl = substr(str_replace('\\', '/', $info->getPathname()),1);

            return $imgurl;
        }catch(Exception $e){
            return false;
        }

    }

    /**
     * 单个视频上传
     * @return string
     */
    public function upload_video_one(){
        try{
            $file = request()->file('file');// 获取表单提交过来的文件
            if(!is_array($file)) return false;
            $error = $_FILES['file']['error'];
            if($error) return false;

            //上传的时候的原文件名
            $dir = config('upload_path');

            if (!is_dir($dir['video'])) mkdir($dir['video'],0777,true);
            $info = $file->move($dir['video']);

            //获取文件的全路径
            $imgurl = substr(str_replace('\\', '/', $info->getPathname()),1);

            return $imgurl;
        }catch(Exception $e){
            return false;
        }

    }
}