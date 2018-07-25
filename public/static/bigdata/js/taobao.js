$(function () {
    //订单列表
    $("#submit_tbOrderList").on("click", function () {
        var platform_id = $(this).attr("platform_id");
        tbOrderList(platform_id);
    })
    function tbOrderList(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.tbOrderList').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Upload_tao/OrderList',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            beforeSend: function (XMLHttpRequest) {
                //console.log(this);
                //alert('数据添加中');
                $("#inp").html("<font>正在获取数据中....</font><img src='__STATIC__/admin/images/Loading.gif' style='width:300px;'>");
            },
            success: function (result) {
                console.log(result.msg);
                $("#inp").html('');
            }
        });
    }

    //订单分类
    $("#submit_tbOrderType").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        tbOrderType(platform_id);
    })
    function tbOrderType(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.tbOrderType').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Upload_tao/OrderType',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            beforeSend: function (XMLHttpRequest) {
                //console.log(this);
                //alert('数据添加中');
                $("#inp").html("<font>正在获取数据中....</font><img src='__STATIC__/admin/images/Loading.gif' style='width:300px;'>");
            },
            success: function (result) {
                dialog.error(result.msg);
                $("#inp").html('');
            }
        });
    }

    //评价
    $("#submit_tbOrderEvaluate").on("click", function () {
        var platform_id = $(this).attr("platform_id");
        tbOrderEvaluate(platform_id);
    })
    function tbOrderEvaluate(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.tbOrderEvaluate').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Upload_tao/OrderEvaluate',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            beforeSend: function (XMLHttpRequest) {
                //console.log(this);
                //alert('数据添加中');
                $("#inp").html("<font>正在获取数据中....</font><img src='__STATIC__/admin/images/Loading.gif' style='width:300px;'>");
            },
            success: function (result) {
                console.log(result.msg);
                $("#inp").html('');
            }
        });
    }

    //已双评
    $("#submit_tbOrderOver").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        tbOrderOver(platform_id);
    })
    function tbOrderOver(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.tbOrderOver').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Upload_tao/OrderOver',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            beforeSend: function (XMLHttpRequest) {
                //console.log(this);
                //alert('数据添加中');
                $("#inp").html("<font>正在获取数据中....</font><img src='__STATIC__/admin/images/Loading.gif' style='width:300px;'>");
            },
            success: function (result) {
                dialog.error(result.msg);
                $("#inp").html('');
            }
        });
    }

});