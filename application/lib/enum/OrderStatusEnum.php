<?php
/**
 * Created by 七月
 * Author: 七月
 * 微信公号: 小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/3/7
 * Time: 16:10
 */

namespace app\lib\enum;


class OrderStatusEnum
{
      /*public function __construct()
      {

      }*/
      public function getOrderStates($key)
      {
          $states=0;
          if($key=='买家已付款，等待卖家发货')
          {
              $states=1;
          }else if($key=='卖家已发货，等待买家确认')
          {
              $states=2;
          }else if($key=='交易关闭')
          {
              $states=3;
          }else if($key=='交易成功')
          {
              $states=4;
          }else if($key=='退款')
          {
              $states=5;
          }
          return $states;
      }
}