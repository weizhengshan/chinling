<?php
namespace  app\admin\validate;

use think\Validate;

class Category extends Validate
{
	protected $rule= [
       'cate_name'=>'require',
       //'cate_pid'=>'require',
       'cate_sort'=>'require|number|between:1,99999'
       //'captcha|验证码'=>'require|captcha'
	];
	protected $message=[
       'cate_name.require'=>'请输入栏目名称',
       	//'cate_pid.require'=>'请输入id',
       	'cate_sort.require'=>'请输入排序',
       	'cate_sort.number'=>'排序要为数字',
       	'cate_sort.between'=>'排序要在1——99999'
	];
}
