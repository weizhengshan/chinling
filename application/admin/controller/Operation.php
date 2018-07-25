<?php
namespace app\admin\controller;

use think\Session;
class Operation  extends Common
{
    
    public function index()
    {
         $page=input('param.page');//当前页默认为第一页;
      $pageSize=10;//每页显示条数为5条；
        //获得登录员的操作信息
         $totalRows=db('operat')->count('ope_id');
        $maxPage=ceil($totalRows/$pageSize);
        if($page<1)
        {
          $page=1;
        }
        if($page>$maxPage)
        {
          $page=$maxPage;
        }
        $data=db('operat')->order('ope_id desc')->page($page,$pageSize)->select();  
        foreach($data as $k=>$v)
        {
            $v['add']=getLocation($v['ip']);
            $data[$k]=$v;
        } 
        $this->assign('data',$data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
         $this->assign('totalRows',$totalRows);
      $this->assign('page',$page);
      $this->assign('maxPage',$maxPage);
        return $this->fetch();
    }
   

}

