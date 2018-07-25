<?php
namespace app\index\controller;

class Products extends Common
{
	//产品介绍
    public function index()
    {
    	  $this->base();
        //产品展示
        
         $protype=db('protypes')->where('protype_states',2)->where('protype_pid',1)->select();
         foreach($protype as $k=>$v)
        {
            $v['proson']=db('protypes')->where('protype_pid',$v['protype_id'])->select();
            $protype[$k]=$v;
        }

    	//判断
    	//type_pid
      $id=input('param.type_pid');
    	$type_pid=input('param.types_pid');
      $wenid=input('param.wen_id');
          //根据判断获得自己和自己的子集
        $page=input('param.page');//当前页默认为第一页;
        $pageSize=15;//每页显示条数为5条； 
        if($type_pid=="")
        {
             
             $totalRows=db('products')->where('prod_states',1)->count('prod_id');
              $maxPage=ceil($totalRows/$pageSize);
             if($page<1){
                $page=1;
              }
              if($page>$maxPage){
                $page=$maxPage;
              }
              $proson=db('products')->where('prod_states',1)->page($page,$pageSize)->select();

        }else
        {

        	if($wenid=="")
        	{
        		$res=$this->art_son($type_pid);
        		//halt($res);
        	
             
             $totalRows=db('products')->where('prod_states',1)->whereIn('protype_pid',$res)->count('prod_id');

             $maxPage=ceil($totalRows/$pageSize);
             if($page<1){
                $page=1;
              }
              if($page>$maxPage){
                $page=$maxPage;
              }
              $proson=db('products')->where('prod_states',1)->whereIn('protype_pid',$res)->page($page,$pageSize)->select();

        	}else
        	{
        		

             $totalRows=db('products')->where('prod_states',1)->where('protype_pid',$wenid)->count('prod_id');

             $maxPage=ceil($totalRows/$pageSize);
             if($page<1){
                $page=1;
              }
              if($page>$maxPage){
                $page=$maxPage;
              }
             $proson=db('products')->where('prod_states',1)->where('protype_pid',$wenid)->page($page,$pageSize)->select(); 
        	}
           
        }
          //$res=db('recruit')->where('states',1)->order('sort')->page($page,$pageSize)->select();
        
          $this->assign('totalRows',$totalRows);
          $this->assign('page',$page);
          $this->assign('maxPage',$maxPage); 
          $this->assign('type_pid',$type_pid);
          $this->assign('wenid',$wenid);
          $this->assign('pid',$id); 
          //halt($protype);
          $this->assign('protype',$protype);
          $this->assign('proson',$proson);

        return $this->fetch();
    }
     /**
    * 获得自己和自己的子集
    */
   public function art_son($type_id)
   {
   		$allData=db('protypes')->select();
   	   //获得自己和自己子集的cate_id
   	   $sonDate=$this->getSonId($allData,$type_id);
   	   //把自己id加进去
   	   $sonDate[]=$type_id;
   	   return $sonDate;
   }
	
   /**
    * 获得子集type_id
    */
   public function getSonId($allData,$type_id)
   {
   		static $tmp=array();
   		foreach($allData as $k=>$v)
   		{
   		   if($type_id==$v['protype_pid']){
   		   	 $tmp[]=$v['protype_id'];
   		   	 $this->getSonId($allData,$v['protype_id']);
   		   }
   		  
   		}
   		return $tmp;
   	}
	
}
