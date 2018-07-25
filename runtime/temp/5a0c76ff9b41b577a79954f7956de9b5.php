<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/var/www/chinlingcloud/public/../application/admin/view/index/product_data.html";i:1531716683;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="__STATIC__/admin/product_add/css/public.css"/>
    <link rel="stylesheet" href="__STATIC__/admin/product_add/css/common.css"/>
    <link rel="stylesheet" href="__STATIC__/admin/product_add/css/index.css"/>
    <script src="__STATIC__/admin/product_add/js/jquery-1.8.3.min.js"></script>
    <script src="__STATIC__/admin/product_add/js/echarts.js"></script>
    <script src="__STATIC__/admin/product_add/js/commonNew.js"></script>
	<script async>
	function fp_ready(){
	// setting custom defaults
	Flatpickr.l10n.firstDayOfWeek = 1;
	//Regular flatpickr
	document.getElementById("flatpickr-tryme").flatpickr();
	}
	</script>
	<script async src="__STATIC__/admin/product_add/js/flatpickr.js"></script>
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/product_add/css/site.css">
	<link rel="stylesheet" id="cal_style" type="text/css" href="__STATIC__/admin/product_add/css/flatpickr.min.css">
</head>
<body async onload="fp_ready()">
<div id="nav">
	<h5>
                平台管理<a class="add">添加分类</a><a class="goBack" style="display: none;">返回</a>
    </h5>
    <ul class="float_r">
        <li class="float_r_li main_0">
            <div class="platform_div">
                <div class="tableBasic">
                    <h6>
                        <span>名称</span>
                        <span>编号</span>
                        <span>简单描述</span>
                        <span>排序</span>
                        <span>操作</span>
                    </h6>
                    <ul class="platformList">

                    </ul>
                </div>
            </div>    
        </li>   
         <li class="float_r_li main_1" style="display: none;">
            <div class="data_type">
                <table class="price">
                	<tr>
		                <td align="center">产品名称</td>
		                <td align="left"><input class="productNames" type="text" readonly value=""/></td>
		            </tr>   
		            <tr>
		                <td align="center">进货价格</td>
		                <td align="left"><input class="wholesale" type="text" value="0.00"/></td>
		            </tr>                   
		            <tr>
		                <td align="center">出货价格</td>
		                <td align="left"><input class="retail" type="text" value="0.00"/></td>
		            </tr>
		    		<tr>
		    			<td align="center">添加时间</td>
						<td align="left"><input id="flatpickr-tryme" type="text" readonly></td>
					</tr>					
		            <tr>
		                <td><input class="hidden" type="hidden" value=""/></td>
		                <td align="left"><a class="submits">提交</a><a href="index.html" class="cancel">取消</a></td>
		            </tr>
		        </table>
            </div>
        </li>
        <li class="float_r_li main_2" style="display: none;">
            <div class="dataForm">
            	<div id="chart-name"></div>
				<div id="chart-main" style="width: 90%;height: 300px;margin: 0 auto;"></div>
				<div class="btnBox">
	                <a class="btnA searchProcess" _id="1">一月</a>
	                <a class="btnA searchProcess" _id="2">二月</a>
	                <a class="btnA searchProcess" _id="3">三月</a>
	                <a class="btnA searchProcess" _id="4">四月</a>
	                <a class="btnA searchProcess" _id="5">五月</a>
	                <a class="btnA searchProcess" _id="6">六月</a>
	                <a class="btnA searchProcess" _id="7">七月</a>
	                <a class="btnA searchProcess" _id="8">八月</a>
	                <a class="btnA searchProcess" _id="9">九月</a>
	                <a class="btnA searchProcess" _id="10">十月</a>
	                <a class="btnA searchProcess" _id="11">十一月</a>
	                <a class="btnA searchProcess" _id="12">十二月</a>
	           </div>            
			</div>
        </li>
        <li class="float_r_li main_3" style="display: none;">
            <div class="data_type">
                    <table>
                        <tr>
                            <td align="center">名称</td>
                            <td align="left"><input class="name" type="text"/></td>
                        </tr>
                        <tr>
                            <td align="center">上级分类</td>
                            <td align="left">
                                <select id="classification" class="classification">

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">简单描述</td>
                            <td align="left"><input class="describe" type="text"/></td>
                        </tr>
                        <tr>
                			<td align="center">所在地区</td>
							<td align="left"><input class="area_select" id="demo2" type="text" readonly="" placeholder="请选择所在地区"/></td>
						</tr>
						<tr>
							<td align="center">详息地址</td>
							
							<td align="left"><input name="detail" class="detail" placeholder="详息地址，如楼道、楼盘号等" value=""/></td>
						</tr>
                        <tr>
                            <td align="center">排序</td>
                            <td align="left"><input class="sort" type="text"/></td>
                        </tr>
                        <tr>
                            <td><input class="hidden" type="hidden" value=""/></td>
                            <td align="left"><a class="submit">提交</a></td>
                        </tr>
                    </table>
                </div>
        </li>
	</ul>
</div>  
<div id="hideBox"  style="display: none;">
	<ul class="hideBoxMain">
		<li>
			<span class="productName"></span>
		</li>
		<li>
			<a onclick="goAddTime(this)" class="btna" _attr="0">添加</a>
		</li>
		<li>
			<select class="dateTime">
				
			</select>
			<a onclick="goAddTime(this)" class="btna" _attr="1">修改</a>
		</li>
		<li>
			<a onclick="goAddTime(this)" class="btna" _attr="2">查看</a>
		</li>
		<li>
			<a class="closeA">取消</a>
		</li>
	</ul>
</div>
<div id="addressChose"  style="display: none;">
	<div class="addressChoseMain">
		<div class="switch_div">
			<a class="cancel">取消</a>
			<a class="determine">确定</a>
		</div>
		<div class="chose_val">
			<span>
				<i>省：</i>
				<b class="province"></b>
			</span>
			<span>
				<i>市：</i>
				<b class="city"></b>
			</span>
			<span>
				<i>县：</i>
				<b class="county"></b>
			</span>
		</div>
		<ul>
			<li class="province_li"><span class="choseing_province chosed" _attr="0">选择省</span>
				<div class="province_div">
					
				</div>
			</li>
			<li class="city_li"><span class="choseing_city" _attr="1">选择市</span>
				<div class="city_div" style="display: none;">
					
				</div>
			</li>
			<li class="county_li"><span class="choseing_county" _attr="2">选择县</span>
				<div class="county_div" style="display: none;">
					
				</div>
			</li>
		</ul>
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="__STATIC__/admin/product_add/js/city.js"></script>
<script type="text/javascript" src="__STATIC__/admin/product_add/js/common.js"></script>
<script type="text/javascript" src="__STATIC__/admin/product_add/js/index.js"></script>