<?php
namespace app\common\model;

use houdunwang\arr\Arr;
use think\Model;  

class Category  extends Model
{
	protected $pk='cate_id';
	protected $table='blog_cate';
	/* 
	 *验证输入
	 */
   public function store($data)
   {
   		//验证 		
   		//添加
   		$result = $this->validate(true)->save($data);
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>0,'msg'=>$this->getError()];
		}else{
			return ['valid'=>1,'msg'=>'添加成功'];
		}

   }
   public function getAll()
   {
   	 $data=db('cate')->order('cate_sort desc,cate_id')->select();
   	 $title='cate_name';

    return 	Arr::tree($data, $title, $fieldPri = 'cate_id', $fieldPid = 'cate_pid');

   }
   /**
    * 获得不是自己和自己子集的数据
    */
   public function getCateData($cateId)
   {
   	    $allData=db('cate')->select();
   	   //获得自己和自己子集的cate_id
   	   $sonDate=$this->getSonId($allData,$cateId);
   	   //把自己id加进去
   	   $sonDate[]=$cateId;
      //halt($sonDate);
   	   //获得需要的栏目
   	   $cateInfo=db('cate')->whereNotIn('cate_id',$sonDate)->select();

   	   return 	Arr::tree($cateInfo, 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
   }
   /**
    * 获得子集cate_id
    */
   public function getSonId($allData,$cateId)
   {
   		static $tmp=array();
   		foreach($allData as $k=>$v)
   		{
   		   if($cateId==$v['cate_pid']){
   		   	 $tmp[]=$v['cate_id'];
   		   	 $this->getSonId($allData,$v['cate_id']);
   		   }
   		  
   		}
   		return $tmp;
   	}
   	/**
   	 * 编辑栏目
   	 */
   	public function edit($data)
   	{
   		//half($data);
   		$result = $this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>0,'msg'=>$this->getError()];
		}else{
			return ['valid'=>1,'msg'=>'编辑成功'];
		}

   	} 
   	/**
   	 * 删除栏目
   	 */
   	public function del($cate_id)
   	{
   		//获得pid
   		$cate_pid=$this->where('cate_id',$cate_id)->value('cate_pid');
   		$update=$this->where('cate_pid',$cate_id)->setField('cate_pid',$cate_pid);
   		if(Category::destroy($cate_id))
   		{
   			return ['valid'=>1,'msg'=>'删除成功'];
   		}else{
   			return ['valid'=>0,'msg'=>'删除失败'];
   		}
   	}
}