<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\Recruit as A;
class Recruit  extends Common
{
    //招聘提交页
    public function index()
    {
        //获取管理员
        $data=db('recruit')->where('states',1)->select();
        $this->assign('data',$data);
        //halt($data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    //提交方法
    public function rec_add()
    {
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);

        //添加
        if(request()->isPost())
            {
        //halt($_POST);
               $zhao=new A();
                $res=$zhao->rec_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
        return $this->fetch();

    }
    //修改方法
    public function rec_edit()
    {
      $id=input('param.rec_id');
      $data=db('recruit')->where('rec_id',$id)->find();
      $this->assign('data',$data);

      //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);

       //修改
        if(request()->isPost())
            {
        //halt($_POST);
               $zhao=new A();
                $res=$zhao->rec_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
 
       return $this->fetch(); 
    }
   //删除方法(假删除）
   public function  rec_dele()
   {
      if(request()->isPost())
            {
        //halt($_POST);
               $zhao=new A();
                $res=$zhao->rec_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
         return $this->fetch();
   }

}
