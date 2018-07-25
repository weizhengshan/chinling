<?php
namespace app\admin\controller;

use app\common\model\CountyType as A;
use app\common\model\Protypes as B;
class CountyType extends Common
{
    
 	public function index()
    {
       $this->base();
      
       //$typesdata=db('biginfo')->where('biginfo_states',1)->order('biginfo_sort')->select();
       $page=input('param.page');//当前页默认为第一页;
       $pageSize=10;//每页显示条数为5条；
       $totalRows=db()->table('qy_varietiesy')
            ->alias('a')
            ->where('varies_states',1)
            ->count('a.varies_id');
       $maxPage=ceil($totalRows/$pageSize);
          if($page<1){
            $page=1;
          }
          if($page>$maxPage){
            $page=$maxPage;
          }
       $typesdata=db()->table('qy_varietiesy')
			->alias('a')
			->join('countys w','a.varies_copid = w.county_id')
            ->join('protypes h','a.varies_agpid =h.protype_id')
            ->join('salesdirection s','a.varies_id = s.saledir_pid','left')
			->where('varies_states',1)
			->order('varies_sort')
            ->field('a.varies_id,a.varies_name,a.varies_grade,a.varies_sort,w.county_name,h.protype_name,s.saledir_id')
            ->page($page,$pageSize)
			->select();
          //halt($typesdata);
         $this->assign('typesdata',$typesdata);
         $this->assign('totalRows',$totalRows);
         $this->assign('page',$page);
         $this->assign('maxPage',$maxPage);
         $keyword="";
         $this->assign('keyword',$keyword);
         //halt($typesdata);
    	return $this->fetch();
    }
    /*筛选*/
    public function search()
    {
        $this->base();
        $page=input('param.page');//当前页默认为第一页;
        $pageSize=10;
        $keyword=input('param.keyword');

       if($keyword)
       {
           //产品名称
            $typesdata=db()->table('qy_varietiesy')
            ->alias('a')
            ->join('countys w','a.varies_copid = w.county_id')
            ->join('protypes h','a.varies_agpid =h.protype_id')
            ->join('salesdirection s','a.varies_id = s.saledir_pid','left')
            ->where('varies_name','like','%'.$keyword.'%') 
            ->where('varies_states',1)
            ->field('a.varies_id,a.varies_name,a.varies_grade,a.varies_sort,w.county_name,h.protype_name,s.saledir_id')
            ->order('varies_sort')
            ->page($page,$pageSize)
            ->select();
           //地区名
       }else
       {

        $this->redirect('admin/countyType/index');
       }
        //echo 1;
        $this->assign('keyword',$keyword);
        $this->assign('typesdata',$typesdata);
        //halt($typesdata);
        return $this->fetch('index');
    }
    public function countyt_add()
    {
  
    	 $this->base();
         /*地区*/
         $id='';
    	 $this->get_addr($id);
         /*品种*/
         $this->get_protype();
          if(request()->isPost())
            {
				//halt($_POST);
               $county=new A();
                $res=$county->countyt_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
       	  return $this->fetch();
    }
    /**
     * 获得地址数据
     * @return [type] [description]
     */
    public function get_addr($id)
    {
        if(empty($id)){
        $typesdata=db('countys')->where('county_states',1)->where('pid',1)->order('county_sort')->select();
         //halt($typesdata);
         //$arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$typesdata);
        }else
        {
         $typesdata=db('countys')->where('county_states',1)->where('pid',1)->order('county_sort')->select();
         $this->assign('arr',$typesdata);
           $citydata=db('countys')->where('county_states',1)->where('county_id',$id)->find();
           $citydatas=db('countys')->where('county_states',1)->where('pid',$citydata['pid'])->select();
           $prodata=db('countys')->where('county_states',1)->where('county_id',$citydata['pid'])->find();
           $prodatas=db('countys')->where('county_states',1)->where('pid',$prodata['pid'])->select();
         $this->assign('prodata',$prodatas); 
         $this->assign('citydata',$citydatas);
         $this->assign('cityid',$citydata['pid']);
         $this->assign('provid',$prodata['pid']);
         }
    }
    /**
     * 获得产品分类
     * @return [type] [description]
     */
    public function get_protype()
    {
          $typesdata=db('protypes')->where('protype_name','大数据')->find();
         $typesdatas=db('protypes')->where('protype_pid',$typesdata['protype_id'])->select();
       /* $getArr= new B();
        $res=$getArr->prod_son($typesdata['protype_id']);
        $typesdatas=db('protypes')->whereIN('protype_id',$res)->select();*/
        //$arr_data=$this->GetTreezhi($typesdatas, 0, 0);
        //halt($arr_data);
        //return $typesdatas;
         $this->assign('arrdata',$typesdatas);
    }
    public function countyt_edit()
    {
    	$this->base();
         $id=input('param.varies_id'); 
          $data=db('varietiesy')->where('varies_states',1)->where('varies_id',$id)->find();
          /*地区*/
         $this->get_addr($data['varies_copid']);
         //halt($data);
         $this->assign('typesdata',$data);
         /*品种*/
         $typesdata=db('protypes')->where('protype_name','大数据')->find();
        $getArr= new B();
        $res=$getArr->prod_son($typesdata['protype_id']);
        $typesdatas=db('protypes')->whereIN('protype_id',$res)->select();
        $arr_data=$this->GetTreezhi($typesdatas, 0, 0);
        //halt($arr_data);
         $this->assign('arrdata',$arr_data);
        

          if(request()->isPost())
            {
				//halt($_POST);
               $county=new A();
                $res=$county->countyt_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
         return $this->fetch();
    }
    //判断没有信息的县产品
    public function isNULLPro()
    {
        //查出公共的id
         $typesdata=db()->table('qy_varietiesy')
            ->alias('a')
            ->join('varieties v','v.varie_name = a.varies_id')
            //->join('salesdirection s','a.varies_id = s.saledir_pid','left')
            ->where('varies_states',1)
            ->field('a.varies_id')
            ->order('varies_sort')
            ->select();
           //halt($typesdata);
           $getId=[];
            for($i=0;$i<count($typesdata);$i++)
            {
               $getId[$i]=$typesdata[$i]['varies_id'];     
            }
                //halt($getId);
        
        //根据公共的得出没有添加的id  通过id下架
        $nullId=db('varietiesy')->whereNotIn('varies_id',$getId)->where('varies_states',1)->field('varies_id')->select();
        //halt($nullId);
        $getNOId=[];
        for($i=0;$i<count($nullId);$i++)
            {
               $getNOId[$i]=$nullId[$i]['varies_id'];     
            }
         //halt($getNOId);   
        return $getNOId; 
    }
    //将没有信息的产品下架
    public function downPro()
    {
        $size=input('size');
        if(isset($size))
        {
            $size=input($size);
        }else
        {
            $size=0;
        }
        $getNOProId=$this->isNULLPro();
        //halt($getNOProId);
      if(!empty($getNOProId))
      {
            $count=count($getNOProId);
            $editState= new A();
            $data=array(
                  'id'=>$getNOProId[$size],
                  'size'=>$size 
            );
            $res=$editState->editState($data);
            if($res['status']=4 && $res['size']<$count)
            {
                echo $res['size'];
                $this->downPro($res['size']);

            }elseif($res['status']=1)
            {
                 $this->downPro($res['size']);
            }else
            {
                echo '更新完成';
            }
        }else
        {
            echo '已更新';
        }
    }

    //模拟添加销量去向
    public function simulationSalesDirection()
    {
         $typesdatas=$this->get_protype();
         
         halt($typesdatas);

    }
     public function countyt_dele()
    {
    	if(request()->isPost())
            {
        //halt($_POST);
               $county=new A();
                $res=$county->countyt_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
    }
    /**
     * 
     *查询地址市/县
     */
    public function provice_post()
    {
        $id=input('param.add'); 
         $typesdata=db('countys')->where('county_states',1)->where('pid',$id)->field('county_id,county_name')->order('county_sort')->select();
         echo json_encode($typesdata);
    }
    /**
     * 
     *查询产品分类
     */
    public function pinzh_post()
    {
        $id=input('param.add'); 
         $typesdata=db('protypes')->where('protype_states',1)->where('protype_pid',$id)->field('protype_id,protype_name')->order('protype_sort')->select();
         echo json_encode($typesdata);
    }
   //无限级分类
	  private function GetTree($arr,$pid,$step)
	  {
		    global $tree;
		    foreach($arr as $key=>$val) {
		        if($val['pid'] == $pid) {
		            $flg = str_repeat('└―',$step);
		            $val['county_name'] = $flg.$val['county_name'];
		            $tree[] = $val;
		            $this->GetTree($arr , $val['county_id'] ,$step+1);
		        }
		    }
		    return $tree;
	  }
          //无限级分类
  private function GetTreezhi($arr,$pid,$step){
    global $tdata;
    foreach($arr as $key=>$val) {
        if($val['protype_pid'] == $pid) {
            $flg = str_repeat('└―',$step);
            $val['protype_name'] = $flg.$val['protype_name'];
            $tdata[] = $val;
            $this->GetTreezhi($arr , $val['protype_id'] ,$step+1);
        }
    }
    return $tdata;
    } 
}