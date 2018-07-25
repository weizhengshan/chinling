<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class System  extends Model
{

  protected  $pk='conf_id';//主键
  protected $table = 'qy_config';
    
    //修改管理状态
   
 
	
	//添加配置
	public function type_add($data)
	{
		//halt($data);
		$data['createtime']=time();
		$result = $this->save($data,['conf_id'=>$data['conf_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'修改失败'];
		}else{
			$caozuo='修改配置';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}

}	