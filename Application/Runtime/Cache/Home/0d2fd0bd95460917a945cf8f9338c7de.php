<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>住院</title>
<link rel="stylesheet" type="text/css" href="/Public/Doctor/css/style.css">
</head>
<body>
		<header>
		<!-- <form action="" method="">
			<p><input type="text" class="input_all" name="" placeholder="请输入"><input type="submit" class="sub_all" name=""></p>
		</form> -->
		<banner class="banner">
			<img src="/Public/Doctor/images/banner1.png">
		</banner>
	</header>
	<div class="hospital">
		<h3><img src="/Public/Doctor/images/yuan1.png">住院</h3>
		<ul class="list">
			<?php if(is_array($ih_list)): $i = 0; $__LIST__ = $ih_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ih_list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Doctor/ihospital_list');?>?h_id=<?php echo ($ih_list["h_id"]); ?>">
				<li>
					<img src="/Public/img/<?php echo ($ih_list["h_photo"]); ?>">
					<div>
						<h4><?php echo ($ih_list["h_hospital"]); ?></h4>
						<p>简介：<?php echo (mb_substr(strip_tags(htmlspecialchars_decode($ih_list["h_introduction"])),0,30,'utf-8')); ?>...</p>
					</div>
					<object><a href="<?php echo U('Doctor/ihospital_list');?>?h_id=<?php echo ($ih_list["h_id"]); ?>">详情&gt;&gt;</a></object>
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <a href="">
				<li>
					<img src="/Public/Doctor/images/diliu.png">
					<div>
						<h4>第六人民医院</h4>
						<p>简介：三甲医院三甲医院三甲医院三甲医院三甲医院</p>
					</div>
					<object><a href="">详情&gt;&gt;</a></object>
				</li>
			</a>
			<a href="">
				<li>
					<img src="/Public/Doctor/images/diliu.png">
					<div>
						<h4>第六人民医院</h4>
						<p>简介：三甲医院</p>
					</div>
					<object><a href="">详情&gt;&gt;</a></object>
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