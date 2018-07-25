<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 下午 12:00
 */

namespace app\admin\model;

use think\Model;
use think\Validate;
use app\lib\upload\uploadExcel;
use app\lib\enum\OrderStatusEnum;

ini_set('max_execution_time', '180');

class UploadTao extends Model
{
    public function OrderList($file, $typeId)
    {
        $result = (new UploadExcel())->UploadFile($file, '买家会员名');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $j = 0;//成功
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段
                $orderId = $sheet->getCell('A' . $row)->getValue();
                $actualPay = $sheet->getCell('I' . $row)->getValue();
                $BuyerName = $sheet->getCell('B' . $row)->getValue();
                $phone = $sheet->getCell('Q' . $row)->getValue();
                $BuyerMessage = $sheet->getCell('L' . $row)->getValue();
                $address = $sheet->getCell('N' . $row)->getValue();
                $orderPayTime = $sheet->getCell('S' . $row)->getValue();
                $orderStates = $sheet->getCell('K' . $row)->getValue();
                $refundM = $sheet->getCell('AX' . $row)->getValue();
                $orderId = ltrim($orderId, '="');
                $orderId = rtrim($orderId, '"');
                $phone = ltrim($phone, "'");
                $where[$row]['tb_orderid'] = $orderId;
                $where[$row]['tb_actualpay'] = $actualPay;
                $where[$row]['tb_Buyername'] = $BuyerName;
                $where[$row]['tb_Buyermessage'] = $BuyerMessage;
                $where[$row]['tb_address'] = $address;
                $where[$row]['tb_orderpaytime'] = $orderPayTime;
                $where[$row]['tb_phone'] = $phone;
                $where[$row]['tb_refundm'] = $refundM;
                $where[$row]['createtime'] = time();
                $where[$row]['type_id'] = $typeId;
                //states 1.买家已付款，等待卖家发货 2.卖家已发货，等待买家确认 3. 交易关闭 4.交易成功 5.退款
                $orderStates = (new OrderStatusEnum())->getOrderStates($orderStates);
                $where[$row]['states'] = $orderStates;
                if ($where && $orderPayTime != "") {
                    $j++;
                    $res = db('tborder')->where('tb_orderid', $orderId)->field('tb_id,states')->find();
                    if ($where[$row]['states'] != $res['states']) {
                        $g++;
                        db('tborder')->where('tb_orderid', $orderId)->update(['states' => $where[$row]['states']]);
                    }
                    //halt($res);
                    if (!isset($res['tb_id'])) {
                        $i++;
                        db('tborder')->insert($where[$row]);
                    } else {
                        $k++;
                        //db('tborder')->where('tb_orderid',$orderId)->save($where[$row]);
                    }
                }
            }
            if ($i != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传，' . $k . '条数据已上传过' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 1, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传，' . $k . '条数据已上传过' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }

    public function OrderOver($file, $typeId)
    {
        $result = (new UploadExcel())->UploadFile($file, '买家会员名');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $j = 0;//成功
            $k = 0;//已上传
            $g = 0;//更新
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {//行数是以第1行开始，这里示例中excel有3列字段
                $orderId = $sheet->getCell('A' . $row)->getValue();
                $orderStates = $sheet->getCell('K' . $row)->getValue();
                $orderId = ltrim($orderId, '="');
                $orderId = rtrim($orderId, '"');
                $where[$row]['tb_orderid'] = $orderId;
                $where[$row]['createtime'] = time();
                $where[$row]['type_id'] = $typeId;
                //states 1.买家已付款，等待卖家发货 2.卖家已发货，等待买家确认 3. 交易关闭 4.交易成功 5.退款
                $orderStates = (new OrderStatusEnum())->getOrderStates($orderStates);
                if ($orderStates == 4) {
                    $orderStates = 6;
                }
                $where[$row]['states'] = $orderStates;
                if ($where) {
                    $j++;
                    $res = db('tborder')->where('tb_orderid', $orderId)->field('tb_id,states')->find();
                    if ($where[$row]['states'] != $res['states']) {
                        $g++;
                        db('tborder')->where('tb_orderid', $orderId)->update(['states' => $where[$row]['states']]);
                    }
                    //halt($res);
                    if (!isset($res['tb_id'])) {
                        $i++;
                        db('tborder')->insert($where[$row]);
                    } else {
                        $k++;
                        db('tborder')->where('tb_orderid', $orderId)->save($where[$row]);
                    }
                }
            }
            if ($i != 0) {
                //return ['valid'=>4,'msg'=>'添加'.$textName.'数据成功'];
                return ['valid' => 4, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传' . $k . '条数据已上传过' . $g . '条数据更新成功'];
            } else {
                return ['valid' => 1, 'msg' => '共上传' . $j . '条数据,其中' . $i . '条成功上传' . $k . '条数据已上传过' . $g . '条数据更新成功'];
            }
        } else {
            return $result;
        }
    }

    public function OrderType($file, $typeId)
    {
        $result = (new UploadExcel())->UploadFile($file, '标题');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $k = 0;
            $j = 0;
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {
                $orderId = $sheet->getCell('A' . $row)->getValue();
                $title = $sheet->getCell('B' . $row)->getValue();
                $number = $sheet->getCell('D' . $row)->getValue();
                $orderId = ltrim($orderId, '="');
                $orderId = rtrim($orderId, '"');
                $where[$row]['tbt_orderid'] = $orderId;
                $where[$row]['tbt_title'] = $title;
                $where[$row]['tbt_purchasen'] = $number;
                $where[$row]['createtime'] = time();
                $where[$row]['type_id'] = $typeId;
                //halt($where);
                if ($where) {
                    $j++;
                    $res = db('tbtype')->where('tbt_orderid', $orderId)->where('tbt_title', $title)->field('tbt_id')->find();
                    //halt($res);
                    if (!isset($res['tbt_id'])) {
                        $i++;
                        db('tbtype')->insert($where[$row]);
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

    public function OrderEvaluate($file)
    {
        $result = (new UploadExcel())->UploadFile($file, '会员状态');
        if ($result['valid'] == 4) {
            /** 循环读取每个单元格的数据 */
            $sheet = $result['data']['sheet'];
            $where = array();
            $i = 0;
            $k = 0;
            $j = 0;
            for ($row = 2; $row <= $result['data']['highestRow']; $row++) {
                $name = $sheet->getCell('A' . $row)->getValue();
                $releaseTime = $sheet->getCell('D' . $row)->getValue();
                $evaluate = $sheet->getCell('E' . $row)->getValue();

                $where[$row]['tbm_name'] = $name;
                $where[$row]['tbm_time'] = $releaseTime;
                $where[$row]['tbm_text'] = $evaluate;
                $where[$row]['createtime'] = time();
                //halt($where);
                if ($where) {
                    $j++;
                    $res = db('tbmessage')->where('tbm_time', $releaseTime)->where('tbm_name', $name)->field('tbm_id')->find();
                    //halt($res);
                    if (!isset($res['tb_id'])) {
                        $i++;
                        db('tbmessage')->insert($where[$row]);
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

}