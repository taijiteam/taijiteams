<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>写字楼</title>
<link rel="stylesheet" type="text/css" href="/Public/Estate/css/style.css">
<style type="text/css">
.shops>form{
	width: 65%;
	margin: 10px auto;
	overflow: hidden;
}
.shops>form>input{
	border: none;
	line-height: 25px;
}
.shops>form>.text{
	width: 73%;
	background: rgb(207,207,207);
	padding: 0px;
	padding-left: 2%;
	border-radius:2px;
	display: block;
	float: left;
}
.shops>form>.sub{
	-webkit-appearance: none;
	width: 25%;
	background: rgb(28,28,28);
	color: rgb(245,213,95);
}
.shops>h4{
	border-bottom: 1px solid rgb(216,216,216);
	line-height: 20px;
	font-size: 14px;
	width: 85%;
	margin: auto;
	color: rgb(255,209,89);
	padding-left: 10px;
	padding-right: 10px;
}
.shops>ul{
	width: 90%;
	margin: auto;
}
.shops>ul>a>li{
	border-bottom: 1px solid rgb(216,216,216);
	overflow: hidden;
	margin-top: 10px;
}
.shops>ul>a>li>img{
	width: 35%;
	display: block;
	float: left;
}
.shops>ul>a>li>div{
	width: 64%;
	margin-left: 1%;
	display: block;
	float: left;
	color: rgb(238,238,238);
}
.shops>ul>a>li>div>h4{
	font-size: 14px;
	margin-top: 5px;
	margin-bottom: 0px;
}
.shops>ul>a>li>div>p{
	font-size: 12px;
	margin-top: 5px;
	margin-bottom: 5px;
}
.shops>ul>a>li>div>span{
	color: #f00;
}
.shops>.menu{
	width: 90%;
	margin: 0 auto;
	overflow: hidden;
}
.shops>.menu>details>summary{
	text-align: right;
}
.shops>.menu>details>form>h4{
	color: rgb(255,209,89);
	font-size: 14px;
}
.shops>.menu>details>form>p>input{
	width: 60px;
	margin-right: 5px;
	margin-left: 5px;
	border: none;
	line-height: 20px;
	border-radius: 5px;
	background: #cfcfcf;
}
.shops>.menu>details>form>select{
    width: 155px;
    line-height: 25px;
    height: 25px;
    background: #cfcfcf;
    margin-left: 40px;
}
.shops>.menu>details>form>input{
	display: block;
	float: right;
	background: rgb(250,196,84);
	-webkit-appearance: none;
	border: none;
	width: 50px;
	border-radius: 2px;
}
</style>
</head>
<body class="shops">
	<form action="<?php echo U('Estate/sousuo');?>" method="post">
			<input type="text" name="keywords" class="text" placeholder="请输入"><input type="submit" class="sub" name="查询">
		</form>
		<div class="menu">
		<details close="">
			<summary>筛选</summary>
			<form action="<?php echo U('Estate/screeningXZ');?>" method="post">
				<h4>区域选择</h4>
				<select name="e_regional">
					<!-- <option value="全部">——全部——</option> -->
					<option value="徐汇区">徐汇区</option><option value="黄浦区">黄浦区</option>
					<option value="普陀区">普陀区</option><option value="静安区">静安区</option>
					<option value="长宁区">长宁区</option><option value="虹口区">虹口区</option>
					<option value="嘉定区">嘉定区</option><option value="松江区">松江区</option>
					<option value="青浦区">青浦区</option><option value="闵行区">闵行区</option>
					<option value="宝山区">宝山区</option><option value="浦东新区">浦东新区</option>
				</select>
				<h4>租金范围</h4>
				<p><input type="text" name="e_rentmin">元&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;<input type="text" name="e_rentmax">元</p>
				<h4>面积范围</h4>
				<p><input type="text" name="e_areamin">㎡&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;<input type="text" name="e_areamax">㎡</p>
				<input type="hidden" name="e_category">
				<input type="submit" value="确定">
			</form>
		</details>
	</div>
	<h4><span>写字楼</span><img src=""></h4>
	<ul>
		<?php if(is_array($office)): $i = 0; $__LIST__ = $office;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$office): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Estate/content');?>?e_id=<?php echo ($office["e_id"]); ?>&openid=<?php echo ($_SESSION['openid']); ?>">
				<li>
					<img src="/Public/Uploads/Estate/<?php echo ($office["p_photo"]); ?>">
					<div>
						<h4><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($office["e_title"])),0,13,'utf-8')); ?>...</h4>
						<p><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($office["e_describe"])),0,20,'utf-8')); ?></p>
						<span><?php echo ($office["e_rent"]); ?>元/月</span>
					</div>
				</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<p id="margin-bottom"></p>
	<footer>
		<ul>
			<a href="<?php echo U('Estate/index');?>"><li><img src="/Public/Estate/images/home.svg"><span>首页</span></li></a>
			<a href="<?php echo U('Estate/tellme');?>"><li><img src="/Public/Estate/images/tell.svg"><span>联系我们</span></li></a>
			<a href="<?php echo U('Estate/center');?>"><li><img src="/Public/Estate/images/center.svg"><span>个人中心</span></li></a>
		</ul>
	</footer>
</body>
</html>