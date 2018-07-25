<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/11 0011
 * Time: 上午 10:46
 */
namespace app\lib\communal;

class Communal
{
    public function month_days($y,$m)
    {
        //获取指定月份天数
        $d=date('j',mktime(0,0,1,($m==12?1:$m+1),1,($m==12?$y+1:$y))-24*3600);
        return $d;
    }
    public function timeList($lastTime)
    {
        $lastMonth=date('m',$lastTime);
        $currentMonth=date('m',time());
        $constantId=$currentMonth-$lastMonth;
        $historyTime=[];
        for ($i=$constantId; $i >= 0; $i--) {
            $historyTime[$i]['year']=date('Y' ,strtotime('-'.$i.' month'));
            $historyTime[$i]['month']=date('m' ,strtotime('-'.$i.' month'));
        }
        $historyData=array();
        $historyDataY=array();
        $timeJosn="";
        for($i=$constantId; $i >= 0; $i--)
        {
            $historyDays=$this->month_days($historyTime[$i]['year'],$historyTime[$i]['month']);
            //echo $historyDays;
            for ($j=1; $j <= $historyDays; $j++) {
                if($historyTime[$i]['month']<10)
                {
                    $historyTime[$i]['month']=substr($historyTime[$i]['month'],-1);
                }
                $num=count($historyDataY);
                $historyDataY[$num]=$historyTime[$i]['year'].'-'.$historyTime[$i]['month'].'-'.$j;
                $historyData[$i][$j]=$historyTime[$i]['month'].'/'.$j;
                $timeJosn=$timeJosn."'".$historyData[$i][$j]."',";
            }
        }
        $timeJson="[".rtrim($timeJosn, ',')."]";

        return array(
            'historyDataY'=>$historyDataY,
            'timeJson'=>$timeJson
        );
    }
    //获取当天的开始时间和结束时间
    public function t_fltime($year = 0, $month = 0, $day = 0)
    {
        if(empty($year))
        {
            $year = date("Y");
        }
        $start_year = $year;
        $start_year_formated = str_pad(intval($start_year), 4, "0", STR_PAD_RIGHT);
        $end_year = $start_year + 1;
        $end_year_formated = str_pad(intval($end_year), 4, "0", STR_PAD_RIGHT);

        if(empty($month))
        {
            //只设置了年份
            $start_month_formated = '01';
            $end_month_formated = '01';
            $start_day_formated = '01';
            $end_day_formated = '01';
        }
        else
        {
            $month > 12 || $month < 1 ? $month = 1 : $month = $month;
            $start_month = $month;
            $start_month_formated = sprintf("%02d", intval($start_month));

            if(empty($day))
            {
                //只设置了年份和月份
                $end_month = $start_month + 1;

                if($end_month > 12)
                {
                    $end_month = 1;
                }
                else
                {
                    $end_year_formated = $start_year_formated;
                }
                $end_month_formated = sprintf("%02d", intval($end_month));
                $start_day_formated = '01';
                $end_day_formated = '01';
            }
            else
            {
                //设置了年份月份和日期
                $startTimestamp = strtotime($start_year_formated.'-'.$start_month_formated.'-'.sprintf("%02d", intval($day))." 00:00:00");
                $endTimestamp = $startTimestamp + 24 * 3600 - 1;
                return array('start' => $startTimestamp, 'end' => $endTimestamp);
            }
        }
        $startTimestamp = strtotime($start_year_formated.'-'.$start_month_formated.'-'.$start_day_formated." 00:00:00");
        $endTimestamp = strtotime($end_year_formated.'-'.$end_month_formated.'-'.$end_day_formated." 00:00:00") - 1;
        return array('start' => $startTimestamp, 'end' => $endTimestamp);
    }
    public function getMonth($year,$month)
    {
        $time = $year."-".$month;
        $month_start = strtotime($time);//指定月份月初时间戳
        $month_end = mktime(23, 59, 59, date('m', strtotime($time))+1, 00);//指定月份月末时间戳
        return array('start' => $month_start, 'end' => $month_end);
    }
}