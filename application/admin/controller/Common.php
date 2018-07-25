<?php
namespace app\admin\controller;

use think\Controller;  
use think\Request;
use think\Session;

class Common  extends Controller
{
    public function __construct( Request $request=null)
    {
        parent::__construct($request);
        if(	!Session::get('admin_id')){
 			
          $this->redirect('admin/login/login');
        }
     $daoh=$this->auth_group();
      
     //halt($daoh);
       /*$auth=new Auth();
        $request=Request::instance();
        $con=$request->controller();
        $action=$request->action();
        $name=$con.'/'.$action;
        $session_id=Session::get('admin_id');
        $notCheck=array('Index/index','Admin/lst','Index/logout');
        	if(!in_array($name, $notCheck)){
       		if(!$auth->check($name,Session::get('admin_id'))){
       			 //return array('status'=>'error','msg'=>'有权限！');
		    	$this->error('没有权限',url('index/index')); 
					$array=array(
		    		'action'=>$name,
		    	);
		    	$this->redirect('index/index',['id'=>$name])->remember();
		    	
		    	//$this->redirect('index/index?name='+$name,['id'=>1]);
		    	}
       
        	
        }*/
    }
    public function auth_group()
    {
    	$admin_id=Session::get('admin_id');
    	//print_r($admin_id); echo "<hr>";
      	$res=db('user')->where('admin_id',$admin_id)->field('role_id')->find();

        //print_r($res);echo "<hr>";
        $arr=db('auth_group')->where('id',$res['role_id'])->field('rules')->find();
        //print_r($arr);echo "<hr>";
        $dao=explode(",",$arr['rules']);
        //print_r($dao);echo "<hr>";
        $daoh=db('auth_rule')->where('status',1)->whereIn('id',$dao)->where('level',0)->field('name,title')->order('sort')->select();
        //halt($daoh);
       return $daoh;
    }
    //网址公共信息
    public function base()
    {
      //导航管理
         $daoh=$this->auth_group();
        $this->assign('daoh',$daoh);
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
    }
      //无限级分类
   public function GetTreecomm($arr,$pid,$step,$pidname,$name){
    global $tree;
    foreach($arr as $key=>$val) {
        if($val[$pidname] == $pid) {
            $flg = str_repeat('└―',$step);
            $val[$name] = $flg.$val[$name];
            $tree[] = $val;
            $this->GetTreecomm($arr,$val[$pidname],$step+1,$pidname,$name);
        }
    }
    return $tree;
}
}
