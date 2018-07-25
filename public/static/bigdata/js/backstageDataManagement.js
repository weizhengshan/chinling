$("#nav").on("click",".nav_span",function(){
	var _attr=$(this).attr("_attr");
	if(_attr==0){
		$(".nav_span").removeClass("kai");
		$(".nav_span").attr("_attr","0");
		$(".nav_span").next().slideUp();
		$(this).addClass("kai");
		$(this).next().slideDown();
		$(this).attr("_attr","1");
	}else{
		$(this).removeClass("kai");
		$(this).next().slideUp();
		$(this).attr("_attr","0");
	}
})
$("#nav").on("click",".nav_span_1",function(){
	var _attr=$(this).attr("_attr")
	if(_attr==0){
		$(".nav_span_1").removeClass("kai");
		$(".nav_span_1").attr("_attr","0");
		$(".nav_span_1").next().slideUp();
		$(this).addClass("kai")
		$(this).next().slideDown();
		$(this).attr("_attr","1")
	}else{
		$(this).removeClass("kai");
		$(this).next().slideUp();
		$(this).attr("_attr","0")
	}
})
$("#nav").on("click",".switch",function(){
	var _id=$(this).attr("_id");
	var _attr=$(this).attr("_attr");
		var _name=$(this).attr("_name");
		var _son_name=$(this).attr("_son_name");
		$(".float_r_li").find("h5").find("span").text("--"+_name+"/"+_son_name);
		$(".float_r_li").find("a").attr("platform_id",_attr);
	$(".switch").removeClass("onA");
	$(this).addClass("onA")
	if(_id==0){
		$(".float_r_li").slideUp();
		$(".main_0").slideDown()
	}else if(_id==1){
		$(".float_r_li").slideUp();
		$(".main_1").slideDown()
	}else if(_id==2){
		
		$(".float_r_li").slideUp();
		$(".main_2").slideDown();
	}else if(_id==3){
		
		$(".float_r_li").slideUp();
		$(".main_3").slideDown();
	}
})
$("#nav").on("change",".input_file",function(){
    $(this).prev("input").val($(this).val())
})

$("#nav").on("click",".add",function(){
	getSelectData();
	$(this).hide();
	$(this).next().show();
	$(".data_type").slideDown();
	$(".tableBasic").slideUp();
})
$("#nav").on("click",".goBack",function(){
	$(this).hide();
	$(this).prev().show();
	$(".data_type").slideUp();
	$(".tableBasic").slideDown();
})
$("#nav").on("click",".submit",function(){
	var name=$(this).parents("table").find(".name").val()
	if(name==""){
		taostr("请填写名称",1000);
		return;
	}
	var describe=$(this).parents("table").find(".describe").val()
	var hidden=$(this).parents("table").find(".hidden").val()
	var sort=$(this).parents("table").find(".sort").val()
	var pid=$(this).parents("table").find("#classification option:selected").val()
	
	if(sort==""){
		taostr("请填写序号",1000);
		return;
	}
	var data={};
	data['platform_name']=name;
	data['platform_dec']=describe;
	data['sort']=sort;
	data['pid']=pid;
	if(hidden!=""){
		data['platform_id']=hidden;
	}
	addPlatformData(data)
	
})
//修改
$("#nav").on("click",".operation",function(){
	var id=$(this).attr("_id")
	getSelectNoOwn(id)
	modifyPlatformData(id)
	$(".main_0").find(".add").hide()
    $(".main_0").find(".goBack").show()
	$(".data_type").slideDown()
	$(".tableBasic").slideUp()
})
$("#nav").on("click",".first_span",function(){
	var that=this;
	var _attr=$(this).attr("_attr")
	var _id=parseInt($(this).attr("_id"))
	var platform_id=parseInt($(this).attr("platform_id"))
	if(_attr==0){
		$(this).addClass("first_span_on")
		$(this).attr("_attr","1")
		getSecondaryData(that,platform_id)
	}else{
		$(this).removeClass("first_span_on")
		$(this).attr("_attr","0")
		$(this).parent().next().children().html("")
	}
	
})
$("#nav").on("click",".undercarriage",function(){
	var that = this;
	var _id=parseInt($(this).attr("_id"))
	delPlatformData(that,_id)
})


getPlatformData()
//添加、更新
function addPlatformData(data)
{
   $.ajax({
    url:Url+'Platform/postData',
    type:"post",
    data:data,
    dataType:"JSON",    
     success:function(res){
        console.log(res)
      if(res.valid==4){
      	taostr(res.msg,1000)
      	getPlatformData()
      	$(".main_0").find(".add").show()
      	$(".main_0").find(".goBack").hide()
      	$(".data_type").slideUp()
		$(".tableBasic").slideDown()	
		//清除input数据
		$(".main_0").find(".name").val("")
		$(".main_0").find(".describe").val("")
		$(".main_0").find(".sort").val("")  
		$(".main_0").find(".hidden").val("")  
      }else
      {
      	taostr(res.msg,1000)
      }
    }
  });  
 } 
 function delPlatformData(that,id)
{
   $.ajax({
    url:Url+'Platform/softDeletions/'+id,
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res)
      if(res.valid==4){
      	taostr(res.msg,1000)
      	$(that).parent().parent().remove()
      	$(that).parent().parent().next().remove()
      }else if(res.valid==1){
      	taostr(res.msg,1000)
      }
    }
  });  
 } 
 //次级数据
 function getSecondaryData(that,id)
{
   $.ajax({
    url:Url+'Platform/getSonData/'+id,
    type:"get",
    dataType:"JSON",    
     success:function(res){
       console.log(res)
      var _id=parseInt($(that).attr("_id"))
      var str='';
      for(var i=0;i<res.length;i++){
      	str+='<div>'
				+'<span class="first_span" _attr="0" _id="'+(_id+1)+'" platform_id="'+res[i].platform_id+'" style="background-position: '+(5+_id*20)+'px 20px;padding-left: '+(20+_id*20)+'px;">'+res[i].platform_name+'</span>'
				+'<span>'+(i+1)+'</span>'
				+'<span>'+res[i].platform_dec+'</span>'
				+'<span>'+res[i].sort+'</span>'
				+'<span><a class="operation" _id="'+res[i].platform_id+'">修改</a>|<a class="undercarriage"  _id="'+res[i].platform_id+'">下架</a></span>'
			+'</div>'
			+'<ol class="ol">'
				+'<li>'
						
				+'</li>'									
			+'</ol>';		
      }
      $(that).parent().next().children().html(str)
    }
  });  
 }
//修改分类下拉框
function getSelectNoOwn(id)
{
   $.ajax({
    url:Url+'Platform/getSelectNoOwn/'+id,
    type:"get",
    dataType:"JSON",   
    async:false,
     success:function(res){
        console.log(res)
      	var str = '<option value="1">顶级分类</option>';
        for(var i=0;i<res.length;i++){
        	str+='<option value="'+res[i].platform_id+'">'+res[i].platform_name+'</option>'
        }
        $("#classification").html(str)
    },
    error:function(res){
    	var str = '<option value="1">顶级分类</option>';
        $("#classification").html(str)
    	console.log(res)
    }
  });  
}
//添加分类下拉框
 function getSelectData()
{
   $.ajax({
    url:Url+'Platform/SelectData',
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res)
      	var str = '<option value="1">顶级分类</option>';
        for(var i=0;i<res.length;i++){
        	str+='<option value="'+res[i].platform_id+'">'+res[i].platform_name+'</option>'
        }
        $("#classification").html(str)
    },
    error:function(res){
    	var str = '<option value="1">顶级分类</option>';
        $("#classification").html(str)
    	console.log(res)
    }
  });  
}
//修改赋值
function modifyPlatformData(id)
{
   $.ajax({
    url:Url+'Platform/getDetails/'+id,
    type:"get",
    dataType:"JSON",  
    async:false,
 	success:function(res){
 		
	$(".main_0").find(".name").val(res.platform_name)
	$(".main_0").find(".describe").val(res.platform_dec)
	$(".main_0").find(".sort").val(res.sort)  
	$(".main_0").find(".hidden").val(res.platform_id)  
     
	for(var i=0;i<$("option").length;i++){
		if(res.pid==$("option").eq(i).val()){
			$("#classification").val($("option").eq(i).val())
		}
	}
}
  });  
 } 
 //数据上传导航
 getPlatformNavData()
  function getPlatformNavData()
{
   $.ajax({
    url:Url+'Platform/getUploadList',
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res)
        var str='';
       for(var i=0;i<res.length;i++){
       	if(res[i].platform_name.indexOf("淘宝")>-1){
       		var str1=''
       	   if(res[i].son.length==0){
       	   		str1='<li class="switch" _id="2" _attr="'+res[i].platform_id+'" _name="'+res[i].platform_name+'" _son_name="'+res[i].platform_name+'">'+res[i].platform_name+'</li>'
       	   }else{
       	   	 	for(var j=0;j<res[i].son.length;j++){
	       	   	 str1+='<li class="switch" _id="2" _attr="'+res[i].son[j].platform_id+'"  _name="'+res[i].platform_name+'" _son_name="'+res[i].son[j].platform_name+'">'+res[i].son[j].platform_name+'</li>'
	       	   	}
       	   }
       	  
       	}else if(res[i].platform_name.indexOf("拼多多")>-1){
       		var str1=''
       	   if(res[i].son.length==0){
       	   		str1='<li class="switch" _id="3" _attr="'+res[i].platform_id+'" _name="'+res[i].platform_name+'" _son_name="'+res[i].platform_name+'">'+res[i].platform_name+'</li>'
       	   }else{
       	   	 	for(var j=0;j<res[i].son.length;j++){
	       	   	 str1+='<li class="switch" _id="3" _attr="'+res[i].son[j].platform_id+'"  _name="'+res[i].platform_name+'" _son_name="'+res[i].son[j].platform_name+'">'+res[i].son[j].platform_name+'</li>'
	       	   	}
       	   }
       	}else{
       		var str1=''
       	   if(res[i].son.length==0){
       	   		str1='<li class="switch" _id="1" _attr="'+res[i].platform_id+'" _name="'+res[i].platform_name+'" _son_name="'+res[i].platform_name+'">'+res[i].platform_name+'</li>'
       	   }else{
       	   	 	for(var j=0;j<res[i].son.length;j++){
	       	   	 str1+='<li class="switch" _id="1" _attr="'+res[i].son[j].platform_id+'"  _name="'+res[i].platform_name+'" _son_name="'+res[i].son[j].platform_name+'">'+res[i].son[j].platform_name+'</li>'
	       	   	}
       	   }
       	}
       		
       		str+='<li><span class="nav_span_1" _attr="0">'+res[i].platform_name+'</span>'
							+'<ol  style="display: none;">'
										+str1		
							+'</ol>'
						+'</li>'				
       }
       $(".platform_data").append(str)
    }
  });  
  } 
function getPlatformData()
{
   $.ajax({
    url:Url+'Platform/getList',
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res)
        var str = '';
        for(var i=0;i<res.length;i++){
        	str+='<li>'
					+'<div>'
						+'<span class="first_span" _attr="0" _id="1" platform_id="'+res[i].platform_id+'" style="background-position: 5px 20px;padding-left: 20px;">'+res[i].platform_name+'</span>'
						+'<span>'+(i+1)+'</span>'
						+'<span>'+res[i].platform_dec+'</span>'
						+'<span>'+res[i].sort+'</span>'
						+'<span><a class="operation" _id="'+res[i].platform_id+'">修改</a>|<a class="undercarriage"  _id="'+res[i].platform_id+'">下架</a></span>'
					+'</div>'
					+'<ol class="ol">'
						+'<li>'
								
						+'</li>'									
					+'</ol>'								
				+'</li>'
        }
        $(".platformList").html(str)
    }
  });  
  } 