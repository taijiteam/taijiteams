<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 防止手机点击放大问题 -->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
	<!-- the end -->
	<title>名院详情</title>
	<link rel="stylesheet" type="text/css" href="/Public/Doctor/css/style.css">
</head>
<body>
	<header>
		<banner class="banner">
			<img src="/Public/Doctor/images/banner1.png">
		</banner>
	</header>
<div class="hospital">
	<h3><img src="/Public/Doctor/images/yuan1.png">名院详情</h3>
	<div class="hospital_cdiv">
		<img src="/Public/img/<?php echo ($h["h_photo"]); ?>">
		<h4><?php echo ($h["h_hospital"]); ?></h4>
		<p>简介：<?php echo (mb_substr(strip_tags(htmlspecialchars_decode($h["h_introduction"])),0,40,'utf-8')); ?></p>
		<p style="color: rgb(250,196,84)">擅长：癌症、肿瘤治疗</p>
	</div>
	<h3><img src="/Public/Doctor/images/jianjie.png">名院简介</h3>
	<p class="hospital_cp"><?php echo ($h["h_introduction"]); ?></p>
	<h3><img src="/Public/Doctor/images/keshi.png">名院科室</h3>
	<p class="hospital_cp">医院设有<?php if(is_array($h_list)): $i = 0; $__LIST__ = $h_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$h_list): $mod = ($i % 2 );++$i; echo ($h_list["de_department"]); endforeach; endif; else: echo "" ;endif; ?></p>
	<h3><img src="/Public/Doctor/images/shebei.png">医疗设备</h3>
	<p class="hospital_cp"><?php echo ($h["h_facilities"]); ?></p>
	<h3><img src="/Public/Doctor/images/dizhi.png">医院地址 </h3>
	<p class="hospital_cp"><?php echo ($h["h_address"]); ?></p>
</div>
<div class="doctor">
	<h3><img src="/Public/Doctor/images/minigyi1.png">名医详情</h3>
	<?php if(is_array($doctor_list)): foreach($doctor_list as $key=>$do): ?><div class="doctor_cdiv">
			<img src="/Public/img/<?php echo ($do["do_photo"]); ?>">
			<div>
				<object><a href="<?php echo U('Doctor/doctor_content');?>?do_id=<?php echo ($do["do_Id"]); ?>">详情</a></object>
				<h4><?php echo ($do["do_doctor"]); ?></h4>
				<p><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($do_list["do_position"])),0,4,'utf-8')); ?></p>
				<p>科室：<?php echo ($do["de_department"]); ?></p>
				<p>擅长：<?php echo ($do["do_adept"]); ?></p>
				<?php if(is_array($label)): foreach($label as $key=>$vo): ?><span><?php echo ($vo["la_label"]); ?></span><?php endforeach; endif; ?>
				<!-- <span>肺癌</span>
                <span>食道癌</span> -->
			</div>
		</div><?php endforeach; endif; ?>
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