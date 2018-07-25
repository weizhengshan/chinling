<?php
namespace app\admin\controller;

use think\Session;
class Recycle  extends Common
{
    //管理员
    public function admin_index()
    {
        //获取管理员
        $data=db('user')->where('states',0)->select();
        $this->assign('data',$data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }

    //文章
    public function article_index()
    {
      //获得文章
      $count=db('contents')->where('cont_states',0)->count('cont_id');
       $data=db()->table('qy_contents a,qy_types b')->where('a.cont_pid =b.type_id')->field('a.cont_id,a.cont_title,a.cont_img,a.createtime,b.type_name')->where('a.cont_states',0)->order('a.cont_id desc')->paginate(10);
    
     //halt($data);
      $this->assign('count',$count);
       $this->assign('data',$data);
       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
  

   //产品
   public function  products_index()
   {
       $count=db('products')->where('prod_states',1)->count('prod_id');;
 
        $data=db()->table('qy_products a, qy_protypes b')->where('a.protype_pid = b.protype_id')->field('a.prod_id,a.prod_title,a.prod_img,a.createtime,b.protype_name')->where('prod_states',0)->order('a.prod_id desc' )->paginate(10);
     

        $this->assign('count',$count);
        $this->assign('data',$data);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
   }
   //产品分类
   public function  img_index()
   {
      $carodata=db('carousel')->where('caro_states',0)->select();
        $this->assign('carodata',$carodata);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
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
