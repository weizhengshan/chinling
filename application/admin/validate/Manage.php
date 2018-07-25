<?php
namespace  app\admin\validate;

use think\Validate;

class Manage extends Validate
{
	protected $rule= [
       'admin_username'=>'require',
       'admin_password'=>'require',
       'email'=>'required',
       'phone'=>'required',
       ''
       //'captcha|验证码'=>'require|captcha'
       ];
       protected $message=[
       'admin_username.require'=>'请输入用户名',
              'admin_password.require'=>'请输入密码',
              'email'=>'请输入邮箱',
              'phone'=>'请输入手机号'
       ];
}
