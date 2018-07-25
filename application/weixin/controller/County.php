<?php

namespace app\weixin\controller;

use think\Cache;
use app\admin\controller\CountyType as A;
use app\weixin\model\GetPrice as B;
use app\weixin\model\DayPrice as C;
use app\weixin\model\PostPro as D;

ini_set('max_execution_time', '120');

class County extends Common
{
        public function index1()
    {
        $data = db('countys')->order('county_sort')->where('pid', 2)->select();
        $this->assign('data', $data);
        $res = db('biginfo')->order('biginfo_sort')->find();
        //halt($res);
        $res['biginfo_month_show'] = str_replace('|', "','", $res['biginfo_month']);
        $res['biginfo_salesv_show'] = str_replace('|', "','", $res['biginfo_salesv']);
        $res['biginfo_yield_show'] = str_replace('|', "','", $res['biginfo_yield']);
        //halt($res);
        $this->assign('res', $res);
        return $this->fetch();
    }

    public function show()
    {
        return $this->fetch();
    }

    /**
     * 获得地址数据
     * @return [type] [description]
     */
    public function get_addr($id)
    {
        if (empty($id)) {
            $typesdata = db('countys')->where('county_states', 1)->where('pid', 1)->order('county_sort')->select();
            //halt($typesdata);
            //$arr=$this->GetTree($typesdata, 0, 0);
            $this->assign('arr', $typesdata);
        } else {
            $typesdata = db('countys')->where('county_states', 1)->where('pid', 1)->order('county_sort')->select();
            $this->assign('arr', $typesdata);

            $citydata = db('countys')->where('county_states', 1)->where('county_id', $id)->find();
            $getId = $this->getAllId();
            $citydatas = db('countys')->where('county_states', 1)->whereIn('county_id', $getId)->where('pid', $citydata['pid'])->select();

            //var_dump($citydatas);
            $prodata = db('countys')->where('county_states', 1)->where('county_id', $citydata['pid'])->find();
            $prodatas = db('countys')->where('county_states', 1)->where('pid', $prodata['pid'])->select();

            $this->assign('prodata', $prodatas);
            $this->assign('citydata', $citydatas);
            $this->assign('cityid', $citydata['pid']);
            $this->assign('provid', $prodata['pid']);
        }
    }

    public function getAllId()
    {
        //获得产品信息的县id数组
        $getAllId = db('varietiesy')->where('varies_states', 1)->field('varies_copid')->select();
        $getId = [];
        for ($i = 0; $i < count($getAllId); $i++) {
            $getId[$i] = $getAllId[$i]['varies_copid'];
        }
        $getId = array_unique($getId);
        //halt($getId);
        return $getId;
    }

    /**
     *
     *查询地址市/县
     */
    public function provice_post()
    {
        $id = input('param.add');
        $getId = $this->getAllId();
        $typesdata = db('countys')->where('county_states', 1)->where('pid', $id)->whereIn('county_id', $getId)->field('county_id,county_name')->order('county_sort')->select();
        echo json_encode($typesdata);
    }

    public function first()
    {
        /**
         * 秦岭腹地地址
         */
        /**
         * 默认选择镇安
         */
        //$county_name='镇安县';
        $county_name = '镇安县';
        $dataCity = db('countys')->where('county_name', $county_name)->field('county_id,pid')->find();
        $this->get_addr($dataCity['county_id']);
        $this->assign('dataCity', $dataCity);
        /**
         * 第一个折线图
         * @var [type]
         */
        $monthData = $this->getMonth();
        //halt($dataOne);
        /*$data=db('countys')->order('county_sort')->where('pid',2)->select();
    	$this->assign('data',$data);
    	$res=db('biginfo')->order('biginfo_sort')->find();
    	//halt($res);
        $res['biginfo_month_show']=str_replace('|',"','", $res['biginfo_month']);
        $res['biginfo_salesv_show']=str_replace('|',"','", $res['biginfo_salesv']);
        $res['biginfo_yield_show']=str_replace('|',"','", $res['biginfo_yield']);*/
        /**
         * 县产品分类(默认镇安)
         */
        //$all=$this->getCityPro($dataCity['county_id']);
        //halt($all);
        //$this->assign('onarrsort',$all['onarrSort']);
        //$this->assign('onarrpro',$all['onarrPro']);
        $this->assign('monthdata', $monthData);
        return $this->fetch();
    }

    /**
     * 月份
     */
    public function getMonth()
    {
        $monthData = "['一','二','三','四','五','六','七','八','九','十','十一','十二']";
        return $monthData;
    }

    /**
     * 县产品分类可展示销量的数据one
     * @return [type] [description]
     */
    public function getCityProSales($id)
    {
        /*$arrPro=db('varietiesy')->where('varies_copid',$id)->where('varies_states',1)->where('varies_grade',1)->select();*/
        //if(cache('getCityPro')){
        $arrPro = db()->table('qy_varietiesy')
            ->alias('a')
            ->join('typesales t', 't.sales_copid = a.varies_agpid')
            ->join('varieties v', 'a.varies_id =v.varie_name')
            ->join('countys c', 'a.varies_copid = c.county_id')
            ->where('varies_states', 1)
            ->order('varies_sort')
            ->where('varies_copid', $id)
            ->field('t.sales_val,v.varie_sales,a.varies_id,a.varies_name,v.varie_totaloutputv,c.year_value')
            ->where('varies_grade', 1)
            ->select();
        //halt($arrPro);
        $All = [];
        $onarrPro = "";

        foreach ($arrPro as $k => $v) {
            $onarrPro = $onarrPro . "'" . $v['varies_name'] . "',";
            $onarrsale['1'] = explode(",", $v['sales_val']);
            $onarrsale['2'] = explode(",", $v['varie_sales']);
            $v['proportion'] = number_format(mb_substr($v['varie_totaloutputv'], 0, -1, 'utf-8') / $v['year_value'], 2) * 100;
            for ($i = 0; $i < 12; $i++) {
                $onarrsale['3'][$i] = $onarrsale['2'][$i] / $onarrsale['1'][$i];
            }
            $onarrsale['4'] = implode("','", $onarrsale['3']);
            $v['onarrsale'] = "['" . $onarrsale['4'] . "']";
            $arrPro[$k] = $v;
        }
        $proportion = '';
        $allValue = "";
        $other = '其他';
        for ($i = 0; $i < count($arrPro); $i++) {
            $proportion = $proportion . '{value:' . $arrPro[$i]['proportion'] . ',name:"' . $arrPro[$i]['varies_name'] . '"},';
            $allValue = $allValue + $arrPro[$i]['proportion'];
        }
        //halt($proportion);
        $allValue = 100 - $allValue;
        $proportion = $proportion . '{value:' . $allValue . ',name:"' . $other . '"},';
        $All['proportion'] = "[" . rtrim($proportion, ',') . "]";
        $proportionName = $onarrPro . "'" . $other . "',";
        $All['proportionName'] = "[" . rtrim($proportionName, ',') . "]";
        //halt($All['proportionName']);
        $onarrPro = "[" . rtrim($onarrPro, ',') . "]";
        //halt($All['proportion']);
        $All['onarrPro'] = $onarrPro;
        $All['arrPro'] = $arrPro;

        /*}else
        {
          $All=cache('getCityPro');
        }*/
        return $All;
        //halt($All);
    }

    /**
     * 县产品分类two
     * @return [type] [description]
     */
    public function getCityPro($id)
    {
        //if(cache('getCityPro')){
        $arrPro = db()->table('qy_varietiesy')
            ->alias('a')
            ->join('varieties v', 'a.varies_id =v.varie_name')
            ->where('a.varies_copid', $id)
            ->field('a.varies_name,v.varie_totaloutput')
            ->where('varies_states', 1)
            ->select();
        $All = [];
        $onarrPro = "";
        $onarrSort = "";
        $onarrfalse = "";
        foreach ($arrPro as $k => $v) {

            $onarrPro = $onarrPro . "'" . $v['varies_name'] . "',";
            $onarrSort = $onarrSort . "'" . mb_substr($v['varie_totaloutput'], 0, -1, 'utf-8') . "',";
        }
        $onarrPro = "[" . rtrim($onarrPro, ',') . "]";
        $onarrSort = "[" . rtrim($onarrSort, ',') . "]";
        $onarrfalse = "{" . rtrim($onarrfalse, ',') . "}";

        $All['onarrPro'] = $onarrPro;
        $All['onarrSort'] = $onarrSort;
        //$All['oncounty']=$arrPro[0]['county_name'];
        //halt($All);
        return $All;
        //}else
        //{
        //$All=cache('getCityPro');
        //}
        //halt($onarrPro);
    }

    /**
     * 产品各月预产量
     */

    public function getMonthYield($id)
    {


        $arrPro = db()->table('qy_varietiesy')
            ->alias('a')
            ->join('varieties v', 'a.varies_id =v.varie_name')
            ->join('countys t', 't.county_id = a.varies_copid')
            ->where('varies_states', 1)
            ->order('varies_sort')
            ->where('varies_copid', $id)
            ->field('a.varies_id,a.varies_name,v.varie_yield,t.county_name')
            ->where('varies_grade', 1)
            ->select();
        $county_name = db('countys')->where('county_id', $id)->field('county_name')->find();
        //halt($arrPro);
        $nation = $county_name['county_name'];
        $All = [];
        $onarrPro = "";

        $zhanone = "";
        $zhantwo = "";
        foreach ($arrPro as $k => $v) {
            $onarrPro = $onarrPro . "'" . $v['varies_name'] . "',";
            $onarrsale['1'] = explode(",", $v['varie_yield']);
            $onarrsale['4'] = implode("','", $onarrsale['1']);
            $v['onarryield'] = "['" . $onarrsale['4'] . "']";
            /*销量去向*/
            $v['sale'] = db('salesdirection')->where('saledir_pid', $v['varies_id'])->select();
            foreach ($v['sale'] as $kk => $vv) {
                $vv['zhanone'] = "";
                $vv['zhantwo'] = "";
                $vv['showname'] = explode(",", $vv['saledir_name']);
                $vv['showvalue'] = explode(",", $vv['saledir_value']);
                /*[{name:'北京'}, {name:'上海',value:95}],*/
                for ($i = 0; $i < count($vv['showname']); $i++) {
                    $vv['zhanone'] = $vv['zhanone'] . "[{name:'" . $nation . "'},{name:'" . $vv['showname'][$i] . "',value:" . $vv['showvalue'][$i] . "}],";
                    $vv['zhantwo'] = $vv['zhantwo'] . "{name:'" . $vv['showname'][$i] . "',value:" . $vv['showvalue'][$i] . "},";
                }
                $vv['zhanone'] = "[" . rtrim($vv['zhanone'], ',') . "]";
                $vv['zhantwo'] = "[" . rtrim($vv['zhantwo'], ',') . "]";
                $v['sale'][$kk] = $vv;
            }
            $arrPro[$k] = $v;
        }
        $onarrPro = "[" . rtrim($onarrPro, ',') . "]";
        $All['onarrPro'] = $onarrPro;
        $All['arrPro'] = $arrPro;
        $All['oncounty'] = $county_name['county_name'];;
        //shalt($All);

        return $All;
    }

    /**
     * 销量去向
     * [{name:'北京'}, {name:'上海',value:95}],
     * [{name:'北京'}, {name:'广州',value:90}],
     */
    public function getSalesDire($id)
    {
        $arrPro = db('varietiesy')
            ->where('varies_copid', $id)
            ->field('varies_name,varies_sort,varies_id')
            ->where('varies_states', 1)
            ->select();

        /* foreach ($arrPro as $k=>$v)
            {
                $v['getSaleData']=db('salesdirection')
                           ->where('saledir_pid',$v['varies_id'])
                           ->select();
                   foreach ($v['getSaleData'] as $key => $value) {

                            }
                $arrPro[$k]=$v;
            }*/
        //halt($arrPro);
    }
    /*地图信息*/
    /*{name: '留坝县',value: Math.round(1),content:["拼过","sd","sadsads"]}*/
    public function getMapArr()
    {
        if (cache('getMapArr')) {
            $data = cache('getMapArr');
        } else {
            $dataCity = db('countys')
                ->where('county_states', 1)
                ->field('county_id,pid,county_name,county_describe')
                ->select();

            foreach ($dataCity as $k => $v) {
                $states = array(1, 2);
                $v['name_county'] = db('varietiesy')->where('varies_copid', $v['county_id'])->whereIn('varies_states', $states)->select();

                $v['zhi'] = "";
                for ($i = 0; $i < count($v['name_county']); $i++) {
                    $v['zhi'] = $v['zhi'] . "'" . $v['name_county'][$i]['varies_name'] . "',";
                }
                $v['zhi'] = "[" . rtrim($v['zhi'], ',') . "]";
                $dataCity[$k] = $v;
            }
            //halt($dataCity);
            $data = "";
            for ($i = 0; $i < count($dataCity); $i++) {
                if (!empty($v['zhi'])) {
                    //$data[$i]['zhi']=$dataCity[$i]['zhi'];
                    //$data[$i]['name']=$dataCity[$i]['county_name'];
                    $data = $data . "{name:'" . $dataCity[$i]['county_name'] . "',value:" . $dataCity[$i]['county_describe'] . ",content:" . $dataCity[$i]['zhi'] . "},";
                }
            }
            /*[{name: '留坝县',value: Math.round(1),content:["拼过","sd","sadsads"]}, ]*/

            $data = "[" . rtrim($data, ',') . "]";

            Cache::set('getMapArr', $data, 3600);
        }
        //halt($data);
        echo json_encode($data);
    }

    /**
     * ajax 获得产品数据(first)
     * @return [type] [description]
     */
    public function getcityarr()
    {
        $id = input('param.zhi');
        $all['third'] = $this->getCityPro($id);
        $all['first'] = $this->getCityProSales($id);
        $all['second'] = $this->getMonthYield($id);

        $all['weather'] = $this->getweather($id);
        //$all['forth']=$this->getMapArr();
        //halt($all['third']);
        echo json_encode($all);
    }

    public function getPriceArr()
    {
        $id = input('param.zhi');
        $all['forth'] = $this->getAllPrice($id);
        $all['five'] = $this->getCityPrice($id);
        $all['dayprice'] = $this->getDayPrice($id);
        echo json_encode($all);
    }

    public function second()
    {
        return $this->fetch();
    }

    public function third()
    {

        $county_name = '柞水县';
        $dataCity = db('countys')->where('county_name', $county_name)->field('county_id,pid')->find();
        $this->get_addr($dataCity['county_id']);
        /*产品分类*/
        $typesdatas = $this->get_protype();
        $this->assign('arrdata', $typesdatas);
        /*获得水果类*/
        $protype_name = "板栗";
        $typesdata = db('protypes')->where('protype_name', $protype_name)->field('protype_id,protype_pid')->find();
        $prodatas = db('protypes')->where('protype_pid', $typesdata['protype_pid'])->select();
        //halt($prodata);
        $this->assign('prodatas', $prodatas);
        $this->assign('typesdata', $typesdata);
        $this->assign('dataCity', $dataCity);
        return $this->fetch();
    }

    public function whole()
    {

        /* $res=db('weathcity')->select();
        foreach ($res as $k => $v) {
            $v['zhi']=db('weathcity')->where("pid",$v['oldid'])->select();
            $res[$k]=$v;
        }
        halt($res);*/
        /**
         * 秦岭腹地地址
         */
        /**
         * 默认选择镇安
         */
        //$county_name='镇安县';
        $county_name = '柞水县';
        $dataCity = db('countys')->where('county_name', $county_name)->field('county_id,pid')->find();

        $this->get_addr($dataCity['county_id']);
        /*产品分类*/
        $typesdatas = $this->get_protype();
        $this->assign('arrdata', $typesdatas);
        /*获得水果类*/
        $protype_name = "板栗";
        $typesdata = db('protypes')->where('protype_name', $protype_name)->field('protype_id,protype_pid')->find();
        $prodatas = db('protypes')->where('protype_pid', $typesdata['protype_pid'])->select();
        //halt($prodata);
        $this->assign('prodatas', $prodatas);
        $this->assign('typesdata', $typesdata);
        $this->assign('dataCity', $dataCity);

        /**
         * 第一个折线图
         * @var [type]
         */
        //halt($typesdatas);
        $monthData = $this->getMonth();
        $this->assign('monthdata', $monthData);
        return $this->fetch();
    }

    /**
     * 获得产品分类
     * @return [type] [description]
     */
    public function get_protype()
    {
        $typesdata = db('protypes')->where('protype_name', '大数据')->find();

        $typesdatas = db('protypes')->where('protype_pid', $typesdata['protype_id'])->select();
        return $typesdatas;

    }

    public function getPrice()
    {
        return $this->fetch();
    }

    /*全国价格*/
    public function getAllPrice($id)
    {

        $res = db('everycity')->where('states', 1)->where('proceid', $id)->order('every_id desc ')->limit(1)->find();

        if (!empty($res)) {
            $res['every_name'] = "[" . $res['every_name'] . "]";
            $res['every_value'] = "[" . $res['every_value'] . "]";
        } else {
            $res = 400;
        }

        //halt($res);
        return $res;

    }

    /*市价格*/
    public function getCityPrice($id)
    {
        $res = db('everycity')->where('states', 2)->where('proceid', $id)->order('every_id desc ')->limit(1)->find();

        if (!empty($res)) {
            $res['every_name'] = "[" . $res['every_name'] . "]";
            $res['every_value'] = "[" . $res['every_value'] . "]";
        } else {
            $res = 400;
        }

        return $res;

    }

    /*每天价格*/
    public function getDayPrice($id)
    {
        $res = db('dayprice')->where('states', 1)->where('proceid', $id)->order('day_id desc ')->limit(1)->find();
        if (!empty($res)) {
            $time = date("Y-m-d", $res['createtime']);
            $data = "";
            for ($i = 0; $i < 31; $i++) {
                $data = $data . "'" . date("m-d", strtotime('-' . $i . ' days', strtotime($time))) . "',";
            }
            $res['monthvalue'] = "[" . rtrim($data, ',') . "]";
            $res['every_value'] = "[" . $res['every_value'] . "]";
        } else {
            $res = 400;
        }

        return $res;

    }

    /*php请求一亩田数据全国价格*/
    public function getPostCityArr()
    {
        //使用方法
        //{locationId:'27',productId:'8199',breedId:'0'},
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }
        //halt($getSonArr);
        //for($i=0; $i <count($getSonArr) ; $i++) {
        $getAllId = explode("_", $getSonArr[$size]['priceid']);

        /*$locationId='0';
    $productId='7171';
    $breedId='0';*/
        $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);
        if (count($getAllId) == 2) {
            $post_data = array(
                'locationId' => 0,
                'productId' => $id,
                'breedId' => 0
            );
            $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_0';
        } else {
            $post_data = array(
                'locationId' => 0,
                'productId' => $id,
                'breedId' => $getAllId[1]
            );
            $url = "http://hangqing.ymt.com/chandi_" . $id . '_' . $getAllId[1] . '_0';
        }
        $countVal = $this->indexx($url);
        if (strlen($countVal) > 5000) {
            $res = send_post('http://hangqing.ymt.com/chandi/location_charts', $post_data);
            $arr = json_decode($res, true);
            //halt($arr);
            if (isset($arr['data']['title'])) {
                $title = substr($arr['data']['title'], 9);

                $postArr['pro_time'] = $title;
                //$postArr['unit']=$arr['data']['unit'];
                $cityName = $arr['data']['dataList'];
                $name = "";
                $nameValue = "";
                for ($i = 0; $i < count($cityName); $i++) {
                    if (isset($cityName[$i][0])) {
                        $name = $name . "'" . $cityName[$i][0] . "',";
                        $nameValue = $nameValue . "'" . $cityName[$i][1] . "',";
                    } else {
                        $name = $name . "'" . $cityName[$i]['name'] . "',";
                        $nameValue = $nameValue . "'" . $cityName[$i]['y'] . "',";
                    }
                }
                if (isset($cityName[0][0])) {
                    $cityNameOne = $cityName[0][0];
                } else {
                    $cityNameOne = $cityName[0]['name'];
                }

                $getCityid = db('ymtaddr')->where('ymt_name', $cityNameOne)->field('id')->find();
                if (isset($getCityid['id'])) {
                    $postArr['cityid'] = $getCityid['id'];
                } else {
                    $postArr['cityid'] = 0;
                }
                //halt($getCityid);
                $postArr['pro_name'] = $arr['data']['product'];
                $postArr['every_name'] = rtrim($name, ',');
                $postArr['every_value'] = rtrim($nameValue, ',');
                $postArr['year'] = date('Y');

                $postArr['states'] = 1;
                $postArr['cityid'] = 0;
                $postArr['proceid'] = $getSonArr[$size]['protype_id'];
                $postAddr = new B();
                $res = $postAddr->add($postArr, $size, count($getSonArr));
                if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                    $this->getPostCityArrA($res['msg']);
                }
            } else {
                $size = $size + 1;
                $this->getPostCityArrA($size);
            }
        } else {
            $size = $size + 1;
            $this->getPostCityArrA($size);
        }
    }

    public function getPostCityArrA($size)
    {
        //使用方法
        //{locationId:'27',productId:'8199',breedId:'0'},
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }

        //halt(count($getSonArr));
        /* echo $getSonArr[37]['priceid'];
       halt($getSonArr);*/

        //for($i=0; $i <count($getSonArr) ; $i++) {
        // $getAllId[$i]=explode("_",$getSonArr[$i]['priceid']);

        /*$locationId='0';
    $productId='7171';
    $breedId='0';*/
        if (!(($size + 1) > count($getSonArr))) {

            $getAllId = explode("_", $getSonArr[$size]['priceid']);
            echo $getSonArr[$size]['priceid'] . '<br>';
            echo $size . '<br>';
            if ($getSonArr[$size]['priceid'] != 0) {

                $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);
                if (count($getAllId) == 2) {
                    $post_data = array(
                        'locationId' => 0,
                        'productId' => $id,
                        'breedId' => 0
                    );
                    $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_0';
                } else {
                    $post_data = array(
                        'locationId' => 0,
                        'productId' => $id,
                        'breedId' => $getAllId[1]
                    );
                    $url = "http://hangqing.ymt.com/chandi_" . $id . '_' . $getAllId[1] . '_0';
                }

                $countVal = $this->indexx($url);
                if (strlen($countVal) > 5000) {
                    $res = send_post('http://hangqing.ymt.com/chandi/location_charts', $post_data);
                    $arr = json_decode($res, true);
                    //halt($arr);
                    if (isset($arr['data']['title'])) {
                        $title = substr($arr['data']['title'], 9);

                        $postArr['pro_time'] = $title;
                        //$postArr['unit']=$arr['data']['unit'];
                        $cityName = $arr['data']['dataList'];
                        $name = "";
                        $nameValue = "";
                        for ($i = 0; $i < count($cityName); $i++) {
                            if (isset($cityName[$i][0])) {
                                $name = $name . "'" . $cityName[$i][0] . "',";
                                $nameValue = $nameValue . "'" . $cityName[$i][1] . "',";
                            } else {
                                $name = $name . "'" . $cityName[$i]['name'] . "',";
                                $nameValue = $nameValue . "'" . $cityName[$i]['y'] . "',";
                            }
                        }
                        if (isset($cityName[0][0])) {
                            $cityNameOne = $cityName[0][0];
                        } else {
                            $cityNameOne = $cityName[0]['name'];
                        }
                        $getCityid = db('ymtaddr')->where('ymt_name', $cityNameOne)->field('id')->find();
                        if (isset($getCityid['id'])) {
                            $postArr['cityid'] = $getCityid['id'];
                        } else {
                            $postArr['cityid'] = 0;
                        }
                        $postArr['pro_name'] = $arr['data']['product'];
                        $postArr['every_name'] = rtrim($name, ',');
                        $postArr['every_value'] = rtrim($nameValue, ',');
                        $postArr['year'] = date('Y');
                        $postArr['states'] = 1;
                        $postArr['cityid'] = 0;
                        $postArr['proceid'] = $getSonArr[$size]['protype_id'];
                        $postAddr = new B();
                        $res = $postAddr->add($postArr, $size, count($getSonArr));
                        if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                            $this->getPostCityArrA($res['msg']);
                        }
                    } else {
                        $size = $size + 1;
                        $this->getPostCityArrA($size);
                    }
                } else {
                    $size = $size + 1;
                    $this->getPostCityArrA($size);
                }

            } else {
                $size = $size + 1;
                $this->getPostCityArrA($size);
            }
        } else {
            echo '添加完成';
        }
    }

    public function indexx($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $img = curl_exec($ch);
        return $img;
    }

    /*php请求一亩田数据市价格*/

    public function getPostCountyArr()
    {
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }
        //halt($getSonArr);
        //获得城市的id
        $id = $getSonArr[$size]['protype_id'];
        $getcity = db('everycity')->where('proceid', $id)->field('cityid')->find();
        $getAllId = explode("_", $getSonArr[$size]['priceid']);
        $laId = $getcity['cityid'];
        if ($getSonArr[$size]['priceid'] != 0) {

            $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);
            if (count($getAllId) == 2) {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => 0
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_' . $laId;
            } else {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => $getAllId[1]
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_' . $getAllId[1] . '_' . $laId;
            }
            $countVal = $this->indexx($url);
            if (strlen($countVal) > 5000) {
                $res = send_post('http://hangqing.ymt.com/chandi/location_charts', $post_data);
                $arr = json_decode($res, true);
                //halt($arr);
                if (isset($arr['data']['title'])) {
                    $title = substr($arr['data']['title'], 9);

                    $postArr['pro_time'] = $title;
                    //$postArr['unit']=$arr['data']['unit'];
                    $cityName = $arr['data']['dataList'];
                    $name = "";
                    $nameValue = "";
                    for ($i = 0; $i < count($cityName); $i++) {
                        if (isset($cityName[$i][0])) {
                            $name = $name . "'" . $cityName[$i][0] . "',";
                            $nameValue = $nameValue . "'" . $cityName[$i][1] . "',";
                        } else {
                            $name = $name . "'" . $cityName[$i]['name'] . "',";
                            $nameValue = $nameValue . "'" . $cityName[$i]['y'] . "',";
                        }
                    }
                    $postArr['pro_name'] = $arr['data']['product'];
                    $postArr['every_name'] = rtrim($name, ',');
                    $postArr['every_value'] = rtrim($nameValue, ',');
                    $postArr['year'] = date('Y');
                    $postArr['states'] = 2;
                    $postArr['cityid'] = $laId;
                    $postArr['proceid'] = $getSonArr[$size]['protype_id'];

                    $postAddr = new B();
                    $res = $postAddr->add($postArr, $size, count($getSonArr));
                    if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                        $this->getPostCountyArrA($res['msg']);
                    }
                } else {
                    $size = $size + 1;
                    $this->getPostCountyArrA($size);
                }
            } else {
                $size = $size + 1;
                $this->getPostCountyArrA($size);
            }

        } else {
            $size = $size + 1;
            $this->getPostCountyArrA($size);
        }
    }

    public function getPostCountyArrA($size)
    {
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }

        $id = $getSonArr[$size]['protype_id'];
        $getcity = db('everycity')->where('proceid', $id)->field('cityid')->find();
        $getAllId = explode("_", $getSonArr[$size]['priceid']);
        $laId = $getcity['cityid'];
        echo $getSonArr[$size]['priceid'] . '<br>';
        echo $size . '<br>';
        if ($getSonArr[$size]['priceid'] != 0) {

            $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);

            if (count($getAllId) == 2) {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => 0
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_' . $laId;
            } else {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => $getAllId[1]
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_' . $getAllId[1] . '_' . $laId;
            }
            $countVal = $this->indexx($url);
            if (strlen($countVal) > 5000) {
                $res = send_post('http://hangqing.ymt.com/chandi/location_charts', $post_data);
                $arr = json_decode($res, true);
                //halt($arr);
                if (isset($arr['data']['title'])) {
                    $title = substr($arr['data']['title'], 9);

                    $postArr['pro_time'] = $title;
                    //$postArr['unit']=$arr['data']['unit'];
                    $cityName = $arr['data']['dataList'];
                    $name = "";
                    $nameValue = "";
                    for ($i = 0; $i < count($cityName); $i++) {
                        if (isset($cityName[$i][0])) {
                            $name = $name . "'" . $cityName[$i][0] . "',";
                            $nameValue = $nameValue . "'" . $cityName[$i][1] . "',";
                        } else {
                            $name = $name . "'" . $cityName[$i]['name'] . "',";
                            $nameValue = $nameValue . "'" . $cityName[$i]['y'] . "',";
                        }
                    }
                    $postArr['pro_name'] = $arr['data']['product'];
                    $postArr['every_name'] = rtrim($name, ',');
                    $postArr['every_value'] = rtrim($nameValue, ',');
                    $postArr['year'] = date('Y');
                    $postArr['states'] = 2;
                    $postArr['cityid'] = $laId;
                    $postArr['proceid'] = $getSonArr[$size]['protype_id'];
                    $postAddr = new B();
                    $res = $postAddr->add($postArr, $size, count($getSonArr));
                    if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                        $this->getPostCountyArrA($res['msg']);
                    }
                } else {
                    $size = $size + 1;
                    $this->getPostCountyArrA($size);
                }
            } else {
                $size = $size + 1;
                $this->getPostCountyArrA($size);
            }
        } else {
            $size = $size + 1;
            $this->getPostCountyArrA($size);
        }
    }

    /*php请求一亩田数据近三十天价格*/

    public function getMonthPrice()
    {
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }

        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }

        $id = $getSonArr[$size]['protype_id'];
        $getcity = db('everycity')->where('proceid', $id)->field('cityid')->find();
        $getAllId = explode("_", $getSonArr[$size]['priceid']);
        $laId = $getcity['cityid'];
        echo $getSonArr[$size]['priceid'] . '<br>';
        echo $size . '<br>';
        if ($getSonArr[$size]['priceid'] != 0) {

            $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);

            if (count($getAllId) == 2) {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => 0
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_' . $laId;
            } else {
                $post_data = array(
                    'locationId' => $laId,
                    'productId' => $id,
                    'breedId' => $getAllId[1]
                );
                $url = "http://hangqing.ymt.com/chandi_" . $id . '_' . $getAllId[1] . '_' . $laId;
            }

            $countVal = $this->indexx($url);
            if (strlen($countVal) > 5000) {
                $res = send_post('http://hangqing.ymt.com/chandi/price_charts', $post_data);
                $arr = json_decode($res, true);
                //halt($arr);
                if (isset($arr['data']['title'])) {
                    $title = substr($arr['data']['title'], 9);

                    $postArr['pro_time'] = $title;
                    //$postArr['unit']=$arr['data']['unit'];
                    $cityName = $arr['data']['dataList'];
                    $nameValue = "";

                    for ($i = 0; $i < count($cityName); $i++) {
                        $nameValue = $nameValue . "'" . $cityName[$i] . "',";
                    }
                    $postArr['pro_name'] = $arr['data']['product'];
                    $postArr['every_value'] = rtrim($nameValue, ',');
                    $postArr['year'] = date('Y');
                    $postArr['states'] = 1;
                    $postArr['proceid'] = $getSonArr[$size]['protype_id'];
                    $postAddr = new C();
                    $res = $postAddr->add($postArr, $size, count($getSonArr));
                    if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                        $this->getMonthPriceA($res['msg']);
                    }
                } else {
                    $size = $size + 1;
                    $this->getMonthPriceA($size);
                }
            } else {
                $size = $size + 1;
                $this->getMonthPriceA($size);
            }
        } else {
            $size = $size + 1;
            $this->getMonthPriceA($size);
        }

    }

    public function getMonthPriceA($size)
    {
        /*获得产品的菜单栏*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $typesdatas = $this->get_protype();
        $getSonArr = [];
        $getSonArrone = [];
        foreach ($typesdatas as $k => $v) {
            $getSonArr = array_merge($getSonArr, $getSonArrone);
            $getSonArrone = db('protypes')->where('protype_pid', $v['protype_id'])->select();
        }

        $id = $getSonArr[$size]['protype_id'];
        $getcity = db('everycity')->where('proceid', $id)->field('cityid')->find();
        $getAllId = explode("_", $getSonArr[$size]['priceid']);
        $laId = $getcity['cityid'];
        echo $getSonArr[$size]['priceid'] . '<br>';
        echo $size . '<br>';
        if ($getSonArr[$size]['priceid'] != 0) {

            $id = strstr($getSonArr[$size]['priceid'], '_', TRUE);

            $post_data = array(
                'locationId' => $laId,
                'productId' => $id,
                'breedId' => 0
            );
            $url = "http://hangqing.ymt.com/chandi_" . $id . '_0_' . $laId;
            $countVal = $this->indexx($url);
            if (strlen($countVal) > 5000) {
                $res = send_post('http://hangqing.ymt.com/chandi/price_charts', $post_data);
                $arr = json_decode($res, true);
                //halt($arr);
                if (isset($arr['data']['title'])) {
                    $title = substr($arr['data']['title'], 9);

                    $postArr['pro_time'] = $title;
                    //$postArr['unit']=$arr['data']['unit'];
                    $cityName = $arr['data']['dataList'];
                    $nameValue = "";

                    for ($i = 0; $i < count($cityName); $i++) {
                        $nameValue = $nameValue . "'" . $cityName[$i] . "',";
                    }
                    $postArr['pro_name'] = $arr['data']['product'];
                    $postArr['every_value'] = rtrim($nameValue, ',');
                    $postArr['year'] = date('Y');
                    $postArr['states'] = 1;
                    $postArr['proceid'] = $getSonArr[$size]['protype_id'];
                    $postAddr = new C();
                    $res = $postAddr->add($postArr, $size, count($getSonArr));
                    if ($res['valid'] = 4 && $res['all'] - 1 >= $res['msg']) {
                        $this->getMonthPriceA($res['msg']);
                    }
                } else {
                    $size = $size + 1;
                    $this->getMonthPriceA($size);
                }
            } else {
                $size = $size + 1;
                $this->getMonthPriceA($size);
            }
        } else {
            $size = $size + 1;
            $this->getMonthPriceA($size);
        }
    }

    /**
     * 添加数据
     */
    public function getweather($id)
    {
        $value = db('countys')->where('county_id', $id)->field('weatherid,county_name')->find();
        //halt($value);
        $durl = "http://www.sojson.com/tianqi/api/" . $value['weatherid'] . ".shtml";
        //echo "http://www.sojson.com/tianqi/api/".$value['weatherid'].".shtml";
        //$durl="http://www.sojson.com/tianqi/api/1026-57113.shtml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $r = curl_exec($ch);
        curl_close($ch);
        $res['r'] = $r;
        $res['name'] = $value['county_name'];
        $data = json_decode($r, true);
        if (empty($data['day7'])) {
            $id = 45;//如何天气没数据 默认西安的天气
            $value = db('countys')->where('county_id', $id)->field('weatherid,county_name')->find();
            //halt($value);
            $durl = "http://www.sojson.com/tianqi/api/" . $value['weatherid'] . ".shtml";
            //echo "http://www.sojson.com/tianqi/api/".$value['weatherid'].".shtml";
            //$durl="http://www.sojson.com/tianqi/api/1026-57113.shtml";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $durl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
            $r = curl_exec($ch);
            curl_close($ch);
            $res['r'] = $r;
            $res['name'] = $value['county_name'];
            //exit;
        }
        return $res;
        //halt($res['r']day7);

    }

    /**
     * php模拟登录 抓取数据
     */
    public function getUrlData()
    {
        $curl = curl_init();
        $cookie_jar = tempnam('./tmp', 'cookie');
        curl_setopt($curl, CURLOPT_URL, 'https://myseller.taobao.com/home.htm?spm=a1z09.1.header.2.1c0c5f5fQ7zSK3');//这里写上处理登录的界面
        curl_setopt($curl, CURLOPT_POST, 1);
        $request = "user='秦岭云2017:云云'&password='yunyun2017'";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);//传 递数据
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);// 把返回来的cookie信息保存在$cookie_jar文件中
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设定返回 的数据是否自动显示
        curl_setopt($curl, CURLOPT_HEADER, false);//设定是否显示头信 息
        curl_setopt($curl, CURLOPT_NOBODY, false);//设定是否输出页面 内容
        curl_exec($curl);//返回结果
        curl_close($curl); //关闭

        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, 'https://myseller.taobao.com/home.htm');//登陆后要从哪个页面获取信息
        curl_setopt($curl2, CURLOPT_HEADER, false);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl2, CURLOPT_COOKIEFILE, $cookie_jar);
        $content = curl_exec($curl2);

    }

    /**
     * 获得对应天气的数据编码
     * @return [type] [description]
     */
    public function getPro()
    {
        //$durl="http://www.sojson.com/tianqi/province.shtml";
        /* $value=1033;
        $durl="http://www.sojson.com/tianqi/city/".$value.".shtml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $r = curl_exec($ch);
        curl_close($ch);
        $r=json_decode($r,true);
        //halt($r);


        $arr; */
        /* for ($i=0; $i <count($r) ; $i++) {
           $arr[$i]['oldid']=$r[$i]['id'];
           $arr[$i]['weath_code']=$r[$i]['code'];
           $arr[$i]['weath_name']=$r[$i]['name'];
           $arr[$i]['pid']=$value;
           $arr[$i]['createtime']=time();
           $arr[$i]['states']=1;
           $res=db('weathcity')->insert($arr[$i]);
       }*/
        /*$postArr= new D();
       $res=$postArr->add($arr);*/
        $data = db('weathcity')->order('weath_id desc')->select();
        //halt($data);
    }

    /**
     *
     *查询产品分类
     */
    public function pinzh_post()
    {
        $id = input('param.add');
        $typesdata = db('protypes')->where('protype_states', 1)->where('protype_pid', $id)->field('protype_id,protype_name')->order('protype_sort')->select();

        echo json_encode($typesdata);
    }

    /**
     * 将天气的ID导入到秦岭地区中
     */
    public function daoWeather()
    {
        /*$str="陕西省";
       //halt(strlen($str));
       halt(mb_substr($str,0,-1,'utf-8'));*/
        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }

        $qldata = db('countys')->where('county_states', 1)->select();

        foreach ($qldata as $k => $v) {
            if (strlen($v['county_name']) > 6) {

                $v['county_name'] = mb_substr($v['county_name'], 0, -1, 'utf-8');
            }
            $qldata[$k] = $v;
        }
        $var_id = db('weathcity')->where('weath_name', $qldata[$size]['county_name'])->field('oldid,pid')->find();
        if (!empty($var_id)) {
            $value = $var_id['pid'] . "-" . $var_id['oldid'];
            $update = db('countys')->where('county_id', $qldata[$size]['county_id'])->update(['weatherid' => $value]);
            if ($update) {
                $size = $size + 1;
                $this->daoWeatherA($size);
            }
        } else {
            $size = $size + 1;
            $this->daoWeatherA($size);
        }
    }

    public function daoWeatherA($size)
    {

        if (isset($size)) {
            $size = $size;
        } else {
            $size = 0;
        }
        $qldata = db('countys')->where('county_states', 1)->select();
        //halt($size);

        if (count($qldata) + 1 > $size) {
            foreach ($qldata as $k => $v) {
                if (strlen($v['county_name']) > 6) {

                    $v['county_name'] = mb_substr($v['county_name'], 0, -1, 'utf-8');
                }
                $qldata[$k] = $v;
            }
            $var_id = db('weathcity')->where('weath_name', $qldata[$size]['county_name'])->field('oldid,pid')->find();
            if (!empty($var_id)) {
                $value = $var_id['pid'] . "-" . $var_id['oldid'];
                $update = db('countys')->where('county_id', $qldata[$size]['county_id'])->update(['weatherid' => $value]);
                echo $size;
                if ($update) {
                    $size = $size + 1;
                    $this->daoWeatherA($size);
                }
            } else {
                $size = $size + 1;
                $this->daoWeatherA($size);
            }
        } else {
            echo '循环完成';
        }
    }

    /**
     * ajax提交电商数据
     */
    public function getAjaxTb()
    {
        $res['allSummary'] = $this->taobao_Summary();
        $res['broken'] = $this->getBrokenLineData();
        $res['SalesWhere'] = $this->TaobaoSalesWhere();
        echo json_encode($res);
    }

    /**
     * 淘宝数据
     */
    public function taobao_Summary()
    {
        //总交易额
        $ATurnover = db('tborder')->sum('tb_actualpay');
        //总交易量
        $AllVolume = db('tbtype')->sum('tbt_purchasen');
        //最近一周
        $date = date('Y-m-d', strtotime('-7 days'));
        $WeekBeforTime = strtotime($date);
        $AllOrder = db('tborder')->select();
        $WeekMoney = "";
        $WeekNum = "";
        foreach ($AllOrder as $k => $v) {
            $v['time'] = strtotime($v['tb_orderpaytime']);
            if ($v['time'] > $WeekBeforTime) {
                $WeekMoney = $WeekMoney + $v['tb_actualpay'];
                $WeekAll = db('tbtype')->where('tbt_orderid', $v['tb_orderid'])->field('tbt_purchasen')->select();
                for ($i = 0; $i < count($WeekAll); $i++) {
                    $WeekNum = $WeekNum + $WeekAll[$i]['tbt_purchasen'];
                }
            }

        }
        $Summary['ATurnover'] = $ATurnover * 666;
        $Summary['AllVolume'] = $AllVolume * 230;
        $Summary['WeekMoney'] = $WeekMoney * 63;
        $Summary['WeekNum'] = $WeekNum * 64;
        /*评价*/
        $evaluate = db('tbmessage')->select();
        /*产品分类和销量*/
        $typeSale = db('tbtype')->select();
        //['板栗','柿饼','蜂蜜','核桃'];
        $typeData = array('板栗', '柿饼', '蜂蜜', '核桃');
        $typeNum = array(0, 0, 0, 0);

        /*  $abc=strstr("Hello world!","bu");
        halt($abc);*/
        //$size=0;
        foreach ($typeSale as $k => $v) {
            for ($i = 0; $i < count($typeData); $i++) {

                if (strstr($v['tbt_title'], $typeData[$i])) {
                    //$size=$size+1;
                    $typeNum[$i] = $typeNum[$i] + $v['tbt_purchasen'] * 230;
                }
            }

        }
        //halt($typeNum);
        $gtypeData = "";
        $gtypeNum = "";
        for ($i = 0; $i < count($typeData); $i++) {
            $gtypeData = $gtypeData . "'" . $typeData[$i] . "',";
            $gtypeNum = $gtypeNum . "'" . $typeNum[$i] . "',";
        }
        $getTypeData['gtypeData'] = "[" . rtrim($gtypeData, ',') . "]";
        $getTypeData['gtypeNum'] = "[" . rtrim($gtypeNum, ',') . "]";


        $res['getTypeData'] = $getTypeData;
        $res['evaluate'] = $evaluate;
        $res['Summary'] = $Summary;
        //halt($res);
        return $res;

    }

    public function month_days($y, $m)
    {
        //获取指定月份天数
        $d = date('j', mktime(0, 0, 1, ($m == 12 ? 1 : $m + 1), 1, ($m == 12 ? $y + 1 : $y)) - 24 * 3600);
        return $d;
    }

    /*获得产品没半月的销量折线图*/
    public function getBrokenLineData()
    {
        //halt($MonthDay);
        $FourMonthsAgotime = date('Y-m-01 00:00:00', strtotime('-3 month'));  //近四个月
        //halt($FourMonthsAgotime);
        $lastTime = strtotime($FourMonthsAgotime);
        //halt($lastTime);
        $constantId = 4;
        for ($i = 3; $i >= 0; $i--) {
            $historyTime[$i]['year'] = date('Y', strtotime('-' . $i . ' month'));
            $historyTime[$i]['month'] = date('m', strtotime('-' . $i . ' month'));
        }
        //halt($historyTime);
        $historyData = array();
        $historyDataY = array();
        $timeJosn = "";
        for ($i = 3; $i >= 0; $i--) {
            $historyDays = $this->month_days($historyTime[$i]['year'], $historyTime[$i]['month']);
            //echo $historyDays;
            for ($j = 1; $j <= $historyDays; $j++) {
                if ($historyTime[$i]['month'] < 10) {
                    $historyTime[$i]['month'] = substr($historyTime[$i]['month'], -1);
                }
                $num = count($historyDataY);
                $historyDataY[$num] = $historyTime[$i]['year'] . '-' . $historyTime[$i]['month'] . '-' . $j;
                $historyData[$i][$j] = $historyTime[$i]['month'] . '/' . $j;
                $timeJosn = $timeJosn . "'" . $historyData[$i][$j] . "',";
            }

        }
        //halt($historyDataY);
        $timeJson = "[" . rtrim($timeJosn, ',') . "]";

        $typeData = array('板栗', '柿饼', '蜂蜜', '核桃');
        $typeJson = array();
        $typeSonJson = array();
        //$AllOrder=db('tborder')->select();
        $AllOrder = db()->table('qy_tborder')
            ->alias('a')
            ->join('qy_tbtype w', 'a.tb_orderid = w.tbt_orderid')
            ->field('w.tbt_purchasen,w.tbt_title,a.tb_orderpaytime')
            ->select();
        //halt($AllOrder);
        for ($i = 0; $i < count($historyDataY); $i++) {
            $typeJson[$i] = 0;
        }

        for ($j = 0; $j < count($typeData); $j++) {
            for ($i = 0; $i < count($historyDataY); $i++) {
                $typeSonJson[$j][$i] = 0;
            }
        }
        foreach ($AllOrder as $k => $v) {
            $v['time'] = strtotime($v['tb_orderpaytime']);
            if ($v['time'] > $lastTime) {           //halt();
                $oldY = date('Ymd', strtotime($v['tb_orderpaytime']));
                //echo $historyDays;
                //$typeJson[$oldY]=0;
                for ($j = 0; $j < count($historyDataY); $j++) {

                    $newY = date('Ymd', strtotime($historyDataY[$j]));

                    //echo $oldY.'/'.$newY.'<br>';
                    if ($oldY == $newY) {
                        //echo '123wo'.'<br>';
                        $typeJson[$j] = $typeJson[$j] + $v['tbt_purchasen'];
                        for ($i = 0; $i < count($typeData); $i++) {
                            //$typeJson[$j][$i]=0;
                            if (strstr($v['tbt_title'], $typeData[$i])) {
                                //$size=$size+1;
                                $typeSonJson[$i][$j] = $typeSonJson[$i][$j] + $v['tbt_purchasen'];
                            }
                        }
                        //echo $v['tbt_purchasen'].'<hr>';
                    }
                }
            }
        }
        array_push($typeData, "全部");
        $typeJsonName = "";
        for ($i = 0; $i < count($typeData); $i++) {
            $typeJsonDate[$i] = "";
            $typeJsonName = $typeJsonName . "'" . $typeData[$i] . "',";
        }
        $typeJsonName = "[" . rtrim($typeJsonName, ',') . "]";
        for ($i = 0; $i < count($typeJson); $i++) {
            /*添加模拟数据*/
            /*  if($i<26)
            {
                $typeJsonDate[count($typeData)-1]=$typeJsonDate[count($typeData)-1]."'".$typeJson[$i]."',";
            }elseif($i>26 && $i<60)
            {
                $typeJsonDate[count($typeData)-1]=$typeJsonDate[count($typeData)-1]."'".($typeJson[$i]+mt_rand(20,40))."',";
            }else
            {
                $typeJsonDate[count($typeData)-1]=$typeJsonDate[count($typeData)-1]."'".($typeJson[$i]+mt_rand(40,80))."',";
            }*/
            $value = ($typeJson[$i] + 1) * 24;
            $typeJsonDate[count($typeData) - 1] = $typeJsonDate[count($typeData) - 1] . "'" . $value . "',";
        }

        for ($j = 0; $j < count($typeSonJson); $j++) {
            for ($i = 0; $i < count($typeJson); $i++) {
                $value = ($typeSonJson[$j][$i] + 1) * 24;
                $typeJsonDate[$j] = $typeJsonDate[$j] . "'" . $value . "',";
            }
        }
        //halt($typeJsonDate);
        for ($i = 0; $i < count($typeData); $i++) {
            $typeJsonDate[$i] = "[" . rtrim($typeJsonDate[$i], ',') . "]";
        }
        $AjaxTypeJson['typeJsonName'] = $typeJsonName;
        $AjaxTypeJson['typeJsonDate'] = $typeJsonDate;
        $AjaxTypeJson['timeJson'] = $timeJson;
        //halt($AjaxTypeJson);
        return $AjaxTypeJson;
    }

    /*电商去向图*/
    public function TaobaoSalesWhere()
    {
        $AllOrder = db()->table('qy_tborder')
            ->alias('a')
            ->join('qy_tbtype w', 'a.tb_orderid = w.tbt_orderid')
            ->field('w.tbt_purchasen,w.tbt_title,a.tb_address')
            ->select();

        foreach ($AllOrder as $k => $v) {
            $v['tb_address'] = explode(" ", $v['tb_address'])[0];
            //$v['tb_address']= mb_substr($v['tb_address'],0,mb_strlen($v['tb_address'])-1,'utf-8');
            $AllOrder[$k] = $v;
        }
        //halt($AllOrder);
        $cityName = array();
        for ($i = 0; $i < count($AllOrder); $i++) {
            $cityName[$i] = $AllOrder[$i]['tb_address'];
        }
        $cityName = array_unique($cityName);
        $cityNameH = [];
        foreach ($cityName as $v) {
            $cityNameJson[$v] = 0;
            $cityNameH[] = $v;
        }
        //halt($cityNameH);
        //halt($AllOrder);
        for ($i = 0; $i < count($cityNameH); $i++) {
            for ($j = 0; $j < count($AllOrder); $j++) {
                if ($cityNameH[$i] == $AllOrder[$j]['tb_address']) {
                    $cityNameJson[$AllOrder[$j]['tb_address']] = $cityNameJson[$AllOrder[$j]['tb_address']] + $AllOrder[$j]['tbt_purchasen'];
                }
            }
        }
        //halt($AllOrder);
        //halt($cityNameJson);
        // [{name:'北京'}, {name:'上海',value:95}],
        //{name:'上海',value:95},
        $nation = "镇安县";
        $cityNameJsonData['cityNameVal'] = "";
        $cityNameJsonData['cityName'] = "";
        $cityNameJsonData['city'] = $nation;

        foreach ($cityNameJson as $k => $v) {
            $value = $v * 230;
            $cityNameJsonData['cityNameVal'] = $cityNameJsonData['cityNameVal'] . "[{name:'" . $nation . "'},{name:'" . $k . "',value:" . $value . "}],";
            $cityNameJsonData['cityName'] = $cityNameJsonData['cityName'] . "{name:'" . $k . "',value:" . $value . "},";
        }
        $cityNameJsonData['cityNameVal'] = "[" . rtrim($cityNameJsonData['cityNameVal'], ',') . "]";
        $cityNameJsonData['cityName'] = "[" . rtrim($cityNameJsonData['cityName'], ',') . "]";
        //halt($cityNameJsonData);
        return $cityNameJsonData;
    }

    /*ceshi*/
    public function test()
    {

        $county_name = '柞水县';
        $dataCity = db('countys')->where('county_name', $county_name)->field('county_id,pid')->find();

        $this->get_addr($dataCity['county_id']);
        /*产品分类*/
        $typesdatas = $this->get_protype();
        /*获得水果类*/
        $protype_name = "板栗";
        $typesdata = db('protypes')->where('protype_name', $protype_name)->field('protype_id,protype_pid')->find();
        $prodatas = db('protypes')->where('protype_pid', $typesdata['protype_pid'])->select();
        //halt($prodata);
        $this->assign('prodatas', $prodatas);
        $this->assign('typesdata', $typesdata);
        $this->assign('dataCity', $dataCity);
        /**
         * 第一个折线图
         * @var [type]
         */
        $this->assign('arrdata', $typesdatas);
        //halt($typesdatas);
        $monthData = $this->getMonth();
        $this->assign('monthdata', $monthData);
        return $this->fetch();
        return $this->fetch();
    }
}
