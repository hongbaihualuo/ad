<?php
namespace app\admin\model;
use think\Model;

class Menu extends Model{

    /**
     * 获取栏目列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_all_menu($where = "is_show = 0"){
        $list = $this->where("parent_id = 0 and status = 0")->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]['child'] = $this->where("parent_id = {$v['menu_id']}")->where($where)->select();
            $list[$k]['url'] = 'javascript:;';
            if(count($list[$k]['child'])>0){
                $child = $list[$k]['child'];
                foreach ( $child as $ke => $va) {
                    $child[$ke]['url'] = url($va['controller']."/".$va['action']);
                    $child[$ke]['child'] = $this->where("parent_id = {$va['menu_id']}")->where($where)->select();
                    if(count($child[$ke]['child'])>0) $child[$ke]['url'] = 'javascript:;';
                }
            }
        }
        return $list;
    }

    /**
     * 获取单个menu
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_menu($where='',$num=6,$page=0,$field='*')
    {
        $this->field($field)->alias('a')
            ->where('status = 0')->where($where)->order('a.menu_id desc');

        if (!$page) {
            $list = $this->limit($num)->select();
        } else {
            $list = $this->paginate($num,false,['query'=>$_REQUEST]);
        }

        return $list;
    }

}
