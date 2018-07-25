<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"/var/www/chinlingcloud/public/../application/admin/view/article/article_edit.html";i:1531716682;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1531900795;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1531716684;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1531899312;}*/ ?>
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
<div id="urHere">DouPHP 管理中心<b>></b><strong>修改文章</strong> </div>   <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
            <h3>修改文章</h3>
    <form action="" id="article_admin" method="post" enctype="multipart/form-data">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
       <td width="90" align="right">文章名称</td>
       <td>
        <input type="text" id="cont_title" name="cont_title"  value="<?php echo $data['cont_title']; ?>" size="80" class="inpMain" />
        <font style="display:none" class="adcont_title" color='red'>文章名称必须填写或在2--20！</font>
       </td>
      </tr>
      <tr>
       <td align="right">文章分类</td>
       <td>
        <select name="cont_pid">
        <?php if(is_array($arr) || $arr instanceof \think\Collection || $arr instanceof \think\Paginator): if( count($arr)==0 ) : echo "" ;else: foreach($arr as $key=>$vo): ?>
            <option <?php if($vo['type_id']==$data['cont_pid']): ?> selected <?php endif; ?> value="<?php echo $vo['type_id']; ?>"><?php echo $vo['type_name']; ?></option>
          <?php endforeach; endif; else: echo "" ;endif; ?>  
        </select>
       </td>
      </tr>
      <tr>
       <td align="right">缩略图</td>
       <td>
         <a class="layui-btn" id="image" style="float: left;"><i class="layui-icon">&#xe67c;</i>重新上传</a>
            <img style="margin-left: 110px;" id="img" src="<?php echo $data['cont_img']; ?>"  width="400">
          <input type="hidden" id="cont_img" name="cont_img" value="<?php echo $data['cont_img']; ?>"/>
          <font style="display:none" class="adcont_img" color='red'>请上传图片</font>  
      </tr>
      <tr>
       <td align="right" valign="top">文章描述</td>
       <td>
       <script src="/static/admin/ueditor/ueditor.config.js"></script>
		<script src="/static/admin/ueditor/ueditor.all.min.js"></script>
		<script src="/static/admin/ueditor/lang/zh-cn/zh-cn.js"></script>
        <script>
			//实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    UE.getEditor('content',{initialFrameWidth:800,initialFrameHeight:400,});	
			</script>
        <!-- /KindEditor -->
        <textarea id="content" name="content"><?php echo $data['cont_text']; ?></textarea>

       </td>
      </tr>
      
      <tr>
       <td align="right">简单备注</td>
       <td>
            <textarea placeholder="请输入备注" class="layui-textarea" id="cont_remarks" name="cont_remarks"><?php echo $data['cont_remarks']; ?></textarea>
            <font style="display:none" class="adcont_remarks" color='red'>备注不在1-100之间</font>
       </td>
      </tr>
      <tr>
       <td></td>
       <td>
        <input type="hidden" name="token" value="7e4a88fb" />
        <input type="hidden" name="cont_id" value="<?php echo $data['cont_id']; ?>" />
        <input type="button" onclick='article_edit()' class="btn"  value="提交" />
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
  $("#cont_img").val(res.path);
  }
  }); 

})
 $(function(){
    $("#cont_title").blur(function(){
    $(".adcont_title").hide();
    })
    $("#cont_img").blur(function(){
    $(".adcont_img").hide();
    })
    $("#content").blur(function(){
    $(".adcontent").hide();
    })
    $("#cont_remarks").blur(function(){
    $(".adcont_remarks").hide();
    })
})
//添加文章
function article_edit(){
var success_url="<?php echo url('admin/article/article_index'); ?>";
var url="<?php echo url('admin/article/article_edit'); ?>";
var admins=$("#article_admin").serialize();
//alert(admins);
var cont_title=$("#cont_title").val();
var cont_img=$("#cont_img").val();
var content=$("#content").val();
var cont_remarks=$("#cont_remarks").val();

if((cont_title.length<2) || (cont_title.length>40)){
$(".adcont_title").show();
}else if(cont_img.length<1){
$(".adcont_img").show();

}else if(cont_remarks.length<1){
$(".adcont_remarks").show();
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