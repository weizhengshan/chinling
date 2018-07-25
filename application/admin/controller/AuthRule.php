<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\AuthRule as A;
class AuthRule  extends Common
{
    //权限展示页
    public function auth_list()
    {
    	$authRule=new A();
		$authRuleRes=$authRule->authRuleTree();
        //halt($authRuleRes);
         //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);

		$this->assign('authRuleRes',$authRuleRes);
    	return $this->fetch();
    }
    //权限增加页
    public function auth_add()
    {
    	$authRule=new A();
		$authRuleRes=$authRule->authRuleTree();
         //导航管理
         $daoh=$this->auth_group();
         $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
		$this->assign('authRuleRes',$authRuleRes);
		if(request()->isPost())
        {
				//halt($_POST);
				$auth=new A();
                $res=$auth->auth_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
		}
    	return $this->fetch();
    }
    //修改权限
    public function auth_edit()
    {
    	$id=input('param.id');
    	$authRule=new A();
		$authRuleRes=$authRule->getSon($id);
         //导航管理
         $daoh=$this->auth_group();
         $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
		//查询自己和自己的子集
		$this->assign('authRuleRes',$authRuleRes);
		
		$data=db('auth_rule')->where('id',$id)->find();
		$this->assign('data',$data);
		if(request()->isPost())
        {
				//halt($_POST);
				$auth=new A();
                $res=$auth->auth_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
		}

    	return $this->fetch();
    }
   //删除方法(假删除）
   public function  auth_dele()
   {
    //halt($_POST);
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->auth_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }

 }   
