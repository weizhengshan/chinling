<?php
namespace app\weixin\controller;

//use think\Controller;  
class Urldata  extends Common
{
    //模拟登录 

	function login_post($url, $cookie, $post) { 

	    $curl = curl_init();//初始化curl模块 

	    curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 

	    curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息 

	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息 

	    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 

	    curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 

	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息 

	    curl_exec($curl);//执行cURL 

	    curl_close($curl);//关闭cURL资源，并且释放系统资源 

	} 
	//登录成功后获取数据 

	function get_content($url, $cookie) { 

	    $ch = curl_init(); 

	    curl_setopt($ch, CURLOPT_URL, $url); 

	    curl_setopt($ch, CURLOPT_HEADER, 0); 

	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie 

	    $rs = curl_exec($ch); //执行cURL抓取页面内容 

	    curl_close($ch); 

	    return $rs; 

	} 
  public function index(){	
	//设置post的数据 

		$post = array ( 

		    'email' => 'oschina账户', 

		    'pwd' => 'oschina密码', 

		    'goto_page' => '/my', 

		    'error_page' => '/login', 

		    'save_login' => '1', 

		    'submit' => '现在登录' 

		); 

		//登录地址 

		$url = "http://jb51.net/action/user/login"; 

		//设置cookie保存路径 

		$cookie = dirname(__FILE__) . '/cookie_jb51.txt'; 

		//登录后要获取信息的地址 

		$url2 = "http://jb51.net/my"; 

		//模拟登录 

		$this->login_post($url, $cookie, $post); 

		//获取登录页的信息 

		$content = get_content($url2, $cookie); 

		//删除cookie文件 

		@ unlink($cookie); 

		//匹配页面信息 

		$preg = "/<td class='portrait'>(.*)<\/td>/i"; 

		preg_match_all($preg, $content, $arr); 

		$str = $arr[1][0]; 

		//输出内容 

		echo $str; 
	}
		
	//测试
	public function indexx()
	{	/*
			$url = "http://www.pc100.net";
		$contents = file_get_contents($url);
		//如果出现中文乱码使用下面代码
		//$getcontent = iconv("gb2312", "utf-8",$contents);
		echo $contents; */
		$url = "http://hangqing.ymt.com/chandi_8205_0_0";
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
		$img = curl_exec($ch);
		halt($img);	
	}
		function getHTTPS() {
	  $url = "https://sycm.taobao.com/ipoll/live/rest.jsonp?appId=sycm&userId=3431116057&topic=tb_user_day_flow&_time=1513740871366&callback=jsonp_1513740871366_8685780239893237";		
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	  curl_setopt($ch, CURLOPT_HEADER, false);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_REFERER, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	  $result = curl_exec($ch);
	  curl_close($ch);
	  halt($result);
	}
	public function  getweather()
	{
		$durl="http://www.sojson.com/tianqi/api/1011-58414.shtml";	
		$ch = curl_init();  
	    curl_setopt($ch, CURLOPT_URL, $durl);  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回    
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回    
	    $r = curl_exec($ch);  
	    curl_close($ch);  
	    halt($r);  
	}
	public function taobaoapi()
	{
		$c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new TradesSoldGetRequest;
		$req->setFields("tid,type,status,payment,orders,rx_audit_status");
		$req->setStartCreated("2000-01-01 00:00:00");
		$req->setEndCreated("2000-01-01 23:59:59");
		$req->setStatus("ALL_WAIT_PAY");
		$req->setBuyerNick("zhangsan");
		$req->setType("game_equipment");
		$req->setExtType("service");
		$req->setRateStatus("RATE_UNBUYER");
		$req->setTag("time_card");
		$req->setPageNo("1");
		$req->setPageSize("40");
		$req->setUseHasNext("true");
		$resp = $c->execute($req, $sessionKey);
	}
	function news_detail() {
		
		//https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN    
                    
		//$code=$_GET['code'];
            		//var_dump($code);
		//$res=$this->getOpenid($code);
		//var_dump($res);
		//$isFollow=$this->isFollow($res);
		//var_dump($isFollow);
		$id=1;
	 	if($id=1)
		{
			$this->redirect('Wap/share_friend',, array('id' => 190,'openid'=>1));
		}
		
		$map ['id'] = I ( 'id' );
		$info = M ( 'material_news' )->where ( $map )->find ();
		$this->assign ( 'info', $info );
		//var_dump($info);
		$this->display ();
	}
           /*让用户去转发朋友圈*/
    function  share_friend()
	{	
		include_once 'sphinx/sphinxapi.php';
		 $jssdk = new \JSSDK("yourAppID", "yourAppSecret");
		 $signPackage = $jssdk->GetSignPackage();
     	 $this->assign('signPackage',$signPackage);
	     $this->display();		
	}
    function ajaxMessage($openid)
    {
            $toUsername ='gh_99d467b23866';
            $content = "啦啦啦德玛西亚";
            $res=$this->_response_text($openid,$toUsername,$content);
            
           echo  json_encode($res);
    }
    function _response_text($openid,$toUsername,$content)
    {
	    $textTpl = "<xml>
	                <ToUserName><![CDATA[%s]]></ToUserName>
	                <FromUserName><![CDATA[%s]]></FromUserName>
	                <CreateTime>%s</CreateTime>
	                <MsgType><![CDATA[text]]></MsgType>
	                <Content><![CDATA[%s]]></Content>
	                <FuncFlag>%d</FuncFlag>
	                </xml>";
	    $resultStr = sprintf($textTpl, $openid, $toUsername, time(), $content, $flag);
	    return $resultStr;
	}
	function _reply_customer($touser,$content){
    
    //更换成自己的APPID和APPSECRET
    $APPID="wx49cfc16a07e40442";
    $APPSECRET="902657db3b77b41da662c396ef85d7b8";

    
    $TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;
    
    $json=file_get_contents($TOKEN_URL);
    $result=json_decode($json);
    
    $ACC_TOKEN=$result->access_token;
    
    $data = '{
        "touser":"'.$touser.'",
        "msgtype":"text",
        "text":
        {
             "content":"'.$content.'"
        }
    }';
    
    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$ACC_TOKEN;
    
    $result = $this->https_post($url,$data);
    $final = json_decode($result);
    return $final;
}

	function https_post($url,$data)
	{
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url); 
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($curl);
	    if (curl_errno($curl)) {
	       return 'Errno'.curl_error($curl);
	    }
	    curl_close($curl);
	    return $result;
	}

}
