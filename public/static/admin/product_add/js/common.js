
provinceData()
$("#addressChose").on("click",".cancel",function(){
	var province=$(".province").text("");
	var city=$(".city").text("");
	var county=$(".county").text("");
	$(".choseing_province").addClass("chosed")
	$(".choseing_province").parents("li").siblings("li").children("span").removeClass("chosed")
	$(".choseing_province").next("div").show()
	$(".choseing_province").parents("li").siblings("li").children("div").hide()
	$("#addressChose").hide();
})
$("#addressChose").on("click",".province_a",function(){
	var zhi=$(this).text()
	var code=$(this).attr("_id")
	cityData(code)
	$(".province").text(zhi)
	$(".city").text("")
	$(".county").text("")
	$(this).parents(".province_li").children("span").removeClass("chosed")
	$(this).parents(".province_li").next("li").children("span").addClass("chosed")
	$(".province_div").hide();
	$(".city_div").show();
	$(".county_div").hide();
})
$("#addressChose").on("click",".city_a",function(){
	var zhi=$(this).text()
	var code=$(this).attr("_id")
	countyData(code)
	$(".city").text(zhi)
	$(".county").text("")
	$(this).parents(".city_li").children("span").removeClass("chosed")
	$(this).parents(".city_li").next("li").children("span").addClass("chosed")
	$(".province_div").hide();
	$(".city_div").hide();
	$(".county_div").show();
})
$("#addressChose").on("click",".county_a",function(){
	var zhi=$(this).text()
	$(".county").text(zhi)
	$(".province_div").hide();
	$(".city_div").hide();
	$(".county_div").show();
})
$("#addressChose").on("click",".choseing_province",function(){
	$(this).addClass("chosed")
	$(this).parents("li").siblings("li").children("span").removeClass("chosed")
	$(this).next("div").show()
	$(this).parents("li").siblings("li").children("div").hide()
})
$("#addressChose").on("click",".choseing_city",function(){
	var province=$(".province").text();
	if(province==""){
		return;
	}
	$(this).addClass("chosed")
	$(this).parents("li").siblings("li").children("span").removeClass("chosed")
	$(this).next("div").show()
	$(this).parents("li").siblings("li").children("div").hide()
})
$("#addressChose").on("click",".choseing_county",function(){
	var province=$(".province").text();
	var city=$(".city").text();
	if(province==""||city==""){
		return;
	}
	$(this).addClass("chosed")
	$(this).parents("li").siblings("li").children("span").removeClass("chosed")
	$(this).next("div").show()
	$(this).parents("li").siblings("li").children("div").hide()
})
$("#addressChose").on("click",".determine",function(){
	var province=$(".province").text();
	var city=$(".city").text();
	var county=$(".county").text();
	var addr=province+","+city+","+county;
	$("#demo2").val(addr)
	var province=$(".province").text("");
	var city=$(".city").text("");
	var county=$(".county").text("");
	$(".choseing_province").addClass("chosed")
	$(".choseing_province").parents("li").siblings("li").children("span").removeClass("chosed")
	$(".choseing_province").next("div").show()
	$(".choseing_province").parents("li").siblings("li").children("div").hide()
	$("#addressChose").hide()
})

function provinceData(){
	var province_data=total_data['100000'];
	var str="";
	for(var k in province_data){
		str+='<a class="province_a" _id="'+k+'">'+province_data[k]+'</a>'
	}
	$(".province_div").html(str)
}
function cityData(code){
	var city_data=total_data[code];
	var str="";
	for(var k in city_data){
		str+='<a class="city_a" _id="'+k+'">'+city_data[k]+'</a>'
	}
	$(".city_div").html(str)
}
function countyData(code){
	var county_data=total_data[code];
	var str="";
	for(var k in county_data){
		str+='<a class="county_a" _id="'+k+'">'+county_data[k]+'</a>'
	}
	$(".county_div").html(str)
}
