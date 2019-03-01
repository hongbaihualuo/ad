<?php
namespace app\admin\controller;

use app\admin\model\Menu;
use think\cache\driver\Redis;
use think\Session;

class Index extends Common{

    /**
     * 首页 （基层）
     */
    public function index()
    {

        $redis = new Redis();
        $menu = new Menu();

        //if(!$redis->get('menulist') )
        $redis->set('menuList',$menu->get_all_menu());

        $this->assign('manage',Session::get('manage'));
        $this->assign('right',Session::get('right'));
        $this->assign('menuList',$redis->get('menuList'));
        return $this->fetch();
    }

    /**
     * 内嵌首页
     */
    public function welcome()
    {
        return $this->fetch();
    }
}