<?php
namespace app\weixin\model;
use think\Model;  

class DayPrice  extends Model{
  
  protected  $pk='day_id';//主键
  protected $table = 'qy_dayprice';
  public function add($data,$size,$all)
  {
  		$data['createtime']=time();
  		/*判断是否有重复的添加*/
  		$yan=$this->where('year',$data['year'])
  		      ->where('pro_time',$data['pro_time'])
  		      ->field('day_id,proceid')
  		      ->find();
  		      //halt($yan['every_id']);
  		if($yan['day_id'] && $data['proceid']==$yan['proceid'])
  		{
  			  /*写入到文件*/
  		     $size=$size+1;
			return ['valid'=>4,'msg'=>$size,'all'=>$all];
  		}else
  		{

  			$result = $this->save($data);	
	  		  if(false === $result){
			    // 验证失败 输出错误信息
			    return ['valid'=>1,'msg'=>'添加失败'];
			}else{
				$size=$size+1;
				return ['valid'=>4,'msg'=>$size,'all'=>$all];
			}
  		}
  }
}
