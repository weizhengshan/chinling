<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Imgclass  extends Model
{

  protected  $pk='caro_id';//主键
  protected $table = 'qy_carousel';
    
    //修改管理状态
   
   public function caro_dele($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['caro_id'])
		{
			$sta_id=$this->where('caro_id',$data['caro_id'])->column('caro_states');
			//halt($sta_id);
			if($sta_id[0]==1)
			{
				$res=$this->where('caro_id',$data['caro_id'])->update(['caro_states' => '0']);
			}
			if($res)
	    {
	    	$caozuo='下架轮播图';

            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'下架成功'];
		}else{

			return ['valid'=>0,'msg'=>'下架失败'];
		}
		}
		  	
	    
	}
	 public function caro_update($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['caro_id'])
		{
			
		
		$res=$this->where('caro_id',$data['caro_id'])->update(['caro_states' => '1']);
		
			if($res)
	    {
	    	$caozuo='上架轮播图';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'上架成功'];
		}else{

			return ['valid'=>0,'msg'=>'上架失败'];
		}
		}
		  	
	    
	}
	 public function caro_deled($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['caro_id'])
		{
			
			//halt($sta_id);
		
				$res=$this->where('caro_id',$data['caro_id'])->delete();
		
			if($res)
	    {
	    	$caozuo='删除轮播图';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'删除成功'];
		}else{

			return ['valid'=>0,'msg'=>'删除失败'];
		}
		}
		  	
	    
	}
	//添加轮播图
	public function caro_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['caro_states']=1;
		$arr['caro_sort']=$data['caro_sort'];
		$arr['caro_name']=$data['caro_name'];
		$arr['caro_img']=$data['caro_img'];
        $arr['pid']=$data['pid'];
        $arr['action']=$data['action'];
        if($data['pid']==3)
        {
        	$arr['caro_zh']=$data['caro_zh'];
        }
		//判断是否为外来注册
		
		
		//判断名称是否唯一
		$caron_yan=$this->where('caro_name',$data['caro_name'])->find();
	
		if($caron_yan['caro_id']!="")
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
			$caozuo='添加轮播图';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//删除管理员	
		public function manage_admin($data)
    {
    	
		//判断$date是
		//halt($data);
		if($data['admin_id'])
		{
			$sta_id=$this->where('admin_id',$data['admin_id'])->column('states');
			//halt($sta_id);
			if($sta_id[0]!==false)
			{
				$res=$this->where('admin_id',$data['admin_id'])->delete();
			}
			
			if($res)
	    {
	    	$caozuo='删除轮播图';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
	    	return ['valid'=>1,'msg'=>'修改状态成功'];
		}else{
			return ['valid'=>0,'msg'=>'修改状态失败'];
		}
		}
		  	
	    
	}
	
	//修改信息
	public  function caro_edit($data)
	{
		
		
		$arr['caro_img']=$data['caro_img'];
		$arr['caro_sort']=$data['caro_sort'];
		$arr['action']=$data['action'];
		if($data['pid']==3)
        {
		$arr['caro_zh']=$data['caro_zh'];
		}
		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['caro_id'=>$data['caro_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'修改失败'];
		}else{
			$caozuo='修改轮播图';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}
	
    //添加logo
	/*public function  logo_add($data)
	{
		$arr['logo_img']=$data['logo_img'];
		$arr['logo_remarks']=$data['logo_remarks'];
		//halt($data);
		$result =db('qy_logo')->save($arr);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>1,'msg'=>'添加失败'];
		}else{
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
