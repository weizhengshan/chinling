<?php
namespace app\admin\controller;

use app\common\model\CountyTypeV as A;
use app\common\model\Protypes as B;
class CountyTypeV extends Common
{
    
 	public function index()
    {
       $this->base();

       //$typesdata=db('biginfo')->where('biginfo_states',1)->order('biginfo_sort')->select();
       
       $typesdata=db()->table('qy_varieties')
			->alias('a')
            ->join('varietiesy v','a.varie_name =v.varies_id')
			->join('countys w','v.varies_copid = w.county_id')
            ->join('protypes h','v.varies_agpid =h.protype_id')
			->where('varie_states',1)
			->order('varie_sort')
			->select();
        //halt($typesdata);   
        foreach($typesdata as $k=>$v)
          {
              $v['data_sales']=explode(',',$v['varie_sales']);
              $v['data_yield']=explode(',',$v['varie_yield']);
              $typesdata[$k]=$v;
          }
          //halt($typesdata);
         $this->assign('typesdata',$typesdata);
         //halt($typesdata);
    	return $this->fetch();
    }

    public function countyt_add()
    {
       
    	 $this->base();
         /*地区*/
    	 $typesdata=db('countys')->where('county_states',1)->order('county_sort')->select();
         //halt($typesdata);
       	 $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
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
			$data=input('post.');
            $dump=db('varietiesy')->where('varies_copid',$data['varie_copid'])->where('varies_agpid',$data['varie_agpid'])->field('varies_id')->find();
            $data['varies_id']=$dump['varies_id'];
               $county=new A();
                $res=$county->countyt_add($data);
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
       	  return $this->fetch();
    }
    public function countyt_edit()
    {
    	$this->base();
         if(request()->isPost())
            {
            $data=input('post.');
            $dump=db('varietiesy')->where('varies_copid',$data['varie_copid'])->where('varies_agpid',$data['varie_agpid'])->field('varies_id')->find();
            $data['varies_id']=$dump['varies_id'];
               $county=new A();
                $res=$county->countyt_edit($data);
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
    	$typesdata=db('countys')->where('county_states',1)->order('county_sort')->select();
       	 $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
         $id=input('param.varie_id'); 
         /*品种*/
         $typesdata=db('protypes')->where('protype_name','大数据')->find();
        $getArr= new B();
        $res=$getArr->prod_son($typesdata['protype_id']);
        $typesdatas=db('protypes')->whereIN('protype_id',$res)->select();
        $arr_data=$this->GetTreezhi($typesdatas, 0, 0);
        //halt($arr_data);
         $this->assign('arrdata',$arr_data);
         $data=db('varieties')->where('varie_states',1)->where('varie_id',$id)->find();
         //halt($data);
         $data_pid=db('varietiesy')->where('varies_id',$data['varie_name'])->field('varies_copid,varies_agpid')->find();
         $data['varies_copid']=$data_pid['varies_copid'];
         $data['varies_agpid']=$data_pid['varies_agpid'];
         $data['data_sales']=explode(',',$data['varie_sales']);
         $data['data_yield']=explode(',',$data['varie_yield']);
         $this->assign('typesdata',$data);

         
         return $this->fetch();
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