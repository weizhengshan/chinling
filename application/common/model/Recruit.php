<?php
namespace app\common\model;


use think\Session;
use think\Validate;
use think\Model;  

class Recruit  extends Model
{

  protected  $pk='rec_id';//主键
  protected $table = 'qy_recruit';
    
    //修改管理状态
   
 
	
	//增加分类
	public function rec_add($data)
	{
		//halt($data);
		$arr['createtime']=time();
		$arr['states']=1;
		$arr['sort']=$data['protype_sort'];
		$arr['position']=$data['rec_position'];
		$arr['nature']=$data['nature'];
		$arr['num']=$data['rec_num'];
		$arr['place']=$data['rec_place'];
		$arr['rec_text']=$data['content'];
		//判断是否为外来注册
		
		
		//判断名称是否唯一
		$type_yan=$this->where('position',$data['rec_position'])->find();

		if($type_yan['rec_id']!="")
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
			$caozuo='添加招聘';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'添加成功'];
		}
	}	
	//修改信息
	public  function rec_edit($data)
	{
		//halt($data);
		$arr['updatetime']=time();
		$arr['states']=1;
		$arr['sort']=$data['protype_sort'];
		$arr['position']=$data['rec_position'];
		$arr['nature']=$data['nature'];
		$arr['num']=$data['rec_num'];
		$arr['place']=$data['rec_place'];
		$arr['rec_text']=$data['content'];
		//判断是否为外来注册
		//halt($user_yan);
		$result = $this->save($arr,['rec_id'=>$data['rec_id']]);
        
		if(false === $result){
		    // 验证失败 输出错误信息
		    return ['valid'=>3,'msg'=>'修改失败'];
		}else{
			$caozuo='修改招聘信息';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
			return ['valid'=>4,'msg'=>'修改成功'];
		}
	}
	//删除分类(如果有子分类不删除)
	public function rec_dele($data)
	{
		
		$res=$this->where('rec_id',$data['rec_id'])->update(['states' => '0']);
		
		if($res)
		    {
		    	$caozuo='下架招聘';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
		    	return ['valid'=>4,'msg'=>'下架成功'];
			}else{
				return ['valid'=>3,'msg'=>'下架失败'];
			}
	}


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
