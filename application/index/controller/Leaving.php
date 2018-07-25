<?php
namespace app\index\controller;

use app\index\model\Leaving as A;
class Leaving extends Common
{
    //文章展示
    public function index()
    {
        $this->base();
         $id=input('param.type_pid');
         $this->assign('pid',$id); 
        return $this->fetch();
    }
    public function leav_add()
    {
        //halt($_POST);
        if(request()->isPost())
        {
                $leaving= new A();
                $res=$leaving->leav_add(input('post.'));
                 $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
        }
    }
    /*
    *引入地图
     */
    public function map()
    {
         return $this->fetch();
    }
}
