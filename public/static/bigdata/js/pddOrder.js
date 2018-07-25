$(function () {

    //订单列表
    $("#submit_pddOrderList").on("click", function () {
        var platform_id = $(this).attr("platform_id");
        var that = this;
       
        PddOrderList(platform_id, that);
    })
    function PddOrderList(platform_id, that) {
        var progress_son = $(that).prev('.progress').find('.progress_son');
        var span = progress_son.find('span');
        var formData = new FormData();
        formData.append("file", $('.pddOrderList').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Pdd_order/OrderList',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            beforeSend: function (XMLHttpRequest) {
                //console.log(this);
                //alert('数据添加中');
                $("#inp").html("<font>正在获取数据中....</font><img src='/static/admin/images/Loading.gif' style='width:300px;'>");
            },
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.onprogress = function (progress) {
                        if (progress.lengthComputable) {
                            var Percentage = parseInt(progress.loaded / progress.total * 100);
                            progress_son.css("width", Percentage + "%");
                            span.text(Percentage + "%")
                            console.log(Percentage)
                        }
                    };
                    xhr.upload.onloadstart = function () {
                        console.log('started...');
                    };
                }
                return xhr;
            },
            success: function (result) {
                console.log(result.msg);
                $("#inp").html('');
            }
        });
    }


    //运单号
    $("#submit_pddWayBill").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        pddWayBill(platform_id);
    })
    function pddWayBill(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.pddWayBill').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Pdd_order/pddWayBill',
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

    //退款表
    $("#submit_pddRefund").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        pddRefund(platform_id);
    })
    function pddRefund(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.pddRefund').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Pdd_order/pddRefund',
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

    //小额打款
    $("#submit_pddSmallAmount").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        pddSmallAmount(platform_id);
    })
    function pddSmallAmount(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.pddSmallAmount').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Pdd_order/pddSmallAmount',
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

    //优惠券
    $("#submit_pddCoupon").on("click", function () {
        var platform_id = $(this).attr("platform_id")
        pddCoupon(platform_id);
    })
    function pddCoupon(platform_id) {
        var formData = new FormData();
        formData.append("file", $('.pddCoupon').get(0).files[0]);
        formData.append("type_id", platform_id);
        $.ajax({
            url: domainName + '/admin/Pdd_order/pddCoupon',
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

});