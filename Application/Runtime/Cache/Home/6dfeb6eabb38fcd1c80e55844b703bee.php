<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title><?php echo ($hospital[0]['h_hospital']); ?></title>
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
	<div class="depa">
		<h3><img src="/Public/Doctor/images/qita.png"><?php echo ($hospital[0]['h_hospital']); ?></h3>
		<ul class="nav">
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=儿科">
				<li>
					<span><img src="/Public/Doctor/images/erke.png"></span>
					<p>儿科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=内科">
				<li>
					<span><img src="/Public/Doctor/images/neike.png"></span>
					<p>内科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=外科">
				<li>
					<span><img src="/Public/Doctor/images/waike.png"></span>
					<p>外科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=肿瘤科">
				<li>
					<span><img src="/Public/Doctor/images/zhongliu.png"></span>
					<p>肿瘤科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=消化科">
				<li>
					<span><img src="/Public/Doctor/images/xiaohua.png"></span>
					<p>消化科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=妇产科">
				<li>
					<span><img src="/Public/Doctor/images/fuchan.png"></span>
					<p>妇产科</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list_1');?>?h_id=<?php echo ($h_id); ?>&de_department=手术">
				<li>
					<span><img src="/Public/Doctor/images/shoushu.png"></span>
					<p>手术</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/ihospital_list');?>?h_id=<?php echo ($h_id); ?>">
				<li>
					<span><img src="/Public/Doctor/images/qita.png"></span>
					<p>全部</p>
				</li>
			</a>
		</ul>
		<ul class="list">
			<?php if(is_array($do_list)): $i = 0; $__LIST__ = $do_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$do_list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Doctor/doctor_content');?>?do_id=<?php echo ($do_list["do_Id"]); ?>">
				<li>
					<img src="/Public/img/<?php echo ($do_list["do_photo"]); ?>">
					<div>
						<object><a href="<?php echo U('Doctor/appoint');?>?do_id=<?php echo ($do_list["do_Id"]); ?>">预约</a></object>
						<h4><?php echo ($do_list["do_doctor"]); ?></h4>
						<p><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($do_list["do_position"])),0,4,'utf-8')); ?></p>
						<p>医院：<?php echo ($do_list["h_hospital"]); ?></p>
						<p>科室：<?php echo ($do_list["de_department"]); ?></p>
						<p>擅长：<?php echo (mb_substr(strip_tags(htmlspecialchars_decode($do_list["do_adept"])),0,14,'utf-8')); ?>...</p>
					</div>
					<?php if(is_array($do_list["erji"])): $i = 0; $__LIST__ = $do_list["erji"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$do_list_1): $mod = ($i % 2 );++$i;?><span><?php echo ($do_list_1["la_label"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
					<!-- <span>肺部结节</span>
					<span>肺癌</span>
					<span>食道癌</span> -->
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <a href="">
				<li>
					<img src="/Public/Doctor/images/cao.png">
					<div>
						<h4>曹子昂</h4>
						<p>主任医师</p>
						<p>医院：仁济医院</p>
						<p>科室：外科</p>
						<p>擅长：胸部恶性肿瘤的外科</p>
					</div>
					<object><a href="">预约</a></object>
					<span>肺部结节</span>
					<span>肺癌</span>
					<span>食道癌</span>
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