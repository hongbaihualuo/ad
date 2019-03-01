<?php
namespace app\admin\controller;


use app\admin\service\AdService;

class Advert extends Common{

    /**
     * 广告列表
     */
    public function ad()
    {
        $sad = new AdService();
        $data = $sad->ad_search();

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 添加广告
     */
    public function ad_add()
    {
        if (request()->isAjax()) {
            $sad = new AdService();
            $data = $sad->ad_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 修改广告
     */
    public function ad_edit()
    {
        if (request()->isAjax()) {
            $sad = new AdService();
            if (input('onoff')){
                $data = $sad->ad_onoff();
            } else {
                $data = $sad->ad_save();
            }
            die($data);
        }

        return $this->fetch();
    }

    /**
     * 删除广告
     */
    public function ad_delete()
    {
        $sad = new AdService();
        $data = $sad->ad_delete();
        die($data);
    }

    /**
     * 广告类型
     */
    public function type()
    {
        $sad = new AdService();
        $data = $sad->type_search();

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 类型添加
     */
    public function type_add()
    {
        if (request()->isAjax()) {
            $sad = new AdService();
            $data = $sad->type_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 类型修改
     */
    public function type_edit()
    {
        if (request()->isAjax()) {
            $sad = new AdService();
            $data = $sad->type_save();
            die($data);
        }

        return $this->fetch();
    }

    /**
     * 类型删除
     */
    public function type_delete()
    {
        $sad = new AdService();
        $data = $sad->type_delete();
        die($data);
    }

    /**
     * 模板
     */
    public function templet()
    {
        $sad = new AdService();
        $data = $sad->templet_search();

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 模板修改
     */
    public function templet_edit()
    {
        $sad = new AdService();
        $data = $sad->templet_save();
        die($data);
    }
}