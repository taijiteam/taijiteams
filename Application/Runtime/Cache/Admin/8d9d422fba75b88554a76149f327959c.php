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

    <button class="layui-btn" id="export" style="float: right"><i class="layui-icon"></i>导出全部积分</button>
    <button class="layui-btn" id="export1" style="float: right;background: red;margin-right: 15px"><i class="layui-icon"></i>导出返利积分</button>
    <button class="layui-btn" id="export2" style="float: right;background: #e1b571"><i class="layui-icon"></i>导出消费积分</button>
</div>
<div class="x-body">
    <div class="layui-collapse" lay-filter="test">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">展开搜索框</h2>
            <div class="layui-colla-content">
                <form method="post" action="/Admin/Order/search?source=商城" class="layui-form layui-col-md12 x-so" >
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
                                <option value="消费积分">消费积分</option>
                                <option value="返利积分">返利积分</option>
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
            <th>订单编号</th>
            <th>付款人</th>
            <th>商品名称</th>
            <th>消费积分</th>
            <th>下单返利积分</th>
            <th>支付方式</th>
            <th>下单时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($consumption)): $k = 0; $__LIST__ = $consumption;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                <td id="order_sn"><?php echo ($vo["order_sn"]); ?></td>
                <td id="member_name"><?php echo ($vo["member_name"]); ?>:<?php echo ($vo["member_mobile"]); ?></td>
                <td id="goods_name"><?php echo ($vo["goods_name"]); ?></td>
                <?php if($vo["pocket_act"] == '1'): if($vo["pocket_type"] == '1'): ?><td>尊享积分-<?php echo ($vo["pocket_value"]); ?></td>
                        <?php elseif($vo["pocket_type"] == '201'): ?>
                        <td>消费积分-<?php echo ($vo["pocket_value"]); ?></td>
                        <?php elseif($vo["pocket_type"] == '202'): ?>
                        <td>消费积分-<?php echo ($vo["pocket_value"]); ?></td>
                        <?php elseif($vo["pocket_type"] == '3'): ?>
                        <td>金币积分-<?php echo ($vo["pocket_value"]); ?></td>
                        <?php elseif($vo["pocket_type"] == '4'): ?>
                        <td>奖励积分-<?php echo ($vo["pocket_value"]); ?></td>
                        <?php else: ?>
                        <td></td><?php endif; ?>
                    <?php else: ?>
                    <td></td><?php endif; ?>
                <?php if($vo["pocket_act"] == '0'): ?><td>消费积分返利+<?php echo ($vo["pocket_value"]); ?></td>
                    <?php else: ?>
                    <td></td><?php endif; ?>
                <td style="color: #1aad19">微信支付</td>
                <td id="addtime"><?php echo (date( "Y-m-d H:i:s",$vo["addtime"])); ?></td>
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
        $(function () {
            $('#export').click(function () {
                window.location.href = "/Admin/Sort/export?order_type=3";
            });
            $('#export1').click(function () {
                window.location.href = "/Admin/Sort/export?order_type=1";
            });
            $('#export2').click(function () {
                window.location.href = "/Admin/Sort/export?order_type=2";
            })
        })
    </script>
<script>
    var _hmt = _hmt || []; (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();
</script>
</body>

</html>