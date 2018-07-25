<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"/var/www/chinlingcloud/public/../application/admin/view/manage/manage_add.html";i:1508145202;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1529648960;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1512365842;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1508134894;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>秦岭云 管理中心 - 网站管理员 </title>
<meta name="Copyright" content="Douco Design." />
<link rel="shortcut icon" href="" type="image/x-icon">
<link rel="stylesheet" href="__STATIC__/admin/layui/css/layui.css"  media="all">
<link href="__STATIC__/admin/css/public.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__STATIC__/admin/js/jquery.tab.js"></script>

<script type="text/javascript" src="__STATIC__/admin/js/jquery.min.js"></script>

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
 <div id="dcMain">
   <!-- 当前位置 -->
<div id="urHere">DouPHP 管理中心<b>></b><strong>网站管理员</strong> </div>   <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
    <h3><a href="<?php echo url('admin/manage/manage_list'); ?>" class="actionBtn">返回列表</a>网站管理员</h3>
            <form id="data_admin" action="" method="post">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
       <td width="100" align="right">管理员名称</td>
       <td>
        <input type="text" id="user_name" name="user_name" size="40" class="inpMain" />
		<font style="display:none" class="adname" color='red'>用户名必须填写或没在6-20位！</font>
       </td>
      </tr>
      <tr>
       <td width="100" align="right">E-mail地址</td>
       <td>
        <input type="text" id="email" name="email" size="40" class="inpMain" />
		<font style="display:none" class="ademail" color='red'>邮箱不合法或为空！</font>
       </td>
      </tr>
	   <tr>
       <td width="100" align="right">手机号</td>
       <td>
        <input type="text" id="phone" name="phone"  size="40" class="inpMain" />
		<font style="display:none" class="adphone" color='red'>手机号不合法或为空！</font>
       </td>
      </tr>
      <tr>
       <td align="right">密码</td>
       <td>
        <input type="password" id="password" name="password" size="40" class="inpMain" />
		<font style="display:none" class="adpassword" color='red'>密码为空或没在6-20位！</font>
       </td>
      </tr>
      <tr>
       <td align="right">管理员角色</td>
       <td>
        <select name="role_id" id="role_id" >			
        <?php if(is_array($roledata) || $roledata instanceof \think\Collection || $roledata instanceof \think\Paginator): $i = 0; $__LIST__ = $roledata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>  
			   <option value="<?php echo $role['id']; ?>"><?php echo $role['title']; ?></option>
		    <?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<font style="display:none" class="adrole" color='red'>未选择权限！</font>
       </td>
      </tr>
      <tr>
       <td></td>
       <td>
        <input type="hidden" name="token" value="5a58b748" />
		<input type="hidden" name="admin_id" value="{input(param.admin_id)}" />
        <input type="button" onclick='manage_add()' value="提交" class="btn"/>
       </td>
      </tr>
     </table>
    </form>
                   </div>
 </div>
 <div class="clear"></div>
 
 <script type="text/javascript">
 $(function(){
$("#user_name").blur(function(){
$(".adname").hide();
})
$("#password").blur(function(){
$(".adpassword").hide();
})
$("#email").blur(function(){
$(".ademail").hide();
})
$("#role_id").blur(function(){
$(".adrole").hide();
})
$("#phone").blur(function(){
$(".adphone").hide();
})
})
function manage_add(){
var success_url="<?php echo url('admin/manage/manage_list'); ?>";
var url="<?php echo url('admin/manage/manage_add'); ?>";
var admins=$("#data_admin").serialize();
//alert(admins);
var adname=$("#user_name").val();
var password=$("#password").val();
var email=$("#email").val();
var phone=$("#phone").val();
var role_id=$("#role_id").val();
var token=$("#token").val();


if((adname.length<6) || (adname.length>20)){
$(".adname").show();
}else if(email.length<1){
$(".ademail").show();
}else if(phone.length !=11){
$(".adphone").show();
}else if(password.length<6 || password.length>20){
$(".adpassword").show();
}else if(role_id.length<1){
$(".adrole").show();
}else{
$.post(url,admins,function(result){
 
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