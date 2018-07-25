$(function () {
   
    var swiper = new Swiper('.swiper-container', {
    	direction : 'vertical',
        slideToClickedSlide:true,
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflow: {
            rotate: -30,
            stretch: 0,
            depth: 200,
            modifier: 1,
            slideShadows : false
        }
    });
    
    
})