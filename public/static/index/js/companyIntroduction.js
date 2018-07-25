$(function () {
   /*$("#nav ul li").on("click",function(){
   	$(this).addClass("on").siblings().removeClass("on");
   	var _type=$(this).attr("_type")
   if(_type==1){
   	$(".main_1").css("display","block");
   	$(".main_2").css("display","none");
   	$(".main_3").css("display","none");
   	$(".main_4").css("display","none");
   }else if(_type==2){
   	$(".main_1").css("display","none");
   	$(".main_2").css("display","block");
   	$(".main_3").css("display","none");
   	$(".main_4").css("display","none");
   }else if(_type==3){
   	$(".main_1").css("display","none");
   	$(".main_2").css("display","none");
   	$(".main_3").css("display","block");
   	$(".main_4").css("display","none");
   }else if(_type==4){
   	$(".main_1").css("display","none");
   	$(".main_2").css("display","none");
   	$(".main_3").css("display","none");
   	$(".main_4").css("display","block");
   }
   })*/
    var _height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))
    if(navigator.userAgent.match(/mobile/i)) {  
        $("#main_newsdetails").css("min-height",_height+60+"px")
   		
   		$(".nolist").css("min-height",_height+60+"px")
    }else{
    	 $("#main_newsdetails").css("min-height",_height+"px")
    	 $(".nolist").css("min-height",_height+60+"px")
    }
  
  
    
})