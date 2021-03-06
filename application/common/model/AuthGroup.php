<?php
namespace app\common\model;
use think\Model;
class AuthGroup extends Model
{

     protected  $pk='id';//主键
    protected $table = 'qy_auth_group';
    //添加
    public function auth_gadd($data)
    {

        if(empty($data['rules']))
        {
             return ['valid'=>8,'msg'=>'权限配置不能为空'];
             exit;
        }
        $rules=implode(',',$data['rules']);
        $arr['status']=1;
        $arr['title']=$data['title'];
        $arr['rules']=$rules;
        //判断是否为外来注册 
        
        //判断名称是否唯一
        $type_yan=$this->where('title',$data['title'])->find();
     
        if($type_yan['id']!="")
        {
             return ['valid'=>0,'msg'=>'名称重复'];
             exit;
        }
        //halt($user_yan);
        $result = $this->save($arr);
        
        if(false === $result){
            // 验证失败 输出错误信息
            return ['valid'=>1,'msg'=>'添加失败'];
        }else{

          $caozuo='添加用户组';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
            return ['valid'=>4,'msg'=>'添加成功'];
        }
    }

    //修改信息
    public  function auth_gedit($data)
    {
          if(empty($data['rules']))
        {
             return ['valid'=>8,'msg'=>'权限配置不能为空'];
             exit;
        }
        $rules=implode(',',$data['rules']);
        $arr['status']=1;
        $arr['title']=$data['title'];
        $arr['rules']=$rules;
        //判断是否为外来注册
        //halt($user_yan);
        $result = $this->save($arr,['id'=>$data['id']]);
        
        if(false === $result){
            // 验证失败 输出错误信息
            return ['valid'=>3,'msg'=>'修改失败'];
        }else{
          $caozuo='修改用户组';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
            return ['valid'=>4,'msg'=>'修改成功'];
        }
    }
    //删除分类(如果有子分类不删除)
    public function auth_gdele($data)
    {
        //halt($data); 
        $res=$this->where('id',$data['id'])->update(['status'=>'0']);
        if($res)
            {
              $caozuo='下架用户组';
            //添加操作记录
            $arr=caozuo($caozuo);
            $res=db('operat')->insert($arr);
                return ['valid'=>4,'msg'=>'删除成功'];
            }else{
                return ['valid'=>3,'msg'=>'删除失败'];
            }
        
    }





    /**
    * 获得不是自己和自己子集的数据
    */
   public function getSon($type_id)
   {
        $allData=$this->select();
       //获得自己和自己子集的cate_id
       $sonDate=$this->getSonId($allData,$type_id);
       //把自己id加进去
       $sonDate[]=$type_id;
      //halt($sonDate);
       //获得需要的栏目
       $cateInfo=$this->whereNotIn('id',$sonDate)->where('status',1)->select();

       return   $cateInfo;
   }
   /**
    * 获得子集type_id
    */
   public function getSonId($allData,$type_id)
   {
        static $tmp=array();
        foreach($allData as $k=>$v)
        {
           if($type_id==$v['pid']){
             $tmp[]=$v['id'];
             $this->getSonId($allData,$v['id']);
           }
          
        }
        return $tmp;
    }




    public function getchilrenid($authRuleId){
        $AuthRuleRes=$this->select();
        return $this->_getchilrenid($AuthRuleRes,$authRuleId);
    }

    public function _getchilrenid($AuthRuleRes,$authRuleId){
        static $arr=array();
        foreach ($AuthRuleRes as $k => $v) {
            if($v['pid'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getchilrenid($AuthRuleRes,$v['id']);
            }
        }

        return $arr;
    }


    public function getparentid($authRuleId){
        $AuthRuleRes=$this->select();
        return $this->_getparentid($AuthRuleRes,$authRuleId,True);
    }

    public function _getparentid($AuthRuleRes,$authRuleId,$clear=False){
        static $arr=array();
        if($clear){
        	$arr=array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if($v['id'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getparentid($AuthRuleRes,$v['pid'],False);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }


}
