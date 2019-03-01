<?php
namespace app\admin\service;


use app\admin\model\User;
use app\admin\model\UserInfo;
use app\admin\model\UserType;
use app\api\model\Video;
use think\image\Exception;

class MemberService extends Common
{
    /**
     * 用户列表页搜索
     * @return string
     */
    public function member_search()
    {
        $search['account'] = input('account');
        $search['type'] = input('type');
        $search['start'] = input('start');
        $search['end'] = input('end');

        $where = '1 = 1';
        if ($search['account']) $where .= " and a.username like '%{$search['account']}%'";
        if (is_numeric($search['type'])) $where .= " and a.user_type = {$search['type']}";
        if ($search['start']) $where .= " and a.add_time > '{$search['start']}'";
        if ($search['end']) $where .= " and a.add_time <= '{$search['end']}'";

        $user = new User();
        $userType = new UserType();
        $list = $user->get_user($where,10,1);

        $data['list'] = $list;
        $data['page'] = $list->render();
        $data['count'] = $user->get_user_count($where);
        $data['search'] = $search;
        $data['type'] = $userType->get_type();

        return $data;
    }

    /**
     * 用户添加修改逻辑处理
     */
    public function member_save()
    {
        $id = input('id');

        $data = [
            'username'  => input('account'),
            'user_type'  => input('type'),
            'nickname'  => input('nickname'),
            'mobile'  => input('mobile'),
            'money'  => input('money'),
            'score'  => input('score'),
            'status'  => input('status') == 0 ? input('status') : 1,
            'is_robot' => input('is_robot') == 0 ? input('is_robot') : 1
        ];

        if (!$data['mobile'] ) return $this->cjson(1,'手机号不能为空！');
        if (!is_numeric($data['user_type']) ) return $this->cjson(1,'类型错误！');
        if (!$id && input('cpassword') != input('password')) return $this->cjson(1,'两次密码输入不一致！');


        $user = new User();
        $userInfo = new UserInfo();

        $check_user = $user->get_user("mobile = '{$data['mobile']}'",1);
        if (!$id && count($check_user)>0 ) return $this->cjson(1,'手机号已存在！');
        if ( input('password') ) $data['password'] = password_hash(input('password'), PASSWORD_DEFAULT);


        $user->startTrans();
        $userInfo->startTrans();

        try{
            if($id){
                if ( $data['status'] == 0 ) {
                    $check = UserType::get($data['user_type']);
                    if ($check['status'] == 1) {
                        $user->rollback();
                        $userInfo->rollback();
                        return $this->cjson(1,'所在类型已停用，请先启用对应类型！');
                    }
                }
                $dataInfo = [
                    'sex'=>input('sex'),
                    'sign'=>input('sign'),
                    'like'=>input('like'),
                    'real_name'=>input('real_name'),
                    'recom_code'=>input('recom_code'),
                    'reg_type'=>input('reg_type'),
                    'source'=>input('source')
                ];

                $user->save($data,['user_id' => $id]);
                $userInfo->save($dataInfo,['user_id' => $id]);
                $user->commit();
                $userInfo->commit();
                $this->add_log(2,'管理员信息修改',"修改了{$data['username']}的信息");
                return $this->cjson(0,'');

            } else {
                $data['add_time'] = date('Y-m-d H:i:s');
                $data['add_ip'] = request()->ip();
                $data['last_time'] = date('Y-m-d H:i:s');
                $data['last_ip'] = request()->ip();
                $user->save($data);
                $userInfo->save(['user_id'=>$user->getLastInsID()]);
                $user->commit();
                $userInfo->commit();
                $this->add_log(1,'添加用户',"添加了{$data['username']}用户");
                return $this->cjson(0,'');
            }
        }catch(Exception $e){
            $user->rollback();
            $userInfo->rollback();
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 用户状态切换
     */
    public function member_onoff()
    {
        $id = input('id');
        $status = input('status') == 0 ? input('status') : 1;
        $user = new User();

        if ($status == 0) {
            $data = $user->get($id);
            $check = UserType::get($data['user_type']);
            if ($check['status'] == 1) return $this->cjson(1,'所在类型已停用，请先启用对应类型！');
        }

        if($user->save(['status'=>$status],['user_id'=>$id])) {
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'执行失败');
        }
    }

    /**
     * 用户删除
     */
    public function member_delete()
    {
        $id = input('id/a');

        $str = implode(',',$id);

        $user = new User();
        $userInfo = new UserInfo();

        $user->startTrans();
        $userInfo->startTrans();

        try{
            $user->where("user_id in ({$str})")->delete();
            $userInfo->where("user_id in ({$str})")->delete();
            $user->commit();
            $userInfo->commit();
            $this->add_log(3,'删除用户',"删除用户");
            return $this->cjson(0,'');
        }catch(Exception $e){
            $user->rollback();
            $userInfo->rollback();
            return $this->cjson(1,'删除失败');
        }
    }

    /**
     * 用户类型设置
     */
    public function type_save()
    {
        $id = input('id');

        $data = [
            'type_name'  => input('name'),
            'desc'  => input('desc'),
            'status'  => input('status') == 0 ? input('status') : 1
        ];

        if (!$data['type_name'] ) return $this->cjson(1,'组名不能为空！');

        $user = new User();
        $userType = new UserType();

        if($id){
            $user->startTrans();
            $userType->startTrans();
            try{
                $user->save(['status'=>$data['status']],['user_type'=>$id]);
                $userType->save($data,['user_type_id' => $id]);
                $user->commit();
                $userType->commit();
                $result = true;
            }catch(Exception $e){
                $user->rollback();
                $userType->rollback();
                $result = false;
            }
            if ($result) {
                $this->add_log(2,'修改用户类型',"修改的用户类型为：".$data['type_name']);
                return $this->cjson(0,'');
            }
        } else {
            if ($userType->save($data)) {
                $this->add_log(1,'添加用户类型',"添加的用户类型为：".$data['type_name']);
                return $this->cjson(0,'');
            };
        }
        return $this->cjson(1,'执行失败');
    }

    /**
     * 删除用户类型
     */
    public function type_delete()
    {
        $id = input('id');

        $user = new User();
        $userType = new UserType();

        $check = $userType->get($id);

        $user->startTrans();
        $userType->startTrans();
        try{
            $user->where(['user_type'=>$id])->delete();
            $userType->where(['user_type_id'=>$id])->delete();
            $user->commit();
            $userType->commit();
            $result = true;
        }catch(Exception $e){
            $user->rollback();
            $userType->rollback();
            $result = false;
        }

        if ($result) {
            $this->add_log(3,'删除用户类型',"删除的用户类型为：".$check['type_name']);
            return $this->cjson(0,'');
        } else {
            return $this->cjson(1,'删除失败');
        }
    }
}