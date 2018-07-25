<?php
namespace app\index\model;
use think\Validate;
class Send extends \think\Model
{
	public static $email_config = [
		//邮件配置
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'695821281@qq.com',//你的邮箱名
    'MAIL_FROM' =>'695821281@qq.com',//发件人地址
    'MAIL_FROMNAME'=>'秦岭云电子商务有限公司',//发件人姓名
    'MAIL_PASSWORD' =>'Z1214032757pf',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    'altbody' 		=> '安德兔注册验证码，如果您看见的是本条内容请与安德兔管理员联系！',
    //邮件配置
    'AccessKeyId' => 'LTAIoU5zDACcUOav',    //AccessKeyId
    'AccessKeySecret' => 'Oy8IzA68lBnLMSWxyurZnU9SjuWJVq',//AccessKeySecret
    'Bucket' => 'aijiana',         //Bucket
    'Endpoint' => 'http://oss-cn-hangzhou.aliyuncs.com',
	];


	public function email($data=[])
	{
		$validate = new Validate([
			['email','require|email','邮箱输入错误|邮箱输入错误'],
			['subject','require','请输入邮件标题'],
			['message','require','请输入邮件内容'],
		]);
		if (!$validate->check($data)) {
			return $validate->getError();
		}
		$config = self::$email_config;
		vendor('phpmailer.phpmailer');
		$phpmailer = new \phpmailer(); //实例化
		$phpmailer->Host		=	$config['MAIL_HOST']; //smtp服务器的名称（这里以QQ邮箱为例）
		$phpmailer->SMTPAuth 	= 	TRUE; //启用smtp认证
		$phpmailer->Username 	= 	$config['MAIL_USERNAME']; //你的邮箱名
		$phpmailer->Password 	= 	$config['MAIL_PASSWORD']; //邮箱密码
		$phpmailer->From 		= 	$config['MAIL_USERNAME']; //发件人地址（也就是你的邮箱地址）
		$phpmailer->FromName 	=	$config['MAIL_FROMNAME']; //发件人姓名
		$phpmailer->CharSet		=	'utf-8'; //设置邮件编码
		$phpmailer->Subject 	=	$data['subject']; //邮件主题
		$phpmailer->Body 		=	$data['message']; //邮件内容
		$phpmailer->AltBody 	=	$config['altbody']; //邮件正文不支持HTML的备用显示
		$phpmailer->WordWrap 	=	50; //设置每行字符长度
		$phpmailer->IsSMTP(true);	 // 启用SMTP
		$phpmailer->IsHTML(true); 	// 是否HTML格式邮件
		$phpmailer->AddAddress($data['email']);
		$status = $phpmailer->Send();
		return true;
	}
}
?>