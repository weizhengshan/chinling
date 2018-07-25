<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 15:40
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\UploadPdd as UploadPddModel;

class PddOrder  extends   Controller
{
        //上传订单文件
        public function OrderList()
        {
            $file = request()->file('file');        // 获取表单提交过来的文件
            $typeId=input('param.type_id');
            $res=(new UploadPddModel())->OrderList($file,$typeId);
            return $res;

        }
            //上传运单号
            public function pddWayBill()
            {
                $file = request()->file('file');        // 获取表单提交过来的文件
                $res=(new UploadPddModel())->pddWayBill($file);
                return $res;
            }
            //退款
          public function pddRefund()
          {
              $file = request()->file('file');        // 获取表单提交过来的文件
              $res=(new UploadPddModel())->pddRefund($file);
              return $res;
          }
          //小额打款
            public function pddSmallAmount()
            {
                $file = request()->file('file');        // 获取表单提交过来的文件
                $res=(new UploadPddModel())->pddSmallAmount($file);
                return $res;
            }
            //优惠券
            public function pddCoupon()
            {
                $file = request()->file('file');        // 获取表单提交过来的文件
                $res=(new UploadPddModel())->pddCoupon($file);
                return $res;
            }
        public function currentMonth()
        {
            $res=(new MicroMartModel())->WeiSalesWhere();
            return $res;
        }
}
