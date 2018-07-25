$(function () {
   var _height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))
    if(navigator.userAgent.match(/mobile/i)) {  
        $("#main_newsdetails").css("min-height",_height+60+"px")
   		$(".news_main > img").css("width","100%");
   		
    }else{
    	$("#main_newsdetails").css("min-height",_height+"px")
    }
})