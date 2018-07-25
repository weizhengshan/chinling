<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/var/www/chinlingcloud/public/../application/admin/view/recruit/rec_add.html";i:1531195046;s:65:"/var/www/chinlingcloud/public/../application/admin/view/base.html";i:1529648960;s:74:"/var/www/chinlingcloud/public/../application/admin/view/public/header.html";i:1512365842;s:71:"/var/www/chinlingcloud/public/../application/admin/view/public/nav.html";i:1508134894;}*/ ?>
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
        <div id="urHere">DouPHP 管理中心<b>></b><strong>添加分类</strong></div>
        <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
            <h3>添加职位</h3>
            <form action="" id="data_type" method="post">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <td width="80" align="right">职位名称</td>
                        <td>
                            <input type="text" id="rec_position" name="rec_position" value="" size="40"
                                   class="inpMain"/>
                            <font style="display:none" class="adrec_position" color='red'>名称不能为空！</font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">职位性质</td>
                        <td>
                            <select name="nature">
                                <option value="1">全职</option>
                                <option value="0">兼职</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="80" align="right">招聘人数</td>
                        <td>
                            <input type="text" id="rec_num" name="rec_num" value="" size="40" class="inpMain"/>
                            <font style="display:none" class="adrec_num" color='red'>名称不能为空！</font>
                        </td>
                    </tr>
                    <tr>
                        <td width="80" align="right">工作地点</td>
                        <td>
                            <input type="text" id="rec_place" name="rec_place" value="" size="40" class="inpMain"/>
                            <font style="display:none" class="adrec_place" color='red'>名称不能为空！</font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">招聘信息</td>
                        <td>
                            <script src="/static/admin/ueditor/ueditor.config.js"></script>
                            <script src="/static/admin/ueditor/ueditor.all.min.js"></script>
                            <script src="/static/admin/ueditor/lang/zh-cn/zh-cn.js"></script>
                            <script>
                                //实例化编辑器
                                //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                                UE.getEditor('content', {initialFrameWidth: 800, initialFrameHeight: 400,});
                            </script>
                            <!-- /KindEditor -->
                            <textarea id="content" name="content"></textarea>

                        </td>
                    </tr>

                    <tr>
                        <td align="right">排序</td>
                        <td>
                            <input type="text" id="protype_sort" name="protype_sort" value="" size="5" class="inpMain"/>
                            <font style="display:none" class="adprotype_sort" color='red'>排序不能为空！</font>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="token" value="b9439ae8"/>
                            <input type="hidden" name="cat_id" value=""/>
                            <input class="btn" type="button" onclick='protype_add()' value="提交"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="clear"></div>
    <script type="text/javascript">
        $(function () {
            $("#rec_position").blur(function () {
                $(".adrec_position").hide();
            })
            $("#rec_num").blur(function () {
                $(".adrec_num").hide();
            })
            $("#rec_place").blur(function () {
                $(".adrec_place").hide();
            })
            $("#protype_sort").blur(function () {
                $(".adprotype_sort").hide();
            })
        })
        function protype_add() {
            var success_url = "<?php echo url('admin/recruit/index'); ?>";
            var url = "<?php echo url('admin/recruit/rec_add'); ?>";
            var admins = $("#data_type").serialize();
            //alert(admins);
            var rec_position = $("#rec_position").val();
            var rec_num = $("#rec_num").val();
            var rec_place = $("#rec_place").val();
            var protype_sort = $("#protype_sort").val();


            if (rec_position.length < 1) {
                $(".adrec_position").show();
            } else if (rec_num.length < 1) {
                $(".adrec_num").show();
            } else if (rec_place.length < 1) {
                $(".adrec_place").show();
            } else if (protype_sort.length < 1) {
                $(".adprotype_sort").show();
            } else {
                $.post(url, admins, function (result) {

                    if (result.status == '4') {
                        dialog.success(result.message, success_url);
                    } else {
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