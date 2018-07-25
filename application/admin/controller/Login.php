<?php
namespace app\admin\controller;

use app\common\model\Admin as A;
use houdunwang\crypt\Crypt;
use think\Controller;  


class Login  extends Controller
{
    public function Login()
    {

        if(request()->isPost()){
        	//halt($_POST);
        	$login=new A();
        	$res=$login->login(input('post.'));
        	if($res['valid'])
        	{
        		//说明登录成功；
        		$this->success($res['msg'],'admin/index/index');
        	}else{
        		//失败
        		$this->error($res['msg']);exit;
        	}
        }
        return $this->fetch();
    }
	 public function check(){
		//halt($_POST[yzcode]);
		if(request()->isPost())
		{
			$login=new A();
        	$res=$login->login(input('post.'));
				$mess=array(
					'status'=>$res['valid'],
					'message'=>$res['msg']
				);
				return $mess;
		}
	}
}
