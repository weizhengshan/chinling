<?php
namespace app\index\controller;

class About extends Common
{
    //文章展示
    public function show()
    {
         $this->base();
        //关于我们的信息
        $id=input('param.type_pid');
        $wenid=input('param.wen_id');
        if($id=="")
        {

          $id=3;
        }
        
       $this->assign('wenid',$wenid);
       //halt($wenid);
        $type=db('types')->where('type_id',$id)->find();

        $typeson=db('types')->where('type_pid',$type['type_id'])->order('type_sort')->select();
         if($wenid=="")
        {
          //获得产品的第一个id
           $dataid=db('types')->where('type_pid',$id)->order('type_sort')->field('type_id')->find();
           $wenid=$dataid['type_id'];
        }
        $newdata=db('contents')->where('cont_pid',$wenid)->where('cont_states',1)->find();
         //halt($newdata);
         $this->assign('pid',$id); 
        $this->assign('newdata',$newdata);
        $this->assign('type',$type);
        $this->assign('typeson',$typeson);
        $this->assign('wenid',$wenid);
        return $this->fetch();
    }
}
