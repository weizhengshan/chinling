<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Protypes  extends Model
{

  protected  $pk='protype_id';//主键
  protected $table = 'qy_protypes';
    
    //修改管理状态
   
 
	
	//增加分类
	public function type_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['protype_states']=1;
		$arr['protype_sort']=$data['protype_sort'];
		$arr['protype_name']=$data['protype_name'];
		$arr['protype_describe']=$data['protype_describe'];
		$arr['protype_pid']=$data['protype_pid'];

		//判断是否为外来注册
		
		
		//判断名称是否唯一
		$type_yan=$this->where('protype_name',$data['protype_name'])->find();
	 
		if($type_yan['protype_id']!="")
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
			$caozuo='添加产品分类';
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
		$arr['protype_sort']=$data['protype_sort'];
		$arr['protype_name']=$data['protype_name'];
		$arr['protype_describe']=$data['protype_describe'];
		$arr['protype_pid']=$data['protype_pid'];

		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['protype_id'=>$data['protype_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'修改失败'];
		}else{
			$caozuo='修改产品分类';
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
		$dataId=$this->where('protype_pid',$data['protype_id'])->column('protype_id');
	    if(!empty($dataId))
	    {
	    	return ['valid'=>0,'msg'=>'请先删除子类'];
	    	exit;
	    }
		
		$res=$this->where('protype_id',$data['protype_id'])->delete();
		
		if($res)
		    {
		    	$caozuo='删除产品分类';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'删除成功'];
			}else{
				return ['valid'=>3,'msg'=>'删除失败'];
			}
		
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
   	   $cateInfo=$this->whereNotIn('protype_id',$sonDate)->select();

   	   return 	$cateInfo;
   }
   /**
    * 获得自己和自己的子集
    */
   public function prod_son($type_id)
   {
   		 $allData=$this->select();
   	   //获得自己和自己子集的cate_id
   	   $sonDate=$this->getSonId($allData,$type_id);
   	   //把自己id加进去
   	   $sonDate[]=$type_id;
   	   return $sonDate;
   }
   /**
    * 获得子集protype_id
    */
   public function getSonId($allData,$type_id)
   {
   		static $tmp=array();
   		foreach($allData as $k=>$v)
   		{
   		   if($type_id==$v['protype_pid']){
   		   	 $tmp[]=$v['protype_id'];
   		   	 $this->getSonId($allData,$v['protype_id']);
   		   }
   		  
   		}
   		return $tmp;
   	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
