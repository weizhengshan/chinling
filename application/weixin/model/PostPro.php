<?php
namespace app\weixin\model;
use think\Model;  

class PostPro  extends Model{
  
  protected  $pk='weath_id';//主键
  protected $table = 'qy_weathcity';
  public function add($data)
  {
  		//halt(count($data));
  		//$arr="";
  		for ($i=0; $i<34; $i++) 
  		{
	  		for ($j=1; $j<35; $i++) 
	  		{ 
	           $result = $this->save($data[$j]);
	  		   //var_dump($data[$i]);
	        }

  		}
  		

  		/*if($yan['every_id'])
  		{
  			  /*写入到文件
  		  
  		}else
  		{

  			$result = $this->save($data);	
	  		  if(false === $result){
			    // 验证失败 输出错误信息
			    return ['valid'=>1,'msg'=>'添加失败'];
			}else{
				return ['valid'=>4,'msg'=>'添加成功'];
			}
  		}  */
  		
		
  }
}
