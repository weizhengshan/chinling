<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/var/www/chinlingcloud/public/../application/admin/view/index/big_data.html";i:1531716683;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="__STATIC__/bigdata/css/public.css"/>
    <link rel="stylesheet" href="__STATIC__/bigdata/css/common.css"/>
    <link rel="stylesheet" href="__STATIC__/bigdata/css/backstageDataManagement.css"/>
    <script src="__STATIC__/bigdata/js/jquery-1.8.3.min.js"></script>
    <script src="__STATIC__/bigdata/js/index.js"></script>
    <script src="__STATIC__/bigdata/js/taobao.js"></script>
    <script src="__STATIC__/bigdata/js/pddOrder.js"></script>
</head>
<body>

<div id="nav" class="clear">
    <ul class="float_l">
        <h3>导航菜单</h3>
        <li><span class="nav_span kai" _attr="0">平台管理</span>
            <ol>
                <li class="switch onA" _id="0">
                    平台管理
                </li>
            </ol>
        </li>

        <li><span class="nav_span" _attr="0">数据上传</span>
            <ol class="platform_data" style="display: none;">

            </ol>
        </li>
    </ul>
    <ul class="float_r">
        <li class="float_r_li main_0">
            <h5>
                平台管理<a class="add">添加分类</a><a class="goBack" style="display: none;">返回</a>
            </h5>
            <div class="platform_div">
                <div class="tableBasic">
                    <h6>
                        <span>名称</span>
                        <span>编号</span>
                        <span>简单描述</span>
                        <span>排序</span>
                        <span>操作</span>
                    </h6>
                    <ul class="platformList">

                    </ul>
                </div>

                <div class="data_type"  style="display: none;">
                    <table>
                        <tr>
                            <td align="center">名称</td>
                            <td align="left"><input class="name" type="text"/></td>
                        </tr>
                        <tr>
                            <td align="center">上级分类</td>
                            <td align="left">
                                <select id="classification" class="classification">

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">简单描述</td>
                            <td align="left"><input class="describe" type="text"/></td>
                        </tr>
                        <tr>
                            <td align="center">排序</td>
                            <td align="left"><input class="sort" type="text"/></td>
                        </tr>
                        <tr>
                            <td><input class="hidden" type="hidden" value=""/></td>
                            <td align="left"><a class="submit">提交</a></td>
                        </tr>
                    </table>
                </div>
            </div>

        </li>
        <!--
            作者：976795114@qq.com
            时间：2018-05-11
            描述：淘宝
        -->
        <li class="float_r_li float_r_li_main main_2" style="display: none;">
            <h5>数据上传 <span></span></h5>
            <div class="upload_div">
                <form id="uploadTao" action="##" method="post" enctype="multipart/form-data">
                    <div class="div_float">
                        <h4>订单数据</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file tbOrderList" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_tbOrderList">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>已双评的订单</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file tbOrderOver" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_tbOrderOver">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>商品分类数据</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file tbOrderType" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_tbOrderType">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>评论</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file tbOrderEvaluate" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_tbOrderEvaluate">上传</a>
                    </div>
                    <div id="inp"></div>
                </form>
            </div>
        </li>
        <!--
            作者：976795114@qq.com
            时间：2018-05-11
            描述：拼多多
        -->
        <li class="float_r_li float_r_li_main main_3" style="display: none;">
            <h5>数据上传 <span></span></h5>
            <div class="upload_div">
                <form id="uploadPdd" action="##" method="post" enctype="multipart/form-data">
                    <div class="div_float">
                        <h4>订单表</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file pddOrderList" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_pddOrderList">上传</a>

                    </div>
                    <div class="div_float">
                        <h4>运单号</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file pddWayBill" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_pddWayBill">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>退款表</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file pddRefund" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_pddRefund">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>小额打款</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text"  class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file pddSmallAmount" value=""/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_pddSmallAmount">上传</a>
                    </div>
                    <div class="div_float">
                        <h4>优惠券结算</h4>
                        <div class="file_div">
                            <span>上传文件：</span>
                            <input type="text" class="input_file_name" readonly="readonly"/>
                            <input type="file" name="" class="input_file pddCoupon" value="66666"/>
                            <i>浏览</i>
                        </div>
                        <div class="progress">
                            <div class="progress_son"><span></span></div>
                        </div>
                        <a id="submit_pddCoupon">上传</a>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</div>
</body>
</html>
<script type="text/javascript" src="__STATIC__/bigdata/js/backstageDataManagement.js"></script>