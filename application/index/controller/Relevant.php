<?php
namespace app\index\controller;

class Relevant extends Common
{
	//产业园介绍
    public function index()
    {

        //关于我们的信息
        $id=input('param.type_pid');
        $wenid=input('param.wen_id');
        if($wenid=="")
        {
          //获得产品的第一个id
           $dataid=db('types')->where('type_pid',$id)->field('type_id')->find();
           $wenid=$dataid['type_id'];
        }
        $type=db('types')->where('type_id',$id)->find();
        $typeson=db('types')->where('type_pid',$type['type_id'])->select();

        $newdata=db('contents')->where('cont_pid',$wenid)->find();
         //halt($typeson);
        $this->assign('newdata',$newdata);
        $this->assign('type',$type);
        $this->assign('typeson',$typeson);
        //logo
        $logo=db('logo')->where('caro_states',1)->column('logo_img');
        $this->assign('logo',$logo[0]);
        //轮播图
        $imgdata=db('carousel')->where('caro_states',1)->field('caro_img')->select();
        //halt($imgdata);
        $this->assign('imgdata',$imgdata);
        //分类导航
        $typedata=db('types')->where('type_pid',1)->select();
        foreach($typedata as $k=>$v)
        {
            $v['typeson']=db('types')->where('type_pid',$v['type_id'])->select();
            $typedata[$k]=$v;
        }
        //halt($typedata);
        $this->assign('typedata',$typedata);
        return $this->fetch();
    }
}
