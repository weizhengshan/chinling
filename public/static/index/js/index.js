$(function () {
	
	if(navigator.userAgent.match(/mobile/i)) {    
   		$("#lunbo_pc").addClass("lunbo_app_or_pc_hidden").removeClass("lunbo_app_or_pc_show");
   		$("#lunbo_app").removeClass("lunbo_app_or_pc_hidden").addClass("lunbo_app_or_pc_show");
    }else{
    	$("#lunbo_pc").removeClass("lunbo_app_or_pc_hidden").addClass("lunbo_app_or_pc_show");
   		$("#lunbo_app").addClass("lunbo_app_or_pc_hidden").removeClass("lunbo_app_or_pc_show");	
    }
   var mySwiper=new Swiper('#lunbo_pc', {
   		effect : 'fade',
        loop:'true',
        pagination : '.swiper-pagination',
		paginationClickable :true,
        autoplay:2000,
        onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
            swiperAnimateCache(swiper); //隐藏动画元素
            swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeEnd: function(swiper){
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
        }
    })
   $("#lunbo_pc").mouseover(function () {
            mySwiper.stopAutoplay();
        }).mouseout(function () {
            mySwiper.startAutoplay();
    })  
       var mySwiper=new Swiper('#lunbo_app', {
   		effect : 'fade',
        loop:'true',
        pagination : '.swiper-pagination',
		paginationClickable :true,
        autoplay:2000,
        onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
            swiperAnimateCache(swiper); //隐藏动画元素
            swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeEnd: function(swiper){
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
        }
    })
   $("#lunbo_app").mouseover(function () {
            mySwiper.stopAutoplay();
        }).mouseout(function () {
            mySwiper.startAutoplay();
    }) 
    
})