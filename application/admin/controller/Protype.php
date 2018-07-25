<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\Protypes as A;
class Protype  extends Common
{
    //分类页
    public function protypes_index()
    {
       
       //导航管理
       $this->base();
       //分类
       $this->getAllData();
       return $this->fetch();
    }
    /**
     * 分类数据
     */
    public function getAllData()
    {
       $typesdata=db('protypes')->where('protype_states',2)->select();
       //$data=$this->getTree($typesdata,$pid='type_pid');
       $arr=$this->GetTree($typesdata, 0, 0); 
       $this->assign('arr',$arr); 
    }
    //提交方法
    public function protype_add()
    {       
		//分类
      $this->getAllData();
       //导航管理
       $this->base();
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
    public function protype_edit()
    {
      //导航管理
       $this->base();
        $admin=input('param.');
      //获得不是自己和自己的子类
        if($admin['protype_id'])
        {
        $type_edit=new A();
        $res=$type_edit->getSon(input('param.protype_id'),2);
        }
       //$data=$this->getTree($typesdata,$pid='type_pid');
       $arr=$this->GetTree($res, 0, 0);
      $this->assign('arr',$arr); 
      //编辑
      $data=db('protypes')->where('protype_id',$admin['protype_id'])->find();
   
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
   public function  protype_dele()
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
        if($val['protype_pid'] == $pid) {
            $flg = str_repeat('└―',$step);
            $val['protype_name'] = $flg.$val['protype_name'];
            $tree[] = $val;
            $this->GetTree($arr , $val['protype_id'] ,$step+1);
        }
    }
    return $tree;
}
 }
