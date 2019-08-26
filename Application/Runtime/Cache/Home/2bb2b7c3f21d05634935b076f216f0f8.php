<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>系统消息</title>
<link rel="stylesheet" type="text/css" href="/Public/Doctor/css/style.css">
<style type="text/css">
body>.mcontent>ul>a>li>div>p>span{
	width: 10px;
	height: 10px;
	background: #f00;
	display: block;
	border-radius: 5px;
	float: left;
	margin: 3px;
}
</style>
</head>
<body>
		<header>
		<banner class="banner">
			<img src="/Public/Doctor/images/banner1.png">
		</banner>
	</header>
	<!-- <div class="head">
			<img src="/Public/Doctor/images/jack.png">
			<span>
				<p><?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?></p>
				<p><?php echo ($_SESSION['infor']['data'][0]['MemberGroupName']); ?></p>
			</span>
		</div> -->
	<div class="mcontent">
		<h3><img src="/Public/Doctor/images/xiaoxi.png">系统消息</h3>
		<ul>
			<?php if(is_array($mlist)): $i = 0; $__LIST__ = $mlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mlist): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Doctor/message_content');?>?m_id=<?php echo ($mlist["m_id"]); ?>">
				<li>
					<!-- <p><?php echo ($mlist["m_message"]); ?></p> -->
					<div>
						<h4><?php if($mlist["m_state"] == 1): ?>新<?php else: endif; ?>消息<img src="/Public/Doctor/images/xiaoxi.png"></h4>
						<p>
							<?php if($mlist["m_state"] == 1): ?><span></span><?php else: endif; ?>
							<?php echo ($mlist["m_content"]); ?>
						</p>
					</div>
					<span>&gt;</span>
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <a href="message_content.html">
				<li>
					<p>2018年07月31日</p>
					<div>
						<h4>新订单<img src="/Public/Doctor/images/xiaoxi.png"></h4>
						<p><span></span>您有一条新的预约订单</p>
					</div>
					<span>&gt;</span>
				</li>
			</a> -->
		</ul>
	</div>
		<footer>
		<ul>
			<a href="<?php echo U('Doctor/index');?>">
				<li>
					<img src="/Public/Doctor/images/home.png">
					<p>首页</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/message');?>?m_merber=<?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?>">
				<li>
					<?php if($_SESSION['message_state'] == 1): ?><span style="width: 10px;height: 10px;background: #f00;display: block;border-radius: 5px;float: left;position: fixed;left: 43%;"></span>
						<?php else: endif; ?>
					<img src="/Public/Doctor/images/xiaoxi.png">
					<p>系统消息</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/center');?>">
				<li>
					<img src="/Public/Doctor/images/merber.png">
					<p>个人中心</p>
				</li> 
			</a>
		</ul>
	</footer>
</body>
</html>