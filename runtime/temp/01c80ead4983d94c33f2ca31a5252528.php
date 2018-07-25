<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:17:"./static/404.html";i:1509952318;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<title>404</title>
		<link href="css/public.css" rel="stylesheet" />
		<link href="css/404.css" rel="stylesheet" />
	</head>
	<body>
		<div id="main_404">
			<div class="img_404">
				<img src="img/404.png" />
			</div>
			<div class="h_404">
				<h3>啊哦--一不小心闯进了未知领域，请点击下面按钮返回首页~~</h3>
			</div>
			<div class="a_404">
				<a href="index.html">返回首页</a>
			</div>
		</div>
	</body>
</html>
<script src="js/jquery-1.8.3.min.js"></script>
<script>
$(function () {
	var _height=$(window).height()
    $("body").css("height",_height)  
})
</script>
