<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 16:20
 */

namespace app\lib\enum;


class OrderStatusPdd
{
    public function getOrderStates($key)
    {
        $states=0;
        if($key=='未发货')
        {
            $states=1;
        }else if($key=='待签收')
        {
            $states=2;
        }else if($key=='已签收')
        {
            $states=3;

        }else if($key=='退款成功')
        {
            $states=4;
        }
        return $states;
    }
}