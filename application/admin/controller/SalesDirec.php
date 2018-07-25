<?php
namespace app\admin\controller;


use app\common\model\SalesDirec as A;
class SalesDirec extends Common
{
    /*直接进来*/
 	public function index()
    {
       $this->base();
       $page=input('param.page');//当前页默认为第一页;
       $pageSize=10;//每页显示条数为5条；
       $totalRows=db()->table('qy_salesdirection')
            ->alias('a')
            ->where('saledir_states',1)
            ->count('a.saledir_id');
       $maxPage=ceil($totalRows/$pageSize);
          if($page<1){
            $page=1;
          }
          if($page>$maxPage){
            $page=$maxPage;
          }
       $typesdata=db()->table('qy_salesdirection')
			->alias('a')
			->join('varietiesy w','a.saledir_pid = w.varies_id')
			->join('countys c','w.varies_copid = c.county_id')
            ->join('protypes h','w.varies_agpid =h.protype_id')
			->where('saledir_states',1)
			->order('saledir_id desc')
			->field('a.saledir_id,a.saledir_name,a.saledir_year,a.saledir_value,w.varies_name,c.county_name,h.protype_name')
            ->page($page,$pageSize)
			->select();
		foreach($typesdata as $k=>$v)
		{
			 $v['name_saledir']=explode(',',$v['saledir_name']);
			 $v['value_saledir']=explode(',',$v['saledir_value']);
			 $typesdata[$k]=$v;	
		}	
          //halt($typesdata);
         $this->assign('typesdata',$typesdata);
         $this->assign('totalRows',$totalRows);
         $this->assign('page',$page);
         $this->assign('maxPage',$maxPage);

       return $this->fetch();
    }
    public function getFindArr()
    {
    	$this->base();
    	$id=input('param.varies_id');
    	/*if($id )
    	{
    		
    	}*/
    	 $typesdata=db()->table('qy_salesdirection')
			->alias('a')
			->join('varietiesy w','a.saledir_pid = w.varies_id')
			->join('countys c','w.varies_copid = c.county_id')
            ->join('protypes h','w.varies_agpid =h.protype_id')
			->where('varies_states',1)
			->where('saledir_pid',$id)
			->order('saledir_id desc')
			->field('a.saledir_id,a.saledir_name,a.saledir_year,a.saledir_value,w.varies_name,c.county_name,h.protype_name')
			->select();	
		foreach($typesdata as $k=>$v)
		{
			 $v['name_saledir']=explode(',',$v['saledir_name']);
			 $v['value_saledir']=explode(',',$v['saledir_value']);
			 $typesdata[$k]=$v;	
		}		
		$this->assign('typesdata',$typesdata);
		if(empty($typesdata))
		{
			$this->redirect('admin/SalesDirec/dire_add',array('varies_id'=>$id));	
		}
    	return $this->fetch('index');
    }
    private function getData($id)
    {
    	$data=db('varietiesy')
    		 ->where('varies_id',$id)
    		 ->where('varies_states',1)
    		 ->field('varies_copid,varies_agpid,varies_name,varies_id')
    		 ->find();
        return $data;
    }
	/*判断是否添加过*/
	private function isSaleValue($id)
	{
		$isPremiseValue=$this->getData($id);
		if($isPremiseValue['varies_id']){
			$isValue=db('salesdirection')
		       ->where('saledir_pid',$id)
		       ->where('saledir_states',1)
		       ->field('saledir_id')
		       ->find();
		    return $isValue; 
		}else{
			$isValue['saledir_id']="厉害了";
			return $isValue; 
		}
		     
	}
    public function dire_add()
    {
    	 /*提交*/
       if(request()->isPost())
            {
        //halt($_POST);
               $type_add=new A();
                $res=$type_add->type_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
       $this->base();
       $id=input('param.varies_id');
       /*判断是否添加过*/
       $isValue=$this->isSaleValue($id);
       //halt($isValue);
       if($isValue['saledir_id']=="")
       {
	       	if(empty($id))
	       {
	       	 $this->redirect('countyType/index');
	       }
	       $data=$this->getData($id);
	       //获得县和产品名称
	       $getCountyName=db('countys')
	       		 ->where('county_id',$data['varies_copid'])
	       		 ->field('county_name')
	       		 ->find();
	       $getTypeName=db('protypes')
	             ->where('protype_id',$data['varies_agpid'])
	             ->field('protype_name')
	             ->find();	 
	       $getData=array(
	       		'id'=>$id,
	       		'name'=>$data['varies_name'],
	       		'county_name'=>$getCountyName['county_name'],
	       		'protype_name'=>$getTypeName['protype_name']
	       );
	       $this->assign('getdata',$getData);  
       }elseif($isValue['saledir_id'])
       {
         /*404*/
          $this->redirect('admin/404/index');
       }
       
       return $this->fetch();
    } 
    /*修改*/
    public function  dire_edit()
    {   
    	 /*提交*/
       if(request()->isPost())
            {
        //halt($_POST);
               $type_add=new A();
                $res=$type_add->type_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
    	$this->base();
    	$id=input('param.saledir_id');
    	$oldArr=$this->getOldArr($id);
    	$data=$this->getData($oldArr['saledir_pid']);
    	//halt($data);
    	//获得县和产品名称
	       $getCountyName=db('countys')
	       		 ->where('county_id',$data['varies_copid'])
	       		 ->field('county_name')
	       		 ->find();
	       $getTypeName=db('protypes')
	             ->where('protype_id',$data['varies_agpid'])
	             ->field('protype_name')
	             ->find();
	     $oldArr['name']=$data['varies_name'];        
	     $oldArr['county_name']= $getCountyName['county_name'];
	     $oldArr['protype_name']= $getTypeName['protype_name']; 
	     //halt($oldArr);      	
    	$this->assign('oldarr',$oldArr);
    	return $this->fetch();
    }
    /*删除*/
     public function dire_dele()
    {
    	if(request()->isPost())
            {
        //halt($_POST);
               $county=new A();
                $res=$county->dire_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         return $this->fetch();
    }
    /*获得修改的信息*/
    private function getOldArr($id)
    {
    		$oldArr=db('salesdirection')
		       ->where('saledir_id',$id)
		       ->where('saledir_states',1)
		       ->find();

			 $oldArr['name_saledir']=explode(',',$oldArr['saledir_name']);
			 $oldArr['value_saledir']=explode(',',$oldArr['saledir_value']);
		    return $oldArr;  
    }
    /*模拟添加数据*/
    public function getTypeData()
    {
    	 $nullId=db('varietiesy')->where('varies_states',1)->field('varies_id')->select();
    	 $getNOId=[];
        	for($i=0;$i<count($nullId);$i++)
            {
               $getNOId[$i]=$nullId[$i]['varies_id'];     
            }
         //halt($getNOId);   
        return $getNOId; 
    }
    public function addSaleValue($size)
    {
    	
        if(isset($size))
        {
            $size=$size;
        }else
        {
            $size=0;
        }
        echo $size.'<br>';
        $getNOId=$this->getTypeData();
       
      if(!empty($getNOId))
      {
            $count=count($getNOId);
            $editState= new A();
            $data=array(
                  'id'=>$getNOId[$size],
                  'size'=>$size 
            );
            //halt($getNOId);
            $res=$editState->AddSaleVale($data);
            if($res['status']=4 && $res['size']<$count)
            {
                echo $res['size'].'<br>';
                $this->addSaleValue($res['size']);

            }elseif($res['status']=1)
            {
                 $this->addSaleValue($res['size']);
            }else
            {
                echo '更新完成';
            }
        }else
        {
            echo '已更新';
        }
    }
}