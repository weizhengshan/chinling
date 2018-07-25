<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Manage  extends Model
{

  protected  $pk='admin_id';//主键
  protected $table = 'qy_user';
    
    //修改管理状态
   
   public function manage_dele($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['admin_id'])
		{
			$sta_id=$this->where('admin_id',$data['admin_id'])->column('states');
			//halt($sta_id);
			if($sta_id[0]==1)
			{
				$res=$this->where('admin_id',$data['admin_id'])->update(['states' => '0']);
			}else
			{
				$res=$this->where('admin_id',$data['admin_id'])->update(['states' => '1']);
			}
			if($res)
	    {
	    	$caozuo='修改Id是'.$data['admin_id'].'管理员的状态';
			//添加操作记录
			$arr=caozuo($caozuo);
			$res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'修改状态成功'];
		}else{

			
			return ['valid'=>0,'msg'=>'修改状态失败'];
		}
		}
		  	
	    
	}
	
	//增加管理员
	public function manage_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['states']=1;
		$arr['admin_username']=$data['user_name'];
		$arr['admin_password']=$data['password'];
		$arr['phone']=$data['phone'];
		$arr['email']=$data['email'];
		$arr['role_id']=$data['role_id'];
		//判断是否为外来注册
		
		
		//判断用户名是否唯一
		$user_yan=$this->where('admin_username',$data['user_name'])->find();
	
		if($user_yan['admin_id']!="")
		{
			 return ['valid'=>0,'msg'=>'用户名已注册'];
			 exit;
		}
		//判断邮箱是否唯一
		$email_yan=$this->where('email',$data['email'])->find();
		if($email_yan['admin_id']!="")
		{
			 return ['valid'=>1,'msg'=>'邮箱已注册'];
			 exit;
		}
		//判断手机号是否唯一
		$phone_yan=$this->where('phone',$data['phone'])->find();
		if($phone_yan['admin_id']!="")
		{
			 return ['valid'=>2,'msg'=>'手机号已注册'];
			 exit;
		}
		//halt($user_yan);
		$result1 = $this->insertGetId($arr);
		//halt($result);
		$arr=array(
			'uid'=>$result1,
			'group_id'=>$arr['role_id']
		);
		$result=db('auth_group_access')->insert($arr);

		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'添加失败'];
		}else{

			$caozuo='增加Id是'.$result1.'管理员';
			//添加操作记录
			$arr=caozuo($caozuo);
			$res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//回收站管理员	
		public function manage_admin($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['admin_id'])
		{
			$sta_id=$this->where('admin_id',$data['admin_id'])->column('states');
			//halt($sta_id);
			if($sta_id[0]!==false)
			{
				$res=$this->where('admin_id',$data['admin_id'])->delete();
			}
			
			if($res)
	    {
	    	$caozuo='删除Id是'.$data['admin_id'].'管理员';
			//添加操作记录
			$arr=caozuo($caozuo);
			$res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'修改状态成功'];
		}else{


			return ['valid'=>0,'msg'=>'修改状态失败'];
		}
		}
		  	
	    
	}
	
	//修改信息
	public  function manage_edit($data)
	{
		
		
		$arr['admin_password']=$data['password'];
		$arr['phone']=$data['phone'];
		$arr['email']=$data['email'];
		$arr['role_id']=$data['role_id'];
		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['admin_id'=>$data['admin_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'添加失败'];
		}else{

			$caozuo='修改Id是'.$data['admin_id'].'管理员';
			//添加操作记录
			$arr=caozuo($caozuo);
			$res=db('operat')->insert($arr);

			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}
	
    
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
