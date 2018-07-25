<?php
namespace app\admin\controller;

use think\Session;

use app\common\model\Productline as A;
use app\common\model\Protypes as B;

class Productline  extends Common
{
    //产品的列表
    public function productline_index()
    {
      $page=input('param.page');//当前页默认为第一页;
      $pageSize=10;//每页显示条数为5条；
      //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
      $pid=input('param.pid');
        $prod_add=new B();
        //获得自己和自己的子集
        $res=$prod_add->prod_son($pid);
        //print_r($res);

        //获取产品分类
       $prodinfo=db('protypes')->where('protype_states',2)->select();
       $arr=$this->GetTree($prodinfo, 0, 0);
       $this->assign('arr',$arr);
        /**
         * 17/12/1(url.indexOf("pid")值有变化)
         */
       /* $this->get_protype();*/
       //获得产品

       
      if($pid!=""){
        $totalRows=db()->table('qy_products a, qy_protypes b')->where('a.protype_pid = b.protype_id')->where('prod_states',1)->whereIn('protype_id',$res)->order('a.prod_id desc' )->count('a.prod_id');
          //数据表总数据条数;
         $maxPage=ceil($totalRows/$pageSize);
          if($page<1){
            $page=1;
          }
          if($page>$maxPage){
            $page=$maxPage;
          }
       $data=db()->table('qy_products a, qy_protypes b')->where('a.protype_pid = b.protype_id')->field('a.prod_id,a.prod_title,a.prod_img,a.createtime,b.protype_name')->where('prod_states',1)->whereIn('protype_id',$res)->order('a.prod_id desc' )->page($page,$pageSize)->select();
      }else
      {
         $totalRows=db('products')->where('prod_states',1)->count('prod_id');
          //数据表总数据条数;
         $maxPage=ceil($totalRows/$pageSize);
          if($page<1){
            $page=1;
          }
          if($page>$maxPage){
            $page=$maxPage;
          }
        $data=db()->table('qy_products a, qy_protypes b')->where('a.protype_pid = b.protype_id')->field('a.prod_id,a.prod_title,a.prod_img,a.createtime,b.protype_name')->where('prod_states',1)->order('a.prod_id desc' )->page($page,$pageSize)->select();
      }
     
     //halt($data); 
       
        //halt($page);
        $this->assign('pid',$pid);
       $this->assign('totalRows',$totalRows);
      $this->assign('page',$page);
      $this->assign('maxPage',$maxPage);
        $this->assign('data',$data);
        //return view();
        return $this->fetch();
    }
    
    /**
     * 网站展示产品分类
     * @return [type] [description]
     */
    public function get_protype()
    {
      $typesdata=db('protypes')->where('protype_name','网站展示')->find();
        $getArr= new B();
        $res=$getArr->prod_son($typesdata['protype_id']);
        $typesdatas=db('protypes')->whereIN('protype_id',$res)->select();
        $arr_data=$this->GetTree($typesdatas, 0, 0);
        //halt($arr_data);
        $this->assign('arr',$arr_data);
    }
    public function productline_add()
    {
      //halt($_POST);
      //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
       //获得分类
      /* $prodinfo=db('protypes')->select();
         $arr=$this->GetTree($prodinfo, 0, 0);
     
        $this->assign('arr',$arr);*/
        /*17/12/1*/
        $this->get_protype();
          //添加
        if(request()->isPost())
            {
        //halt($_POST);
               $prod_add=new A();
                $res=$prod_add->prod_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
        return $this->fetch();
    }
    //修改方法l
    public function productline_edit()
    {
        //获得分类
       /* $prodinfo=db('protypes')->select();
         $arr=$this->GetTree($prodinfo, 0, 0);*/
          /*17/12/1*/
        $this->get_protype();
     //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        $id=input('param.prod_id');
        //获得要修改的内容
        $data=db('products')->where('prod_id',$id)->find();
        $this->assign('data',$data);
          //添加
        if(request()->isPost())
            {
        //halt($_POST);
               $prod_add=new A();
                $res=$prod_add->prod_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
            return $this->fetch();
    }
   //删除方法
   public function  productline_dele()
   {
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->prod_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //上架
   public function  productline_update()
   {
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->prod_update(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //删除
     public function  productline_deled()
   {
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->prod_deled(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
  //移动产品到分类
  public function productline_editzhi()
  {
      //halt($_POST);
      if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->prod_editzhi(input('post.'));
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
