$(function () {
   /*$("#nav ul li").on("click",function(){
   	$(this).addClass("on").siblings().removeClass("on");
   	var _type=$(this).attr("_type")
   if(_type==1){
   	$(".main_1").css("display","block");
   	$(".main_2").css("display","none");
   	$(".main_3").css("display","none");

   }else if(_type==2){
   	$(".main_1").css("display","none");
   	$(".main_2").css("display","block");
   	$(".main_3").css("display","none");
   	
   }else if(_type==3){
   	$(".main_1").css("display","none");
   	$(".main_2").css("display","none");
   	$(".main_3").css("display","block");
   	$(".main_4").css("display","none");
   }
   })*/
   var _height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))
    if(navigator.userAgent.match(/mobile/i)) {  
        $("#main").css("min-height",_height+60+"px")
   		$(".nolist").css("min-height",_height+60+"px")
    }else{
    	 $("#main").css("min-height",_height+"px")
  		 $(".nolist").css("min-height",_height+"px")
    }
    var __height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))-parseInt($("#nav_newslist").css("height"))-parseInt($(".recruitment_title").css("height"))
    //console.log(__height)
  	$(".recruitment_content ul").css("min-height",__height)
  	
  	
   $(".cli_show_hide").on("click",function(){

    var _src=$(this).children("img").attr("class")
    var _id=$(this).attr("_id")

    if(_src=="kai"){     
        

      $(this).children("img").attr("src","/static/index/img/f6.png")
      $(this).children("img").attr("class","guan")
      $(this).parent().next(".cli_show_hide_zhi").css("display","block")
      var res=ajax_re(_id);
      /**
       * 判断old和new 是相等
       */
    }else{ 
       $(this).children("img").attr("class","kai")
      $(this).children("img").attr("src","/static/index/img/f5.png")
      $(this).parent().next().css("display","none")
    }  
   })
  
   
})

