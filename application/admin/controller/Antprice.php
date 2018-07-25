<?php
namespace app\admin\controller;

use app\common\model\Antprice as B;
use app\common\model\Protypes as C;
use app\common\model\Protypes as A;
class Antprice extends Common
{
    
 	public function index()
    {
    	$this->base();
    	  $typesdata=db()->table('qy_varietprice')
			->alias('a')
			->join('varietiesy v','a.price_varpid =v.varies_id')
			->join('countys w','v.varies_copid = w.county_id')
			->where('price_states',1)
			->select();
      
      foreach($typesdata as $k=>$v)
      {
          $v['data']=explode(',',$v['price_val']);
          $typesdata[$k]=$v;
      }
     //halt($typesdata);
        $this->assign('typesdata',$typesdata);
    	return $this->fetch();
    }
    public function antprice_add()
    {
    	$this->base();
         /*地区*/
    	 $typesdata=db('countys')->where('county_states',1)->order('county_sort')->select();
         //halt($typesdata);
       	 $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
         /*品种*/
         $typesdata=db('protypes')->where('protype_name','大数据')->find();
        $getArr= new C();
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
               $county=new B();
                $res=$county->antprice_add($data);
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
        return $this->fetch();
    }
    /*修改*/
     public function antprice_edit()
    {
    	$this->base();
         if(request()->isPost())
            {
            $data=input('post.');
            $dump=db('varietiesy')->where('varies_copid',$data['varie_copid'])->where('varies_agpid',$data['varie_agpid'])->field('varies_id')->find();
            $data['varies_id']=$dump['varies_id'];
               $county=new B();
                $res=$county->antprice_edit($data);
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }    
    	$typesdata=db('countys')->where('county_states',1)->order('county_sort')->select();
       	 $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
         $id=input('param.price_id'); 
         /*品种*/
         $typesdata=db('protypes')->where('protype_name','大数据')->find();
        $getArr= new A();
        $res=$getArr->prod_son($typesdata['protype_id']);
        $typesdatas=db('protypes')->whereIN('protype_id',$res)->select();
        $arr_data=$this->GetTreezhi($typesdatas, 0, 0);
        //halt($arr_data);
         $this->assign('arrdata',$arr_data);
         $data=db('varietprice')->where('price_states',1)->where('price_id',$id)->find();
         //halt($data);
         $data_pid=db('varietiesy')->where('varies_id',$data['price_varpid'])->field('varies_copid,varies_agpid')->find();
         $data['varies_copid']=$data_pid['varies_copid'];
         $data['varies_agpid']=$data_pid['varies_agpid'];
         $data['data']=explode(',',$data['price_val']);
         $this->assign('typesdata',$data);
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