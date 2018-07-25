<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\Leaving as A;
class Leaving  extends Common
{
       //联系提交页
    public function index()
    {
      $page=input('param.page');//当前页默认为第一页;
      $pageSize=10;//每页显示条数为5条；
        //获取留言信息
      $totalRows=db('leaving')->count('leav_id');
        $maxPage=ceil($totalRows/$pageSize);
        if($page<1)
        {
          $page=1;
        }
        if($page>$maxPage)
        {
          $page=$maxPage;
        }
        //echo $page;
        $leavinfo=db('leaving')->order('leav_id desc')->page($page,$pageSize)->select();  
        foreach($leavinfo as $k=>$v)
        {
            $v['add']=getLocation($v['ip']);
            $leavinfo[$k]=$v;
        } 
       //halt($leavinfo);
        $this->assign('leavinfo',$leavinfo);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
       // halt($leavinfo);
        $this->assign('totalRows',$totalRows);
      $this->assign('page',$page);
      $this->assign('maxPage',$maxPage);
        return $this->fetch();
    }

 
  public function send_email()
   {

        $admin=input('param.type_id');
    //获得信息
    $data=db('leaving')->where('leav_id',$admin)->field('email')->find();
    $this->assign('email',$data['email']);
       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);

     return $this->fetch();
  }
    //发送邮箱
    public function send_emails()
    {
       //halt($_POST);
     if(request()->isPost())
            {
        //halt($_POST);
               $mag_add=new A();
                $res=$mag_add->send_email(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }  
   }

}