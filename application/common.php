<?php
use think\Session;
// 应用公共文件
/**
 *
 * 获得登录这的IP
 */
function getIp(){
    $onlineip='';
    if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){
        $onlineip=getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
        $onlineip=getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
        $onlineip=getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
        $onlineip=$_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
} 
/**
 * 管理员操作记录
 */
function caozuo($caozuo)
{
			//添加操作记录
			$arr['ip']=getIP();
			$arr['id']=Session::get('admin_id');
			$arr['name']=Session::get('admin_username');
			$arr['czstate']=$caozuo;
			$arr['createtime']=time();
			return $arr;	
			
}
/**
 * 邮箱发送
 */
function sendEmail($data,$config) {

   vendor("PHPMailer.PHPMailer");
    $phpmailer = new \phpmailer(); //实例化
    $phpmailer->Host    = $config['MAIL_HOST']; //smtp服务器的名称（这里以QQ邮箱为例）
    $phpmailer->SMTPAuth  =   TRUE; //启用smtp认证
    $phpmailer->Username  =   $config['MAIL_USERNAME']; //你的邮箱名
    $phpmailer->Password  =   $config['MAIL_PASSWORD']; //邮箱密码
    $phpmailer->From    =   $config['MAIL_USERNAME']; //发件人地址（也就是你的邮箱地址）
    $phpmailer->FromName  = $config['MAIL_FROMNAME']; //发件人姓名
    $phpmailer->CharSet   = 'utf-8'; //设置邮件编码
    $phpmailer->Subject   = $data['subject']; //邮件主题
    $phpmailer->Body    = $data['message']; //邮件内容
    $phpmailer->AltBody   = $config['altbody']; //邮件正文不支持HTML的备用显示
    $phpmailer->WordWrap  = 50; //设置每行字符长度
    $phpmailer->IsSMTP(true);  // 启用SMTP
    $phpmailer->IsHTML(true);   // 是否HTML格式邮件
    $phpmailer->AddAddress($data['email']);
    $status= $phpmailer->Send();
      //发送成功就删除
      return $status;
}
/**
 *访问首页记录
 * 
 */
//统计访问量
function fwl()
{ 
    $Ip=getIP();
    $time=time();
    $date['btime']=$time;
    $y_Id=M("jn_fwl")->where("Ip='{$Ip}'")->getField("fId");
    if($y_Id!="")
    {
        $y_count=db("jn_fwl")->where("Ip='{$Ip}'")->getField("count");
    
        $y_time=db("jn_fwl")->where("Ip='{$Ip}'")->getField("btime");
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        if($y_time>$beginToday && $y_time<$endToday)
        {
            $date['count']=$y_count+1;
            $date['btime']=$time;
            $add_IP=M("jn_fwl")->where("Ip='{$Ip}'")->save($date);
        }else
        {
            $date['Ip']=$Ip;
            $date['btime']=$time;
            $date['count']=1;
            $add_IP=M("jn_fwl")->add($date);
        }
    }else
    {
        $date['Ip']=$Ip;
        $date['count']=1;
        $add_IP=db("jn_fwl")->add($date);
    }
        
}
//根据ip定位城市
          
function getLocation($ip='')
      {
       empty($ip) && $ip = getip();
       if($ip=="127.0.0.1") return "本机地址";
       $api = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=$ip"; 
       $json = @file_get_contents($api);//调用新浪IP地址库 
       $arr = json_decode($json,true);//解析json
       $country = $arr['country']; //取得国家
       $province = $arr['province'];//获取省份 
       $city = $arr['city']; //取得城市
       if((string)$country == "中国"){
        if((string)($province) != (string)$city){
         $_location = $province.$city;
        }else{
         $_location = $country.$city;      
        }
       }else{
        $_location = $country;
       }
       return $_location;
      }      
/**
 * 删除缓存
 */
//清除缓存
    function deltree($pathdir)
    {
        header("Content-type:text/html;charset=utf-8");
        //echo $pathdir;//我调试时用的
         if((is_empty_dir($pathdir))==3)
         {
            return ['valid'=>4,'msg'=>'缓存已清除'];
            exit;
         };
        if((is_empty_dir($pathdir))==2)
        {//如果是空的

           $shan=rmdir($pathdir);//直接删除
        }else{//否则读这个目录，除了.和..外
              $d=dir($pathdir);
              while($a=$d->read())
              {
                  if(is_file($pathdir.'/'.$a) && ($a!='.') && ($a!='..')){$shan=unlink($pathdir.'/'.$a);}
                  //如果是文件就直接删除
                  if(is_dir($pathdir.'/'.$a) && ($a!='.') && ($a!='..'))
                  {//如果是目录
                      if((is_empty_dir($pathdir.'/'.$a))==1)//是否为空
                      {//如果不是，调用自身，不过是原来的路径+他下级的目录名
                          deltree($pathdir.'/'.$a);
                      }
                      if((is_empty_dir($pathdir.'/'.$a))==2)
                      {//如果是空就直接删除
                       $shan=rmdir($pathdir.'/'.$a);
                      }
                  }
              }
            $d->close(); 

           //我调试时用的
            //halt($shan);
        }

        if($shan)
        {
            return ['valid'=>4,'msg'=>'缓存清除成功'];
        }else
        {
            return ['valid'=>3,'msg'=>'缓存清除异常'];
        }
        
    }
//遍历文件机文件夹
    function rmdi_r($dirname){
 //判断是否为一个目录，非目录直接关闭
 if(is_dir($dirname)){
         //如果是目录，打开他
         $name=opendir($dirname);
         //使用while循环遍历
         while($file=readdir($name)){
          //去掉本目录和上级目录的点
          if($file=="." || $file==".."){
           continue;
          }
          //如果目录里面还有一个目录，再次回调
          if(is_dir($dirname."/".$file)){
           $this->rmdi_r($dirname."/".$file);
          }
          //如果目录里面是个文件，那么输出文件名
          if(is_file($dirname."/".$file)){
           echo($dirname."/".$file).'<br>';
          }
         }
         //遍历完毕关闭文件
         closedir($name);
         //输出目录名
         echo($dirname);
 }
}
     function is_empty_dir($pathdir)
    {
       
        //先判断目录是否存在     
            if(is_dir($pathdir))
            {
              //判断目录是否为空，我的方法不是很好吧？只是看除了.和..之外有其他东西不是为空   
            $d=opendir($pathdir);
            $i=0;
              while($a=readdir($d))
              {
                $i++;
              }
                closedir($d);
                if($i>2)
                {
                    return 1;
                }
                else{
                    return 2;
                }
            }
            else
            {

                 return 3;
                 exit;
            }
       
    }
 function send_post($url, $post_data) {
     
      $postdata = http_build_query($post_data);
      $options = array(
        'http' => array(
          'method' => 'POST',
          'header' => 'Content-type:application/x-www-form-urlencoded',
          'content' => $postdata,
          'timeout' => 15 * 6000 // 超时时间（单位:s）
        )
      );
      $context = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
     
      return $result;
    }  