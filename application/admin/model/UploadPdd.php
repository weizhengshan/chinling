<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 15:57
 */

namespace app\admin\model;

use app\lib\upload\uploadExcel;
use app\lib\enum\OrderStatusPdd;
use think\Model;

ini_set('max_execution_time', '180');

class UploadPdd extends Model
{
    public function OrderList($file, $typeId)
    {
        $result = (new UploadExcel())->UploadFile($file, '订单号');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $j = 0;//成功
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段
                $orderId = $sheet->getCell('B' . $row)->getValue();
                $pdd_name = $sheet->getCell('A' . $row)->getValue();
                $actualpay = $sheet->getCell('H' . $row)->getValue();
                $sum = $sheet->getCell('I' . $row)->getValue();
                $consignee = $sheet->getCell('L' . $row)->getValue();
                $phone = $sheet->getCell('M' . $row)->getValue();
                $address = $sheet->getCell('N' . $row)->getValue();
                $address = $address . '/' . $sheet->getCell('O' . $row)->getValue();
                $address = $address . '/' . $sheet->getCell('P' . $row)->getValue();
                //$address =$address.'/'.$sheet->getCell('Q'.$row)->getValue();

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
//                $where[$row]['paytime'] = $paytime;

                $where[$row]['remarks'] = $remarks;
                $where[$row]['refund_state'] = $refund_state;
                $where[$row]['platformpay'] = $platformpay;
                $where[$row]['platformpay_state'] = $platformpay_state;
                $where[$row]['waybill'] = $waybill;
                $where[$row]['createtime'] = time();
                $where[$row]['type_id'] = $typeId;      //店铺id
                //states 1.买家已付款，等待卖家发货 2.卖家已发货，等待买家确认 3. 交易关闭 4.交易成功 5.退款
                $orderStates = (new OrderStatusPdd())->getOrderStates($state);
                $where[$row]['state'] = $orderStates;
                if ($where) {
                    $j++;
                    $res = db('pddorder')->where('pdd_orderid', $orderId)->field('pdd_id')->find();
                    //halt($res);
//                    if ($where[$row]['states'] != $res['states']) {
//                        $g++;
//                        db('pddorder')->where('pdd_orderid', $orderId)->update(['states' => $where[$row]['states']]);
//                    }
//                    return ['msg'=>$where[$row]];
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
        } else {
            return $result;
        }
    }

    public function pddWayBill($file)
    {
        $verifyName = '寄件人姓名';
        $result = (new UploadExcel())->UploadFile($file, $verifyName);
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $j = 0;//
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段
                $WayBill = $sheet->getCell('M' . $row)->getValue();
                $phone = $sheet->getCell('G' . $row)->getValue();
                $where[$row]['phone'] = $phone;
                if ($where) {
                    $j++;
                    $res = db('pddorder')->where('waybill', $WayBill)->field('pdd_id')->find();
                    if ($res['pdd_id'] != '') {
                        $g++;
                        db('pddorder')->where('waybill', $WayBill)->update(['phone' => $where[$row]['phone'], 'update_time' => time()]);
                    } else {
                        $k++;
                    }
                }
            }
            if ($j != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }

    public function pddRefund($file)
    {
        $result = (new UploadExcel())->UploadFile($file, '订单编号');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $j = 0;//
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段
                $i++;
                $orderId = $sheet->getCell('B' . $row)->getValue();
                $refund_state = $sheet->getCell('D' . $row)->getValue();
                $refund = $sheet->getCell('F' . $row)->getValue();
                if ($refund_state == '退款成功') {
                    $refund_state = 2;
                }
                $where[$row]['refund'] = $refund;
                $where[$row]['refund_state'] = $refund_state;
                if ($where && $where[$row]['refund_state'] == 2) {
                    $j++;
                    $res = db('pddorder')->where('pdd_orderid', $orderId)->field('pdd_id')->find();
                    if ($res['pdd_id'] != '') {
                        $g++;
                        db('pddorder')->where('pdd_orderid', $orderId)->update(['refund' => $where[$row]['refund'], 'refund_state' => $where[$row]['refund_state'], 'update_time' => time()]);
                    } else {
                        $k++;
                    }
                }
            }
            if ($j != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $i . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 4, 'msg' => '共上传' . $i . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }

    public function pddSmallAmount($file)
    {
        $result = (new UploadExcel())->UploadFile($file, '商品ID');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $j = 0;//
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段

                $orderId = $sheet->getCell('A' . $row)->getValue();
                $refund = $sheet->getCell('G' . $row)->getValue();

                $where[$row]['refund'] = $refund;
                $where[$row]['refund_state'] = 3;
                if ($where) {
                    $j++;
                    $res = db('pddorder')->where('pdd_orderid', $orderId)->field('pdd_id')->find();
                    if ($res['pdd_id'] != '') {
                        $g++;
                        db('pddorder')->where('pdd_orderid', $orderId)->update(['refund' => $where[$row]['refund'], 'refund_state' => $where[$row]['refund_state'], 'update_time' => time()]);
                    } else {
                        $k++;
                    }
                }
            }
            if ($j != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }

    public function pddCoupon($file)
    {
        $result = (new UploadExcel())->UploadFile($file, '发生时间');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $j = 0;//
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段

                $orderId = $sheet->getCell('A' . $row)->getValue();
                $refundone = $sheet->getCell('C' . $row)->getValue();
                $refundtwo = $sheet->getCell('D' . $row)->getValue();
                $Platformpay_state = 1;
                if ($refundone != 0) {
                    $Platformpay_state = 2;
                }
                if ($refundtwo != 0) {
                    $Platformpay_state = 3;
                }
                $where[$row]['platformpay_state'] = $Platformpay_state;
                if ($where && $orderId != "") {
                    $j++;
                    $res = db('pddorder')->where('pdd_orderid', $orderId)->field('pdd_id')->find();
                    if ($res['pdd_id'] != '') {
                        $g++;
                        db('pddorder')->where('pdd_orderid', $orderId)->update(['platformpay_state' => $where[$row]['platformpay_state'], 'update_time' => time()]);
                    } else {
                        $k++;
                    }
                }
            }
            if ($j != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $k . '条数据更新失败' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }
}