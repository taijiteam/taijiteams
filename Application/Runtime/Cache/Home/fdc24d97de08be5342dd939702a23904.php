<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>成员风采</title>
<style type="text/css">
body{
	background: #000;
	margin: 0;
	padding: 0;
}
a{
	color: #fff;
	text-decoration:none;
}
ul{
	padding-left: 0px;
	overflow: hidden;
	margin-top: 7px;
	margin-bottom: 5px;
}
li{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
footer{
	position: fixed;
	bottom: 0px;
	width: 100%;
}
footer>ul{
	margin: 0;
	padding: 5px 0;
	background: rgb(35,35,35);
	overflow: hidden;
}
footer>ul>a>li{
	display: block;
	float: left;
	width: 25%;
	text-align: center;
	margin-left: 6.25%;
}
footer>ul>a>li>img{
	width: 25px;
}
footer>ul>a>li>span{
	display: block;
	text-align: center;
	font-size: 10px;
	color: rgb(248,194,84);
}
.list>.body{
	overflow: hidden;
	width: 100%;
	margin-bottom: 65px;
}
.list>.body>.nav{
	margin: 0;
	padding: 0;
	width: 100%;
	overflow: hidden;
	background: rgb(35,35,35);
	position: fixed;
}
.list>.body>.nav>li{
	font-size: 14px;
	width: 20%;
	display: block;
	float: left;
	text-align: center;
	margin: 0;
	padding: 10px 0;
}
.list>.body>.nav>li>a{
	color: #fff;
}
.swiper-slide{
	margin-top: 50px;
}
.swiper-slide>p{
	color: #fff;
	margin: 0 auto;
	width: 90%;
	font-size: 10px;
}
.swiper-slide>ul{
	overflow: hidden;
	width: 90%;
	margin: 0 auto;
	padding: 0;
}
.swiper-slide>ul>li{
	width: 100%;
	overflow: hidden;
	margin: 0 auto;
	padding: 10px 0;
	border-bottom: 1px solid rgb(151,151,151);
}
.swiper-slide>ul>li>a>span{
	width: 28.15%;
	height: 37.335vw;
	display: block;
	float: left;
	background: #ccc;
	margin-left: 2.374%;
}
.swiper-slide>ul>li>a>span>img{
	width: 100%;
}
.swiper-slide>ul>li>a>div{
	width: 63%;
	display: block;
	float: left;
	overflow: hidden;
	color: #fff;
	margin-left: 4%;
}
.swiper-slide>ul>li>a>div>h4{
	margin: 5px 0;
	font-size: 14px;
}
.swiper-slide>ul>li>a>div>p{
	margin: 3px 0;
	font-size: 12px;
}
.swiper-slide>ul>li>a>div>span{
	display: block;
	width: 65px;
	text-align: center;
	font-size: 12px;
	color: rgb(250,196,84);
	padding: 1px 4px;
	margin-top: 20px;
}
.swiper-slide>ul>li>a>div>object{
	display: block;
	text-align: right;
}
.swiper-slide>ul>li>a>div>object>a{
	color: rgb(248,194,84);
	font-size: 12px;
}
#starlist #selected {
	color: rgb(248,194,84);
}
.list>.back_to_top{
	width: 30px;
	height: 30px;
	position: fixed;
	bottom: 100px;
	right: 30px;
	border-radius: 15px;
	padding: 0;
	background: #00ff97;
	border: none;
}
.list>.back_to_top>img{
	width: 100%;
}
</style>
<link rel="stylesheet" href="/Public/Activity/css/jflex.min.css" type="text/css" media="all">
<script src="/Public/Activity/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/Public/Activity/js/comm.js"></script>
</head>
<body class="list">
<div class="body">
	<ul class="nav" id="starlist">
		<li><a href="<?php echo U('Member/index');?>?cardid=<?php echo ($_SESSION['cardId']); ?>">全部成员</a></li>
		<li><a href="<?php echo U('Member/index_2');?>?category=商政名流">商政名流</a></li>
		<li><a href="<?php echo U('Member/index_2');?>?category=企业精英">企业精英</a></li>
		<li><a href="<?php echo U('Member/index_2');?>?category=文艺雅仕">文艺雅仕</a></li>
		<li><a href="<?php echo U('Member/index_2');?>?category=名医专家">名医专家</a></li>
	</ul>
	<div class="swiper-slide">
		<p>默认按成员进驻时间排序</p>
		<ul class="mui-table-view">
			<?php if(is_array($mlist)): $i = 0; $__LIST__ = $mlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mlist): $mod = ($i % 2 );++$i;?><li class="mui-table-view-cell">
					<a href="<?php echo U('Member/content');?>?id=<?php echo ($mlist["m_id"]); ?>">
						<span><img src="/Public/Uploads/Member/<?php echo ($mlist["m_img"]); ?>"></span>
						<div>
							<h4><?php echo ($mlist["m_cname"]); ?></h4>
							<p><?php echo ($mlist['erji'][0]); ?></p>
							<p><?php echo ($mlist['erji'][1]); ?></p>
							<span>[ <?php echo ($mlist["m_category"]); ?> ]</span>
							<object><a href="<?php echo U('Member/content');?>?id=<?php echo ($mlist["m_id"]); ?>">成员详情»</a></object>
						</div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>
<button class="back_to_top"><img src="/Public/Merber/images/icon/backtop.png"></button>
<footer>
	<ul>
		<a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22"><li><img src="/Public/Merber/images/icon/index.svg"><span>首页</span></li></a>
		<a href="javascript:;" onclick="modaldemo()"><li><img src="/Public/Merber/images/icon/sousuo.svg"><span>搜索</span></li></a>
		<?php if($_SESSION['infor']['data'][0]['MemberGroupName'] == '内部测试'): ?><a href="<?php echo U('Member/setup');?>"><li><img src="/Public/Merber/images/icon/shezhi.png"><span>设置</span></li></a>
			<?php else: ?>
			<a href="<?php echo U('Member/my');?>?num=<?php echo ($_SESSION['cardId']); ?>"><li><img src="/Public/Merber/images/icon/my.svg"><span>我的</span></li></a><?php endif; ?>
		<input type="hidden" value="<?php echo ($_SESSION['audo']); ?>"/>
		<input type="hidden" value="<?php echo ($_COOKIE['audo']); ?>"/>
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
<form action="<?php echo U('Member/search');?>" method="post" style="overflow: hidden;" class="search">
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

<script type="text/javascript">
var backButton=$('.back_to_top');
function backToTop() {
	$('html,body').animate({
		scrollTop: 0
	}, 800);
}
backButton.on('click', backToTop);

$(window).on('scroll', function () {/*当滚动条的垂直位置大于浏览器所能看到的页面的那部分的高度时，回到顶部按钮就显示 */
	if ($(window).scrollTop() > $(window).height())
		backButton.fadeIn();
	else
		backButton.fadeOut();
});
$(window).trigger('scroll');/*触发滚动事件，避免刷新的时候显示回到顶部按钮*/
</script>
</body>
</html>