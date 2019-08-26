<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>个人中心</title>
</head>

<link rel="stylesheet" type="text/css" href="/merber_all_show/Public/Activity/css/style.css">
<link rel="stylesheet" type="text/css" href="/merber_all_show/Public/Activity/css/ertaostyle.css">
<style type="text/css">

</style>
<body class="center">
<!-- 这里是头部 -->
<header class="cheader">
	<div>
		<!-- <p><img src="/merber_all_show/Public/Project/image/kai.png"></p> -->
		<p><img src="<?php echo ($_SESSION['information']['headimgurl']); ?>"></p>
	</div>
	<p><span class="span1"><img src="/merber_all_show/Public/Project/image/center1.png"><?php echo ($_SESSION['infor']['data'][0]['MemberGroupName']); ?></span><img class="dao" src="/merber_all_show/Public/Project/image/dao.png"><!-- <span class="span2"></span> --></p>
</header>
<!-- 这里是身体 -->
<div class="body">
	<!-- 栏目1 -->
	<ul>
		<a href="<?php echo U('Activity/information');?>?openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/merber_all_show/Public/Project/image/hyxx.png">成员信息</li></a>
		<a href="<?php echo U('Activity/actorder');?>?cardid=<?php echo ($_SESSION['cardId']); ?>"><li><img src="/merber_all_show/Public/Project/image/wddd.png">活动报名</li></a>
		<a href="<?php echo U('Activity/collec');?>?cardid=<?php echo ($_SESSION['cardId']); ?>"><li><img src="/merber_all_show/Public/Project/image/wdsc.png">我的收藏</li></a>
		<a href="<?php echo U('Activity/order2');?>?cardid=<?php echo ($_SESSION['cardId']); ?>"><li><img src="/merber_all_show/Public/Project/image/yjfk.png">我的需求</li></a>
		<a href="tellme.html"><li><img src="/merber_all_show/Public/Project/image/lxwm.png">联系我们</li></a>
	</ul>
</div>
<!-- 这里是底部 -->
<footer>
	<ul>
		<!--<a href="<?php echo U('Activity/index');?>?phone=<?php echo ($_SESSION['infor']['data'][0]['Mobile']); ?>"><li><img src="/merber_all_show/Public/Activity/images/icon/index.svg"><span>首页</span></li></a>-->
		<a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22"><li><img src="/merber_all_show/Public/Activity/images/icon/index.svg"><span>首页</span></li></a>
		<a href="javascript:;" onclick="modaldemo()"><li><img src="/merber_all_show/Public/Activity/images/icon/sousuo.svg"><span>搜索</span></li></a>
		<a href="<?php echo U('Activity/center');?>?phone=<?php echo ($_SESSION['infor']['data'][0]['Mobile']); ?>"><li><img src="/merber_all_show/Public/Activity/images/icon/my.svg"><span>我的</span></li></a>
	</ul>
</footer>
<style type="text/css">
.modal-body{
	overflow: hidden;
}
.modal-body>input{
	-webkit-appearance: none;/*兼容苹果手机*/
	line-height: 30px;
	display: block;
	margin: auto;
	font-size: 14px;
}
.suuure{
	-webkit-appearance: none;/*兼容苹果手机*/
	font-size: 15px;
	color: #fff;
	background-color: #009688;
	border-color: #009688;
	display: inline-block;
	box-sizing: border-box;
	cursor: pointer;
	text-align: center;
	font-weight: 400;
	white-space: nowrap;
	vertical-align: middle;
	border: solid 1px #ddd;
	width: auto;
	-webkit-transition: background-color .1s linear;
	-moz-transition: background-color .1s linear;
	-o-transition: background-color .1s linear;
	transition: background-color .1s linear;
}
.modal-header .close {
	position: absolute;
	right: 15px;
	top: 15px;
	padding: 0 5px;
	background: #f95c5c;
}
.btn{
	font-size: 15px;
}
</style>
<!--普通弹出层-->
<form action="<?php echo U('Activity/search');?>" method="post" style="overflow: hidden;" class="search">
<div id="modal-demo" class="modal fade middle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content radius">
			<div class="modal-header">
				<h3 class="modal-title">搜索</h3>
				<a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
			</div>
			<div class="modal-body">

					<input type="text" class="sousuo" name="keywords" class="text" placeholder="请输入"/>

			</div>
			<div class="modal-footer">
				<input type="submit" value="确定" class="suuure" />
				<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
			</div>
		</div>
	</div>
</div>
</form>
<link rel="stylesheet" type="text/css" href="/merber_all_show/Public/Project/css/H-ui.min.css" />
<script type="text/javascript" src="/merber_all_show/Public/Project/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/merber_all_show/Public/Project/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/merber_all_show/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript">
function modaldemo(){
	$("#modal-demo").modal("show");
}
</script>
</body>
</html>