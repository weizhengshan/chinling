<?php
namespace app\common\model;


use think\Model;  

class Tay  extends Model
{
	protected $pk='tag_id';
	protected $table='blog_tag';
	/* 
	 *验证输入
	 */
   public function addTay($data)
   {
   		//验证 		
   		//添加

   		$result = $this->validate(true)->save($data,$data['tag_id']);
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>0,'msg'=>$this->getError()];
		}else{
			return ['valid'=>1,'msg'=>'添加成功'];
		}

   }
 }