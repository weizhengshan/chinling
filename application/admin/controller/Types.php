<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\Types as A;
class Types  extends Common
{
    //分类页
    public function types_index()
    {
        //获取管理员
       $typesdata=db('types')->order('type_sort')->select();

      
       $arr=$this->GetTree($typesdata, 0, 0);
       
        $this->assign('arr',$arr);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    //提交方法
    public function type_add()
    {

       
		//分类
       $typesdata=db('types')->select();
       //$data=$this->getTree($typesdata,$pid='type_pid');
       $arr=$this->GetTree($typesdata, 0, 0);
       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
      $this->assign('arr',$arr); 
		  //添加
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
    //修改方法
    public function type_edit()
    {
      //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        $admin=input('param.');
      //获得不是自己和自己的子类
        if($admin['type_id'])
        {
        $type_edit=new A();
        $res=$type_edit->getSon(input('param.type_id'));
        }
       //$data=$this->getTree($typesdata,$pid='type_pid');
       $arr=$this->GetTree($res, 0, 0);
      $this->assign('arr',$arr); 
      //编辑
      $data=db('types')->where('type_id',$admin['type_id'])->find();
   
      $this->assign('data',$data);
    //添加
        if(request()->isPost())
                {
            //halt($_POST);
                   $type_edit=new A();
                    $res=$type_edit->type_edit(input('post.'));
                        $mess=array(
                            'status'=>$res['valid'],
                            'message'=>$res['msg']
                        );
                        return $mess;
                }
         
        return $this->fetch();
    }
   //删除方法(假删除）
   public function  type_dele()
   {
    //halt($_POST);
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->type_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //无限级分类
  private function GetTree($arr,$pid,$step){
    global $tree;
    foreach($arr as $key=>$val) {
        if($val['type_pid'] == $pid) {
            $flg = str_repeat('└―',$step);
            $val['type_name'] = $flg.$val['type_name'];
            $tree[] = $val;
            $this->GetTree($arr , $val['type_id'] ,$step+1);
        }
    }
    return $tree;
}
 }