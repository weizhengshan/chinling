$(function () {
   
$("#start_go").on("click",function(){
		$("#out").css("display","none")
		$("#in").css("display","block")
	})
$("#cancellation").on("click",function(){
		$("#out").css("display","block");
		$("#in").css("display","none");
		location.reload();
	})
   startTime();
   $("#start_go").css("opacity","1");
})
var  domainName= 'http://www.chinlingcloud.com';
var Url="http://wechat.chinlingcloud.com/index.php/api/v2/"
function startTime()//显示日期的函数 
  { 
    var today=new Date();//创建日期时间对象 
    var n=today.getFullYear();//获取当前时间的年份 
    var m=today.getMonth();//获取当前时间的月份 
    var d=today.getDate();//获取当前时间的日期 
    var h=today.getHours();//获取当前时间的小时 
    var f=today.getMinutes();//获取当前时间的分钟 
    var s=today.getSeconds();//获取当前时间的秒钟 
    var weekday=new Array(7);//创建星期数组 
    var w=today.getDay();
    weekday[0]="星期日"; 
    weekday[1]="星期一"; 
    weekday[2]="星期二"; 
    weekday[3]="星期三"; 
    weekday[4]="星期四"; 
    weekday[5]="星期五"; 
    weekday[6]="星期六"; 
    f=checkTime(f); 
    s=checkTime(s); 
    $("#timer").text(weekday[w]+" "+n+"-"+(m+1)+"-"+checkTime(d)+"     "+h+":"+f+":"+s);        
    t=setTimeout('startTime()',500); 
  } 
  function checkTime(i)//日期校验函数 
  { 
    if (i<10)  
   { 
     return i="0" + i; 
    } 
    else 
    { 
     return i; 
    } 
  }   
  
    function taostr(str, timer) {
        var htmlStr = '<div id="taostr" style="width:100px;height:50px;position: fixed;left: 0;right:0;top: 0;bottom:0;margin:auto;z-index: 100000000000;">'
            + '<div style="width:100px;min-height:50px;text-align:center;padding:20px;line-height: 50px;font-size: 24px;background: rgba(0,0,0,0.6);color: #EEEEEE;border-radius: 5px;">' + str + '</div>'
            + '</div>'
        $("body").append(htmlStr);
        window.setTimeout(function () {
            $("#taostr").remove()
        }, timer);
    }