<?php
namespace app\admin\controller;

use app\admin\model\Manage;
use app\admin\model\ManageGroup;
use app\admin\model\Menu;
use app\admin\service\ManagerService;
use think\cache\driver\Redis;

class Manager extends Common
{
    /**
     * 管理员列表 （model层）
     */
    public function manager()
    {

        $smanage = new ManagerService();

        $this->assign('data', $smanage->manager_search());
        return $this->fetch();
    }

    /**
     * 添加管理员页面 (基层)
     */
    public function manager_add()
    {
        if (request()->isAjax()) {
            $smanager = new ManagerService();
            $data = $smanager->manager_save();
            die($data);
        }
        $manageGroup = new ManageGroup();
        $group = $manageGroup->get_group('a.status = 0', 100);

        $this->assign('group', $group);
        return $this->fetch();
    }

    /**
     * 修改管理员页面 (基层)
     */
    public function manager_edit()
    {
        if (request()->isAjax()) {
            $smanager = new ManagerService();
            if (input('onoff')) {
                $data = $smanager->manage_onoff();
            } else {
                $data = $smanager->manager_save();
            }

            die($data);
        }

        $id = input('id');
        $data = Manage::get($id);
        if (!$data) $this->error('ID错误');

        $manageGroup = new ManageGroup();
        $group = $manageGroup->get_group('a.status = 0', 100);

        $this->assign('group', $group);
        $this->assign('detail', $data);
        return $this->fetch();
    }

    /**
     * 管理员删除 (service层)
     */
    public function manager_delete()
    {
        $smanager = new ManagerService();
        $data = $smanager->manager_delete();
        die($data);
    }

    /**
     * 管理组列表 （model层）
     */
    public function group()
    {

        $manageGroup = new ManageGroup();
        $list = $manageGroup->get_group('', 10, 1);
        $page = $list->render();
        $count = $manageGroup->get_group_count();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);

        return $this->fetch();
    }

    /**
     * 添加管理组页面 (基层)
     */
    public function group_add()
    {
        if (request()->isAjax()) {
            $smanager = new ManagerService();
            $data = $smanager->group_save();
            die($data);
        }
        $manageGroup = new ManageGroup();
        $group = $manageGroup->get_group('a.status = 0', 100);

        $this->assign('group', $group);
        return $this->fetch();
    }

    /**
     * 修改管理组页面 (基层)
     */
    public function group_edit()
    {
        if (request()->isAjax()) {
            $smanager = new ManagerService();
            $data = $smanager->group_save();
            die($data);
        }

        $id = input('id');
        $manageGroup = new ManageGroup();

        $data = $manageGroup->get($id);
        if (!$data) $this->error('ID错误');
        $group = $manageGroup->get_group('a.status = 0', 100);

        $this->assign('group', $group);
        $this->assign('detail', $data);
        return $this->fetch();
    }

    /**
     * 管理组权限设置（model层）
     */
    public function group_right()
    {
        $id = input('id');
        $redis = new Redis();
        $menu = new Menu();
        $manageGroup = new ManageGroup();

        $data = $manageGroup->get($id);
        if (!$data) $this->error('ID错误');

        //if(!$redis->get('menuAllList') )
        $redis->set('menuAllList',$menu->get_all_menu(''));

        $this->assign('id',$id);
        $this->assign('right',explode(',',$data['manage_group_right']));
        $this->assign('menuList',$redis->get('menuAllList'));
        return $this->fetch();
    }

    /**
     * 管理组权限添加，修改逻辑（service层）
     */
    public function group_right_change()
    {
        $smanager = new ManagerService();
        $data = $smanager->group_right_save();
        die($data);
    }

    /**
     * 管理组删除 (service层)
     */
    public function group_delete()
    {
        $smanager = new ManagerService();
        $data = $smanager->group_delete();
        die($data);
    }

    /**
     * 管理员日志 （model层）
     */
    public function log()
    {
        $smanage = new ManagerService();

        $this->assign('data', $smanage->log_search());
        return $this->fetch();
    }


}