<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 防止手机点击放大问题 -->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
	<!-- the end -->
	<title>名医详情</title>
	<link rel="stylesheet" type="text/css" href="/Public/Doctor/css/style.css">
</head>
<body>
	<header>
		<banner class="banner">
			<img src="/Public/Doctor/images/banner1.png">
		</banner>
	</header>
<div class="doctor">
	<h3><img src="/Public/Doctor/images/minigyi1.png">名医详情</h3>







	<div class="doctor_cdiv">
		<img src="/Public/img/<?php echo ($do["do_photo"]); ?>">
		<div>
			<object><a href="<?php echo U('Doctor/appoint');?>?do_id=<?php echo ($do["do_Id"]); ?>">预约</a></object>
			<h4><?php echo ($do["do_doctor"]); ?></h4>
			<p><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($do_list["do_position"])),0,4,'utf-8')); ?></p>
			<p>科室：<?php echo ($do["de_department"]); ?></p>
			<p>擅长：<?php echo ($do["do_adept"]); ?></p>
			<?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;?><span><?php echo ($label["la_label"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>





	<h3><img src="/Public/Doctor/images/minigyi1.png">名医简介</h3>
	<p class="doctor_cp"><?php echo ($do["do_intorduction"]); ?></p>
	<h3><img src="/Public/Doctor/images/yijianfankui.png">用户评价</h3>
	<p class="doctor_cpj">
		<img src="/Public/Doctor/images/feichanghao.png"><span class="span1">非常好(<?php echo ($ev_dlevel_3); ?>)</span><!-- <span class="span2">21</span> -->
		<img src="/Public/Doctor/images/henhao.png"><span class="span1">很好(<?php echo ($ev_dlevel_2); ?>)</span><!-- <span class="span2">21</span> -->
		<img src="/Public/Doctor/images/yiban.png"><span class="span1">一般(<?php echo ($ev_dlevel_1); ?>)</span><!-- <span class="span2">21</span> -->
	</p>
	<ul class="doctor_cul">
		<?php if(is_array($ev_list)): $i = 0; $__LIST__ = $ev_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ev_list): $mod = ($i % 2 );++$i;?><li>
				<h4>
					<img class="img1" src="/Public/Doctor/images/IMG_1538.jpg">
					<span><?php echo ($ev_list["ev_user"]); ?></span>
					<?php if($ev_list["ev_dlevel"] == 3): ?><img class="img2" src="/Public/Doctor/images/feichanghao.png">
						<?php elseif($ev_list["ev_dlevel"] == 2): ?><img class="img2" src="/Public/Doctor/images/henhao.png">
						<?php elseif($ev_list["ev_dlevel"] == 1): ?><img class="img2" src="/Public/Doctor/images/yiban.png"><?php endif; ?>
					<span><?php echo ($ev_list["ev_time"]); ?></span>
				</h4>
				<p><?php echo ($ev_list["ev_content"]); ?></p>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		<!-- <li>
            <h4><img class="img1" src="/Public/Doctor/images/IMG_1538.jpg"><span>张三</span><img class="img2" src="/Public/Doctor/images/feichanghao.png"></h4>
            <p>曹子昂教授为国内著名食管外科专家，连续四年被评为全国十佳食管外科医生。</p>
        </li> -->
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