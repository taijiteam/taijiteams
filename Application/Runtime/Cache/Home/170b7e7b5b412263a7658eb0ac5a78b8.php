<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>精彩活动</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			list-style: none;
		}
		body{
			background: url(/Public/Activity/images/activey.png) no-repeat;
			background-size: 100% 100%;
			height: 100vh;
			overflow: scroll;
		}
		.Housekeeper{
			width: 100%;
		}
		.header{
			width: 8.75rem;
			height: 8.75rem;
			margin: 0 auto;
			padding: 30px 0;
		}
		.header_img{
			width: 100%;
			height: 100%;
		}
		.Mask{
			/*position: absolute;*/
			/*left:50%;*/
			/*top:50%;*/
			/*transform: translate(-50%, -50%);*/
			width: 18.75rem;
			height: 18.75rem;
			background: #000;
			opacity:0.6;
			margin: 0 auto;
			border-radius: 8px;
		}
		.title{
			font-size: 1.875rem;
			line-height: 3rem;
			color: #fbebb5;
			text-align: center;
		}
		.Side{
			width: 2.125rem;
			height: 1.25rem;
		}
		.Side_img{
			width: 100%;
			height: 100%;
		}
		.heading{
			text-align: center;
			color: #fbebb5;
			font-size: 1.125rem;
			line-height: 2.5rem;
		}
		.footer{
			text-align: center;
		}
		.footer>a>button{
			width: 7.5rem;
			height: 2.5rem;
			border: 0.125rem solid #fff;
			background: none;
			color: #fff;
			text-align: center;
			margin: 1.35rem 0;
			border-radius: 8px;
		}
	</style>
</head>
<body>
	<div class="Housekeeper">
		<div class="header">
			<img src="/Public/Estate/images/logo.png" class="header_img">
		</div>
		<div class="Mask">
			<div class="title">精彩活动</div>
			<div class="Side">
				<img src="/Public/Estate/images/path.png" alt="" class="Side_img">
			</div>
			<div class="heading">渠道专属直通道</div>
			<div class="heading">跳脱繁琐报名方式</div>
			<div class="heading">直达现场-活动展示板块</div>
			<div class="heading">定格难忘瞬间让精彩跃然眼前</div>
			<div class="footer">
				<a href="/Home/Activity/list_act"><button>立即进入</button></a>
			</div>
		</div>
	</div>
</body>
</html>