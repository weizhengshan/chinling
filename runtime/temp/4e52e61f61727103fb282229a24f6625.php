<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"/var/www/chinlingcloud/public/../application/admin/view/imgclass/in_carousel.html";i:1531716683;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1531716682;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1531716684;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1531899312;}*/ ?>
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
<div id="urHere">DouPHP 管理中心<b>></b><strong><?php echo $dataname; ?></strong> </div>   <div class="mainBox imgModule">
    <h3>
	<a href="<?php echo url('admin/imgclass/in_carousel',['pid'=>1]); ?>" class="actionBtn">　首页轮播图｜</a>
		<a href="<?php echo url('admin/imgclass/in_carousel',['pid'=>2]); ?>" class="actionBtn">首页模块图　｜</a>
		<a href="<?php echo url('admin/imgclass/in_carousel',['pid'=>3]); ?>" class="actionBtn">运营模式图　｜</a>
    <a href="<?php echo url('admin/imgclass/in_carousel',['pid'=>4]); ?>" class="actionBtn">手机端轮播图｜</a>
    <?php echo $dataname; ?></h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
    <tr>
       <th>添加<?php echo $dataname; ?></th>
       <th><?php echo $dataname; ?>列表</th>
     </tr>
     <tr>
      <td width="350" valign="top">
       <form action="" method="post" id="caro_data" enctype="multipart/form-data">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
         <tr>
          <td><b><?php echo $dataname; ?>名称</b>
			<input type="text" id="caro_name" name="caro_name" value="" size="20" class="inpMain" />
			<font style="display:none" class="adcaro_name" color='red'>名称不能未空</font>
          </td>
         </tr>
          <tr>
          <td><b>链接</b>
			<input type="text"  name="action" value="" size="50" class="inpMain" />
			
          </td>
         </tr>
         <tr>
          <td>
		  <!--lay上传图片-->
		  <a class="layui-btn" id="image" style="float: left;"><i class="layui-icon">&#xe67c;</i>上传<?php echo $dataname; ?></a>
			<img style="margin-left: 110px;" id="img" src="__STATIC__/admin/images/default_upload.jpg" <?php if($pid==1): ?> width="540" <?php else: ?> width="200"<?php endif; ?> height="140">
			<input type="hidden" id="caro_img" name="caro_img" value=""/>
			<font style="display:none" class="adcaro_img" color='red'>请上传图片</font>	
		   </td>
         </tr>
         <?php if($pid==3): ?>
       		<tr>
          <td><b>正反面 反为2</b>
			<input type="text" name="caro_zh" id="caro_zh" value="1" size="20" class="inpMain" />	
          </td>
         </tr>	
         <?php endif; ?>
         <tr>
          <td><b>排序</b>
			<input type="text" name="caro_sort" id="caro_sort" value="" size="20" class="inpMain" />
			<font style="display:none" class="adcaro_sort" color='red'>排序不能为空</font>	
          </td>
         </tr>
         <tr>
          <td>
                      <input type="hidden" name="token" value="79db104d" />
                      <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
			<input type="button" onclick='caro_add()' value="提交" class="btn"/>
          </td>
         </tr>
        </table>
       </form>
      </td>
      <td valign="top">
       <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
        <tr>
         <td width="100"><?php echo $dataname; ?></td>
         <td width="100"><?php echo $dataname; ?>名称</td>
         <td width="100">链接</td>
         <?php if($pid==3): ?><td width="100">正反</td><?php endif; ?>
         <td width="50" align="center">排序</td>
         <td width="80" align="center">操作</td>
        </tr>
		<?php if(is_array($carodata) || $carodata instanceof \think\Collection || $carodata instanceof \think\Paginator): if( count($carodata)==0 ) : echo "" ;else: foreach($carodata as $key=>$vo): ?>
                <tr>
         <td><a href="<?php echo $vo['caro_img']; ?>" target="_blank"><img src="<?php echo $vo['caro_img']; ?>" <?php if($vo['pid']==1): ?> width="540" <?php else: ?> width="200"<?php endif; ?> height="140" /></a></td>
         <td><?php echo $vo['caro_name']; ?></td>
         <td><?php echo $vo['action']; ?></td>
         <?php if($pid==3): ?><td><?php echo !empty($vo['caro_zh']) && $vo['caro_zh']=='1'?'正':'反'; ?></td><?php endif; ?>
         <td align="center"><?php echo $vo['caro_sort']; ?></td>
         <td align="center"><a  class="layui-btn layui-btn-sm" style="margin-bottom: 10px" href="<?php echo url('admin/imgclass/edit_carousel',['caro_id'=>$vo['caro_id'],'pid'=>$vo['pid']]); ?>">编辑</a><br/><a  class="layui-btn layui-btn-sm" href="JavaScript:" onclick="caro_dele('确定要下架吗？',<?php echo $vo['caro_id']; ?>)">下架</a></td>
        </tr>
         <?php endforeach; endif; else: echo "" ;endif; ?>       
               </table>
              <h3 align="center"><?php echo !empty($carodata[0])?'':'这里没有数据'; ?></h3>  
      </td>
     </tr>
    </table>
   </div>
 </div>
 <div class="clear"></div>
 <script>
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
	$("#caro_img").val(res.path);
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
function caro_add(){
	var success_url=window.location.href;
	var url="<?php echo url('admin/imgclass/caro_add'); ?>";
	var admins=$("#caro_data").serialize();
	//alert(admins);
	var caro_name=$("#caro_name").val();
	var caro_img=$("#caro_img").val();
	var caro_sort=$("#caro_sort").val();
	if(caro_name.length<1){
	$(".adcaro_name").show();
	}else if(caro_img.length<1){
	$(".adcaro_img").show();
	}else if(caro_sort.length <1){
	$(".adcaro_sort").show();
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
//删除轮播图
function caro_dele(message, id) {
        layer.open({
            content : message,
			
            icon:3,
            btn : ['是','否'],
            yes : function(){
                var url="<?php echo url('admin/imgclass/caro_dele'); ?>";
				var success_url=window.location.href;
				$.post(url,{'caro_id':id},function(result){
				if(result.status=='1')
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