<?php
namespace app\admin\service;

use app\admin\model\Ad;
use app\admin\model\AdTemplet;
use app\admin\model\AdType;
use app\admin\model\System;
use think\image\Exception;

class AdService extends Common {

    /**
     * 广告搜索列表
     */
    public function ad_search(){

        $search['name'] = input('name');
        $search['start'] = input('start');
        $search['end'] = input('end');

        $where = '1 = 1';
        if ($search['name']) $where .= " and a.ad_name like '%{$search['title']}%'";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";

        $ad = new Ad();
        $list = $ad->get_ad($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $ad->get_ad_count($where);
        $data['search'] = $search;

        return $data;
    }

    /**
     * 广告添加修改
     */
    public function ad_save()
    {
        $id = input('id');

        $data = [
            'ad_type' => input('type'),
            'ad_img' => input('img'),
            'ad_name' => input('name'),
            'ad_title' => input('title'),
            'ad_desc' => input('desc'),
            'ad_link' => input('link'),
            'add_time' => date('Y-m-d H:i:s'),
            'status'   => input('status') == 0 ? input('status') : 1
        ];

        if (!is_numeric($data['ad_type'])) $this->cjson(1,'广告类型不正确！');
        if ($data['ad_img']) $this->cjson(1,'广告图片不能为空！');
        if (!$data['ad_name']) $this->cjson(1,'广告名称不能为空！');

        $ad = new Ad();
        if ($id) {
            if ($data['status'] == 0) {
                $odata = $ad->get($id);
                $check = AdType::get($odata['ad_type']);
                if ($check['status'] == 1) return $this->cjson(1,'所在类型已停用，请先启用对应类型！');
            }
            $result = $ad->save($data,['ad_id'=>$id]);
            $this->add_log(2,'修改广告',"修改广告");
        } else {
            $result = $ad->save($data);
            $this->add_log(1,'添加广告',"添加广告");
        }

        if ($result) {
            return $this->cjson(0,'执行成功！');
        } else {
            return $this->cjson(1,'执行出错！');
        }
    }

    /**
     * 广告状态切换
     */
    public function ad_onoff()
    {
        $id = input('id');
        $status = input('status') == 0 ? input('status') : 1;
        $ad = new Ad();

        if ($status == 0) {
            $data = $ad->get($id);
            $check = AdType::get($data['ad_type']);
            if ($check['status'] == 1) return $this->cjson(1,'所在类型已停用，请先启用对应类型！');
        }

        if($ad->save(['status'=>$status],['ad_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 广告删除
     */
    public function ad_delete()
    {
        $id = input('id/a');

        $str = implode(',',$id);

        $ad = new Ad();

        try{
            $ad->where("ad_id in ({$str})")->delete();
            $this->add_log(3,'删除广告',"删除广告");
            return $this->cjson(0,'');
        }catch(Exception $e){
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * 类型搜索列表
     */
    public function type_search(){

        $search['name'] = input('name');

        $where = '1 = 1';
        if ($search['name']) $where .= " and a.type_name like '%{$search['name']}%'";

        $adType = new AdType();
        $list = $adType->get_type($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $adType->get_type_count($where);
        $data['search'] = $search;

        return $data;
    }

    /**
     * 广告类型修改
     */
    public function type_save()
    {
        $id = input('id');

        $data = [
            'type_name' => input('name'),
            'link' => input('link'),
            'status'   => input('status') == 0 ? input('status') : 1
        ];

        if (!$data['type_name']) $this->cjson(1,'链接名不能为空！');
        if (!$data['link']) $this->cjson(1,'链接名不能为空！');

        $ad = new Ad();
        $adType = new AdType();

        if ($id) {
            $data['templet_content'] = input('content');
            $ad->startTrans();
            $adType->startTrans();
            try{
                $ad->save(['status'=>$data['status']],['ad_type'=>$id]);
                $adType->save($data,['type_id'=>$id]);
                $ad->commit();
                $adType->commit();
                $this->add_log(2,'修改类型',"修改类型");
                return $this->cjson(0,'');
            }catch(Exception $e){
                $ad->rollback();
                $adType->rollback();
                return $this->cjson(1,'修改失败');
            }

        } else {
            $data['templet_id'] = input('templet');
            $check = AdTemplet::get(['templet_id'=>$data['templet_id']]);
            if (!$check) $this->cjson(1,'未找到对应分类！');

            $data['templet_content'] = $check['content'];

            $adType->startTrans();

            $sys = System::get(1);
            try{
                $adType->save($data);
                $id = $adType->getLastInsID();
                $js = '<script type="text/javascript" ad-data-type="ad" ad-data-id="'.$id.'" src="http://'.$sys['domain'].'/static/ad.js"></script>';
                $adType->save(['type_js'=>$js],['type_id'=>$id]);
                $adType->commit();
                $this->add_log(1,'添加类型',"添加类型");
                return $this->cjson(0,'执行成功！');
            }catch(Exception $e){
                $adType->rollback();
                return $this->cjson(1,'执行出错！');
            }

        }
    }

    /**
     * 类型删除
     */
    public function type_delete()
    {
        $id = input('id/a');

        $str = implode(',',$id);

        $ad = new Ad();
        $adType = new AdType();

        $ad->startTrans();
        $adType->startTrans();

        try{
            $ad->where("ad_type in ({$str})")->delete();
            $adType->where("type_id in ({$str})")->delete();
            $ad->commit();
            $adType->commit();
            $this->add_log(3,'删除类型',"删除类型");
            return $this->cjson(0,'');
        }catch(Exception $e){
            $ad->rollback();
            $adType->rollback();
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * 模板搜索列表
     */
    public function templet_search(){

        $adTemplet = new AdTemplet();
        $list = $adTemplet->get_templet('',10,1);

        $data['list'] = $list;
        $data['count'] = $adTemplet->get_templet_count('');

        return $data;
    }

    /**
     * 广告模板修改
     */
    public function templet_save()
    {
        $id = input('id');

        $data = [
            'content' => input('content'),
        ];

        if (!$data['content']) $this->cjson(1,'内容不能为空！');

        $adTemplet = new AdTemplet();

        if ($adTemplet->save($data,['templet_id'=>$id])){
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'修改失败！');
        }
    }
}