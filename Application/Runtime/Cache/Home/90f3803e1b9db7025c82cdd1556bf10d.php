<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>订单页</title>
</head>

<link rel="stylesheet" type="text/css" href="/Public/Airport/css/style.css">
<style type="text/css">
.order>.body>.nav{
	overflow: hidden;
}
.order>.body>.nav>ul>a>li{
	width: 33%;
	display:  block;
	float: left;
	color: #efc694;
	text-align: center;
}
.order>.body>.nav>ul>a>li>img{
	width: 33%;
	display: block;
	margin: 0 auto;
}
.order>.body>.list>h4{
	margin: 0;
	margin-left: 20px;
	color: #efc694;
}
.order>.body>.list>ul>a>li{
	overflow: hidden;
	background: rgba(53, 53, 53, 0.81);
	margin: 0 auto;
}
.order>.body>.list>ul>a>li>h5{
	border-bottom: 1px solid #5c5c5c;
	padding-left: 20px;
	margin: 0;
	overflow: hidden;
}
.order>.body>.list>ul>a>li>h5>span{
	color: #efc694;
	display: block;
	float: left;
	line-height: 40px;
}
.order>.body>.list>ul>a>li>h5>object>a{
	display: block;
	float: right;
	width: 70px;
	color: #fff;
	text-align: center;
	margin-top: 5px;
	margin-right: 20px;
	line-height: 20px;
	border-radius: 5px;
}
.order>.body>.list>ul>a>li>div{
	overflow: hidden;
	border-bottom: 1px solid #5c5c5c;
}
.order>.body>.list>ul>a>li>div>div{
	display: block;
	margin-left: 20px;
	width: 70%;
	margin-top: 10px;
}
.order>.body>.list>ul>a>li>div>div>p{
	margin: 0;
	font-size: 12px;
	line-height: 20px;
}
.order>.body>.list>ul>a>li>div>span{
	color: #efc694;
	display: block;
	float: right;
	margin-right: 20px;
}
.order>.body>.list>ul>.zwdd{
	color: #fff;
	background: rgb(53,53,53);
	text-align: center;
	line-height: 70px;
	margin: 0;
}
</style>
<body class="order">
<!-- 这里是头部 -->
<header class="cheader">
	<div>
		<p><img src="<?php echo ($_SESSION['information']['headimgurl']); ?>"></p>
	</div>
	<p>
		<span class="span1">
			<img src="/Public/Airport/images/icon/order-write.png">
				<?php if($o_state == 2): ?>待确认订单
					<?php elseif($o_state == 1): ?>
						待支付订单
					<?php elseif($o_state == ''): ?>
						全部订单
					<?php else: endif; ?>
		</span>
		<img class="dao" src="/Public/Airport/images/icon/dao.png">
	</p>
</header>

<!-- <p><a href="input.html">input</a></p> -->
<!-- 这里是身体 -->
<div class="body">
	<!-- 栏目1 -->
	<div class="nav">
		<ul>
			<a href="/Home/Airport/order?o_state=2&o_state&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/daiqueren.png"><span>待确认</span></li></a>
			<a href="/Home/Airport/order?o_state=1&o_state&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/pay.png"><span>待支付</span></li></a>
			<a href="/Home/Airport/order?o_state&o_state&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/order-copy.png"><span>全部订单</span></li></a>
		</ul>
	</div>

	<!-- 栏目2 -->
	<div class="list">
		<h4>机场订单</h4>
		<ul>
			<?php if($countfood == 0): ?><p class="zwdd">暂无订单</p>
				<?php else: ?>
				<?php if(is_array($orderfood)): $i = 0; $__LIST__ = $orderfood;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orderfood): $mod = ($i % 2 );++$i;?><li>
						<h5><span>订单号：<?php echo ($orderfood["order_sn"]); ?></span>

							<?php if($orderfood["o_state"] == 2): ?><object><a href="javascript:;" style="background: #E6602E;;">待确认</a></object>
								<?php elseif($orderfood["order_status"] == 1): ?>
								<object><a href="javascript:;" style="background: #8D0415;">待支付</a></object>
								<?php elseif($orderfood["order_status"] == 4): ?>
								<object><a href="javascript:;" style="background: #1D9A74;">已完成</a></object>
								<?php else: ?>
								<!--<object><a href="javascript:;" style="background: #838383;">已取消</a></object>--><?php endif; ?>
						</h5>
						<div>
							<div>
								<p><?php echo ($orderfood["type"]); ?></p>
								<p>订单数量：<?php echo ($orderfood["order_number"]); ?></p>
								<p>订单日期：<?php echo (date("Y-m-d H:i:s",$orderfood["addtime"])); ?></p>
							</div>
							<span>￥<?php echo ($orderfood["member_payme"]); ?></span>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</ul>
	</div>
</div>
<!-- 这里是底部 -->
<footer>
    <ul>
        <a href="/Home/Airport/index?openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/index.png"><span>首页</span></li></a>
        <a href="/Home/Airport/order/Home/Airport/order?o_state&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/order-copy2.png"><span>订单</span></li></a>
        <a href="/Home/Airport/center?openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/merber.png"><span>个人中心</span></li></a>
    </ul>
</footer>
</body>
</html>