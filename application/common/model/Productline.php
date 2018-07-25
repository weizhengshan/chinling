<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Productline  extends Model
{

  protected  $pk='prod_id';//主键
  protected $table = 'qy_products';
    
    //修改管理状态
   
 
	
	//增加分类
	public function prod_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['prod_states']=1;
		
		$arr['prod_title']=$data['prod_title'];
		//halt($data['prod_img']);
		$arr['prod_img']=$data['prod_img'];
		$arr['protype_pid']=$data['protype_pid'];
		$arr['prod_rel']=Session::get('admin_id');
		$arr['prod_text']=$data['prod_text'];
		//判断是否为外来注册
		
		
		//判断名称是否唯一
		$type_yan=$this->where('prod_title',$data['prod_title'])->find();
	 
		if($type_yan['prod_id']!="")
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
			$caozuo='添加产品';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//修改信息
	public  function prod_edit($data)
	{
		$arr['updatetime']=time();
		$arr['prod_title']=$data['prod_title'];
		//halt($data['prod_img']);
		$arr['prod_img']=$data['prod_img'];
		$arr['protype_pid']=$data['protype_pid'];
		$arr['prod_updat']=Session::get('admin_id');
		$arr['prod_text']=$data['prod_text'];

		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['prod_id'=>$data['prod_id']]);
        
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
	public function prod_dele($data)
	{
		
		$res=$this->where('prod_id',$data['prod_id'])->update(['prod_states' => '0']);
		
		if($res)
		    {
		    	$caozuo='下架产品';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'下架成功'];
			}else{
				return ['valid'=>3,'msg'=>'下架失败'];
			}
		
	}
	//上架
	public function prod_update($data)
	{
		
		$res=$this->where('prod_id',$data['prod_id'])->update(['prod_states' => '1']);
		
		if($res)
		    {
		    	$caozuo='上架产品';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'上架成功'];
			}else{
				return ['valid'=>3,'msg'=>'上架失败'];
			}
		
	}
	//上架
	public function prod_deled($data)
	{
		
		$res=$this->where('prod_id',$data['prod_id'])->delete();
		
		if($res)
		    {
		    	$caozuo='删除产品';
            //删除加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'删除成功'];
			}else{
				return ['valid'=>3,'msg'=>'删除失败'];
			}
		
	}
	//移动产品到指定分类
	public function prod_editzhi($data)
	{
		//halt($data);
		if($data['action']=='category_move')
		{
				if(empty($data['checkbox']))
			{
				return ['valid'=>8,'msg'=>'还未选择产品'];	
				exit;
			}
			
			$res=$this->whereIn('prod_id',$data['checkbox'])->update(['protype_pid'=>$data['new_cat_id']]);
	
			if($res)
		    {
		    	$caozuo='移动产品到分类';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'移动成功'];
			}else{
				return ['valid'=>3,'msg'=>'移动失败'];
			}
		}else if($data['action']=='del_all')
		{
			if(empty($data['checkbox']))
			{
				return ['valid'=>8,'msg'=>'还未选择产品'];	
			}
			$res=$this->whereIn('prod_id',$data['checkbox'])->update(['prod_states'=>'0']);
			if($res)
		    {
		    	$caozuo='下架产品';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'删除成功'];
			}else{
				return ['valid'=>3,'msg'=>'删除失败'];
			}
		}else
		{
			return ['valid'=>8,'msg'=>'还未选择业务逻辑'];	
		}
		
	}
	
	/**
    * 获得自己和自己子集的数据
    */
   public function prod_son($type_id)
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
