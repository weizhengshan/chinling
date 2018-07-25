<?php
namespace app\index\controller;

use think\Controller;  
class Common  extends Controller
{
   public function base()
    {
          //logo
        $logo=db('logo')->where('caro_states',1)->column('logo_img');
        $this->assign('logo',$logo);
        //顶级栏目
        $topdata=db('types')->where('type_pid',1)->order('type_sort')->select();
        foreach($topdata as $k=>$v)
        {
            $v['typeson']=db('types')->where('type_pid',$v['type_id'])->order('type_sort')->select();
            $topdata[$k]=$v;
        }

        //halt($topdata);
        $this->assign('topdata',$topdata);
        //店铺管理
        $shopdata=db('types')->where('type_pid',30)->select();
        //halt($shopdata);
        $this->assign('shopdata',$shopdata);
        //pc轮播图
        $imgdata=db('carousel')->where('caro_states',1)->where('pid',1)->order('caro_sort')->limit(5)->field('caro_img')->select();
        //halt($imgdata);
        $this->assign('imgdata',$imgdata);
        //手机轮播图
        $shouimgdata=db('carousel')->where('caro_states',1)->where('pid',4)->order('caro_sort')->limit(5)->field('caro_img')->select();
        //halt($imgdata);
        $this->assign('shouimgdata',$shouimgdata);
        //底部导航
         $bottomdata=db('types')->where('type_pid',31)->select();
        foreach($bottomdata as $k=>$v)
        {  

            //$v['typeson']=db('types')->where('type_pid',$v['type_id'])->select();
            if($v['priority']!=false)
            {
            	$v['type_id']=$v['priority'];
            }
            $bottomdata[$k]=$v;
        }
        //halt($bottomdata);
        $this->assign('bottomdata',$bottomdata);
        //halt($bottomdata);
        //微博链接
        $weibodata=db('types')->where('type_pid',40)->find();
        //halt($weibodata);
        $this->assign('weibodata',$weibodata);
        //网站配置
        $website=db('config')->find();
        $this->assign('website',$website);
        //关键词.描述
        $web=db('config')->where('conf_id',1)->field('site,describe')->find();
       //halt($web);
        $this->assign('web',$web);

    } 
}

