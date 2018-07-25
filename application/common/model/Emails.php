<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Emails  extends Model
{

  protected  $pk='ema_id';//主键
  protected $table = 'qy_email';
    
    //修改管理状态
   
 
	//添加邮箱
	public function type_eadd($data)
	{
		//halt($data);
		$data['createtime']=time();
		$result = $this->save($data,['ema_id'=>$data['ema_id']]);
       	//$result = db('email')->insert($data); 
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'修改失败'];
		}else{
			$caozuo='修改邮箱配置';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}
}	