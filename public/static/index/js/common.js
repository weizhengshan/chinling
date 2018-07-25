$(function () {
    $(".header_nav_hide").click(function(e){
    	if($(this).text()=="＝"){
    		$(this).text("×");
    		$(".header_nav").show()
    		return;
    	}else{
    		$(this).text("＝");
    		$(".header_nav").hide()
    	}   	
    })
    $(".weixin").click(function(e){
		$(".bg-marker").css("display","block")
		$(".weixin-layout").css("display","block")
		$(".weixin_erweima").css("display","block")
    	$(".weibo_erweima").css("display","none")
    	$(".qidai").css("display","none")
    })
    $(".weixin-back").click(function(e){
    	$(".bg-marker").css("display","none") 
    	$(".weixin-layout").css("display","none")
    })
    $(".no").click(function(e){
    	$(".bg-marker").css("display","block")
		$(".qidai").css("display","block")
    })
    var _height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))
    if(navigator.userAgent.match(/mobile/i)) {  
        
   		$(".nolist").css("min-height",_height+60+"px")
   		$("#main_newslist").css("min-height",_height+60+"px")
    }else{
    	$(".nolist").css("min-height",_height+60+"px")
    	$("#main_newslist").css("min-height",_height+60+"px")
    }
})
function pageScroll(){ 
	//把内容滚动指定的像素数（第一个参数是向右滚动的像素数，第二个参数是向下滚动的像素数） 
	window.scrollBy(0,-100); 
	//延时递归调用，模拟滚动向上效果 
	scrolldelay = setTimeout('pageScroll()',0); 
	//获取scrollTop值，声明了DTD的标准网页取document.documentElement.scrollTop，否则取document.body.scrollTop；因为二者只有一个会生效，另一个就恒为0，所以取和值可以得到网页的真正的scrollTop值 
	var sTop=document.documentElement.scrollTop+document.body.scrollTop; 
	//判断当页面到达顶部，取消延时代码（否则页面滚动到顶部会无法再向下正常浏览页面） 
	if(sTop==0) clearTimeout(scrolldelay); 
	}