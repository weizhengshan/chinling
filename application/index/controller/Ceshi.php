<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19 0019
 * Time: 上午 11:52
 */

namespace app\index\controller;


class Ceshi  extends Common
{
    public function index(){

        $b=array('4','3','8','9','2','1');
        $len=count($b);//6

        for($k=1;$k<$len;$k++)
        {
            for($j=0;$j<$len-$k;$j++){
                if($b[$j]>$b[$j+1]){
                    $temp =$b[$j+1];
                    $b[$j+1] =$b[$j] ;
                    $b[$j] = $temp;
                }
            }
        }
        halt($b);
    }
}