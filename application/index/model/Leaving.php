<?php
namespace app\index\model;


use think\Session;
use think\Validate;
use think\Model;  

class Leaving  extends Model
{

  protected  $pk='leav_id';//主键
  protected $table = 'qy_leaving';
    
  
 
	
	//添加留言
	public function leav_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['theme']=$data['theme'];
		$arr['username']=$data['username'];
		$arr['phone']=$data['phone'];
		$arr['email']=$data['email'];
		$arr['addr']=$data['addr'];
		$arr['ip']=getIp();
		$arr['text']=$data['text'];

		//判断是否为外来注册

		//halt($user_yan);
		$result = $this->save($arr);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'提交失败'];
		}else{
			return ['valid'=>4,'msg'=>'提交成功,感谢您的建议'];
		}
	}	
	
	
}
