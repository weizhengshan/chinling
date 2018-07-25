<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\System as A;
use app\common\model\Emails as B;
class System  extends Common
{
    //网站配置信息
    public function system_index()
    {
        //获取配置信息
       $info=db('config')->find();
        $this->assign('info',$info);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    //提交方法
    public function system_add()
    {
         if(request()->isPost())
            {
        //halt($_POST);
               $type_add=new A();
                $res=$type_add->type_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }


         return $this->fetch();
    }
    //
    public function system_eamil()
    { 
       //获取配置信息
       $info=db('email')->find();
        $this->assign('info',$info);

        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    public function system_eadd()
    {

      if(request()->isPost())
            {
        //halt($_POST);
               $type_add=new B();
                $res=$type_add->type_eadd(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
    }
}
