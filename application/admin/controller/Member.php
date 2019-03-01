<?php
namespace app\admin\controller;


use app\admin\model\User;
use app\admin\model\UserType;
use app\admin\service\MemberService;

class Member extends Common{

    /**
     * 会员列表页 （service层）
     * @return mixed
     */
    public function member(){
        $smember = new MemberService();
        $data = $smember->member_search();

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 添加会员 （model层）
     */
    public function member_add(){

        if (request()->isAjax()) {
            $smember = new MemberService();
            $data = $smember->member_save();
            die($data);
        }
        $userType = new UserType();
        $this->assign('type',$userType->get_type());
        return $this->fetch();
    }

    /**
     * 修改会员 （service层）
     */
    public function member_edit(){

        if (request()->isAjax()) {
            $smember = new MemberService();
            if (input('onoff')) {
                $data = $smember->member_onoff();
            } else {
                $data = $smember->member_save();
            }
            die($data);
        }

        $id = input('id');

        $user = new User();
        $userType = new UserType();

        $detail = $user->get_user("a.user_id = {$id}",1);
        if (count($detail)<=0)$this->error('未找到相应用户');

        $this->assign('detail',$detail[0]);
        $this->assign('type',$userType->get_type());
        return $this->fetch();
    }

    /**
     * 删除会员 （service层）
     */
    public function member_delete()
    {
        $smember = new MemberService();
        $data = $smember->member_delete();
        die($data);
    }

    /**
     * 会员类型
     */
    public function type()
    {
        $userType = new UserType();
        $list = $userType->get_all_type();

        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
    }

    /**
     * 会员类型添加
     */
    public function type_add()
    {
        if (request()->isAjax()) {
            $smember = new MemberService();
            $data = $smember->type_save();
            die($data);
        }
        return $this->fetch();
    }

    /**
     * 会员类型修改
     */
    public function type_edit()
    {
        if (request()->isAjax()) {
            $smember = new MemberService();
            $data = $smember->type_save();
            die($data);
        }

        $id = input('id');
        if(!is_numeric($id)) $this->error("ID错误");

        $detail = UserType::get($id);
        $this->assign('detail',$detail);
        return $this->fetch();
    }

    /**
     * 会员类型删除
     */
    public function type_delete()
    {
        $smember = new MemberService();
        $data = $smember->type_delete();
        die($data);
    }
}