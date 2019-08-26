<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title><?php if($cate==''): echo ($catetime); else: echo ($cate); endif; ?></title>
<link rel="stylesheet" type="text/css" href="/Public/Activity/css/default.css">
<link rel="stylesheet" href="/Public/Activity/css/jflex.min.css" type="text/css" media="all">
<link href="http://fonts.useso.com/css?family=Roboto:400,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/Public/Activity/css/idangerous.swiper.css">
<link rel="stylesheet" type="text/css" href="/Public/Activity/css/ertaostyle.css">
<script src="/Public/Activity/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/Public/Activity/js/comm.js"></script>
</head>
<style type="text/css">

</style>
<body class="list">
<div class="banner">
	<ul class="slides">
		<li>
			<img alt="" src="/Public/Activity/images/icon/baner1.jpg">
		</li>
		<li>
			<img alt="" src="/Public/Activity/images/icon/baner3.jpg">
		</li>
		<li>
			<img alt="" src="/Public/Activity/images/icon/baner2.jpg">
		</li>
		<li>
			<img alt="" src="/Public/Activity/images/icon/baner4.jpg">
		</li>
	</ul>
</div>
<div class="body">
	<div class="title">
		<h4><?php if($cate==''): echo ($catetime); else: echo ($cate); endif; ?></h4>
		<ul id="starlist">
			<li><a href="<?php echo U('Activity/list_act');?>?category=活动&catetime=往期活动">全部</a></li>
			<li><a href="<?php echo U('Activity/list_act');?>?category=活动&catetime=往期活动&cate=酒会">酒会</a></li>
			<li><a href="<?php echo U('Activity/list_act');?>?category=活动&catetime=往期活动&cate=论坛">论坛</a></li>
			<li><a href="<?php echo U('Activity/list_act');?>?category=活动&catetime=往期活动&cate=沙龙">沙龙</a></li>
		</ul>
	</div>
	<!--<p><a class="week">最近一周</a><a class="month">最近一月</a></p>-->
	<ul class="liebiao">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Activity/content');?>?id=<?php echo ($list["a_id"]); ?>&category=<?php echo ($list["a_category"]); ?>&cardid=<?php echo ($_SESSION['cardId']); ?>">
				<li>
					<span><img src="/Public/Uploads/Activity/<?php echo ($list["a_img"]); ?>"></span>
					<div>
						<p class="title"><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($list["a_title"])),0,30,'utf-8')); ?></p>
						<p><span class="time"><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($list["a_start"])),0,10,'utf-8')); ?>~<?php echo (mb_substr(strip_tags(htmlspecialchars_decode($list["a_end"])),0,10,'utf-8')); ?></span></p>
						<p>
							<span class="address"><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($list["a_address"])),0,4,'utf-8')); ?></span>
							<?php if($list["a_price"] == ''): ?><span class="rmb">免费</span><?php else: ?>
								<span class="rmb">￥<?php echo ($list["a_price"]); ?>起</span><?php endif; ?>
							<?php if($catetime == 最新活动): ?><object><a href="<?php echo U('Activity/actappoint');?>?id=<?php echo ($list["a_id"]); ?>">立即报名</a></object>
								<?php else: endif; ?>
						</p>
					</div>
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<footer>
	<ul>
		<!--<a href="<?php echo U('Activity/index');?>?phone=<?php echo ($_SESSION['infor']['data'][0]['Mobile']); ?>"><li><img src="/Public/Activity/images/icon/index.svg"><span>首页</span></li></a>-->
		<a href="/Home/Home/home"><li><img src="/Public/Activity/images/icon/index.svg"><span>首页</span></li></a>
		<a href="javascript:;" onclick="modaldemo()"><li><img src="/Public/Activity/images/icon/sousuo.svg"><span>搜索</span></li></a>
		<a href="<?php echo U('Activity/center');?>?phone=<?php echo ($_SESSION['infor']['data'][0]['Mobile']); ?>"><li><img src="/Public/Activity/images/icon/my.svg"><span>我的</span></li></a>
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
<link rel="stylesheet" type="text/css" href="/Public/Project/css/H-ui.min.css" />
<script type="text/javascript" src="/Public/Project/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript">
function modaldemo(){
	$("#modal-demo").modal("show");
}
</script>
<!-- 请在上方写相关业务脚本 -->
<!-- 轮播 -->
<script type="text/javascript" src="/Public/Activity/js/jflex.min.js"></script>
<script type="text/javascript">
$('.banner').jFlex({
	autoplay: true
});
</script>
</body>
</html>