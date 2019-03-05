<?php
namespace app\api\controller;


use app\admin\model\System;
use app\api\model\Ad;
use app\api\model\AdType;
use think\Controller;

class Index extends Controller{
    public function get_ad()
    {
        header("Content-type:text/html;charset=utf-8");
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');

        $type_id = input('id');
        $result = ['code'=>0,'msg'=>'','data'=>''];

        if (!is_numeric($type_id)) {
            $result['code'] = 1;
            $result['msg'] = 'ID错误';
            die(json_encode($result));
        }

        $ad = new Ad();
        $adType = new AdType();

        $sys = System::get(1);
        $dataType = $adType->get(['type_id'=>$type_id,'status'=>0]);
        $datalist = $ad->get_ad("ad_type = {$type_id} and status = 0",1000);
        if (!$dataType) {
            $result['code'] = 1;
            $result['msg'] = '未找到该广告';
            die(json_encode($result));
        }

        if (count($datalist) <= 0) {
            $result['code'] = 1;
            $result['msg'] = '没有设置广告';
            die(json_encode($result));
        }

        $rand_keys = array_rand($datalist, 1);

        $dataAd = $datalist[$rand_keys];

        $dataType['templet_content'] = str_replace('{img}','http://'.$sys['domain'].$dataAd['ad_img'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{link}',$dataAd['ad_link'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{title}',$dataAd['ad_title'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{desc}',$dataAd['ad_desc'],$dataType['templet_content']);

        $result['data'] = $dataType;
        die(json_encode($result));
    }
}