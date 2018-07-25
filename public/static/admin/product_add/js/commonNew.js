 	var Url="http://wechat.chinlingcloud.com/index.php/api/v2/"
    var storage = window.localStorage;
    var storageSe = window.sessionStorage;

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg); //匹配目标参数
        if (r != null) return decodeURI(r[2]);
        return null; //返回参数值
    }
    //将时间戳转化为时间格式
    function timestampToTime(timestamp) {
    	if( timestamp.toString().length==10){
    		var date = new Date(timestamp*1000);
    	}else{
    		var date = new Date(timestamp);
    	}
        //时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D;
    }


    function taostr(str, timer) {
        var htmlStr = '<div id="taostr" style="width:240px;height:32px;position: fixed;left: 0;right:0;top: 0;bottom:0;margin:auto;z-index: 100000000000;">'
            + '<div style="width:200px;min-height:32px;text-align:center;padding:20px;line-height: 32px;font-size: 16px;background: rgba(0,0,0,0.6);color: #EEEEEE;border-radius: 5px;">' + str + '</div>'
            + '</div>'
        $("body").append(htmlStr);
        window.setTimeout(function () {
            $("#taostr").remove()
        }, timer);
    }

    function addChose() {
        
    }



function CurentTime()
    { 
        var now = new Date();
       
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
       
        //var hh = now.getHours();            //时
        //var mm = now.getMinutes();          //分
       
        var clock = year + "-";
       
        if(month < 10)
            clock += "0";
       
        clock += month + "-";
       
        if(day < 10)
            clock += "0";
           
        clock += day + " ";
       
//      if(hh < 10)
//          clock += "0";
//         
//      clock += hh + ":";
//      if (mm < 10) clock += '0'; 
//      clock += mm; 
        return(clock); 
    } 

