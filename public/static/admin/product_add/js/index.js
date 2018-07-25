
$("#nav").on("click",".add",function(){
	getSelectData();
	$(this).hide();
	$(this).next().show();
	$(".main_3").slideDown();
	$(".main_0").slideUp();
	$(".main_2").slideUp();
	$(".main_1").slideUp();
})
$("#nav").on("click",".goBack",function(){
	$(this).hide();
	$(this).prev().show();
	$(".main_3").slideUp();
	$(".main_0").slideDown();
	$(".main_2").slideUp();
	$(".main_1").slideUp();
})
$("#nav").on("click",".secondary",function(){
	var id=$(this).attr("platform_id")
	var name=$(this).text()
	var text=$(this).text()
	$("#hideBox").attr("_id",id)
	$("#hideBox").attr("_name",name)
	$(".productName").text(text)
	$("#hideBox").show();
	getWeekDataData(id)
});
$("#hideBox").on("click",".closeA",function(){
	$("#hideBox").hide();
});
$("#nav").on("click",".submit",function(){
	var name=$(this).parents("table").find(".name").val();
	if(name==""){
		taostr("请填写名称",1000);
		return;
	}
	var describe=$(this).parents("table").find(".describe").val();
	var hidden=$(this).parents("table").find(".hidden").val();
	var sort=$(this).parents("table").find(".sort").val();
	var pid=$(this).parents("table").find("#classification option:selected").val();
	var address=$(this).parents("table").find(".area_select").val();
	var addressDetailed=$(this).parents("table").find(".detail").val();
	if(sort==""){
		taostr("请填写序号",1000);
		return;
	}
	var data={};
	data['record_name']=name;
	data['record_dec']=describe;
	data['sort']=sort;
	data['pid']=pid;
	data['addr']=address;
	data['addr_detail']=addressDetailed;
	if(hidden!=""){
		data['record_id']=hidden;
	}
	addPlatformData(data)
	
})
//修改
$("#nav").on("click",".operation",function(){
	var id=$(this).attr("_id");
	getSelectNoOwn(id);
	modifyPlatformData(id);
	$(".add").hide();
    $(".goBack").show();
	$(".main_3").slideDown();
	$(".main_0").slideUp();
	$(".main_2").slideUp();
	$(".main_1").slideUp();
})
$("#nav").on("click",".first_span",function(){
	var that=this;
	var _attr=$(this).attr("_attr");
	var _id=parseInt($(this).attr("_id"));
	var platform_id=parseInt($(this).attr("platform_id"));
	if(_attr==0){
		$(this).addClass("first_span_on");
		$(this).attr("_attr","1");
		getSecondaryData(that,platform_id);
	}else{
		$(this).removeClass("first_span_on");
		$(this).attr("_attr","0");
		$(this).parent().next().children().html("");
	}
	
});

$(".input_file").on("change",function () {
	$(this).prev(".input_file_name").val($(this).val());
})
$(".searchProcess").click(function () {
        var monthData=$(this).attr("_id");
        var _id=$(".btnBox").attr("_id")
        $(this).addClass("btnOn").siblings().removeClass("btnOn")
        getCharData(_id,monthData);
 })



$("#nav").on("click",".submits",function(){
	var wholesale=$(this).parents("table").find(".wholesale").val();
	if(wholesale==""){
		taostr("请填写批发价格",1000);
		return;
	}	
	var retail=$(this).parents("table").find(".retail").val();
	if(retail==""){
		taostr("请填写零售价格",1000);
		return;
	}
	var str = $('#flatpickr-tryme').val(); // 日期字符串
	str = str.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(str); // 构造一个日期型数据，值为传入的字符串
	var time = date.getTime();
	var record_id=$(".price").attr("record_id")
	var _id=$(".price").attr("_id")
	var data={};
	data['wholesale']=wholesale;
	data['retail']=retail;
	data['specified_time']=time/1000;
	data['record_id']=record_id;
	if(_id){
		data['dprice_id']=_id;
	}
	console.log(data)
	addTimeData(data)
	
})
$("#nav").on("click",".area_select",function(){
	$("#addressChose").show();
})


getPlatformData();
//添加、更新
function addPlatformData(data)
{
   $.ajax({
    url:Url+'RecordType/postData',
    type:"post",
    data:data,
    dataType:"JSON",    
     success:function(res){
        console.log(res);
      if( res.valid == 4 ){
      	taostr(res.msg,1000);
      	getPlatformData();
      	$(".add").show();
      	$(".goBack").hide();
      	$(".main_0").slideDown();
		$(".main_1").slideUp();
		$(".main_2").slideUp();
		$(".main_3").slideUp();
		//清除input数据
		$(".main_3").find(".name").val("");
		$(".main_3").find(".describe").val("");
		$(".main_3").find(".sort").val("");
		$(".main_3").find(".area_select").val("");
		$(".main_3").find(".detail").val("");
		$(".main_3").find(".hidden").val("");
      }else
      {
      	taostr(res.msg,1000);
      }
    }
  });  
 } 

 //次级数据
 function getSecondaryData(that,id)
{
   $.ajax({
    url:Url+'RecordType/getSonData/'+id,
    type:"get",
    dataType:"JSON",    
     success:function(res){
       console.log(res);
      var _id=parseInt($(that).attr("_id"));
      var str='';
      for(var i=0;i<res.length;i++){
      	str+='<div>'+
				'<span class="first_span secondary" _attr="0" _id="'+(_id+1)+'" platform_id="'+res[i].record_id+'" style="background-position: '+(5+_id*20)+'px 20px;padding-left: '+(20+_id*20)+'px;">'+res[i].record_name+'</span>'+
				'<span>'+(i+1)+'</span>'+
				'<span>'+res[i].record_dec+'</span>'+
				'<span>'+res[i].sort+'</span>'+
				'<span><a class="operation" _id="'+res[i].record_id+'">修改</a>|<a class="undercarriage"  _id="'+res[i].record_id+'">下架</a></span>'+
			'</div>'+
			'<ol class="ol">'+
				'<li>'+
				'</li>'+
			'</ol>';
      }
      $(that).parent().next().children().html(str);
    }
  });  
 }
//修改分类下拉框
function getSelectNoOwn(id)
{
   $.ajax({
    url:Url+'RecordType/getSelectNoOwn/'+id,
    type:"get",
    dataType:"JSON",   
    async:false,
     success:function(res){
        console.log(res);
      	var str = '<option value="1">顶级分类</option>';
        for(var i=0;i<res.length;i++){
        	str+='<option value="'+res[i].record_id+'">'+res[i].record_name+'</option>';
        }
        $("#classification").html(str);
    },
    error:function(res){
    	var str = '<option value="1">顶级分类</option>';
        $("#classification").html(str);
    	console.log(res);
    }
  });  
}
//添加分类下拉框
function getSelectData()
{
   $.ajax({
    url:Url+'RecordType/SelectData',
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res);
      	var str = '<option value="1">顶级分类</option>';
        for(var i=0;i<res.length;i++){
        	str+='<option value="'+res[i].record_id+'">'+res[i].record_name+'</option>';
        }
        $("#classification").html(str);
    },
    error:function(res){
    	var str = '<option value="1">顶级分类</option>';
        $("#classification").html(str);
    	console.log(res)
    }
  });  
}
//修改赋值
function modifyPlatformData(id)
{
   $.ajax({
    url:Url+'RecordType/getDetails/'+id,
    type:"get",
    dataType:"JSON",  
    async:false,
 	success:function(res){
 		
	$(".main_3").find(".name").val(res.record_name);
	$(".main_3").find(".describe").val(res.record_dec);
	$(".main_3").find(".sort").val(res.sort);
	$(".main_3").find(".area_select").val(res.addr);
	$(".main_3").find(".detail").val(res.addr_detail);
	$(".main_3").find(".hidden").val(res.record_id);
     
	for(var i=0;i<$("option").length;i++){
		if(res.pid==$("option").eq(i).val()){
			$("#classification").val($("option").eq(i).val())
		}
	}
}
  });  
 } 
 
function getPlatformData()
{
   $.ajax({
    url:Url+'RecordType/getList',
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res);
        var str = '';
        for(var i=0;i<res.length;i++){
        	str+='<li>'
					+'<div>'
						+'<span class="first_span" _attr="0" _id="1" platform_id="'+res[i].record_id+'" style="background-position: 5px 20px;padding-left: 20px;">'+res[i].record_name+'</span>'
						+'<span>'+(i+1)+'</span>'
						+'<span>'+res[i].record_dec+'</span>'
						+'<span>'+res[i].sort+'</span>'
						+'<span><a class="operation" _id="'+res[i].record_id+'">修改</a>|<a class="undercarriage"  _id="'+res[i].record_id+'">下架</a></span>'
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
  
function getWeekDataData(id)
{
   $.ajax({
    url:Url+'RecordPrice/getWeekData/'+id,
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res);
     	var str = "";
     	for(var i=0;i<res.length;i++){
     		str+='<option value="'+res[i].dprice_id+'">'+res[i].specified_time+'</option>'
     	}
     	$(".dateTime").html(str)
    }
  });  
 } 
 
	function goAddTime(that){
		var id=$("#hideBox").attr("_id");
		var _name=$("#hideBox").attr("_name")
		var _attr=$(that).attr("_attr")
		if(_attr==0){
			$(".main_3").slideUp();
			$(".main_0").slideUp();
			$(".main_2").slideUp();
			$(".main_1").slideDown();
			$(".add").hide()
			$(".goBack").show()
			$(".productNames").val(_name)
			$('#flatpickr-tryme').val(CurentTime())
			$(".price").attr("record_id",id)
			$(".price").attr("_id",null)
		}else if(_attr==1){
			var _id=$('.dateTime option:selected').val();
			$(".main_3").slideUp();
			$(".main_0").slideUp();
			$(".main_2").slideUp();
			$(".main_1").slideDown();
			$(".add").hide()
			$(".goBack").show()
			$(".productNames").val(_name)
			$(".price").attr("record_id",id)
			$(".price").attr("_id",_id)
			getDetailsData(_id)
		}else if(_attr==2){
			$(".main_3").slideUp();
			$(".main_0").slideUp();
			$(".main_2").slideDown();
			$(".main_1").slideUp();
			$(".add").hide()
			$(".goBack").show()
			var myDate = new Date();
			var monthData =myDate.getMonth()+1;
			var btnAObj=$(".btnA");
		    for(var i=0;i<btnAObj.length;i++){
		        if(monthData==btnAObj.eq(i).attr("_id")){
		            btnAObj.eq(i).addClass("btnOn")
		        }
		    }
		    $(".btnBox").attr("_id",id)
		    $("#chart-name").text(_name)
			getCharData(id,monthData)
		}
		$("#hideBox").hide();
	}
	
function getDetailsData(id)
{
   $.ajax({
    url:Url+'RecordPrice/getDetails/'+id,
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res);
        //var res=(new Function('return( ' + res + ' );'))()
		$(".main_1").find(".wholesale").val(res.wholesale);
		$(".main_1").find(".retail").val(res.retail);
      	$(".main_1").find("#flatpickr-tryme").val(timestampToTime(res.specified_time));
    }
  });  
 } 
function addTimeData(data)
{
   $.ajax({
    url:Url+'RecordPrice/postData',
    type:"post",
    data:data,
    dataType:"JSON",    
     success:function(res){
        console.log(res);
        var res=(new Function('return( ' + res + ' );'))()
      if( res.valid == 4 ){
      	taostr(res.msg,1000);
      	$(".main_3").slideUp();
		$(".main_0").slideDown();
		$(".main_2").slideUp();
		$(".main_1").slideUp();
		//清除input数据
		$("wholesale").val("");
		$(".retail").val("");
      }else
      {
      	taostr(res.msg,1000);
      }
    }
  });  
 } 
 
 function getCharData(id,month)
{
   $.ajax({
    url:Url+'ChartPrice/getCharData/'+id+'/'+month,
    type:"get",
    dataType:"JSON",    
     success:function(res){
        console.log(res);
        myChart2Fun(res)
    }
  });  
   }

function myChart2Fun(data) {
    var days=(new Function('return( ' + data.days + ' );'))();

    var  getobjectse="";
    for(var i=0; i<data.data.length; i++)
    {
        getobjectse=getobjectse+"{"
            +"name:"+"'"+data.data[i]['name']+"'"+","
            +"type:'line',"          
            +"data:"+data.data[i]['str']+
            "},"
    }
    getobjectse="["+getobjectse+"]";
    var getobjectse=(new Function('return( ' + getobjectse + ' );'))();

    var myChart = echarts.init(document.getElementById('chart-main'));
    var option = {
        backgroundColor: '#fff',
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:data.name,
            textStyle:{
                fontSize:12
            }
        },
        grid: {
            left: '1%',
            right: '1%',
            bottom: '1%',
            containLabel: true
        },

        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: days,
            axisLabel:{ //调整x轴的lable  
		            textStyle:{
		                fontSize:12 // 让字体变大
		            }
            	}
        },
        yAxis: {
            nameLocation: 'center',
            type: 'value',
            axisLabel:{ //调整x轴的lable  
		            textStyle:{
		                fontSize:12 // 让字体变大
		            }
            	}
        },
        series:getobjectse
    };
    myChart.setOption(option,true);
}
function addTimeData(data)
{
   $.ajax({
    url:Url+'RecordPrice/postData',
    type:"post",
    data:data,
    dataType:"JSON",    
     success:function(res){
        console.log(res);
        //var res=(new Function('return( ' + res + ' );'))()
      if( res.valid == 4 ){
      	taostr(res.msg,1000);
      	$(".main_3").slideUp();
		$(".main_0").slideDown();
		$(".main_2").slideUp();
		$(".main_1").slideUp();
		//清除input数据
		$(".name").val("");
		$(".describe").val("");
      }else
      {
      	taostr(res.msg,1000);
      }
    }
  });  
 } 