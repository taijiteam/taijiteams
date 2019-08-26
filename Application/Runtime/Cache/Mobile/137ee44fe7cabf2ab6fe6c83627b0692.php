<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
<link href="/favicon.ico" rel="shortcut icon">
<meta name="viewport" content="target-densitydpi=device-dpi, width=375px, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>渠道Plus - 商城</title>
<meta name="keywords" content="关键词">
<meta name="description" content="描述">
<link rel="stylesheet" href="/Public/Mobile/css/swiper.min.css" />
<link rel="stylesheet" href="/Public/Mobile/css/common.css?v=<?php echo ($versions); ?>" />
<link rel="stylesheet" href="/Public/Mobile/css/style.css?v=<?php echo ($versions); ?>" />
</head>
<body>

<div class="pb_tp_a">
    <h1>服务条款</h1>
    <!--<a href="javascript:history.go(-1);" class="pbjta"><img src="/Public/Mobile/images/01322.png"></a>-->
</div>

<div  class="tiaokuan container">
    <?php switch($memberInfo['m_groupname']): case "内部测试": ?><h1 style="color: #f9cf81;">消费积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>
            <!--<h1 style="margin-top: 50px;color: #f9cf81;">尊享积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>-->
            <h1 style="margin-top: 50px;color: #f9cf81;">奖励积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p><?php break;?>
        <?php case "尊享大咖": ?><h1 style="color: #f9cf81;">消费积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>
            <h1 style="margin-top: 50px;color: #f9cf81;">尊享积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>
            <!--<h1 style="margin-top: 50px;color: #f9cf81;">奖励积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>--><?php break;?>
        <?php case "悦享成员": ?><h1 style="color: #f9cf81;">消费积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>
            <!--<h1 style="margin-top: 50px;color: #f9cf81;">尊享积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>
            <h1 style="margin-top: 50px;color: #f9cf81;">奖励积分</h1>
            <p>1.开具发票需要您先进行确认收货。</p>
            <p>2.电子发票在订单完成后，在订单详情中下载和查看。</p>
            <p>3.如您下单时未选择开票，自然年内，仍可通过订单详情在收货后重新申请开票。</p>--><?php break; endswitch;?>
</div>

<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/jquery.SuperSlide.2.1.3.js"></script>
<script src="/Public/Mobile/js/all.js?v=<?php echo ($versions); ?>"></script>
</body>
</html>