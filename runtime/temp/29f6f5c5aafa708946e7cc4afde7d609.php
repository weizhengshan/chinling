<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:84:"/var/www/chinlingcloud/public/../application/admin/view/county_type/countyt_add.html";i:1512551630;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1529648960;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1512365842;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1508134894;}*/ ?>
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
<div id="urHere">DouPHP 管理中心<b>></b><strong>添加区域产品</strong> </div>   <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
            <h3>添加区域产品</h3>
    <form action="" id="data_type" method="post">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
       <td width="80" align="right">产品名称</td>
       <td>
        <input type="text" id="varies_name" name="varies_name" value="" size="40" class="inpMain" />
		    <font style="display:none" class="advaries_name" color='red'>名称不能为空！</font>
       </td>
      </tr>
      <tr>
       <td align="right">所属县</td>
       <td>
            <select>
              <option >中国大陆</option>   
                     </select>
            <select id="select_k1" class="form-control" onchange="provice(this)">
              <option >请选择省</option> 
            <?php if(is_array($arr) || $arr instanceof \think\Collection || $arr instanceof \think\Paginator): if( count($arr)==0 ) : echo "" ;else: foreach($arr as $key=>$vo): ?>
              <option value="<?php echo $vo['county_id']; ?>"><?php echo $vo['county_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>                         
            </select>
            <select id="select_k2" class="form-control" onchange="city(this)">
              <option >请选择市</option>             
            </select>
            <select name="varies_copid" id="select_k3">
              <option >请选择县</option>             
            </select>  
       </td>
       </td>
      </tr>
      <script type="text/javascript">
        //地址市
function provice(txt)
{
    var add=txt.value;
   $.ajax({
    url:"<?php echo url('CountyType/provice_post'); ?>",
    type:"post",
    dataType:"json",
     data:"add="+add,
     success:function(res){
       $("#select_k2").html("");
      $(res).each(function(k,v){
        $("#select_k2").append($("<option value="+v.county_id+">"+v.county_name+"</option>"));
      })
       
      $("#select_k2").trigger("change");
    }
  });  
  } 
 //地址县区
function city(text)
{
    var city=text.value;
   $.ajax({
    url:"<?php echo url('CountyType/provice_post'); ?>",
    type:"post",
    dataType:"json",
     data:"add="+city,
     success:function(res){
       $("#select_k3").html("");
      $(res).each(function(k,v){
        $("#select_k3").append($("<option value="+v.county_id+">"+v.county_name+"</option>"));
      })  
    }
  });  
  }  
  
   //产品分类
function pinzh(text)
{
    var city=text.value;
   $.ajax({
    url:"<?php echo url('CountyType/pinzh_post'); ?>",
    type:"post",
    dataType:"json",
     data:"add="+city,
     success:function(res){
       $("#select_k5").html("");
      $(res).each(function(k,v){
        $("#select_k5").append($("<option value="+v.protype_id+">"+v.protype_name+"</option>"));
      })  
    }
  });  
  }  
      </script>
       <tr>
       <td align="right">所属品类</td>
       <td>
        <select>
          <option >品种分类</option>   
        </select>
            <select id="select_k4" class="form-control" onchange="pinzh(this)">
              <option >请选择分类</option> 
            <?php if(is_array($arrdata) || $arrdata instanceof \think\Collection || $arrdata instanceof \think\Paginator): if( count($arrdata)==0 ) : echo "" ;else: foreach($arrdata as $key=>$vo): ?>
              <option value="<?php echo $vo['protype_id']; ?>"><?php echo $vo['protype_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>                         
            </select>
            <select name="varies_agpid" id="select_k5">
              <option >请选择</option>                      
            </select>
       </td>
       </td>
      </tr>
       <tr>
       <td width="80" align="right">级别</td>
       <td>
        <input type="text" id="varies_grade" name="varies_grade" value="" size="20" class="inpMain" />
        <font style="display:none" class="advaries_grade" color='red'>级别不能为空！</font>
       </td>
      </tr>
       <tr>
       <td width="80" align="right">相关参考链接</td>
       <td>
         <textarea name="varies_link"  id="varies_link" cols="60" rows="4" class="textArea"></textarea>
       </td>
      </tr>
      <tr>
       <td align="right">排序</td>
       <td>
        <input type="text" id="varies_sort" name="varies_sort" value="" size="5" class="inpMain" />
		<font style="display:none" class="advaries_sort" color='red'>排序不能为空！</font>
       </td>
      </tr>
      <tr>
       <td>
        <input type="hidden" name="token" value="b9439ae8" />
        <input  class="btn" type="button" onclick='type_add()' value="提交" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>
 <div class="clear"></div>
 <script type="text/javascript">
 $(function(){
$("#varies_name").blur(function(){
$(".advaries_name").hide();
})
$("#varies_grade").blur(function(){
$(".advaries_grade").hide();
})

})
function type_add(){
var success_url="<?php echo url('admin/countyType/index'); ?>";
var url="<?php echo url('admin/countyType/countyt_add'); ?>";
var admins=$("#data_type").serialize();
//alert(admins);
var varies_name=$("#varies_name").val();


if((varies_name.length<1) || (varies_name.length>20)){
$(".advaries_name").show();
}else if(varies_grade.length<1){
$(".advaries_grade").show();
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