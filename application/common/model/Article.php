<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Article  extends Model
{

  protected  $pk='cont_id';//主键
  protected $table = 'qy_contents';
    
    //修改管理状态
   
 
	
	//增加分类
	public function art_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['cont_states']=1;
		$arr['cont_title']=$data['cont_title'];
		$arr['cont_remarks']=$data['cont_remarks'];
		$arr['cont_pid']=$data['cont_pid'];
		$arr['cont_rel']=Session::get('admin_id');
		$arr['cont_img']=$data['cont_img'];
		$arr['cont_text']=$data['content'];

		//halt($user_yan);
		$result = $this->save($arr);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'添加失败'];
		}else{
			 $caozuo='添加文章';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//修改信息
	public  function art_edit($data)
	{
		$arr['updatetime']=time();
		$arr['cont_title']=$data['cont_title'];
		$arr['cont_remarks']=$data['cont_remarks'];
		$arr['cont_pid']=$data['cont_pid'];
		$arr['cont_updat']=Session::get('admin_id');
		$arr['cont_img']=$data['cont_img'];
		$arr['cont_text']=$data['content'];

		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['cont_id'=>$data['cont_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'修改失败'];
		}else{
			$caozuo='修改文章';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}
	//下架
	public function art_dele($data)
	{
		
		$res=$this->where('cont_id',$data['cont_id'])->update(['cont_states' => '0']);
		
		if($res)
		    {
		    	$caozuo='下架文章';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'下架成功'];
			}else{
				return ['valid'=>3,'msg'=>'下架失败'];
			}
		
	}
	//上架
	public function art_update($data)
	{
		
		$res=$this->where('cont_id',$data['cont_id'])->update(['cont_states' => '1']);
		
		if($res)
		    {
		    	$caozuo='上架文章';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'上架成功'];
			}else{
				return ['valid'=>3,'msg'=>'上架失败'];
			}
		
	}
	//删除
	public function art_deled($data)
	{
		
		$res=$this->where('cont_id',$data['cont_id'])->delete();
		
		if($res)
		    {
		    	$caozuo='删除文章';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'删除成功'];
			}else{
				return ['valid'=>3,'msg'=>'删除失败'];
			}
		
	}
	//移动产品到指定分类
	public function art_editzhi($data)
	{
		//halt($data);
		if($data['action']=='category_move')
		{
				if(empty($data['checkbox']))
			{
				return ['valid'=>8,'msg'=>'还未选择产品'];	
				exit;
			}
			
			$res=$this->whereIn('cont_id',$data['checkbox'])->update(['cont_pid'=>$data['new_cat_id']]);
	
			if($res)
		    {
		    	$caozuo='移动文章';
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
				return ['valid'=>8,'msg'=>'还未选择文章'];	
			}
			$res=$this->whereIn('cont_id',$data['checkbox'])->update(['cont_states'=>'0']);
			if($res)
		    {
		    	$caozuo='下架文章';
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
