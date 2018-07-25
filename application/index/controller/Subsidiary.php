<?php
namespace app\index\controller;


class Subsidiary extends Common
{

	public function index()
	{
		$this->base();
		$name='子公司介绍';
		$data_id=db('types')->where('type_name',$name)->column('type_id');
		$data_cont=db('contents')->where('cont_pid',$data_id[0])->where('cont_states',1)->field('count(cont_id),cont_id')->select();
       if($data_cont[0]['count(cont_id)']==1)
        {
		 $this->redirect('index/Subsidiary/info',['wen_id'=>$data_cont[0]['cont_id'],'type_pid'=>$data_id[0]]);
        }
		$data=db('contents')->where('cont_pid',$data_id[0])->where('cont_states',1)->select();
		//halt($data);
		$this->assign('pid',$data_id[0]);
		$this->assign('data',$data);
		$this->assign('name',$name);
		return $this->fetch();
	}
	public function info()
	{
		$this->base();
		$name='子公司介绍';
		 $wenid=input('param.wen_id');
         $this->assign('wenid',$wenid);
         $type_id=input('param.type_id');
         $newdata=db('contents')->where('cont_id',$wenid)->where('cont_states',1)->find();
  			
         $this->assign('newdata',$newdata);

		$this->assign('pid','$type_pid'); 
		$this->assign('name',$name);
		return $this->fetch();
	}

}