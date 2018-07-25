<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"/var/www/chinlingcloud/public/../application/admin/view/sales_direc/index.html";i:1531716685;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1531716682;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1531716684;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1531716684;}*/ ?>
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
<div id="urHere">DouPHP 管理中心<b>></b><strong>县产品销售去向</strong> </div>   <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3><a href="<?php echo url('admin/county_type/index'); ?>" class="actionBtn add"></a>县产品销售去向</h3> 
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
        <th >编号</th>
        <th >产品名称</th>
        <th >所属县</th>
        <th >所属品类</th>
        <th >年份</th>
        <th >销量信息</th>
        <th>操作</th>
	    </tr>
   
 		  <?php if(is_array($typesdata) || $typesdata instanceof \think\Collection || $typesdata instanceof \think\Paginator): if( count($typesdata)==0 ) : echo "" ;else: foreach($typesdata as $key=>$vo): ?>
            <tr align="center">
               <td><?php echo $vo['saledir_id']; ?></td>      
               <td ><?php echo $vo['varies_name']; ?></td>
               <td><?php echo $vo['county_name']; ?></td>
               <td><?php echo $vo['protype_name']; ?></td>
               <td><?php echo $vo['saledir_year']; ?></td>
               <td align="left">
                  <table  border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                          <tr>
                           <th>去向:</th>
                          <?php 
                          for($i=0;$i<count($vo['name_saledir']);$i++)
                          {
                            echo '<td align="center">'.$vo['name_saledir'][$i].'</td>';
                          } 
                          ?>     
                          <tr>
                           <th>占比:</th>
                          <?php 
                          for($i=0;$i<count($vo['name_saledir']);$i++)
                          {
                            echo '<td align="center">'.$vo['value_saledir'][$i].'</td>';
                          } 
                          ?>     
                          </tr>
                   </table>  
               </td>
               <td ><a  class="layui-btn layui-btn-sm" href="<?php echo url('admin/SalesDirec/dire_edit',['saledir_id'=>$vo['saledir_id']]); ?>">编辑</a><a  class="layui-btn layui-btn-sm" href="JavaScript:" onclick="types_dele('确定要下架吗？',<?php echo $vo['saledir_id']; ?>)">下架</a></td>
             </tr>
           <?php endforeach; endif; else: echo "" ;endif; ?>  
          </table>
           <h3 align="center"><?php echo !empty($typesdata[0])?'':'这里没有数据'; ?></h3>
        </div>

<?php if(count($typesdata)!=1) { ?>    
<div class="pager">总计 <?php echo $totalRows; ?> 个记录，共 <?php echo $maxPage; ?> 页，当前第 <?php echo $page; ?> 页 | 
      <a href="<?php echo url('admin/SalesDirec/index',['page'=>1]); ?>">第一页</a> 
      <?php if($page>1): ?> 
      <a href="<?php echo url('admin/SalesDirec/index',['page'=>$page-1]); ?>">上一页</a>
      <?php endif; if($maxPage>$page): ?> 
      <a href="<?php echo url('admin/SalesDirec/index',['page'=>$page+1]); ?>">下一页</a>
      <?php endif; ?>  
      <a href="<?php echo url('admin/SalesDirec/index',['page'=>$maxPage]); ?>">最末页</a>      
    </div>
 </div>
<?php } ?>
 <div class="clear"></div>
 
 <script type="text/javascript">
 //删除分类
function types_dele(message, id){
        layer.open({
            content : message,      
            icon:3,
            btn : ['是','否'],
            yes : function(){
                var url="<?php echo url('admin/SalesDirec/dire_dele'); ?>";
        var success_url="<?php echo url('admin/SalesDirec/index'); ?>";
        $.post(url,{'saledir_id':id},function(result){
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