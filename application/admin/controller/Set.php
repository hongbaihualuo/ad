<?php
namespace app\admin\controller;

use app\admin\model\Carousel;
use app\admin\model\Seo;
use app\admin\model\System;
use app\admin\service\FileService;
use app\admin\service\SetService;

class Set extends Common
{

    /**
     * 基本信息 (基层)
     */
    public function base()
    {
        $this->assign('system', System::get(1));
        return $this->fetch();
    }

    /**
     * 图片文件上传 （serivce层）
     */
    public function base_upload()
    {
        $sfile = new FileService();
        $data = $sfile->upload_one();
        die($data);
    }

    /**
     * 更新基础设置 （serivce层）
     */
    public function base_change()
    {
        $sset = new SetService();
        $data = $sset->base_save();
        die($data);
    }

    /**
     * 轮播图 （model层）
     */
    public function carousel()
    {
        $carousel = new Carousel();

        $list = $carousel->get_carousel();
        $page = $list->render();
        $count = $carousel->get_carousel_count();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->fetch();
    }

    /**
     * 添加轮播图页面 (基层)
     */
    public function carousel_add()
    {
        if(request()->isAjax()) {
            $sset = new SetService();
            $data = $sset->carousel_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 修改轮播图页面 (基层)
     */
    public function carousel_edit()
    {

        if(request()->isAjax()) {
            $sset = new SetService();
            if(input('onoff')) {
                $data = $sset->carousel_onoff();
            } else {
                $data = $sset->carousel_save();
            }
            die($data);
        }

        $id = input('id');
        $data = Carousel::get($id);
        if (!$data) $this->error('ID错误');

        $this->assign('detail',$data);
        return $this->fetch();
    }

    /**
     * 轮播图删除 (service层)
     */
    public function carousel_delete()
    {
        $sset = new SetService();
        $data = $sset->carousel_delete();
        die($data);
    }

    /**
     * seo （model层）
     */
    public function seo()
    {
        $seo = new Seo();

        $list = $seo->get_seo();
        $page = $list->render();
        $count = $seo->get_seo_count();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->fetch();
    }

    /**
     * 添加seo页面 (基层)
     */
    public function seo_add()
    {
        if (request()->isAjax()) {
            $sset = new SetService();
            $data = $sset->seo_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 修改seo页面 (基层)
     */
    public function seo_edit()
    {
        if (request()->isAjax()) {
            $sset = new SetService();
            $data = $sset->seo_save();
            die($data);
        }
        $id = input('id');
        $data = Seo::get($id);
        if (!$data) $this->error('ID错误');

        $this->assign('detail',$data);
        return $this->fetch();
    }

    /**
     * seo删除 (service层)
     */
    public function seo_delete()
    {
        $sset = new SetService();
        $data = $sset->seo_delete();
        die($data);
    }

}