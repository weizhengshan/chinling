<?php
namespace app\admin\controller;

use app\common\model\Manage as A;
use think\Session;
class Manage  extends Common
{
    //管理员列表
    public function manage_list()
    {
        //获取管理员
        
       // $data=db('user')->select();
       $data=db()->table('qy_user a,qy_auth_group b')->where('a.role_id =b.id')->field('a.admin_id,a.admin_username,a.createtime,a.states,a.phone,a.email,a.lastlogin,b.title')->order('a.admin_id desc')->select();
       // print_r($managerinfo);
        $this->assign('data',$data);
        //导航管理
         $daoh=$this->auth_group();
        $this->assign('daoh',$daoh);
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        //halt($data);
        return $this->fetch();
    }
    //停用或开启
    public  function check()
    {
      if(request()->isPost())
            {
                $login=new A();
                $res=$login->check(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;

            }
     }
     //增加管理员
     public function manage_add()
     {
        //添加信息提交
        //权限管理
        $roledata=db('auth_group')->where('status',1)->select();
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
	   $this->assign('roledata',$roledata);
	   //halt($admin);
       if(request()->isPost())
            {
				//halt($_POST);
               $mag_add=new A();
                $res=$mag_add->manage_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
		
		
         return $this->fetch();
     }
    //修改信息
	public function manage_edit()
	{
		$admin=input('param.');
		//获得信息
		$data=db('user')->where('admin_id',$admin['admin_id'])->find();
		$this->assign('data',$data);
		//导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
		
		 //权限管理
        $roledata=db('auth_group')->where('status',1)->select();

       $this->assign('roledata',$roledata);
		//更新
		 if(request()->isPost())
            {
				//halt($_POST);
               $mag_add=new A();
                $res=$mag_add->manage_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
		
        return $this->fetch();
	}
     //禁用管理员
	 public function manage_dele()
	 {
		if(request()->isPost())
            {
				//halt($_POST);
               $mag_add=new A();
                $res=$mag_add->manage_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
	 }
	 //删除管理员
	 public function manage_admin()
	 {
		 if(request()->isPost())
            {
				//halt($_POST);
               $mag_add=new A();
                $res=$mag_add->manage_admin(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
	 }
    
   
}
