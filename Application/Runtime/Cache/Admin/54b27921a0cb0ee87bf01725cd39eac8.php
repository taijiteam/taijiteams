<?php if (!defined('THINK_PATH')) exit();?><html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
<title>渠道plus微管家</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
<link rel="stylesheet" href="/Public/Admin/css/font.css">
<link rel="stylesheet" href="/Public/Admin/css/xadmin.css">
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Admin/js/xadmin.js"></script>
<script type="text/javascript" src="/Public/Admin/js/cookie.js"></script>
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
<script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
<script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<style>
    .layui-row-search input{
        margin-bottom: 30px;
        width: 256px;
        height: 40px;
    }
    .layui-input-inline{
        width: 200px;
        margin-right: 30px;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
</div>
<div class="x-body">
    <div class="layui-collapse" lay-filter="test">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">展开搜索框</h2>
            <div class="layui-colla-content">
                <form method="post" action="/Admin/Order/activitySearch?source=活动" class="layui-form layui-col-md12 x-so" >
                    <div class="layui-row">
                            <input type="text" name="mobile" placeholder="请输入收货人手机号" autocomplete="off" class="layui-input">

                            <input type="text" name="order_sn" placeholder="请输入收货人订单号" autocomplete="off" class="layui-input">

                        <!--<div class="layui-input-inline">
                            <select id="pay" name="pay" autocomplete="off" class="layui-input">
                                <option value="">请选择支付方式</option>
                                <option value="微信支付">微信支付</option>
                                <option value="支付宝支付">支付宝支付</option>
                                <option value="POS机支付">POS机支付</option>
                                <option value="银行卡转账">银行卡转账</option>
                            </select>
                        </div>-->
                        <div class="layui-input-inline">
                            <select id="audit" name="audit" autocomplete="off" class="layui-input">
                                <!--<option value=" ">请选择订单状态</option>-->
                                <option value="交易完成">交易完成</option>
                                <option value="驳回审核">驳回审核</option>
                            </select>
                        </div>
                        <input  type="submit" class="layui-btn layui-btn-lg " lay-filter="add" lay-submit="" value="查找">
                    </div>
                </form>
            </div>
        </div>

    <!--<xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','<?php echo U('Index/memberAdd');?>',700,600)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<span style="color: red"><?php echo ($count); ?></span> 条</span>
    </xblock>-->
    <table class="layui-table x-admin">
        <thead>
        <tr>
            <th></th>
            <th>订单编号</th>
            <th>付款人</th>
            <th>商品名称</th>
            <th>支付金额</th>
            <th>支付状态</th>
            <th>支付方式</th>
            <th>下单时间</th>
            <th style="text-align: center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($orderList)): $k = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                <td>
                    <input type="checkbox" name="" lay-skin="primary"></td>
                <td><?php echo ($vo["o_number"]); ?></td>
                <td><?php echo ($vo["o_name"]); ?>:<?php echo ($vo["o_phone"]); ?></td>
                <td><?php echo ($vo["o_cate"]); ?></td>
                <td><?php echo ($vo["o_price"]); ?></td>
                <?php if($vo["o_state"] == 7): ?><td style="background-color: 	#C3C3C3">驳回审核</td>
                    <?php elseif($vo["o_state"] == 4): ?><td style="background-color: rgba(4,174,115,0.42)">交易完成</td>
                    <?php else: ?><td></td><?php endif; ?>
                <!--<?php if($vo["order_status"] == 2): ?><td style="background-color: #FFA54F">待发货</td>
                    <?php elseif($vo["order_status"] == 3): ?><td style="background-color: #CCCCCC">待发货</td>
                    <?php elseif($vo["order_status"] == 4): ?><td style="background-color: #7FFFD4">已收货</td>
                    <?php elseif($vo["order_status"] == 9): ?><td>已取消</td>
                    <?php elseif($vo["order_status"] == 1): ?><td></td>
                    <?php else: ?><td></td><?php endif; ?>-->
                <td style="color: #1aad19">微信支付</td>
                <!--<td title="<?php echo ($vo["deliver_address"]); ?>"><?php echo (subtext($vo["deliver_address"],10)); ?></td>-->
                <td><?php echo ($vo["o_time"]); ?></td>
                <td class="td-manage" style="font-size: 14px;">
                    <!--<a title="审核" href="/Admin/Order/detail/?order_id=<?php echo ($vo["order_id"]); ?>">-->
                    <a title="审核" href="javascript:;" onclick="x_admin_show('审核','/Admin/Order/audit?order_id=<?php echo ($vo["o_id"]); ?>&source=活动',450,350)">
                        <img src="/Public/Admin/images/audit.png" alt="" style="width: 40px">
                        <!--<span style="display:block;position: absolute;font-size: 10px;">审核</span>-->
                    </a>
<!--                    <span>&nbsp;&nbsp;&nbsp;  |  &nbsp;&nbsp;&nbsp;</span>-->
<!--                    <a title="反审核" onclick="order_del(this,'<?php echo ($vo["order_id"]); ?>')" href="javascript:;">-->
<!--                        <img src="/Public/Admin/images/backtrack.png" alt="" style="width: 31px">-->
<!--                    </a>-->
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div class="page">
        <div>
            <?php echo ($page); ?>
        </div>
    </div>

</div>
<script>
    $("#btn").click(function () {
        //var pay         = $("#pay option:checked").val();		//支付方式
        var audit       = $("#audit option:checked").val();		//订单状态
        var mobile      = $('input[name="mobile"]').val();		//服务经理
        var order_sn    = $('input[name="order_sn"]').val();	//服务经理
        console.log(order_sn);
        $.ajax({
            url : "/Admin/Order/search?source=活动",
            type: "post",
            data:{
                //pay         : pay,
                audit       : audit,
                mobile      : mobile,
                order_sn    : order_sn,
            },
            dataType: "json",
            success:function (res) {
                if (res.code == "200"){
                    alert('11');
                }else{
                    alert(res.message);
                }
            }
        })
    })
</script>



<script>var _hmt = _hmt || []; (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();
</script>
</body>

</html>