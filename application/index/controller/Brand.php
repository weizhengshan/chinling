<?php
namespace app\index\controller;

class Brand extends Common
{

	public function index()
	{
		$this->base();
		$mo_name='品牌故事';
		$data_id=db('types')->where('type_name',$mo_name)->column('type_id');
		$data_cont=db('contents')->where('cont_pid',$data_id[0])->where('cont_states',1)->find();
		//halt($data_cont);	
		$this->assign('pid',$data_id[0]);
		$this->assign('data',$data_cont);
		$this->assign('name',$mo_name);
		return $this->fetch();
	}
}