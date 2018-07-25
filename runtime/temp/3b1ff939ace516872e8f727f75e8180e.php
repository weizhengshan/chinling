<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/var/www/chinlingcloud/public/../application/index/view/products/index.html";i:1510651644;s:65:"/var/www/chinlingcloud/public/../application/index/view/base.html";i:1510803549;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<title>陕西秦岭云电子商务有限公司</title>
		<link rel="shortcut icon" href="<?php echo $logo[3]; ?>" type="image/x-icon">
		<meta name="keywords" content="<?php echo $web['site']; ?>">
		<meta name="description" content="<?php echo $web['describe']; ?>">
		<meta name="author" content="陕西秦岭云电子商务有限公司"/>
		<link href="__STATIC__/index/css/public.css" rel="stylesheet" />
		<link href="__STATIC__/index/css/common.css" rel="stylesheet" />
	    <link rel="stylesheet" href="__STATIC__/index/css/swiper.min.css"/>
	    <link rel="stylesheet" href="__STATIC__/index/css/animate.min.css">
		<script src="__STATIC__/index/js/jquery-1.8.3.min.js"></script>
	</head>
	<body>		
        <div id='header' class='clear'>
			<div class='header_logo'>
				<span class='header_nav_hide'>＝</span>
				<a href="<?php echo url('index/index/index'); ?>">
					<img src='<?php echo $logo[0]; ?>'/>
				</a>
			</div>
			<div class='header_nav'>
				<ul class='clear'>
					<!-- <li class='index_nav'><a href='index.html'>首页</a></li> -->
      				 <?php if(is_array($topdata) || $topdata instanceof \think\Collection || $topdata instanceof \think\Paginator): $i = 0; $__LIST__ = $topdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<li <?php if($pid == $vo['type_id']): ?> class='companyIntroduction_nav xuan' <?php endif; ?>>
						<a href="<?php echo url($vo['action'],['type_pid'=>$vo['type_id']]); ?>"><?php echo $vo['type_name']; ?></a>
						<?php if($vo['typeson']!= false): ?>
						<div class="er_nav">
							<dl class="companyIntroduction_nav_erji">
								<dt></dt>
								<?php if(is_array($vo['typeson']) || $vo['typeson'] instanceof \think\Collection || $vo['typeson'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['typeson'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($i % 2 );++$i;?>
								<dd><a href="<?php echo url($vo['action'],['type_pid'=>$vo['type_id'],'wen_id'=>$son['type_id']]); ?>"><?php echo $son['type_name']; ?></a></dd>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</dl>
						</div>
						<?php endif; ?>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<!-- 店铺链接1 -->
					<?php if(is_array($shopdata) || $shopdata instanceof \think\Collection || $shopdata instanceof \think\Paginator): $i = 0; $__LIST__ = $shopdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shop): $mod = ($i % 2 );++$i;?>
					<li class="shangpu_hide" >
						<a <?php if($shop['action']==false): ?> href='#' <?php else: ?> href='<?php echo $shop['action']; ?>'  <?php endif; if($shop['action']==false): ?> class="no" <?php endif; ?> ><?php echo $shop['type_name']; ?></a>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>				
			</div>
			<div class='header_shangpu_show'>
				<!-- 店铺链接2 -->
				<?php if(is_array($shopdata) || $shopdata instanceof \think\Collection || $shopdata instanceof \think\Paginator): $i = 0; $__LIST__ = $shopdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shop): $mod = ($i % 2 );++$i;?>
					<a <?php if($shop['action']==false): ?> href='#' <?php else: ?> href='<?php echo $shop['action']; ?>'  target="_blank"<?php endif; if($shop['action']==false): ?> class="no"  <?php endif; ?> ><?php echo $shop['type_name']; ?></a>
					<span>|</span>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			
        </div>
		<div class='shangpu'>
			<!-- 店铺链接3 -->
			<?php if(is_array($shopdata) || $shopdata instanceof \think\Collection || $shopdata instanceof \think\Paginator): $i = 0; $__LIST__ = $shopdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shop): $mod = ($i % 2 );++$i;?>
			<a <?php if($shop['action']==false): ?> href='#' <?php else: ?> href='<?php echo $shop['action']; ?>'  target="_blank"<?php endif; if($shop['action']==false): ?> class="no" <?php endif; ?> ><?php echo $shop['type_name']; ?></a>
			<?php endforeach; endif; else: echo "" ;endif; ?>
	 	</div>		

		<div class="rm-container">	      	
	        <nav class="rm-nav">
	            <ul class="frist_ul">
	            	<?php if(is_array($protype) || $protype instanceof \think\Collection || $protype instanceof \think\Paginator): $i = 0; $__LIST__ = $protype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                <li><a href="<?php echo url('index/products/index',['types_pid'=>$vo['protype_id']]); ?>"><?php echo $vo['protype_name']; ?></a>	
	                    <dl class="second_ul">
	                    	<?php if(is_array($vo['proson']) || $vo['proson'] instanceof \think\Collection || $vo['proson'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['proson'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($i % 2 );++$i;?>
	                        <a href="<?php echo url('index/products/index',['types_pid'=>$vo['protype_id'],'wen_id'=>$son['protype_id']]); ?>"><dd><?php echo $son['protype_name']; ?>

	                           <!-- 三级分类 <div class="three_ul">
	                               <div><a href="#">Sub Sub Item 1</a></div>
	                               <div><a href="#">Sub Sub Item 2</a></div>	                              
	                           </div>  -->
	                        </dd></a>
	                        <?php endforeach; endif; else: echo "" ;endif; ?>
	                    </dl>	                   
	                </li>
	            	<?php endforeach; endif; else: echo "" ;endif; ?>
	            </ul>
	        </nav>
	    </div>	    
	    <div class="productlist">
			<?php if($proson != NULL): ?>
			<ul>
			         <?php if(is_array($proson) || $proson instanceof \think\Collection || $proson instanceof \think\Paginator): $i = 0; $__LIST__ = $proson;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($i % 2 );++$i;?>
							<li>						
								<div><img src="<?php echo $son['prod_img']; ?>"/></div>
								<div>
									<h3><?php echo $son['prod_title']; ?></h3>
								</div>					
							</li>	
						
					 <?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>		 	
			<div class="pages">
        		<h3>
        						<span><a href="<?php echo url('index/products/index',['page'=>1,'type_pid'=>$type_pid,'wen_id'=>$wenid]); ?>">首页</a></span>
        						<?php if($page==1 || $page<'1'): else: ?>
			        			<span><a href="<?php echo url('index/products/index',['page'=>$page-1,'type_pid'=>$type_pid,'wen_id'=>$wenid]); ?>">上一页</a></span>
			        			<?php endif; ?>
			        			<span>第<b><?php echo $page; ?></b>页</span>
			        			<span>共<b><?php echo $maxPage; ?></b>页</span>
			        			<?php if($maxPage==$page || $maxPage<$page): else: ?>
			        			<span><a href="<?php echo url('index/products/index',['page'=>$page+1,'type_pid'=>$type_pid,'wen_id'=>$wenid]); ?>">下一页</a></span>
			        			<?php endif; ?>
			        			<span><a href="<?php echo url('index/products/index',['page'=>$maxPage,'type_pid'=>$type_pid,'wen_id'=>$wenid]); ?>">尾页</a></span>        			
        		</h3>
        	</div>
        	<?php else: ?>
        	<div class="nolist">	
					<div>
						<img src="__STATIC__/index/img/erweima_1.jpg"/>
						<h3>暂无内容</h3>
					</div>
			</div>
			<?php endif; ?>
	    </div>
    

<!--底部的开始-->
<div id="footer_out">
	<div id="footer" class="clear">
		<a class="goTop" onclick="pageScroll()">返回顶部</a>
		<div class="footer">
			<div class="footer_t">
				<div class="link">
					<?php if(is_array($bottomdata) || $bottomdata instanceof \think\Collection || $bottomdata instanceof \think\Paginator): $i = 0; $__LIST__ = $bottomdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bottom): $mod = ($i % 2 );++$i;?>
					<a  <?php if($bottom['action']==false): ?> class="weixin" <?php else: ?> href="<?php echo url($bottom['action'],['type_pid'=>$bottom['type_id']]); ?>"  <?php endif; ?> ><?php echo $bottom['type_name']; ?></a>
					<i class="cut">|</i>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<a  href="<?php echo $weibodata['action']; ?>" target="_blank"><?php echo $weibodata['type_name']; ?></a>
				</div>
			</div>
			<div class="footer_b">
				<div class="copyright">
					<em>
					<?php echo $website['icp']; ?>
					</em>
			
				</div>
			</div>
		</div>
		<div class="sm">
			<div class="sm_erweima">
				<img src="<?php echo $logo[1]; ?>">
				<h3>关注微信</h3>
			</div>
			<div class="sm_erweima">
				<img src="<?php echo $logo[2]; ?>">
				<h3>关注微博</h3>
			</div>
		</div>
		<div class="footer_num">
				<h6>
					<span>联系电话：</span>
					<span class="phone"><?php echo $website['phone']; ?></span>
				</h6>
				<h6>
					<span>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：</span>
					<span class="dizhi"><?php echo $website['address']; ?></span>
				</h6>
				<!--<h6>
					<span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：</span>
					<span class="youxiang"><?php echo $website['email']; ?></span>
				</h6>
				<h6>
					<span>q&nbsp;&nbsp;&nbsp;q&nbsp;&nbsp;&nbsp;号：</span>
					<span class="qqhao"><?php echo $website['qq']; ?></span>
				</h6>-->
				
		</div>			
	</div>
</div>
		<div class="bg-marker"></div>
		<div class="weixin-layout">				
			<img class="erweima weixin_erweima" src="<?php echo $logo[1]; ?>"/>
			<h4 class="ui-btn">
				<a class="weixin-back" href="javascript:;">返回</a>
			</h4>
		</div>	
		<div class="weixin-layout qidai" style="display: none;">				
			<img class="erweima weixin_erweima" src="__STATIC__/index/img/timg.jpg"/>
			<h4 class="ui-btn">
				<a class="weixin-back" href="javascript:;">返回</a>
			</h4>
		</div>	
	</body>
</html>
<script src="__STATIC__/index/js/swiper.animate1.0.2.min.js"></script>
<script src="__STATIC__/index/js/swiper-3.4.2.min.js"></script>
<script src="__STATIC__/index/js/common.js"></script>	
<script src="__STATIC__/admin/dialog/dialog/layer.js"></script>
<script src="__STATIC__/admin/dialog/dialog.js"></script>
<script src="__STATIC__/index/js/index.js"></script>
<script src="__STATIC__/index/js/newslist.js"></script>	
<script src="__STATIC__/index/js/newsdetails.js"></script>	
<script src="__STATIC__/index/js/companyIntroduction.js"></script>	
<script src="__STATIC__/index/js/products.js"></script> 
