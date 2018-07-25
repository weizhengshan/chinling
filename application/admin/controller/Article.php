<?php
namespace app\admin\controller;

use think\Paginator;
use think\Session;
use app\common\model\Article as A;
use app\common\model\Types as B;
class Article  extends Common
{
    //孵化器提交页
    public function article_index()
    {

      $page=input('param.page');//当前页默认为第一页;
      $pageSize=10;//每页显示条数为5条；
    
       $pid=input('param.pid');
        $article=new B();
        //获得自己和自己的子集
        $res=$article->art_son($pid);
        //print_r($res);
      //获得文章分类
       $typesdata=db('types')->select();
       $arr=$this->GetTree($typesdata, 0, 0);
       $this->assign('arr',$arr);
      //获得文章
      if($pid!=""){
       $totalRows=db()->table('qy_contents a,qy_types b')->where('a.cont_pid =b.type_id')->whereIn('type_id',$res)->where('a.cont_states',1)->count('a.cont_id');
       //数据表总数据条数;
    $maxPage=ceil($totalRows/$pageSize);
    if($page<1){
      $page=1;
    }
    if($page>$maxPage){
      $page=$maxPage;
    }

      $data=db()->table('qy_contents a,qy_types b')->where('a.cont_pid =b.type_id')->field('a.cont_id,a.cont_title,a.cont_img,a.createtime,b.type_name')->whereIn('type_id',$res)->where('a.cont_states',1)->order('a.cont_id desc')->page($page,$pageSize)->select();
      
		}else
		{
      $totalRows=db('contents')->where('cont_states',1)->count('cont_id');
      //数据表总数据条数;
    $maxPage=ceil($totalRows/$pageSize);
    if($page<1){
      $page=1;
    }
    if($page>$maxPage){
      $page=$maxPage;
    }

			 $data=db()->table('qy_contents a,qy_types b')->where('a.cont_pid =b.type_id')->field('a.cont_id,a.cont_title,a.cont_img,a.createtime,b.type_name')->where('a.cont_states',1)->order('a.cont_id desc')->page($page,$pageSize)->select();
       
		}

    
    //halt($data);
	     $this->assign('pid',$pid);
      $this->assign('totalRows',$totalRows);
      $this->assign('page',$page);
      $this->assign('maxPage',$maxPage);
       $this->assign('data',$data);

       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    //提交方法
    public function article_add()
    {
    	 //获取管理员
		//halt($_POST);
       $typesdata=db('types')->select();
       $arr=$this->GetTree($typesdata, 0, 0);
       $this->assign('arr',$arr);
       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);

       //提交数据
       if(request()->isPost())
            {
				//halt($_POST);
               $article=new A();
                $res=$article->art_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

    		return $this->fetch();
    }
    //修改方法
    public function article_edit()
    {

		//halt($_POST);
       $typesdata=db('types')->select();
       $arr=$this->GetTree($typesdata, 0, 0);
       $this->assign('arr',$arr);
       //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
       //获得要修改的信息
       $id=input('param.cont_id');
       $data=db('contents')->where('cont_id',$id)->find();
       $this->assign('data',$data);
       //修改数据提交
       if(request()->isPost())
            {
				//halt($_POST);
               $article=new A();
                $res=$article->art_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

    		return $this->fetch();
    }
   //删除方法(假删除）
   public function  article_dele()
   {
   			if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->art_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //上架
   public function  article_update()
   {
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->art_update(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //删除
   public function  article_deled()
   {
        if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->art_deled(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
   }
   //移动产品到分类
  public function article_editzhi()
  {
      //halt($_POST);
      if(request()->isPost())
            {
        //halt($_POST);
               $types=new A();
                $res=$types->art_editzhi(input('post.'));
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
