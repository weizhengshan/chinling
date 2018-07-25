<?php
namespace app\admin\controller;

use think\Session;
use think\Validate;
use app\common\model\Imgclass as A;
use app\common\model\Imglogo as B;
class Imgclass  extends Common
{
    //logo提交
    public function in_logo()
    {
        /**
         * pid  1,LOGO 2,微信二维码 3,微博二维码
         */
        //获取管理员
       $pid=input('param.pid');
       $dataname='';
       if($pid=="")
       {
            $pid=1;
       }
        switch ($pid)
        {
        case 1:
          $dataname="LOGO";
          $imgsize='25012360';
          break;
        case 2:
          $dataname="微信二维码";
             $imgsize='100123100';
            
          break;
        case 3:
          $dataname="微博二维码";
          $imgsize='100123100';
          break;
        case 4:
          $dataname="LOGO图标";
          $imgsize='100123100';
          break;  
        default:
            $pid=1;
            $dataname="LOGO";
             $imgsize='25012360';
        }
       //判断是修改什么

       $logodata=db('logo')->where('pid',$pid)->find();
       $logodata['dataname']=$dataname;
       //print_r($logodata);
        $this->assign('logodata',$logodata);
		//导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        $this->assign('imgsize',$imgsize);
		if(request()->isPost())
            {
				//halt($_POST);
               $logo_add=new B();
                $res=$logo_add->logo_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
            
        return $this->fetch();
    }
    //轮播图
    public function in_carousel()
    {
         /**
         * pid  1,首页轮播图 2,首页模块图
         */
        //获取管理员
       $pid=input('param.pid');
       $dataname='';
       if($pid=="")
       {
            $pid=1;
       }
        switch ($pid)
        {
        case 1:
          $dataname="首页轮播图";
          break;
        case 2:
          $dataname="首页模块图";
          break;
        case 3:
          $dataname="运营模式图";
          break;  
         case 4:
          $dataname="手机端轮播图";
          break;   
        default:
            $pid=1;
            $dataname="首页轮播图";
        }
		//获得轮播图信息
		$carodata=db('carousel')->where('caro_states',1)->where('pid',$pid)->select();
        $this->assign('carodata',$carodata);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        $this->assign('dataname',$dataname);
        $this->assign('pid',$pid);
		return $this->fetch();
    }
	
	//上传图片
	public function upload(){
    // 获取表单上传文件 例如上传了001.jpg
    	$path ="/uploads/";
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
    	// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
    	$path = $path . $info->getSaveName();
    	
            // 成功上传后 返回上传信息
    	return json(array('state'=>1,'path'=>$path));
        }else{
            // 上传失败返回错误信息
    	return json(array('state'=>0,'errmsg'=>'上传失败'));
        }
	}

  //上传图片
  public function uploadimg(){
    // 获取表单上传文件 例如上传了001.jpg
       $imgsize=input('param.imgsize');
       $imgsize=explode('123',$imgsize);
      $path ="/uploads/";
        $file = request()->file('file');
        halt($file);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        
        if($info){
            $pic =  ROOT_PATH.'public/uploads/'.$info->getSaveName();
        $image = \think\Image::open($pic);
        $height = $image->height();
        $widthzhi=round($height/$imgsize[1])*$imgsize[0];
        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
        $image->thumb($widthzhi,$imgsize[1])->save($pic);
        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png       
      // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg       
           //\think\Image::open($info)->thumb(150, 150)->save($pic);  
             $path = $path.$info->getSaveName();
            // 成功上传后 返回上传信息
      return json(array('state'=>1,'path'=>$path));
        }else{
            // 上传失败返回错误信息
      return json(array('state'=>0,'errmsg'=>'上传失败'));
        }
  }
	//添加轮播图
	public function caro_add()
	{
	   //halt($admin);
       if(request()->isPost())
            {
				//halt($_POST);
               $caro_add=new A();
                $res=$caro_add->caro_add(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
		
		
         //return $this->fetch();
     
	}
	//删除轮播图(假删)
	public function caro_dele()
	{
		if(request()->isPost())
            {
				//halt($_POST);
               $caro_dele=new A();
                $res=$caro_dele->caro_dele(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         
	}
    //删除轮播图
    public function caro_deled()
    {
        if(request()->isPost())
            {
                //halt($_POST);
               $caro_dele=new A();
                $res=$caro_dele->caro_deled(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         
    }
    //上架
    public function caro_update()
    {

        if(request()->isPost())
            {
                //halt($_POST);
               $caro_dele=new A();
                $res=$caro_dele->caro_update(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }

         
    }
	//修改轮播图
	public function  edit_carousel()
	{
         $pid=input('param.pid');
         $dataname='';
       if($pid=="")
       {
            $pid=1;
       }
        switch ($pid)
        {
        case 1:
          $dataname="首页轮播图";
          break;
        case 2:
          $dataname="首页模块图";
          break;
        case 3:
          $dataname="运营模式图";
          break;
        case 4:
          $dataname="手机端轮播图";
          break;  
        default:
            $pid=1;
            $dataname="首页轮播图";
        }
		$carodata=db('carousel')->where('caro_states',1)->where('pid', $pid)->select();
        $this->assign('carodata',$carodata);
        $this->assign('pid',$pid);
        $this->assign('dataname',$dataname);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
		//修改信息

		$caro=input('param.');
		//获得信息
		$data=db('carousel')->where('caro_id',$caro['caro_id'])->find();
		$this->assign('data',$data);
		
		
		//更新
		 if(request()->isPost())
            {
				//halt($_POST);
               $caro_edit=new A();
                $res=$caro_edit->caro_edit(input('post.'));
                    $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
            }
		
        return $this->fetch();
	}
	
	
}
	

