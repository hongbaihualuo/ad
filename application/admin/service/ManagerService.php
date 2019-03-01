<?php
namespace app\admin\service;


use app\admin\model\Manage;
use app\admin\model\ManageGroup;
use app\admin\model\ManageLog;
use think\image\Exception;

class ManagerService extends Common {

    /**
     * 管理员搜索列表
     */
    public function manager_search(){

        $search['account'] = input('account');
        $search['realname'] = input('realname');

        $where = '1 = 1';
        if ($search['account']) $where .= " and a.manage = '{$search['account']}'";
        if ($search['realname']) $where .= " and a.real_name = '{$search['realname']}'";

        $manage = new Manage();
        $list = $manage->get_manager($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $manage->get_manager_count($where);
        $data['search'] = $search;

        return $data;
    }

    /**
     * 管理员设置
     * @return string
     */
    public function manager_save(){
        $id = input('id');

        $data = [
            'manage'  => input('account'),
            'manage_group_id'  => input('group'),
            'real_name'  => input('name'),
            'status'  => input('status') == 0 ? input('status') : 1
        ];

        if (!$data['manage'] ) return $this->cjson(1,'账号不能为空！');
        if (!is_numeric($data['manage_group_id']) ) return $this->cjson(1,'组别错误！');
        if (!$id && input('cpassword') != input('password')) return $this->cjson(1,'两次密码输入不一致！');


        $mange = new Manage();
        $check_manage = $mange->get_manager("manage = '{$data['manage']}'",1);
        if (!$id && count($check_manage)>0 ) return $this->cjson(1,'此账号已存在！');

        if ( input('password') ) $data['password'] = password_hash(input('password'), PASSWORD_DEFAULT);
        if($id){
            if ( $data['status'] == 0 ) {
                $check = ManageGroup::get($data['manage_group_id']);
                if ($check['status'] == 1) return $this->cjson(1,'所在组别已停用，请先启用对应组别！');
            }
            if ($mange->save($data,['manage_id' => $id])) {
                $this->add_log(2,'管理员信息修改',"修改了{$data['manage']}的信息");
                return $this->cjson(0,'');
            }
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            if ($mange->save($data)) {
                $this->add_log(1,'添加管理员',"添加了{$data['manage']}管理员");
                return $this->cjson(0,'');
            }
        }
        return $this->cjson(1,'执行失败');

    }

    /**
     * 管理员状态切换
     */
    public function manage_onoff()
    {
        $id = input('id');
        $status = input('status') == 0 ? input('status') : 1;
        $manage = new Manage();
        if ($status == 0) {
            $data = $manage->get($id);
            $check = ManageGroup::get($data['manage_group_id']);
            if ($check['status'] == 1) return $this->cjson(1,'所在组别已停用，请先启用对应组别！');
        }

        if($manage->save(['status'=>$status],['manage_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 管理员删除
     */
    public function manager_delete()
    {
        $id = input('id/a');
        if($id == 1) return $this->cjson(1,'初始管理员禁止删除');
        $check = Manage::get($id);
        if (isset($check['manage']))  return $this->cjson(1,'未找到该管理员');

        if (Manage::destroy($id)) {
            $this->add_log(3,'删除管理员',"删除了管理员{$check['manage']}");
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * 管理组设置
     * @return string
     */
    public function group_save(){
        $id = input('id');

        $data = [
            'manage_group_name'  => input('name'),
            'manage_group_desc'  => input('desc'),
            'status'  => input('status') == 0 ? input('status') : 1
        ];

        if (!$data['manage_group_name'] ) return $this->cjson(1,'组名不能为空！');
        if($id == 1 && $data['status'] == 1) return $this->cjson(1,'基础管理组禁止关闭');

        $mange = new Manage();
        $mangeGroup = new ManageGroup();

        if($id){
            $mange->startTrans();
            $mangeGroup->startTrans();
            try{
                $mange->save(['status'=>$data['status']],['manage_group_id'=>$id]);
                $mangeGroup->save($data,['manage_group_id' => $id]);
                $mange->commit();
                $mangeGroup->commit();
                $result = true;
            }catch(Exception $e){
                $mange->rollback();
                $mangeGroup->rollback();
                $result = false;
            }
            if ($result) {
                $this->add_log(2,'修改管理组',"修改的管理组为：".$data['manage_group_name']);
                return $this->cjson(0,'');
            }
        } else {
            if ($mangeGroup->save($data)) {
                $this->add_log(1,'添加管理组',"添加的管理组为：".$data['manage_group_name']);
                return $this->cjson(0,'');
            };
        }
        return $this->cjson(1,'执行失败');

    }

    /**
     * 管理员删除
     */
    public function group_delete()
    {
        $id = input('id');
        if($id == 1) return $this->cjson(1,'基础管理组禁止删除');

        $mange = new Manage();
        $mangeGroup = new ManageGroup();

        $check = $mangeGroup->get($id);

        $mange->startTrans();
        $mangeGroup->startTrans();
        try{
            $mange->where(['manage_group_id'=>$id])->delete();
            $mangeGroup->where(['manage_group_id'=>$id])->delete();
            $mange->commit();
            $mangeGroup->commit();
            $result = true;
        }catch(Exception $e){
            $mange->rollback();
            $mangeGroup->rollback();
            $result = false;
        }

        if ($result) {
            $this->add_log(3,'删除管理组',"删除的管理组为：".$check['manage_group_name']);
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * 管理组权限设置
     */
    public function group_right_save(){

        $id = input('id');
        $right = input('right/a');

        $mangeGroup = new ManageGroup();

        $data = [
            'manage_group_right'=>implode(',',$right)
        ];

        if ($mangeGroup->save($data,['manage_group_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'设置失败');
        }
    }

    /**
     * 管理员日志搜索列表
     */
    public function log_search(){

        $search['account'] = input('account');
        $search['realname'] = input('realname');
        $search['start'] = input('start');
        $search['end'] = input('end');
        $search['type'] = input('type');

        $where = '1 = 1';
        if ($search['account']) $where .= " and m.manage = '{$search['account']}'";
        if ($search['realname']) $where .= " and m.real_name = '{$search['realname']}'";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";
        if (is_numeric($search['type'])) $where .= " and a.type = '{$search['type']}'";

        $manageLog = new ManageLog();
        $list = $manageLog->get_log($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $manageLog->get_log_count($where);
        $data['search'] = $search;

        return $data;
    }
}
