<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\AuthGroup as A;
class AuthGroup  extends Common
{
    //权限展示页
    public function auth_glist()
    {
    	$data=db('auth_group')->where('status',1)->select();
		$this->assign('data',$data);
		//halt($data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
    	return $this->fetch();
    }
    //权限增加页
    public function auth_gadd()
    {
    	$authRule=new \app\common\model\AuthRule();
        $data=$authRule->authRuleTree();
		$this->assign('data',$data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
		if(request()->isPost())
        {
				//halt($_POST);
				$auth=new A();
                $res=$auth->auth_gadd(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
		}
    	return $this->fetch();
    }
    //修改权限
    public function auth_gedit()
    {
    	 if(request()->isPost()){
          $auth=new A();
                $res=$auth->auth_gedit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
        }
        $authgroups=db('auth_group')->find(input('id'));
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        $this->assign('authgroups',$authgroups);
        $authRule=new \app\common\model\AuthRule();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);

    	return $this->fetch();
    }
   //删除方法(假删除）
   public function  auth_gdele()
   {
    //halt($_POST);
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->auth_gdele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }

 }   
