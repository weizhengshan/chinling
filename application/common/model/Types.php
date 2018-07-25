<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Types  extends Model
{

  protected  $pk='type_id';//主键
  protected $table = 'qy_types';
    
    //修改管理状态
   
 
	
	//增加分类
	public function type_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['type_states']=1;
		$arr['type_sort']=$data['type_sort'];
		$arr['type_name']=$data['type_name'];
		$arr['type_describe']=$data['type_describe'];
		$arr['type_pid']=$data['type_pid'];
		$arr['action']=$data['action'];

		//判断是否为外来注册
		
		
		//判断名称是否唯一
		$type_yan=$this->where('type_name',$data['type_name'])->find();
		//halt($type_yan);
		if($type_yan['type_id']!="")
		{
			 return ['valid'=>0,'msg'=>'名称重复'];
			 exit;
		}

		//halt($user_yan);
		$result = $this->save($arr);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'添加失败'];
		}else{
			$caozuo='添加分类';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//修改信息
	public  function type_edit($data)
	{
		$arr['createtime']=time();
		$arr['type_sort']=$data['type_sort'];
		$arr['type_name']=$data['type_name'];
		$arr['type_describe']=$data['type_describe'];
		$arr['type_pid']=$data['type_pid'];
		$arr['action']=$data['action'];
		//判断是否为外来注册
		//判断名称是否唯一
		$type_yan=$this->where('type_name',$data['type_name'])->find();
		//halt($type_yan);
		if($type_yan['type_id'] != $data['type_id'])
		{
			 return ['valid'=>0,'msg'=>'名称重复'];
			 exit;
		}
		//halt($user_yan);
		$result = $this->save($arr,['type_id'=>$data['type_id']]);
        

		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'修改失败'];
		}else{
			$caozuo='修改产品';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}
	//删除分类(如果有子分类不删除)
	public function type_dele($data)
	{
		//判断是否有子分类
		$dataId=$this->where('type_pid',$data['type_id'])->column('type_id');
	    if(!empty($dataId))
	    {
	    	return ['valid'=>0,'msg'=>'请先删除子类'];
	    	exit;
	    }
		
		$res=$this->where('type_id',$data['type_id'])->delete();
		
		if($res)
		    {

		    	$caozuo='删除分类';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'删除成功'];
			}else{
				return ['valid'=>3,'msg'=>'删除失败'];
			}
		
	}

	 /**
    * 获得自己和自己的子集
    */
   public function art_son($type_id)
   {
   		 $allData=$this->select();
   	   //获得自己和自己子集的cate_id
   	   $sonDate=$this->getSonId($allData,$type_id);
   	   //把自己id加进去
   	   $sonDate[]=$type_id;
   	   return $sonDate;
   }
	
	/**
    * 获得不是自己和自己子集的数据
    */
   public function getSon($type_id)
   {
   	    $allData=$this->select();
   	   //获得自己和自己子集的cate_id
   	   $sonDate=$this->getSonId($allData,$type_id);
   	   //把自己id加进去
   	   $sonDate[]=$type_id;
      //halt($sonDate);
   	   //获得需要的栏目
   	   $cateInfo=$this->whereNotIn('type_id',$sonDate)->select();

   	   return 	$cateInfo;
   }
   /**
    * 获得子集type_id
    */
   public function getSonId($allData,$type_id)
   {
   		static $tmp=array();
   		foreach($allData as $k=>$v)
   		{
   		   if($type_id==$v['type_pid']){
   		   	 $tmp[]=$v['type_id'];
   		   	 $this->getSonId($allData,$v['type_id']);
   		   }
   		  
   		}
   		return $tmp;
   	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
