<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"/var/www/chinlingcloud/public/../application/admin/view/productline/productline_add.html";i:1508981702;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1529648960;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1512365842;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1508134894;}*/ ?>
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
<div id="urHere">DouPHP 管理中心<b>></b><strong>添加产品</strong> </div>   <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
            <h3>添加产品</h3>
    <form action="" id="pro_admin" method="post" enctype="multipart/form-data">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
       <td width="90" align="right">产品名称</td>
       <td>
        <input type="text" id="prod_title" name="prod_title"  value="" size="80" class="inpMain" />
        <font style="display:none" class="adprod_title" color='red'>用户名必须填写或没在1-20位！</font>
       </td>
      </tr>
      <tr>
       <td align="right">产品分类</td>
       <td>
        <select name="protype_pid">
        <?php if(is_array($arr) || $arr instanceof \think\Collection || $arr instanceof \think\Paginator): if( count($arr)==0 ) : echo "" ;else: foreach($arr as $key=>$vo): ?>
            <option value="<?php echo $vo['protype_id']; ?>"><?php echo $vo['protype_name']; ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>  
        </select>
       </td>
      </tr>
      <tr>
       <td align="right">缩略图</td>
       <td>
         <a class="layui-btn" id="image" style="float: left;"><i class="layui-icon">&#xe67c;</i>上传图片</a>
            <img style="margin-left: 110px;" id="img" src=""  width="400">
          <input type="hidden" id="prod_img" name="prod_img" value=""/>
          <font style="display:none" class="adprod_img" color='red'>请上传图片</font>  
      </tr>
      <tr>
       <td align="right" valign="top">产品备注</td>
       <td>
        <textarea id="prod_text" name="prod_text" style="width:800px;height:80px;" class="textArea"></textarea>
        <font style="display:none" class="adprod_text" color='red'>用户名必须填写或没在6-20位！</font>

       </td>
      </tr>
       <td></td>
       <td>
        <input type="hidden" name="token" value="7e4a88fb" />
        <input type="button" onclick='prod_add()' class="btn"  value="提交" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>
 <div class="clear"></div>
 <script type="text/javascript">
 //上传图片
layui.use('upload',function(){
  var upload = layui.upload,
  jq = layui.jquery;
  upload.render({
  url: '<?php echo url("admin/imgclass/upload"); ?>'
  ,elem:'#image'
  ,ext: 'jpg|png|gif'
  ,area: ['500', '500px']
  ,done: function(res){
  jq('input[name=img]').val(res.path);
  img.src = ""+res.path;
  $("#prod_img").val(res.path);
  }
  }); 

})
 $(function(){
    $("#prod_title").blur(function(){
    $(".adprod_title").hide();
    })
    $("#prod_img").blur(function(){
    $(".adprod_img").hide();
    })
    $("#prod_text").blur(function(){
    $(".adprod_text").hide();
    })
})
//添加文章
function prod_add(){
var success_url="<?php echo url('admin/productline/productline_index'); ?>";
var url="<?php echo url('admin/productline/productline_add'); ?>";
var admins=$("#pro_admin").serialize();
//alert(admins);
var prod_title=$("#prod_title").val();
var prod_img=$("#prod_img").val();
var prod_text=$("#prod_text").val();

if((prod_title.length<1) || (prod_title.length>20)){
$(".adprod_title").show();
}else if(prod_img.length<1){
$(".adprod_img").show();
}else if(prod_text.length<1){
$(".adprod_text").show();
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