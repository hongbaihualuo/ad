<?php
namespace app\admin\controller;


use app\admin\model\Ad;
use app\admin\model\AdTemplet;
use app\admin\model\AdType;
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
        $adType = new AdType();
        $typeList = $adType->get_type('status = 0',200);

        $this->assign('type',$typeList);
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

        $id = input('id');

        $ad = new Ad();
        $adType = new AdType();
        $adDate = $ad->get_ad("ad_id = {$id}",1);
        if (count($adDate)<=0) $this->error('未找到该广告！');


        $typeList = $adType->get_type('status = 0',200);

        $this->assign('type',$typeList);
        $this->assign('detail',$adDate[0]);
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

        $adTemplet = new AdTemplet();
        $templetList = $adTemplet->get_templet('',200);

        $this->assign('templet',$templetList);
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

        $id = input('id');

        $adType = new AdType();
        $adTemplet = new AdTemplet();
        $adType = $adType->get_type("type_id = {$id}",1);
        if (count($adType)<=0) $this->error('未找到该广告！');

        $templetList = $adTemplet->get_templet('',200);

        $this->assign('templet',$templetList);
        $this->assign('detail',$adType[0]);
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

        if (request()->isAjax()) {
            $sad = new AdService();
            $data = $sad->templet_save();
            die($data);
        }

        $id = input('id');

        $adTemplet = new AdTemplet();

        $date = $adTemplet->get_templet("templet_id = {$id}",1);
        if (count($date)<=0) $this->error('未找到该广告！');

        $this->assign('detail',$date[0]);
        return $this->fetch();
    }
}