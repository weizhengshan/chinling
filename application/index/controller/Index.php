<?php
namespace app\index\controller;

use think\Model;  
class Index extends Common
{
	//网站首页
    public function index()
    {
       $this->base();
       //访问量
       $this->fwl();
        //模块数据
        $ModularData=db('carousel')->where('caro_states',1)->where('pid',2)->field('caro_img,action,caro_name')->order('caro_sort')->limit(4)->select();
        $this->assign('ModularData',$ModularData);
        //运营模式图
        $Pattern=db('carousel')->where('caro_states',1)->where('pid',3)->where('caro_zh',1)->order('caro_sort')->field('caro_img,caro_name')->limit(5)->select();
        
        $Pattern_one=db('carousel')->where('caro_states',1)->where('pid',3)->where('caro_zh',2)->order('caro_sort')->field('caro_img')->limit(5)->select();
        for($i=0;$i<count($Pattern_one);$i++)
        {
          $Pattern[$i]['imgtwo']=$Pattern_one[$i]['caro_img'];

        }
        $this->assign('Pattern',$Pattern);
        //首页id值等于三;
        $mo_name='首页';
        $data_id=db('types')->where('type_name',$mo_name)->column('type_id');
        $this->assign('pid',$data_id[0]); 
        return $this->fetch();
    }
    
      //访问记录
    public function fwl()
    {
        $Ip=getIP();
        $time=time();
    $date['btime']=$time;
    $y_Id=db("fwl")->where("ip='{$Ip}'")->column('fid');
    //return $y_Id;
        if(!empty($y_Id))
        {
            $y_count=db("fwl")->where("ip='{$Ip}'")->column("count");
        
            $y_time=db("fwl")->where("ip='{$Ip}'")->column("btime");
            //halt($y_time);
            $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        
            $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            if($y_time[0]>$beginToday && $y_time[0]<$endToday)
            {
                $date['count']=$y_count[0]+1;
                $date['btime']=$time;
                $add_IP=db("fwl")->where("ip='{$Ip}'")->update(['count'=>$y_count[0]+1,'btime'=>$time]);
            }else
            {
                $date['ip']=$Ip;
                $date['btime']=$time;
                $date['count']=1;
                $add_IP=db("fwl")->insert($date);
            }
        }else
        {
            $date['ip']=$Ip;
            $date['count']=1;
            $add_IP=db("fwl")->insert($date);
        }
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
