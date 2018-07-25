<?php
namespace app\admin\controller;

use think\Session;
use app\common\model\Statistics as A;
class Statistics  extends Common
{
    //访客统计
    public function index()
    {

       $info=db('fwl')->select();
       $this->assign('info',$info);
      $this_month=input('param.month');
       //判断GET是否有值，为空默认显示当前月份的数据  
        $this_year= date("Y");  //当前年份
        if($this_month=="")
        {
            $this_month=date("m");
        }
        //$this_month=date("m");  //当前月份
        $month_day=$this->month_days($this_year,$this_month);
        //halt($month_day);
       for($i=1;$i<=$month_day;$i++)
       {
          $month_day_arr[$i]['day']=$i."日";
          $thisday_row=$this->t_fltime($this_year,$this_month,$i);
          $sql1="select sum(count) as count_ip from qy_fwl  where btime between '".$thisday_row['start']."' and '".$thisday_row['end']."'"; 
          $count_ip_row=db()->query($sql1);   //一天所有ip的访问量
      //组装一天内所有访问量
      if($count_ip_row[0]['count_ip'])
          {
            $month_day_arr[$i]['count_ip']=$count_ip_row[0]['count_ip'];
            //$month_day_arr[$i][price_real]=sprintf("%.2f", $count);
          }else{
            $month_day_arr[$i]['count_ip']=0;
          }     
        }
        //halt($month_day_arr);
        $str_days="";
        $str_countips="";
        foreach($month_day_arr as $k => $v)
        {
          $str_days=$str_days."'".$v['day']."',";
          $str_countips=$str_countips.$v['count_ip'].",";
        }
        //halt($str_days);
        $str_days_last="[".rtrim($str_days, ',')."]"; 
        $str_days_countip="[".rtrim($str_countips, ',')."]"; 
        //halt($str_days_last);
        $this->assign('monthday',$str_days_last);
        $this->assign('count_ip',$str_days_countip);
        $this->assign('this_month',$this_month);
        //月份数组
        $month=array(
            array('id'=>1),
            array('id'=>2),
            array('id'=>3),
            array('id'=>4),
            array('id'=>5),
            array('id'=>6),
            array('id'=>7),
            array('id'=>8),
            array('id'=>9),
            array('id'=>10),
            array('id'=>11),
            array('id'=>12),
        );
        $this->assign('month',$month);
        $month_firstend=$this->mFristAndLast($this_year,$this_month);
      $sql="select sum(count) as count_all from qy_fwl where btime between '".$month_firstend['firstday']."' and '".$month_firstend['lastday']."'"; 
      $count_all=db()->query($sql);
      //halt($count_all);
    $this->assign('count_all',$count_all[0]['count_all']);
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
        $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
    }
     public function month_days($y,$m)
     {    
     //获取指定月份天数
      $d=date('j',mktime(0,0,1,($m==12?1:$m+1),1,($m==12?$y+1:$y))-24*3600);
      return $d;
     }
  //天气
  public function tian()
  {
       $ch = curl_init();
       $ph=101110101;
        $url = 'http://apis.baidu.com/tianyiweather/basicforecast/weatherapi?area='.$ph;
        $header = array(
            'apikey: e0a0a2150a235c72f08eb2f092c17df5',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);

        $data=json_decode($res,true);
        //halt($data);
        $data=$data['observe'][$ph]['1001002'];
        //halt($data);
        $reltime=date('Y-m-d', time()); 
        $reltime=$reltime.'  '.$data['000'];
        $reltime=strtotime($reltime);
      
        $time=time();
        $info=array(
            'rainfall'=>$data['006'],
            'pressure'=>$data['007'],
            'wind'=>$data['003'],
            'windph'=>$data['004'],
            'reltime'=>$reltime,
            'weather'=>$data['001'],
            'humidity'=>$data['005'],
            'temperature'=>$data['002'],
            'createtime'=>time()
        );
        $weather_add=new A();
        $weather_add->type_add($info); 
        
        //halt($info);
        //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();

  }
  public function  zhuan($weatherinfo,$value)
  {
      $str_hours="";
       foreach($weatherinfo as $k => $v)
        {
          $str_hours=$str_hours."'".$v[$value]."',";
        }
        
        $str_hours="[".rtrim($str_hours, ',')."]"; 
        return $str_hours;
  }
  //温度
  public function weather()
  {
        $weatherinfo=db('weather')->order('wea_id desc')->limit(24)->select();
        foreach($weatherinfo as $k=>$v)
        {
            $v['h']=date('H', $v['reltime']);
            $weatherinfo[$k]=$v;
        }
       // halt($weatherinfo);
       //小时
       $str_hours=$this->zhuan($weatherinfo,'h');
      //温度
       $str_temps=$this->zhuan($weatherinfo,'temperature');
       //湿度
        $str_hum=$this->zhuan($weatherinfo,'humidity');
      //降雨量
       $str_rain=$this->zhuan($weatherinfo,'rainfall');
        //风力
       $str_wind=$this->zhuan($weatherinfo,'wind');

        $this->assign('hours',$str_hours);
        $this->assign('temp',$str_temps);
        $this->assign('hum',$str_hum);
         $this->assign('rain',$str_rain);
         $this->assign('wind',$str_wind);
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
  } 
  //动态数据加载
  public function dong()
  {


        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);
        return $this->fetch();
  }
  public function update()
  {
     if(request()->isPost())
            {
              $res=array(
               'categories'=> '["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]',
               'data'=> '[5, 20, 36, 10, 10, 20]'
              );
                    
              return $res;
            }
  } 
  //统计
   function twoDecimal($num) {
        return sprintf("%.2f", $num);
    }
   
//中国地图


  public function tongji()
  {

 $province_config = array(
    'heilongjiang' => '黑龙江',
    'jilin' => '吉林',
    'liaoning' => '辽宁',
    'hebei' => '河北',
    'shandong' => '山东',
    'jiangsu' => '江苏',
    'zhejiang' => '浙江',
    'anhui' => '安徽',
    'henan' => '河南',
    'shanxi' => '山西',
    'shaanxi' => '陕西',
    'gansu' => '甘肃',
    'hubei' => '湖北',
    'jiangxi' => '江西',
    'fujian' => '福建',
    'hunan' => '湖南',
    'guizhou' => '贵州',
    'sichuan' => '四川',
    'yunnan' => '云南',
    'qinghai' => '青海',
    'hainan' => '海南',
    'shanghai' => '上海',
    'chongqing' => '重庆',
    'tianjin' => '天津',
    'beijing' => '北京',
    'ningxia' => '宁夏',
    'neimongol' => '内蒙古',
    'guangxi' => '广西',
    'xinjiang' => '新疆',
    'xizang' => '西藏',
    'guangdong' => '广东',
    'hongkong' => '香港',
    'taiwan' => '台湾',
    'macau' => '澳门', //澳门
);

$provinces = array(
    0 => array(
        'province' => '其他',
        'qty' => 12
    ),
    '1' => array(
        'province' => '上海',
        'qty' => 150
    ),
    '2' => array(
        'province' => '北京',
        'qty' => 60
    ),
    '3' => array
        (
        'province' => '陕西',
        'qty' => 82
    ),
    '4' => array(
        'province' => '新疆',
        'qty' =>25
    ),
    '5' => array(
        'province' => '广西',
        'qty' => 60
    ),
    '6' => array
        (
        'province' => '台湾',
        'qty' => 35
    ), 
   '7' => array
        (
        'province' => '香港',
        'qty' => 36
    ), 
   
);    
//print_r($provinces);
$maps = array();
$i = 0;
$total = 0;
foreach ($provinces as $k => $v) {
    $total += $v['qty'];
    if ($v['province'] == '其他') {
        $province_other = $v;
        unset($provinces[$k]);
    }
    if ($v['qty'] > 0) {
        foreach ($province_config as $k2 => $v2) {
            if ($v['province'] == $v2) {
                $maps[$k2] = array("name" => $v['province'], "value" => $v['qty'], "stateInitColor" => $i, "index" => $i + 1);
                $i++;
            }
        }
    }
}
//print_r($maps);
$maps_colors = array('003399', '0058B0', '0071E1', '1C8DFF', '51A8FF', '82C0FF', 'AAD5FF');

$i = 0;
$percent_value = 0;
$maps_num = count($maps);

foreach ($maps as $k => $v) {
    if ($i < $maps_num) {
        $maps[$k]['color'] = $maps_colors[$i];
        $i++;
    }
    $percent =$this->twoDecimal(($v['value'] / $total) * 100);
    $maps[$k]['value'] = $percent . "%";
    $percent_value +=$percent;
}

if ($percent_value != 100) {
    $maps['other'] = array(
        "name" => '其他地区',
        "value" => (100 - $percent_value) . "%",
        "stateInitColor" => '7',
        "index" => 8,
        "color" => "14c1d0"
    );
}

$maps_json = $maps ? json_encode($maps) : "";
$colors_json = json_encode($maps_colors);
$this->assign("maps", $maps);
$this->assign("maps_json", $maps_json);
$this->assign("maps_colors", json_encode($maps_colors));

 //导航管理
        $daoh=$this->auth_group();
        $ssname=Session::get('admin_username');
        $this->assign('ssname',$ssname);
        $this->assign('daoh',$daoh);


      return $this->fetch();
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
  //获取某个月开始结束的时间戳
  public function mFristAndLast($y = "", $m = "")
  {
    if ($y == "") $y = date("Y");
    if ($m == "") $m = date("m");
    $m = sprintf("%02d", intval($m));
    $y = str_pad(intval($y), 4, "0", STR_PAD_RIGHT);
 
    $m>12 || $m<1 ? $m=1 : $m=$m;
    $firstday = strtotime($y . $m . "01000000");
    $firstdaystr = date("Y-m-01", $firstday);
    $lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));
 
    return array(
        "firstday" => $firstday,
        "lastday" => $lastday
    );
  }

}