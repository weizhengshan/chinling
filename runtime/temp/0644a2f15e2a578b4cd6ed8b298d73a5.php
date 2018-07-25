<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/var/www/chinlingcloud/public/../application/admin/view/imgclass/in_logo.html";i:1531716683;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1531900795;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1531716684;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1531899312;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>秦岭云 管理中心 - 网站管理员 </title>
<meta name="Copyright" content="Douco Design." />
<link rel="shortcut icon" href="" type="image/x-icon">
<link rel="stylesheet" href="__STATIC__/admin/layui/css/layui.css"  media="all">
<link href="__STATIC__/admin/css/public.css" rel="stylesheet" type="text/css">
 <script type="text/javascript" src="__STATIC__/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/admin/js/jquery.tab.js"></script>
<script type="text/javascript" src="__STATIC__/admin/js/global.js"></script>
<script src="__STATIC__/admin/dialog/dialog/layer.js"></script>
<script src="__STATIC__/admin/dialog/dialog.js"></script>
<script type="text/javascript" src="__STATIC__/admin/layui/layui.js"></script>
</head>
<body>
      
<div id="dcWrap">
  <div id="dcHead">
 <div id="head">
  <div class="logo"><a href="index.html"><img src="__STATIC__/admin/images/dclogo.gif" alt="logo"></a></div>
  <div class="nav">
    <ul>
    <li><a href="JavaScript:" onclick="huan_cuns('确定要清除缓存吗？','<?php echo $ssname; ?>')">清除缓存</a></li>
   </ul>
   <ul class="navRight">
    <li class="M noLeft"><a href="JavaScript:void(0);">您好，<?php echo $ssname; ?></a>
    </li>
    <li class="noRight"><a href="<?php echo url('admin/index/logout'); ?>">退出</a></li>
   </ul>
  </div>
 </div>
</div>
<script type="text/javascript">
//删除分类
function huan_cuns(message, id) {
        layer.open({
            content : message,
      
            icon:3,
            btn : ['是','否'],
            yes : function(){
                var url="<?php echo url('admin/index/runtime'); ?>";
        var success_url=window.location.href;
        $.post(url,{'type_id':id},function(result){
        if(result.status=='4')
          {
          dialog.success(result.message,success_url);
          }else
          {
            dialog.error(result.message);
          } 
        })
            }
        });
    }
 </script>

<!-- dcHead 结束 --> 
<div id="dcLeft">
<div id="menu">
 <ul class="bot">
   <?php if(is_array($daoh) || $daoh instanceof \think\Collection || $daoh instanceof \think\Paginator): if( count($daoh)==0 ) : echo "" ;else: foreach($daoh as $key=>$vo): ?>
    <li><a href="<?php echo url($vo['name']); ?>"><i class="manager"></i><em><?php echo $vo['title']; ?></em></a></li>
   <?php endforeach; endif; else: echo "" ;endif; ?>
 
 </ul>
  <!-- <ul>
     
     <li><a href="<?php echo url('admin/manage/manage_list'); ?>"><i class="manager"></i><em>网站管理员</em></a></li>
     <li><a href="<?php echo url('admin/auth_rule/auth_list'); ?>"><i class="managerLog"></i><em>权限管理</em></a></li>
     <li><a href="<?php echo url('admin/auth_group/auth_glist'); ?>"><i class="managerLog"></i><em>用户组管理</em></a></li>
     <li><a href="<?php echo url('admin/imgclass/in_logo'); ?>"><i class="show"></i><em>Logo</em></a></li>
     <li><a href="<?php echo url('admin/imgclass/in_carousel'); ?>"><i class="show"></i><em>首页轮播图</em></a></li>
     <li><a href="<?php echo url('admin/system/system_index'); ?>"><i class="system"></i><em>系统设置</em></a></li>
    </ul>
    <ul>
     <li><a href="<?php echo url('admin/types/types_index'); ?>"><i class="productCat"></i><em>导航分类</em></a></li>
     <li><a href="<?php echo url('admin/article/article_index'); ?>"><i class="product"></i><em>文章列表</em></a></li>
    </ul>
     <ul>
     <li><a href="<?php echo url('admin/protype/protypes_index'); ?>"><i class="articleCat"></i><em>产品分类</em></a></li>
     <li><a href="<?php echo url('admin/productline/productline_index'); ?>"><i class="article"></i><em>产品列表</em></a></li>
    </ul>
    <ul class="bot">
     <li><a href="backup.html"><i class="backup"></i><em>数据备份</em></a></li>
     <li><a href="<?php echo url('admin/operation/index'); ?>"><i class="managerLog"></i><em>操作记录</em></a></li>
     <li><a href="<?php echo url('admin/leaving/index'); ?>"><i class="managerLog"></i><em>留言管理</em></a></li>
     <li><a href="<?php echo url('admin/recycle/admin_index'); ?>"><i class="managerLog"></i><em>回收站</em></a></li>
    </ul> -->  
</div></div>
<script>


    var liList=$(".bot").children("li");
    var strFullPath=window.document.location.href;
    for(var i=0;i<liList.length;i++){
        var aHref=liList.eq(i).children("a").attr("href");
        var aHrefNew= find(aHref,"/",2)
        if(strFullPath.indexOf("imgclass") != -1){
            if(strFullPath.indexOf("in_carousel") != -1 && aHref.indexOf("in_carousel") != -1 ){
                liList.eq(i).css("background","#cccccc");
                break;
            }else if(strFullPath.indexOf("in_logo") != -1 && aHref.indexOf("in_logo") != -1 ){
                liList.eq(i).css("background","#cccccc");
                break;
            }
        }else if(strFullPath.indexOf(aHrefNew) != -1){
                liList.eq(i).css("background","#cccccc");
                break;
            }
    }

    function find(str,cha,num){
        var x=str.indexOf(cha);
        for(var i=0;i<num;i++){
            x=str.indexOf(cha,x+1);
        }
        var newStr = str.slice(0,x+1)
        return newStr;
    }
</script>

 <div id="dcMain">
   <!-- 当前位置 -->
<div id="urHere">DouPHP 管理中心<b>></b><strong>LOGO</strong> </div>   <div class="mainBox imgModule">
    <h3>

		<a href="<?php echo url('admin/imgclass/in_logo',['pid'=>3]); ?>" class="actionBtn">微博二维码　｜</a>
		<a href="<?php echo url('admin/imgclass/in_logo',['pid'=>2]); ?>" class="actionBtn">微信二维码　｜</a>
		<a href="<?php echo url('admin/imgclass/in_logo',['pid'=>4]); ?>" class="actionBtn">LOGO图标｜</a>
		<a href="<?php echo url('admin/imgclass/in_logo',['pid'=>1]); ?>" class="actionBtn">LOGO　｜</a><?php echo $logodata['dataname']; ?>
	</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
    <tr>
       <th><?php echo !empty($logodata['logo_id'])?'修改':'添加'; ?><?php echo $logodata['dataname']; ?></th>
       <!--<th>LOGO列表</th>-->
     </tr>
     <tr>
      <td width="350" valign="top">
       <form action="" method="post" id="logo_data" enctype="multipart/form-data">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
		<tr>
          <td>
		  <!--lay上传图片-->
		  <a class="layui-btn" id="image" style="float: left;"><i class="layui-icon">&#xe67c;</i><?php echo !empty($logodata['logo_id'])?'修改':'添加'; ?><?php echo $logodata['dataname']; ?></a>
			
			<?php if($logodata['pid']==1): ?>
			<img style="margin-left: 110px;" id="img" src="<?php echo $logodata['logo_img']; ?>">
			<?php else: ?>
			<img style="margin-left: 110px;" id="img" src="<?php echo $logodata['logo_img']; ?>" width="277" height="277">
			<?php endif; ?>
			<input type="hidden" id="logo_img" name="logo_img" value="<?php echo $logodata['logo_img']; ?>" width="500" height="140"/>
			<font style="display:none" class="adlogo_img" color='red'>请上传图片</font>	
		   </td>
         </tr>
         <tr>
          <td><b><?php echo $logodata['dataname']; ?>备注</b>
			<textarea placeholder="请输入备注" class="layui-textarea" id="logo_remarks" name="logo_remarks"><?php echo $logodata['logo_remarks']; ?></textarea>
			<font style="display:none" class="adlogo_remarks" color='red'>备注不在1-100之间</font>
          </td>
         </tr>
         <tr>
          <td>
                      <input type="hidden" name="token" value="79db104d" />
					  <input type="hidden" name="logo_id" value="<?php echo $logodata['logo_id']; ?>" />
					  <input type="hidden" name="pid" value="<?php echo $logodata['pid']; ?>" />
			<input type="button" onclick='logo_add()' value="提交" class="btn"/>
          </td>
         </tr>
        </table>
       </form>
      </td>
     </tr>
    </table>
   </div>
 </div>
 <div class="clear"></div>
 <script>
 //上传图片
 var imgsize=<?php echo $imgsize; ?>;
layui.use('upload',function(){
  
  var upload = layui.upload,
  
  jq = layui.jquery;
  upload.render({
	url: "<?php echo url('admin/imgclass/upload'); ?>?imgsize="+imgsize
	,elem:'#image'
	,ext: 'jpg|png|gif'
	,area: ['500', '500px']
	,done: function(res){
	jq('input[name=img]').val(res.path);
	img.src = ""+res.path;
	$("#logo_img").val(res.path);
	}
  }); 

})
//提交
$(function(){
	$("#car_name").blur(function(){
	$(".adcar_name").hide();
	})
	$("#caro_img").blur(function(){
	$(".adcaro_img").hide();
	})
	$("#caro_sort").blur(function(){
	$(".adcaro_sort").hide();
	})

})
function logo_add(){
	var success_url=window.location.href;

	var pid=<?php echo $logodata['pid']; ?>;
	var url="<?php echo url('admin/imgclass/in_logo'); ?>";
	var admins=$("#logo_data").serialize();
	//alert(admins);
	var logo_remarks=$("#logo_remarks").val();
	var logo_img=$("#logo_img").val();

	//alert(logo_remarks.length);
	//alert(logo_remarks.length);
	if(logo_remarks.length<1 ){
	$(".adlogo_remarks").show();
	}else if(logo_remarks.length>200){
	$(".adlogo_remarks").show();
	}else if(logo_img.length<1){
	$(".adlogo_img").show();
	}else{
	$.post(url,admins,function(result)
	{	 
	if(result.status=='4')
		{
		dialog.success(result.message,success_url);
		}else
		{
			dialog.error(result.message);
		} 
		})
	}

}
</script>

 <div id="dcFooter">
 <div id="footer">
  <div class="line"></div>
  <ul>
   版权所有 © 2016-2017 西安秦岭云电子商务有限公司，并保留所有权利。
  </ul>
 </div>
</div><!-- dcFooter 结束 -->
<div class="clear"></div> </div>


</body>
</html>