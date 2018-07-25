<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Imglogo  extends Model
{

  protected  $pk='logo_id';//主键
  protected $table = 'qy_logo';
    
	
    //添加logo
	public function  logo_add($data)
	{
		$arr['logo_img']=$data['logo_img'];
		$arr['logo_remarks']=$data['logo_remarks'];
		$arr['pid']=$data['pid'];
		//halt($data);
		$result = $this->save($arr,['logo_id' => $data['logo_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'添加失败'];
		}else{
			
			if($data['logo_id'])
			{
				$caozuo='修改lOGO';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
				return ['valid'=>4,'msg'=>'修改成功'];
				exit;
			}
			$caozuo='添加LOGO';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
