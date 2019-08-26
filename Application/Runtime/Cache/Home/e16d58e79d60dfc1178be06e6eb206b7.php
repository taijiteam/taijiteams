<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>首页</title>
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
	<ul class="ul_head">
		<a href="<?php echo U('Doctor/hospital');?>">
			<li>
				<img src="/Public/Doctor/images/yuan.png">
				<p>名院展示</p>
			</li>
		</a>
		<a href="<?php echo U('Doctor/doctor');?>">
			<li>
				<img src="/Public/Doctor/images/mingyi.png">
				<p>名医预约</p>
			</li>
		</a>
		<a href="<?php echo U('Doctor/ihospital');?>">
			<li>
				<img src="/Public/Doctor/images/zhuyuan.png">
				<p>住院</p>
			</li>
		</a>
		<a href="<?php echo U('Doctor/department');?>">
			<li>
				<img src="/Public/Doctor/images/kemu.png">
				<p>科目分类</p>
			</li>
		</a>
		<a href="<?php echo U('Doctor/tellme');?>">
			<li>
				<img src="/Public/Doctor/images/tellme.png">
				<p>联系我们</p>
			</li>
		</a>
	</ul>
	<p id="margintop"></p>
	<div class="div_body_1">
		<h3><img src="/Public/Doctor/images/yuan1.png"><span class="h">名院展示</span><span class="gt"><a href="<?php echo U('Doctor/ranking');?>" style="color: #b9b9b9; font-size: 12px;">名院排行 &gt;&gt;</a></span></h3>
		<ul>
			<?php if(is_array($h_list)): $i = 0; $__LIST__ = $h_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$h_list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Doctor/hospital_content');?>?h_id=<?php echo ($h_list["h_id"]); ?>">
					<li>
						<img src="/Public/img/<?php echo ($h_list["h_photo"]); ?>">
						<h3><?php echo ($h_list["h_hospital"]); ?></h3>
						<span>三甲医院</span>
					</li>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <a href="">
				<li>
					<img src="/Public/Doctor/images/diliu.png">
					<h3>仁济医院</h3>
					<span>三甲医院</span>
				</li>
			</a>
			<a href="">
				<li>
					<img src="/Public/Doctor/images/diliu.png">
					<h3>仁济医院</h3>
					<span>三甲医院</span>
				</li>
			</a> -->
		</ul>
	</div>
	<div class="div_body_1">
		<h3><img src="/Public/Doctor/images/minigyi1.png"><span class="h">名医风采</span><a href="<?php echo U('Doctor/doctor');?>"><span class="gt">&gt;</span></a></h3>
		<ul>
			<?php if(is_array($do_list_2)): $i = 0; $__LIST__ = $do_list_2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$do_list_2): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Doctor/doctor_content');?>?do_id=<?php echo ($do_list_2["do_Id"]); ?>">
				<li>
					<img src="/Public/img/<?php echo ($do_list_2["do_photo"]); ?>">
					<h3><?php echo ($do_list_2["do_doctor"]); ?></h3>
					<span>职位：<?php echo (mb_substr(strip_tags(htmlspecialchars_decode($do_list_2["do_position"])),0,4,'utf-8')); ?></span>
					<span>医院：<?php echo ($do_list_2["h_hospital"]); ?></span>
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- <a href="">
				<li>
					<img src="/Public/Doctor/images/cao.png">
					<h3>曹子昂</h3>
					<span>职位：主任医师</span>
					<span>医院：仁济医院</span>
				</li>
			</a>
			<a href="">
				<li>
					<img src="/Public/Doctor/images/cao.png">
					<h3>曹子昂</h3>
					<span>职位：主任医师</span>
					<span>医院：仁济医院</span>
				</li>
			</a> -->
		</ul>
	</div>
	<div class="div_body_3">
		<h3><img class="img1" src="/Public/Doctor/images/kemu1.png"><span class="h">热门科室</span><img class="img2" src="/Public/Doctor/images/hot.png"><a href="<?php echo U('Doctor/department');?>"><span class="gt">&gt;</span></a></h3>
		<!-- 公告消息测试 -->

		<!-- 公告消息 -->
		<div class="div_kemu">
			<a href="<?php echo U('Doctor/department_list');?>?de_department=儿科">
			<div class="color_1">
				<p class="p_1">儿科</p>
				<p class="p_2">PEDIATRICS</p>
			</div>
			</a>
			<a href="<?php echo U('Doctor/department_list');?>?de_department=内科">
			<div class="color_2">
				<p class="p_1">内科</p>
				<p class="p_2">INTERNAL</p>
				<p class="p_2">MEDICINE</p>
			</div>
			</a>
			<a href="<?php echo U('Doctor/department_list');?>?de_department=外科">
			<div class="color_3">
				<p class="p_1">外科</p>
				<p class="p_2">SURGERY</p>
			</div>
			</a>
			<hr>
			<a href="<?php echo U('Doctor/department_list');?>?de_department=肿瘤科">
			<div class="color_4">
				<p class="p_1">肿瘤科</p>
				<p class="p_2">ONGOLOGY</p>
			</div>
			</a>
			<a href="<?php echo U('Doctor/department_list');?>?de_department=妇产科">
			<div class="color_5">
				<p class="p_1">妇产科</p>
				<p class="p_2">GYNAECOLOGY</p>
			</div>
			</a>
			<a href="<?php echo U('Doctor/department_list');?>?de_department=手术">
			<div class="color_6">
				<p class="p_1">手术科</p>
				<p class="p_2">OPERATION ROOM</p>
			</div>
			</a>
		</div>
	</div>
	
<link rel="stylesheet" type="text/css" href="http://www.qudaoplus.cn/statics/css/allfooter.css">
<footer id="footer">
  <ul>
      <a href="http://www.qudaoplus.cn/merber_all_show/index.php/home/Personnal/central"><li class="core li"><em></em><span>成员中心</span></li></a>
      <a href="http://shop.qudaoplus.cn/Home/Home/home"><li class="vip on li"><em></em><span>成员专享</span></li></a>
      <!-- <a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=32"><li class="activity"><em></em><span>精彩活动</span></li></a> -->
      <a href="http://shop.qudaoplus.cn/Home/Home/tellMe"><li class="steward li"><em></em><span>联系管家</span></li></a>
  </ul>
</footer>

</body>
</html>