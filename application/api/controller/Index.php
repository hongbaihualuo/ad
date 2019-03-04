<?php
namespace app\api\contronller;


use app\api\model\Ad;
use app\api\model\AdType;

class Index{
    public function get_ad()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');

        $type_id = input('id');

        $ad = new Ad();
        $adType = new AdType();

        $dataType = $adType->get($type_id);
        $datalist = $ad->get_ad("ad_type = {$type_id}",1000);

        $result = ['code'=>0,'msg'=>'','data'=>''];

        $rand_keys = array_rand($datalist, 1);
        $dataAd = $datalist[$rand_keys[0]];

        $dataType['templet_content'] = str_replace('{img}',$dataAd['ad_img'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{link}',$dataAd['ad_link'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{title}',$dataAd['ad_title'],$dataType['templet_content']);
        $dataType['templet_content'] = str_replace('{desc}',$dataAd['ad_desc'],$dataType['templet_content']);

        $result['data'] = $dataType;
        die(json_encode($result));
    }
}