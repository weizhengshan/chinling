<?php
namespace app\admin\controller;

use app\common\model\Protypes as A;
use app\common\model\Typesales as B;
class Typesales extends Common
{
    
 	public function index()
    {
    	$this->base();
    	  $typesdata=db()->table('qy_typesales')
			->alias('a')
			->join('protypes w','a.sales_copid = w.protype_id')
			->where('sales_states',1)
			->order('sales_sort')
			->select();
      
      foreach($typesdata as $k=>$v)
      {
          $v['data']=explode(',',$v['sales_val']);
          $typesdata[$k]=$v;
      }
     //halt($typesdata);
        $this->assign('typesdata',$typesdata);
    	return $this->fetch();
    }
    public function sales_add()
    {
    	$this->base();
    	$typesdata=db('protypes')->where('protype_name','大数据')->find();
    	$getArr= new A();
    	$res=$getArr->prod_son($typesdata['protype_id']);
    	$typesdata=db('protypes')->whereIN('protype_id',$res)->select();
       	$arr=$this->GetTree($typesdata, 0, 0);
      //月份
      $month_data='一,二,三,四,五,六,七,八,九,十,十一,十二';
      $month_arr=explode(',',$month_data);
      $this->assign('month_arr',$month_arr);   
      $this->assign('arr',$arr);
      //添加
        if(request()->isPost())
            {
            //halt($_POST);
               $type_add=new B();
                $res=$type_add->sales_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
      return $this->fetch();
    }
    public function sales_edit()
    {
     $this->base();
      $typesdata=db('protypes')->where('protype_name','大数据')->find();
      $getArr= new A();
      $res=$getArr->prod_son($typesdata['protype_id']);
      $typesdata=db('protypes')->whereIN('protype_id',$res)->select();
      $arr=$this->GetTree($typesdata, 0, 0);
      //月份
      $month_data='一,二,三,四,五,六,七,八,九,十,十一,十二';
      $month_arr=explode(',',$month_data);
      $this->assign('month_arr',$month_arr);   
      $this->assign('arr',$arr);
      //数据
      $id=input('param.sales_id');
      $data=db('typesales')->where('sales_id',$id)->find();
      $data['data_val']=explode(',',$data['sales_val']);
      //halt($data);
      $this->assign('data',$data);
       //修改
        if(request()->isPost())
            {
            //halt($_POST);
               $type_add=new B();
                $res=$type_add->sales_edit(input('post.'));
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