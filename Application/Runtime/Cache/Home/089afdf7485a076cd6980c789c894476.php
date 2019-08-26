<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>个人信息</title>
</head>
<link rel="stylesheet" type="text/css" href="/Public/Airport/css/style.css">
<style type="text/css">
.infor>.body>div{
	width: 80%;
	margin: 35px auto;
	border: 1px solid #efc694;
	border-radius: 10px;
}
.infor>.body>div>p{
	width: 95%;
	border-bottom: 1px solid rgb(97, 76, 34);
	line-height: 30px;
	overflow: hidden;
	margin: 13px auto;
}
.infor>.body>div>p>.span1{
	display: block;
	float: left;
	text-align: right;
	width: 30%;
	color: #efc694;
	font-size: 14px;
}
.infor>.body>div>p>.span2{
	color: #fff;
	display: block;
	float: left;
	width: 70%;
	font-size: 14px;
}
</style>
<body class="infor">
<!-- 这里是头部 -->
<header class="cheader">
	<div>
		<p><img src="/Public/Airport/images/qinziyou.jpg"></p>
	</div>
	<p>
		<span class="span1"><img src="/Public/Airport/images/icon/infor.png">张三</span>
		<img class="dao" src="/Public/Airport/images/icon/dao.png"><!-- <span class="span2"></span> --></p>
</header>
<!-- 这里是身体 -->
<div class="body">
	<!-- 栏目1 -->
	<div>
		<p><span class="span1">姓名：</span><span class="span2"><?php echo ($conven_1['data'][0]['TrueName']); ?></span></p>
		<p><span class="span1">性别：</span><span class="span2"><?php if($conven_1['data'][0]['Sex'] == 1): ?>先生<?php else: ?>女士<?php endif; ?></span></p>
		<p><span class="span1">年龄：</span><span class="span2"><?php echo ($age); ?></span></p>
		<p><span class="span1">生日：</span><span class="span2"><?php echo ($conven_1['data'][0]['Birthday']); ?></span></p>
		<p><span class="span1">联系电话：</span><span class="span2"><?php echo ($conven_1['data'][0]['Mobile']); ?></span></p>
		<p><span class="span1">住宅地址：</span><span class="span2"><?php echo ($conven_1['data'][0]['Address']); ?></span></p>
	</div>
</div>
<!-- 这里是底部 -->
<footer>
	<ul>
		<a href="index.html"><li><img src="/Public/Airport/images/icon/index.png"><span>首页</span></li></a>
		<a href="order.html"><li><img src="/Public/Airport/images/icon/order-copy2.png"><span>订单</span></li></a>
		<a href="center.html"><li><img src="/Public/Airport/images/icon/merber.png"><span>个人中心</span></li></a>
	</ul>
</footer>
</body>
</html>