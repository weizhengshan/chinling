<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Statistics  extends Model
{

  protected  $pk='wea_id';//主键
  protected $table = 'qy_weather';
    
    //修改管理状态
   
 
	
	//增加
	public function type_add($data)
	{
		$result = $this->save($data);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    $caozuo='添加天气数据失败';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    return ['valid'=>1,'msg'=>'添加失败'];
		}else{

			return ['valid'=>4,'msg'=>'添加成功'];
		}

	}
}		