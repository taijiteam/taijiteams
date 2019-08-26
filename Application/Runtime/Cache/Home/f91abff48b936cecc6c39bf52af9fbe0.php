<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>房产首页</title>
<link rel="stylesheet" type="text/css" href="/Public/Estate/css/style.css">
</head>
<body class="index">
	<header>
		<img src="/Public/Estate/images/banner.png">



		
		<form action="<?php echo U('Estate/sousuo');?>" method="post">
			<input type="text" name="keywords" class="text" placeholder="请输入"><input type="submit" class="sub" name="查询">
		</form>



	</header>
	<ul class="nav">
		<a href="<?php echo U('Estate/shops');?>?e_category=商铺"><li><img src="/Public/Estate/images/shangpu.png"><span>商铺</span></li></a>
		<a href="<?php echo U('Estate/office');?>?e_category=写字楼"><li><img src="/Public/Estate/images/xiezilou.png"><span>写字楼</span></li></a>
		<a href="<?php echo U('Estate/residence');?>?e_category=住宅"><li><img src="/Public/Estate/images/zhuzhai.png"><span>住宅</span></li></a>
		<a href="<?php echo U('Estate/factory');?>?e_category1=厂房&e_category2=仓库"><li><img src="/Public/Estate/images/cangku.png"><span>厂房仓库</span></li></a>
	</ul>
	<div>
		<h4><span>精品商铺</span></h4>
		<ul class="ul_1">
			<?php if(is_array($shops)): $i = 0; $__LIST__ = $shops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shops): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Estate/content');?>?e_id=<?php echo ($shops["e_id"]); ?>&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Uploads/Estate/<?php echo ($shops["p_photo"]); ?>"><span><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($shops["e_title"])),0,6,'utf-8')); ?>...</span></li></a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div>
		<h4><span>精品住宅</span></h4>
		<ul class="ul_1">
			<?php if(is_array($residence)): $i = 0; $__LIST__ = $residence;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$residence): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Estate/content');?>?e_id=<?php echo ($residence["e_id"]); ?>&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Uploads/Estate/<?php echo ($residence["p_photo"]); ?>"><span><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($residence["e_title"])),0,6,'utf-8')); ?>...</span></li></a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div>
		<h4><span>精品写字楼</span></h4>
		<ul class="ul_2">
			<?php if(is_array($office)): $i = 0; $__LIST__ = $office;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$office): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Estate/content');?>?e_id=<?php echo ($office["e_id"]); ?>&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Uploads/Estate/<?php echo ($office["p_photo"]); ?>"><span><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($office["e_title"])),0,6,'utf-8')); ?>...</span></li></a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div>
		<h4><span>区域房源</span></h4>
		<ul class="ul_3">
			<a href="<?php echo U('Estate/regional');?>?e_regional=徐汇区">
				<li style="background:url(/Public/Estate/images/xuhui.png) center 0 no-repeat; background-size: 100%;"><span>徐汇区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=静安区">
				<li style="background:url(/Public/Estate/images/jingan.png) center 0 no-repeat; background-size: 100%;"><span>静安区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=松江区">
				<li style="background:url(/Public/Estate/images/songjiang.png) center 0 no-repeat; background-size: 100%;"><span>松江区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=虹口区">
				<li style="background:url(/Public/Estate/images/hongkou.png) center 0 no-repeat; background-size: 100%;"><span>虹口区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=嘉定区">
				<li style="background:url(/Public/Estate/images/jiading.png) center 0 no-repeat; background-size: 100%;"><span>嘉定区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=黄浦区">
				<li style="background:url(/Public/Estate/images/huangpu.png) center 0 no-repeat; background-size: 100%;"><span>黄浦区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=宝山区">
				<li style="background:url(/Public/Estate/images/baoshan.png) center 0 no-repeat; background-size: 100%;"><span>宝山区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=浦东新区">
				<li style="background:url(/Public/Estate/images/pudong.png) center 0 no-repeat; background-size: 100%;"><span>浦东新区</span></li>
			</a>
			<a href="<?php echo U('Estate/regional');?>?e_regional=长宁区">
				<li style="background:url(/Public/Estate/images/changning.png) center 0 no-repeat; background-size: 100%;"><span>长宁区</span></li>
			</a>
		</ul>
	</div>
	<p id="margin-bottom"></p>
	
<link rel="stylesheet" type="text/css" href="http://www.qudaoplus.cn/statics/css/allfooter.css">
<footer id="footer">
  <ul>
      <a href="http://www.qudaoplus.cn/merber_all_show/index.php/home/Personnal/central"><li class="core li"><em></em><span>成员中心</span></li></a>
      <a href="/Home/Home/home"><li class="vip on li"><em></em><span>成员专享</span></li></a>
      <!-- <a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=32"><li class="activity"><em></em><span>精彩活动</span></li></a> -->
      <a href="/Home/Home/tellMe"><li class="steward li"><em></em><span>联系管家</span></li></a>
  </ul>
</footer>

	
</body>
</html>