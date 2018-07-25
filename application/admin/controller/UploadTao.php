<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 上午 11:58
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\UploadTao as UploadTaoModel;

class UploadTao extends Controller
{
    //上传订单文件
    public function OrderList()
    {
        $file = request()->file('file');        // 获取表单提交过来的文件
        $typeId=input('param.type_id');
        $res=(new UploadTaoModel())->OrderList($file,$typeId);
        return $res;
    }
    //上传订单分类
    public function OrderType()
    {
        $file = request()->file('file');        // 获取表单提交过来的文件
        $typeId=input('param.type_id');
        $res=(new UploadTaoModel())->OrderType($file,$typeId);
        return $res;
    }
    //上传已双评
    public function OrderOver()
    {
        $file = request()->file('file');        // 获取表单提交过来的文件
        $typeId=input('param.type_id');
        $res=(new UploadTaoModel())->OrderOver($file,$typeId);
        return $res;
    }
    //上传评论
    public function OrderEvaluate()
    {
        $file = request()->file('file');        // 获取表单提交过来的文件
        $res=(new UploadTaoModel())->OrderEvaluate($file);
        return $res;
    }
}