<?php
namespace app\admin\controller;

use app\common\model\CountyArea as A;
class CountyArea extends Common
{
    
 	public function index()
    {
       $this->base();

       $typesdata=db('countys')->where('county_states',1)->order('county_sort')->select(); 
       	 $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
         //halt($typesdata);
    	return $this->fetch();
    }

    public function countys_add()
    {
    	 $this->base();
    	 $typesdata=db('countys')->where('county_states',1)->order('county_sort')->select();
         
        $arr=$this->GetTree($typesdata, 0, 0);
         $this->assign('arr',$arr);
          if(request()->isPost())
            {
				//halt($_POST);
               $county=new A();
                $res=$county->county_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
     
       return $this->fetch();
    }
    public function countys_edit()
    {
    	$this->base();
       if(request()->isPost())
            {
        //halt($_POST);
               $county=new A();
                $res=$county->county_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
    	$id=input('param.county_id'); 
    	if($id)
        {
        $type_edit=new A();
        $res=$type_edit->getSon(input('param.county_id'));
        $arr=$this->GetTree($res, 0, 0);
         $this->assign('arr',$arr);
        }
       	 
        
        $data=db('countys')->where('county_states',1)->where('county_id',$id)->find();
        $this->assign('data',$data);
         
    	return $this->fetch();
    }
    public function county_dele()
    {
    	if(request()->isPost())
            {
        //halt($_POST);
               $county=new A();
                $res=$county->county_dele(input('post.'));
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
}