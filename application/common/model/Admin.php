<?php
namespace app\common\model;

use houdunwang\crypt\Crypt;
use think\Loader;
use think\Session;
use think\Validate;
use think\Model;  

class Admin  extends Model
{

  protected  $pk='admin_id';//主键
  protected $table = 'qy_user';
    public function login($data)
    {

    	//halt($data);
    	//yanzheng
    	$validate = Loader::validate('Admin');

		if(!$validate->check($data)){
		    return ['valid'=>0,'msg'=>$validate->getError()];
		}
		//对比用户名。密码
		
		$userInfo=db('user')->where('admin_username',$data['admin_username'])->where('admin_password',$data['admin_password'])->where('states',1)->find();
		
		if(!$userInfo)
		{
			return ['valid'=>0,'msg'=>'账户密码不匹配'];
		}
		//session
		Session::set('admin_id',$userInfo['admin_id'],'think');
		Session::set('admin_username',$userInfo['admin_username'],'think');
		//更新登录记录
		$resd=array(
			'lastlogin'=>time()
		);
		$id=Session::get('admin_id');
		$time=time();
		$resd=$this->save($resd,['admin_id'=>$id]);
		//添加操作记录
		$caozuo='登录';
		$arr=caozuo($caozuo);
		$res=db('operat')->insert($arr);
		return ['valid'=>1,'msg'=>'登录成功'];


       // halt($data);
    }
    //修改密码 
   
    public function pass($data)
    {
    	//都不为空
    	 $validate = new Validate([
	    'admin_password'  => 'require',
	    'new_password' => 'require',
	    'confirm_password' => 'require|confirm:new_password'
	],[

		'admin_password.require'=>'请输入原始密码',
		'new_password.require'=>'请输入新密码',
		'confirm_password.require'=>'请输入确认密码',
		'confirm_password.confirm'=>'两次密码不一致'

		]);

		if (!$validate->check($data)) {
		    return ['valid'=>0,'msg'=>$validate->getError()];
		}
    	//判断原始密码是否正确
    	$admin_id=Session::get('admin_id');
    	$userInfo=$this->where('admin_id',$admin_id)->where('admin_password',Crypt::encrypt($data['admin_password']))->find();   
		if(!$userInfo)
		{
			return ['valid'=>0,'msg'=>'密码不匹配'];
		}
    	//跟新密码
		// save方法第二个参数为更新条件
			$res=$this->save([
			    'admin_password'  => Crypt::encrypt($data['new_password']),
			],[$this->pk => $admin_id]);
	 
	    if($res)
	    {
	    	return ['valid'=>1,'msg'=>'修改密码成功'];
		}else{

			
			return ['valid'=>0,'msg'=>'修改密码失败'];
		}
	}
   
}
