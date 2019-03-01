<?php
namespace app\admin\service;

use app\admin\model\Carousel;
use app\admin\model\Seo;
use app\admin\model\System;

class SetService extends Common {

    /**
     * 基础设置
     * @return string
     */
    public function base_save(){

        $data = [
            'address'  => input('address'),
            'company'  => input('company'),
            'copyright'  => input('copyright'),
            'desc'  => input('desc'),
            'icp'  => input('icp'),
            'instructions'  => input('instructions'),
            'keywords'  => input('keywords'),
            'title'  => input('title'),
            'email'  => input('webemail'),
            'phone'  => input('webphone'),
            'qq'  => input('webqq'),
            'wechat'  => input('wechat'),
            'about'  => input('about'),
            'domain'  => input('domain')
        ];

        if (!check_phone($data['phone']) && $data['phone']) return $this->cjson(1,'联系电话格式不正确！');
        if (!check_email($data['email']) && $data['email']) return $this->cjson(1,'联系邮箱格式不正确！');

        $system = new System();

        if ($system->save($data,['system_id' => 1])) {
            $this->add_log(2,'基础设置',"基础设置");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'更新失败');
        }
    }

    /**
     * 轮播图设置
     * @return string
     */
    public function carousel_save(){
        $id = input('id');

        $data = [
            'carousel_title'  => input('title'),
            'carousel_desc'  => input('desc'),
            'carousel_img'  => input('img'),
            'carousel_url'  => input('banner_url'),
            'is_show'  => input('is_show')==0? input('is_show'):1,
            'carousel_type'  => input('type'),
            'orderby'  => input('orderby')
        ];

        if (!$data['carousel_title'] ) return $this->cjson(1,'名称不能为空！');
        if (!$data['carousel_img'] ) return $this->cjson(1,'轮播图不能为空！');
        if (!is_numeric($data['carousel_type']) || $data['carousel_type']>2 ) return $this->cjson(1,'类型错误！');

        $carousel = new Carousel();

        if($id){
            $result = $carousel->save($data,['carousel_id' => $id]);
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            $result = $carousel->save($data);
        }

        if ($result) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }

    }

    /**
     * 轮播图状态切换
     */
    public function carousel_onoff()
    {
        $id = input('id');
        $show = input('status') == 0?input('status'):1;
        $carousel = new Carousel();

        if($carousel->save(['is_show'=>$show],['carousel_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 轮播图批量删除
     */
    public function carousel_delete()
    {
        $id = input('id/a');

        if (Carousel::destroy($id)) {
            $this->add_log(3,'轮播图删除',"删除轮播图");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * seo设置
     * @return string
     */
    public function seo_save(){
        $id = input('id');

        $data = [
            'seo_name'  => input('name'),
            'title'  => input('title'),
            'keywords'  => input('keywords'),
            'desc'  => input('desc'),
            'controller'  => input('controller'),
            'action'  => input('action')
        ];

        if (!$data['seo_name'] ) return $this->cjson(1,'seo名称不能为空！');
        if (!$data['title'] ) return $this->cjson(1,'title不能为空！');
        if (!$data['controller'] ) return $this->cjson(1,'控制器不能为空！');
        if (!$data['action'] ) return $this->cjson(1,'方法名不能为空！');

        $seo = new Seo();

        if($id){
            $result = $seo->save($data,['seo_id' => $id]);
        } else {
            $result = $seo->save($data);
        }

        if ($result) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }

    }

    /**
     * seo批量删除
     */
    public function seo_delete()
    {
        $id = input('id/a');
        if (Seo::destroy($id)) {
            $this->add_log(3,'seo删除',"删除seo信息");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'删除失败');
        }
    }
}