<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"/var/www/chinlingcloud/public/../application/admin/view/index/index.html";i:1531716683;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1531900795;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1531716684;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1531899312;}*/ ?>
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

 <div id="dcMain"> <!-- 当前位置 -->
     <style>
         .bttnIframe{
             background:#0b8bea;
             font-size:20px;
             color:#fff;
             padding: 5px 10px;
             border-radius: 5px;
             margin-bottom: 10px;
             display: inline-block;
             cursor:pointer;
         }
         .bttnIframe_on{
             color: #ffffff;
             background: #51b3fb;
         }
     </style>
<div id="urHere">DouPHP 管理中心</div>
     <div id="index" class="mainBox" style="padding-top:18px;padding-bottom:0px;height:auto !important;">
 
   <div><h3>欢迎来到秦岭云后台管理</h3></div>
      <div class="indexBox">
       <span  class="child1 bttnIframe bttnIframe_on" _attr="big_data" >大数据平台管理</span>
       <span  class="child1 bttnIframe" _attr="product_data">商品价格记录</span>
       <a href="<?php echo url('weixin/county/getPostCityArr'); ?>" class="child1" style="background:#0b8bea;font-size:20px;color:#fff;padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;display: inline-block;">更新一亩田全国价格</a>
       <a href="<?php echo url('weixin/county/getPostCountyArr'); ?>" class="child1" style="background:#0b8bea;font-size:20px;color:#fff;padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;display: inline-block;">更新一亩田市价格</a>
       <a href="<?php echo url('weixin/county/getMonthPrice'); ?>" class="child1" style="background:#0b8bea;font-size:20px;color:#fff;padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;display: inline-block;">更新一亩田近一个月价格</a>
  </div>

   </div>
     <iframe src="big_data.html" class="big_data"  width="100%" height="1000" frameborder="0" scrolling="no"></iframe>
     <iframe src="product_data.html" class="product_data" style="display: none" width="100%" height="1000" frameborder="0" scrolling="no"></iframe>
 <div class="clear"></div>
     <script>
        $(".bttnIframe").on("click",function () {
            var _attr=$(this).attr("_attr");
            if(_attr==="big_data"){
                $(".big_data").css("display","block");
                $(".product_data").css("display","none");
                $(this).addClass("bttnIframe_on");
                $(this).next().removeClass("bttnIframe_on")
            }else {
                $(".big_data").css("display","none");
                $(".product_data").css("display","block");
                $(this).prev().removeClass("bttnIframe_on");
                $(this).addClass("bttnIframe_on")
            }

        })
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