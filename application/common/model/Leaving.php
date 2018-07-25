<?php
namespace app\common\model;

use think\Session;
use think\Validate;
use think\Model;  

class Leaving  extends Model
{

  protected  $pk='leav_id';//主键
  protected $table = 'qy_leaving';
   private function config_email()
  {

    $array=array(
        'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
        'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
        'MAIL_USERNAME' =>'buhaoxiao135@163.com',//你的邮箱名
        'MAIL_FROM' =>'buhaoxiao135@163.com',//发件人地址
        'MAIL_FROMNAME'=>'秦岭云电子商务有限公司',//发件人姓名
        'MAIL_PASSWORD' =>'1214032757zpf',//邮箱密码
        /*'MAIL_USERNAME' =>'black66885@163.com',//你的邮箱名
        'MAIL_FROM' =>'black66885@163.com',//发件人地址
        'MAIL_FROMNAME'=>'秦岭云电子商务有限公司',//发件人姓名
        'MAIL_PASSWORD' =>'7701Black',//邮箱密码*/
        'MAIL_CHARSET' =>'utf-8',//设置邮件编码
        'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
        'altbody'     => '秦岭云电子商务有限公司！',
    );
    return $array;
  }
    public function send_email($data)
    {
    		//halt($_POST);
    		 $data['subject']=$data['cont_title'];
   			 $data['message']=$data['content'];
             $data['email']=$data['email'];

     $email=$this->config_email();
     $res=sendEmail($data,$email);
     /*$res=sendEmail("$email","尊敬的","欢迎使用邮箱验证方式，请点击下面的链接进行邮箱的验证！<br/>http://www.aijiana.com/index.php?m=Home&c=Uinfo&a=renzh&verify= <br/> 如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>该验证邮件有效期为24小时，超时请重新发送邮件。<br>发件时间：<br>此邮件为系统自动发出的，请勿直接回复。");*/
         //halt($res);  
          // halt($res);
          if($res !== true)
          {
            return ['valid'=>3,'msg'=>'发送失败'];
          }else
          {
         	return ['valid'=>4,'msg'=>'发送成功'];
        }
        
        
    } 
}