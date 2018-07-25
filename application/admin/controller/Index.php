<?php
namespace app\admin\controller;

use app\common\model\Admin as A;
use think\Session;
use think\Request;
use app\common\lib\upload;
use app\lib\enum\OrderStatusPdd;
ini_set('max_execution_time','120');
class Index  extends Common
{
    public function index()
    {

         $id=input('param.id');

        $this->assign('id',$id);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
    public function logout()
    {
	
        		//清除session
        		session(null);
        		//$this->success('退出成功','admin/index/index');
				$this->redirect('admin/index/index');
		
      //return $this->fetch();
    }
    public function big_data()
    {
        return $this->fetch();
    }
    public function product_data()
    {
        return $this->fetch();
    }
    public function welcome()
    {
        //echo '123213';
     //halt($_SERVER);
        return $this->fetch();
    }

    //删除缓存
    public function runtime(){
        $pathdir = ROOT_PATH.'runtime/temp';
     
        $res =deltree($pathdir);
       
        $mess=array(
                        'status'=>$res['valid'],
                        'message'=>$res['msg']
                    );
                    return $mess;
    }
    /**
     * 测试
     */
    public function ceshi()
    {
       
       
       /* $pieces = explode("type", $data);
        halt($pieces); */
    }
    /**
     * 上传excel订单数据 
     */
    public function  upload_excel()
    {
        $this->base();

        return $this->fetch();
    }
    /**
     * 上传excel订单单数数据 
     */
    public function  upload_excel_type()
    {
        $this->base();
        return $this->fetch();
    }
    /**
     * 上传excel订单单数数据 
     */
    public function  upload_excel_message()
    {
        $this->base();

        return $this->fetch();
    }
    public function uploadUserOrder()
    {  
      if(Request::instance()->isPost()){  
        $file = request()->file('file');        // 获取表单提交过来的文件  
        $error = $_FILES['file']['error'];  // 如果$_FILES['file']['error']>0,表示文件上传失败  
        if(!$error){  
          $dir = ROOT_PATH . 'public' . DS . 'upload';  
          // 验证文件并移动到框架应用根目录/public/uploads/ 目录下  
          $info = $file->validate(['size'=>3145728,'ext'=>'xls,xlsx,csv'])->rule('uniqid')->move($dir);  
          /*判断是否符合验证*/  
          if($info){    //  符合类型  
            $extension = $info->getExtension();  

            $filename = $dir. DS .$info->getSaveName(); 

            //echo $filename;  
            Vendor("PHPExcel.IOFactory");
                if ($extension =='xlsx') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel2007");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension =='xls') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel5");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension=='csv') {
                    $reader = \PHPExcel_IOFactory::createReader("CSV");

                    //默认输入字符集
                    $reader->setInputEncoding('GBK');

                    //默认的分隔符
                    $reader->setDelimiter(',');

                    //载入文件
                    $PHPExcel = $reader->load($filename);
                }
/*
            $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel2007格式  

            $PHPExcel = $reader->load($filename); // 载入excel文件  
            halt($PHPExcel);*/
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
            $highestRow = $sheet->getHighestRow(); // 取得总行数  
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数 
            //判断上传是否为订单数据
            $SecondField="买家会员名";
            $number=1;
            $is_order=$sheet->getCell('B'.$number)->getValue(); 
            if($is_order!=$SecondField)
            {
                echo "不是订单数据";
                exit;    
            }
            /** 循环读取每个单元格的数据 */
            //$User = new User;
            //halt($sheet);
            //$res=db('tborder')->where('tb_refundm','0.00')->delete();
            //halt($res);
            //原来的数据条数
            $oldList=db('tborder')->count();
            $where=array();
              $i = 0;
              $j =0;//成功
              $k=0;//已上传
              $g=0;//更新
            for ($row = 2; $row <= $highestRow; $row++)
            {//行数是以第1行开始，这里示例中excel有3列字段
                $orderId = $sheet->getCell('A'.$row)->getValue();
                $actualPay = $sheet->getCell('I'.$row)->getValue();
                $BuyerName = $sheet->getCell('B'.$row)->getValue();
                $phone = $sheet->getCell('Q'.$row)->getValue();
                $BuyerMessage= $sheet->getCell('L'.$row)->getValue();
                $address= $sheet->getCell('N'.$row)->getValue();
                $orderPayTime= $sheet->getCell('S'.$row)->getValue();
                $orderStates= $sheet->getCell('K'.$row)->getValue();
                $refundM= $sheet->getCell('AX'.$row)->getValue();
                $orderId=ltrim($orderId, '="');
                $orderId=rtrim($orderId, '"');
                $phone=ltrim($phone, "'");
                $where[$row]['tb_orderid']=$orderId;
                $where[$row]['tb_actualpay']=$actualPay;
                $where[$row]['tb_Buyername']=$BuyerName;
                $where[$row]['tb_Buyermessage']=$BuyerMessage;
                $where[$row]['tb_address']=$address;
                $where[$row]['tb_orderpaytime'] = $orderPayTime;
                $where[$row]['tb_phone'] = $phone;
                $where[$row]['tb_refundm'] = $refundM;
                $where[$row]['createtime'] = time();
                $where[$row]['type_id'] = 1;
                //states 1.买家已付款，等待卖家发货 2.卖家已发货，等待买家确认 3. 交易关闭 4.交易成功 5.退款
                //$orderStates=(new OrderStatusEnum())->getOrderStates($orderStates);
                $where[$row]['states'] = 4;
                if($where && $orderPayTime!="")
                {
                    $j++;
                    $res=db('tborder')->where('tb_orderid',$orderId)->field('tb_id,states')->find();
                    if($where[$row]['states']!=$res['states'])
                    {
                        $g++;
                        db('tborder')->where('tb_orderid',$orderId)->update(['states'=>$where[$row]['states']]);
                    }
                    //halt($res);
                    if(!isset($res['tb_id']))
                    {
                        $i++;
                        db('tborder')->insert($where[$row]);
                    }else
                    {
                        $k++;
                        //db('tborder')->where('tb_orderid',$orderId)->save($where[$row]);
                    }
                }

                    //$User->data($data,true)->isUpdate(false)->save();
                }

            }
            //添加后的的数据条数
            $NewsList=db('tborder')->count();
            $List=$NewsList-$oldList;
            echo '数据加载完成,共更新了'.$List.'条'; 
            //$this->success('导入数据库成功',url('index'));  
          } else{ //  不符合类型业务  
            $this->error('请选择上传3MB内的excel表格文件...');  
            //echo $file->getError();
          }
        }else{  
          $this->error('请选择需要上传的文件...');  
        }  
    }
     public function uploadUserType()
    {  
      if(Request::instance()->isPost()){  
        $file = request()->file('file');        // 获取表单提交过来的文件  
        $error = $_FILES['file']['error'];  // 如果$_FILES['file']['error']>0,表示文件上传失败  
        if(!$error){  
          $dir = ROOT_PATH . 'public' . DS . 'upload';  
          // 验证文件并移动到框架应用根目录/public/uploads/ 目录下  
          $info = $file->validate(['size'=>3145728,'ext'=>'xls,xlsx,csv'])->rule('uniqid')->move($dir);  
          /*判断是否符合验证*/  
          if($info){    //  符合类型  
            $extension = $info->getExtension();  

            $filename = $dir. DS .$info->getSaveName(); 

            //echo $filename;  
            Vendor("PHPExcel.IOFactory");
                if ($extension =='xlsx') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel2007");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension =='xls') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel5");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension=='csv') {
                    $reader = \PHPExcel_IOFactory::createReader("CSV");

                    //默认输入字符集
                    $reader->setInputEncoding('GBK');

                    //默认的分隔符
                    $reader->setDelimiter(',');

                    //载入文件
                    $PHPExcel = $reader->load($filename);
                }
/*
            $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel2007格式  

            $PHPExcel = $reader->load($filename); // 载入excel文件  
            halt($PHPExcel);*/
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
            $highestRow = $sheet->getHighestRow(); // 取得总行数  
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数  
            /** 循环读取每个单元格的数据 */  
            //判断上传是否为订单数据
            $SecondField="标题";
            $number=1;
            $is_order=$sheet->getCell('B'.$number)->getValue(); 
            if($is_order!=$SecondField)
            {
                echo "不是订单分类数据";
                exit;    
            } 
            //$User = new User; 
            //halt($sheet); 
            //$res=db('tborder')->delete();
            //halt($res);
            $oldList=db('tbtype')->count();
            $where=array();
             $i=0;
            for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始，这里示例中excel有3列字段  
              $orderId = $sheet->getCell('A'.$row)->getValue();
              $title = $sheet->getCell('B'.$row)->getValue(); 
              $number = $sheet->getCell('D'.$row)->getValue();  
             

              $orderId=ltrim($orderId, '="');
              $orderId=rtrim($orderId, '"'); 

              $where[$row]['tbt_orderid']=$orderId;
              $where[$row]['tbt_title']=$title;
              $where[$row]['tbt_purchasen']=$number;
              $where[$row]['createtime'] = time();
              $where[$row]['type_id'] = 1;
              //halt($where);
           
              if($where)
              {
                $res=db('tbtype')->where('tbt_orderid',$orderId)->where('tbt_title',$title)->field('tbt_id')->find();
                //halt($res);
                if(!isset($res['tbt_id']))
                {
                    $res=db('tbtype')->insert($where[$row]);
                }
              }
                 
              } 
             
            }
            //添加后的的数据条数
            $NewsList=db('tbtype')->count();
            $List=$NewsList-$oldList;
            echo '数据加载完成,共更新了'.$List.'条'; 
            //$this->success('导入数据库成功',url('index'));  
          } else{ //  不符合类型业务  
            $this->error('请选择上传3MB内的excel表格文件...');  
            //echo $file->getError();  
          }  
        }else{  
          $this->error('请选择需要上传的文件...');  
        }  
    }
     public function uploadUserMessage()
    {  
      if(Request::instance()->isPost()){  
        $file = request()->file('file');        // 获取表单提交过来的文件  
        $error = $_FILES['file']['error'];  // 如果$_FILES['file']['error']>0,表示文件上传失败  
        if(!$error){  
          $dir = ROOT_PATH . 'public' . DS . 'upload';  
          // 验证文件并移动到框架应用根目录/public/uploads/ 目录下  
          $info = $file->validate(['size'=>3145728,'ext'=>'xls,xlsx,csv'])->rule('uniqid')->move($dir);  
          /*判断是否符合验证*/  
          if($info){    //  符合类型  
            $extension = $info->getExtension();  

            $filename = $dir. DS .$info->getSaveName(); 

            //echo $filename;  
            Vendor("PHPExcel.IOFactory");
                if ($extension =='xlsx') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel2007");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension =='xls') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel5");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension=='csv') {
                    $reader = \PHPExcel_IOFactory::createReader("CSV");

                    //默认输入字符集
                    $reader->setInputEncoding('GBK');

                    //默认的分隔符
                    $reader->setDelimiter(',');

                    //载入文件
                    $PHPExcel = $reader->load($filename);
                }
/*
            $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel2007格式  

            $PHPExcel = $reader->load($filename); // 载入excel文件  
            halt($PHPExcel);*/
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
            $highestRow = $sheet->getHighestRow(); // 取得总行数  
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数  

            /** 循环读取每个单元格的数据 */ 
            //判断上传是否为订单数据
            $SecondField="会员状态";
            $number=1;
            $is_order=$sheet->getCell('B'.$number)->getValue(); 
            if($is_order!=$SecondField)
            {
                echo "不是评论数据";
                exit;    
            }  
            //$User = new User; 
            //halt($sheet); 
        
            //halt($res);
             $oldList=db('tbmessage')->count();
            $where=array();
             $i=0;
            for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始，这里示例中excel有3列字段  
              $name = $sheet->getCell('A'.$row)->getValue();
              $releaseTime = $sheet->getCell('D'.$row)->getValue(); 
              $evaluate = $sheet->getCell('E'.$row)->getValue();  

              $where[$row]['tbm_name'] = $name;
              $where[$row]['tbm_time'] = $releaseTime;
              $where[$row]['tbm_text'] = $evaluate;
              $where[$row]['createtime'] = time();
              //halt($where);
           
              if($where)

              {
                $res=db('tbmessage')->where('tbm_time',$releaseTime)->where('tbm_name',$name)->field('tbm_id')->find();
                //halt($res);
           
                if(!isset($res['tb_id']))
                {
                    $res=db('tbmessage')->insert($where[$row]);
                }
              }
                //$User->data($data,true)->isUpdate(false)->save();  
              } 
             
            }
            //添加后的的数据条数
            $NewsList=db('tbmessage')->count();
            $List=$NewsList-$oldList;
            echo '数据加载完成,共更新了'.$List.'条'; 
            //$this->success('导入数据库成功',url('index'));  
          } else{ //  不符合类型业务  
            $this->error('请选择上传3MB内的excel表格文件...');  
            //echo $file->getError();  
          }  
        }else{  
          $this->error('请选择需要上传的文件...');  
        }  
    }
    /*七牛图片上传*/
    public function qiniu_upload_img()
    {
        $this->base();
        return $this->fetch();
    }
    //上传到本地
    public function uploadifyImg1()
    {

    // 获取表单上传文件 例如上传了001.jpg
        //halt($_FILES);
        $path ="/uploads/";
        $file = request()->file('images');
        //halt($file);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
        $path = $path . $info->getSaveName();
        
            // 成功上传后 返回上传信息
        return json_encode(array('state'=>1,'path'=>$path));
        }else{
            // 上传失败返回错误信息
        return json(array('state'=>0,'errmsg'=>'上传失败'));
        }
    } 
    //上传到七牛
    public function uploadifyImg(){  
       
         $image = Upload::image($_FILES,$_POST['imgtype']); 
         //图片样式处理
         $fops = 'imageView2/1/w/800/h/100';
        // 捕获异常  
        try{  
            // 返回qiniu上的文件名  
           
        }catch(\Exception $e){  
            echo json_encode(['status'=>0,'message'=>$e->getMessage()]);  
        }  
        // 返回给uploadify插件状态  
        if($image){  
            $data = [  
                'status' => 1,  
                'message' => 'OK',  
                'path' => config('qiniu.image_url').'/'.$image.'?'.$fops,  
            ];  
            echo json_encode($data);exit;       
        }else{  
            echo json_encode(['status'=>0,'message'=>'上传失败']);  
        }  
    }
    public function pddUploadUserOrder()
    {
        $typeId =15;
        if (Request::instance()->isPost()) {
            $file = request()->file('file');        // 获取表单提交过来的文件
            $error = $_FILES['file']['error'];  // 如果$_FILES['file']['error']>0,表示文件上传失败
            if (!$error) {
                $dir = ROOT_PATH . 'public' . DS . 'upload';
                // 验证文件并移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['size' => 3145728, 'ext' => 'xls,xlsx,csv'])->rule('uniqid')->move($dir);
                /*判断是否符合验证*/
                if ($info) {    //  符合类型
                    $extension = $info->getExtension();

                    $filename = $dir . DS . $info->getSaveName();

                    //echo $filename;
                    Vendor("PHPExcel.IOFactory");
                    if ($extension == 'xlsx') {
                        $reader = \PHPExcel_IOFactory::createReader("Excel2007");
                        $PHPExcel = $reader->load($filename);
                    } else if ($extension == 'xls') {
                        $reader = \PHPExcel_IOFactory::createReader("Excel5");
                        $PHPExcel = $reader->load($filename);
                    } else if ($extension == 'csv') {
                        $reader = \PHPExcel_IOFactory::createReader("CSV");

                        //默认输入字符集
                        $reader->setInputEncoding('GBK');

                        //默认的分隔符
                        $reader->setDelimiter(',');

                        //载入文件
                        $PHPExcel = $reader->load($filename);
                    }
                    /*
                                $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel2007格式

                                $PHPExcel = $reader->load($filename); // 载入excel文件
                                halt($PHPExcel);*/
                    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumm = $sheet->getHighestColumn(); // 取得总列数
                    //判断上传是否为订单数据
                    $SecondField = "订单号";
                    $number = 1;
                    $is_order = $sheet->getCell('B' . $number)->getValue();
                    if ($is_order != $SecondField) {
                        echo "不是订单数据";
                        exit;
                    }
                    /** 循环读取每个单元格的数据 */
                    //$User = new User;
                    //halt($sheet);
                    //$res=db('tborder')->where('tb_refundm','0.00')->delete();
                    //halt($res);
                    //原来的数据条数
                    $oldList = db('tborder')->count();
                    $where = array();
                    $i = 0;
                    $j = 0;//成功
                    $k = 0;//已上传
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $orderId = $sheet->getCell('B' . $row)->getValue();
                        $pdd_name = $sheet->getCell('A' . $row)->getValue();
                        $actualpay = $sheet->getCell('H' . $row)->getValue();
                        $sum = $sheet->getCell('I' . $row)->getValue();
                        $consignee = $sheet->getCell('L' . $row)->getValue();
                        $phone = $sheet->getCell('M' . $row)->getValue();

                        $address = $sheet->getCell('N' . $row)->getValue();
                        $address = $address . '/' . $sheet->getCell('O' . $row)->getValue();
                        $address = $address . '/' . $sheet->getCell('P' . $row)->getValue();
                        $address = $address . '/' . $sheet->getCell('Q' . $row)->getValue();

                        $paytime = $sheet->getCell('R' . $row)->getValue();
                        $paytime = strtotime($paytime);
                        $state = $sheet->getCell('C' . $row)->getValue();
                        $remarks = $sheet->getCell('AD' . $row)->getValue();
                        $refund_state = 1;
                        $platformpay = $sheet->getCell('F' . $row)->getValue();
                        $platformpay_state = 1;
                        $waybill = $sheet->getCell('Y' . $row)->getValue();
                        $orderId = ltrim($orderId, '="');
                        $orderId = rtrim($orderId, '"');
                        $phone = ltrim($phone, "'");
                        $where[$row]['pdd_orderid'] = $orderId;
                        $where[$row]['pdd_name'] = $pdd_name;
                        $where[$row]['actualpay'] = $actualpay;
                        $where[$row]['sum'] = $sum;
                        $where[$row]['consignee'] = $consignee;
                        $where[$row]['phone'] = $phone;
                        $where[$row]['address'] = $address;
                        $where[$row]['paytime'] = $paytime;

                        $where[$row]['remarks'] = $remarks;
                        $where[$row]['refund_state'] = $refund_state;
                        $where[$row]['platformpay'] = $platformpay;
                        $where[$row]['platformpay_state'] = $platformpay_state;
                        $where[$row]['waybill'] = $waybill;
                        $where[$row]['createtime'] = time();
                        $where[$row]['type_id'] = $typeId;
                        //states 1.买家已付款，等待卖家发货 2.卖家已发货，等待买家确认 3. 交易关闭 4.交易成功 5.退款
                        $orderStates = (new OrderStatusPdd())->getOrderStates($state);
                        $where[$row]['state'] = $orderStates;
                        if ($where) {
                            $j++;
                            $res = db('pddorder')->where('pdd_orderid', $orderId)->field('pdd_id')->find();
                            //halt($res);
                            if (!isset($res['pdd_id'])) {
                                $i++;
                                db('pddorder')->insert($where[$row]);
                            } else {
                                $k++;
                            }
                        }
                    }
                    if ($i != 0) {
                        //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                        return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传' . $k . '条数据已上传过'];
                    } else {
                        return ['valid' => 1, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传' . $k . '条数据已上传过'];
                    }
                } else { //  不符合类型业务
                    $this->error('请选择上传3MB内的excel表格文件...');
                    //echo $file->getError();
                }
            } else {
                $this->error('请选择需要上传的文件...');
            }
        }
    }
}
