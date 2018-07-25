$(function () {
   var _height=parseInt($(window).height())-parseInt($("#header").css("height"))-parseInt($("#footer").css("height"))
   
    if(navigator.userAgent.match(/mobile/i)) {  
        $("#main").css("min-height",_height+60+"px")	   		  
    }else{
    	$("#main").css("min-height",_height+"px")
    }
  onlyD();
  $('#js-msg').html('');
  //表单提交
  $('.js-msf-sbt').click(function () {
    var $theme = $(".js-theme");
    var $name = $(".js-name");
    var $phone = $(".js-phone");
    var $email = $(".js-email");
    var $address = $(".js-address");
    var $message = $(".js-message");
   /* if ($theme.val()=="") {
      $theme.next('em').html('主题不能为空！');
      return false
    }else {
      $theme.next('em').html('')
    }*/
   /* if ($name.val()=="") {
      $name.next('em').html('姓名不能为空！');
      return false
    }else {
      $name.next('em').html('')
    }*/
   /* if (!/^1(3|5|7|8)\d\d\d\d\d\d\d\d\d$/.test($phone.val())) {
      // console.log('手机号码不正确！');
      $phone.next('em').html('手机号码不正确！');
      return false
    }else {
      $phone.next('em').html('')
    }*/
    if (!/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test($email.val())) {
      // console.log('手机号码不正确！');
      $email.next('em').html('邮箱不正确！');
      return false
    }else {
      $email.next('em').html('')
    }
    /*if ($address.val()=="") {
      $address.next('em').html('地址不能为空！');
      return false
    }else {
      $address.next('em').html('')
    }*/
    if ($message.val()=="") {
     $message.next('em').html('留言内容不能为空！');
      return false
    }else {
      $message.next('em').html('')
    }
    var formData = $('#js-msg-form').serialize();
    //表单提交
    var res=ajax_re(formData);
  // 表单重置
  
// 限制电话号码只能输数字


})
  $('.js-msf-reset').on('click',function () {
      
      document.getElementById("js-msg-form").reset()
  })

  })
function onlyD() {
var phone = document.getElementById('phone')
phone.onfocus = phone.onblur = phone.onkeyup = function(){
      this.value = this.value.replace(/\D/g, '');
}
}
