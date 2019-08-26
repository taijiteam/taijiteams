<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- 防止手机点击放大问题 -->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
	<!-- the end -->
	<title>活动详情</title>
	<link rel="stylesheet" href="/Public/Activity/css/jflex.min.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Activity/css/ertaostyle.css">
	<link rel="stylesheet" href="/Public/Activity/css/jquery-labelauty.css">
</head>
<style type="text/css">
	.infor>p>a{
		display: block;
		overflow: hidden;
	}
	.pinglun>div>ul{
		width: 90%;
		margin: 0 auto;
	}
	.pinglun>.list>ul>li{
		width: 100%;
		overflow: hidden;
		margin-top: 20px;
	}
	.pinglun>.list>ul>li>img{
		width: 10%;
		display: block;
		float: left;
		border-radius: 50%;
	}
	.changtu{
		width: 100%;
		height: 100%;
	}
	.pinglun>.list>ul>li>div{
		width: 85%;
		margin: 0;
		display: block;
		float: left;
		margin-left: 2%;
		color: #fff;
	}
	.pinglun>.list>ul>li>div>h5{
		margin: 0;
		line-height: 200%;
		font-size: 16px;

	}
	.pinglun>.list>ul>li>div>p{
		margin: 0;
		font-size: 13px;
	}
	.pinglun>.list>ul>li>div>p>img{
		width: 10px;
	}
	.pinglun>.list>ul>li>div>p>span{
		color: rgb(236, 177, 0);
		font-size: 12px;
		margin-right: 5px;
	}
	.pinglun>.list>ul>li>div>span{
		display: block;
		color: rgb(193,192,191);
		text-align: right;
		font-size: 12px;
	}
	.pinglun>div{
		width: 90%;
		margin: 10px auto;
		background: rgb(53,53,53);
		border-radius: 10px;
		overflow: hidden;
		padding-top: 10px;
		padding-bottom: 10px;
	}
	.pinglun>div>a{
		border: 0.5px solid rgb(248,194,84);
		color: rgb(248,194,84);
		width: 27%;
		display: block;
		float: left;
		margin-left: 3%;
		margin-right: 2.5%;
		background: none;
		border-radius: 10px;
		line-height: 25px;
		margin-top: 6px;
		margin-bottom: 6px;
		text-align: center;
	}
	.pinglun>div>a>span{
		color: rgb(195,195,195);
	}
	footer>.sc>p>a{
		width: 100%;
		height: 100%;
		overflow: hidden;
		display: inline-block;
	}
	.dowebok>li>input.labelauty + label{
		background: none;
		text-align: center;
		border: 0.5px solid rgb(248,194,84);
		color: rgb(248,194,84);
	}
	.dowebok>li>input.labelauty:checked + label{
		background: rgb(248,194,84);
	}
	.dowebok>li>input.labelauty + label{
		width: 65px;
	}
	.dowebok>li>input.labelauty:checked + label{
		width: 65px;
	}
	/*the end*/
</style>
<body class="content">
<div class="banner">
	<ul class="slides">
		<?php if(is_array($images)): $i = 0; $__LIST__ = $images;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$images): $mod = ($i % 2 );++$i;?><li>
				<img alt="" src="/Public/Uploads/Activity/<?php echo ($images["i_image"]); ?>">
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		<!--<li>-->
		<!--<img alt="" src="/Public/Activity/images/shouyebanner.jpg">-->
		<!--</li>-->
		<!--<li>-->
		<!--<img alt="" src="/Public/Activity/images/beasts_feature.jpg">-->
		<!--</li>-->
		<!--<li>-->
		<!--<img alt="" src="/Public/Activity/images/element-taiwan-thmb.jpg">-->
		<!--</li>-->
		<!--<li>-->
		<!--<img alt="" src="/Public/Activity/images/streets-newyork.jpg">-->
		<!--</li>-->
	</ul>
</div>
<div class="body">
	<div>
		<h4>活动详情</h4>
		<div class="infor">
			<p><b style="font-size: 16px;"><?php echo ($content["a_title"]); ?></b></p>
			<p>时间：<?php echo (substr($content["a_start"],0,10)); ?> 至 <?php echo (substr($content["a_end"],0,10)); ?></p>
			<p><a><span class="adre">地点：<?php echo ($content["a_address"]); ?></span><span class="right"></span></a></p>
			<!--<p><a href="<?php echo U('Activity/actshow');?>?id=<?php echo ($content["a_id"]); ?>&name=部分参会单位"><span class="left">部分参会单位</span><span class="right">〉</span></a></p>
			<p><a href="<?php echo U('Activity/actshow');?>?id=<?php echo ($content["a_id"]); ?>&name=参会须知"><span class="left">参会须知</span><span class="right">〉</span></a></p>
			<p><a href="<?php echo U('Activity/actshow');?>?id=<?php echo ($content["a_id"]); ?>&name=会议场地"><span class="left">会议场地</span><span class="right">〉</span></a></p>
			<p><a href="<?php echo U('Activity/supplies');?>?supplies=<?php echo ($content["a_supplies"]); ?>"><span class="left">会议用品</span><span class="right">〉</span></a></p>-->
			<div >
				<?php if($content["a_id"] == 9): ?><img alt="" class="changtu" src="/Public/Activity/images/5ce281f981cef.jpg">
					<?php else: ?>
					<img alt="" class="changtu" src="/Public/Activity/images/shimao.png"><?php endif; ?>
			</div>
		</div>
	</div>
	<?php if($content["a_intor"] != ''): ?><div>
			<h4>活动介绍</h4>
			<div>
				<?php echo ($content["a_intor"]); ?>
			</div>
		</div>
		<?php else: endif; ?>
	<!--<div>
        <h4>会议日程</h4>
        <div>
            <?php echo ($content["a_schedule"]); ?>
        </div>
    </div>-->
	<div>
		<?php if($guest["g_mid"] != 0): ?><h4>参会嘉宾</h4>
			<div>
				<ul class="jiabin">
					<?php if(is_array($guest)): $i = 0; $__LIST__ = $guest;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$guest): $mod = ($i % 2 );++$i;?><li>
							<?php if($guest["g_mid"] == 0): ?><span>
									<a href="javascript:;">
										<img src="/Public/Uploads/Activity/<?php echo ($guest["g_headimg"]); ?>" width="100%" style="border-radius: 50%;">
									</a>
								</span>
								<?php else: ?>
								<span>
									<a href="<?php echo U('Member/content');?>?id=<?php echo ($guest["g_mid"]); ?>">
										<img src="/Public/Uploads/Activity/<?php echo ($guest["g_headimg"]); ?>" width="100%" style="border-radius: 50%;">
									</a>
								</span><?php endif; ?>
							<!--<span><a href="<?php echo U('Member/content');?>?id=<?php echo ($guest["g_mid"]); ?>"><img src="/Public/Uploads/Activity/<?php echo ($guest["g_headimg"]); ?>" width="100%" style="border-radius: 50%;"></a></span>-->
							<h5><?php echo ($guest["g_name"]); ?></h5>
							<p><?php echo ($guest["g_work"]); ?></p>
							<p><?php echo ($guest["g_pos"]); ?></p>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<?php else: endif; ?>
	</div>
	<!--<div>
		<h4>参会须知</h4>
		<div>
			<?php echo ($content["a_notice"]); ?>
		</div>
	</div>-->
	<!-- 第五栏 -->
	<div class="pinglun">
		<h4>用户评价</h4>
		<div class="pinlun">
			<input type="hidden" name="a_id" value="<?php echo ($content["a_id"]); ?>"/>
			<ul class="dowebok">
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="非常满意" data-labelauty="非常满意[<?php echo ($ev); ?>]"></li>
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="服务很好" data-labelauty="服务很好[<?php echo ($ev1); ?>]"></li>
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="印象不错" data-labelauty="印象不错[<?php echo ($ev2); ?>]"></li>
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="描述相符" data-labelauty="描述相符[<?php echo ($ev3); ?>]"></li>
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="性价比高" data-labelauty="性价比高[<?php echo ($ev4); ?>]"></li>
				<li><input class="xinput" type="radio" onclick="pinglun()" name="pinglun" value="行程合理" data-labelauty="行程合理[<?php echo ($ev5); ?>]"></li>
				<!--<li><input class="xinput" type="radio" name="radio" disabled data-labelauty="不可用"></li>-->
			</ul>
		</div>
		<div class="list" id="divdiv">
			<ul id="ulul">
				<?php if(is_array($evalist)): $i = 0; $__LIST__ = $evalist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$evalist): $mod = ($i % 2 );++$i;?><li>
						<!--<img src="/Public/Activity/images/kai.png">-->
						<img src="<?php echo ($evalist["e_headimg"]); ?>"/>
						<div>
							<h5><?php echo ($evalist["e_name"]); ?></h5>
							<p>打分&nbsp;&nbsp;
								<?php if($evalist["e_star"] == 1): ?><img src="/Public/Activity/images/icon/colle2.svg">
									<?php elseif($evalist["e_star"] == 2): ?>
									<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg">
									<?php elseif($evalist["e_star"] == 3): ?><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg">
									<img src="/Public/Activity/images/icon/colle2.svg">
									<?php elseif($evalist["e_star"] == 4): ?>
									<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg">
									<?php elseif($evalist["e_star"] == 5): ?>
									<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><?php endif; ?>
							</p>
							<p><?php echo ($evalist["e_text"]); ?></p>
							<p>
								<!-- <img src=""> -->
								<?php if(is_array($evalist["second"])): $i = 0; $__LIST__ = $evalist["second"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$second): $mod = ($i % 2 );++$i;?><span><?php echo ($second); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
							</p>
							<span><?php echo ($evalist["e_time"]); ?> 发表</span>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>

<!-- 收藏按钮 -->
<!-- <?php if($collect["c_id"] == ''): ?><div><p class="shoucang"><a onClick="admin_start(this,<?php echo ($project["p_id"]); ?>,<?php echo ($_SESSION['cardId']); ?>)" href="javascript:;"><img src="/Public/Project/images/icon/shoucang1.svg"></a></p></div>
<?php else: ?>
<div><p class="shoucang"><a onClick="admin_stop(this,<?php echo ($collect["c_id"]); ?>,<?php echo ($project["p_id"]); ?>,<?php echo ($_SESSION['cardId']); ?>)" href="javascript:;"><img src="/Public/Project/images/icon/shoucang2.svg"></a></p></div><?php endif; ?>
 -->
<footer>
	<?php if($collect["c_id"] == ''): ?><div class="sc">
			<p>
				<a href="javascript:;" onclick="admin_start(this,<?php echo ($content["a_id"]); ?>,<?php echo ($_SESSION['cardId']); ?>)">
					<img src="/Public/Activity/images/icon/colle1.svg">
					<span>收藏</span>
				</a>
			</p>
		</div>
		<?php else: ?>
		<div class="sc">
			<p>
				<a href="javascript:;" onclick="admin_stop(this,<?php echo ($collect["c_id"]); ?>,<?php echo ($content["a_id"]); ?>,<?php echo ($_SESSION['cardId']); ?>)">
					<img src="/Public/Activity/images/icon/colle2.svg">
					<span>取消收藏</span>
				</a>
			</p>
		</div><?php endif; ?>
	<a href="<?php echo U('Activity/actappoint');?>?id=<?php echo ($content["a_id"]); ?>">立即报名</a>
<!--	<?php if($catetime == 最新活动): ?>-->
<!--		<a href="<?php echo U('Activity/actappoint');?>?id=<?php echo ($content["a_id"]); ?>">立即报名</a>-->
<!--		<?php else: ?>-->
<!--		<a href="javascript:;" style="background-color: rgb(99,99,99)">已结束</a>-->
<!--<?php endif; ?>-->

</footer>

<script type="text/javascript" src="/Public/Project/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript">
	function pinglun() {
		var pinglun = $('input[name="pinglun"]:checked').val();//
		var id = $('input[name="a_id"]').val();//
		//alert(pinglun);
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Activity/pinglun');?>",
			data: {
				id:id,
				pinglun:pinglun,
			},
			dataType: 'json',
			success: function(data){
				//alert(JSON.stringify(data));
				if (data != '' || data !=0) {
					var star = ''
					var html = '';
					for (var i = 0; i < data.length; i++) {
						if (data[i].e_star == 5) {
							html += '<li><img src="' + data[i].e_headimg + '"/><div><h5>' + data[i].e_name + '</h5><p>打分&nbsp;&nbsp;<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"></p><p>' + data[i].e_text + '</p><p><span>' + data[i].e_keywords + '</span></p><span>' + data[i].e_time + ' 发表</span></div></li>';
						} else if (data[i].e_star == 4) {
							html += '<li><img src="' + data[i].e_headimg + '"/><div><h5>' + data[i].e_name + '</h5><p>打分&nbsp;&nbsp;<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"></p><p>' + data[i].e_text + '</p><p><span>' + data[i].e_keywords + '</span></p><span>' + data[i].e_time + ' 发表</span></div></li>';
						} else if (data[i].e_star == 3) {
							html += '<li><img src="' + data[i].e_headimg + '"/><div><h5>' + data[i].e_name + '</h5><p>打分&nbsp;&nbsp;<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"></p><p>' + data[i].e_text + '</p><p><span>' + data[i].e_keywords + '</span></p><span>' + data[i].e_time + ' 发表</span></div></li>';
						} else if (data[i].e_star == 2) {
							html += '<li><img src="' + data[i].e_headimg + '"/><div><h5>' + data[i].e_name + '</h5><p>打分&nbsp;&nbsp;<img src="/Public/Activity/images/icon/colle2.svg"><img src="/Public/Activity/images/icon/colle2.svg"></p><p>' + data[i].e_text + '</p><p><span>' + data[i].e_keywords + '</span></p><span>' + data[i].e_time + ' 发表</span></div></li>';
						} else if (data[i].e_star == 1) {
							html += '<li><img src="' + data[i].e_headimg + '"/><div><h5>' + data[i].e_name + '</h5><p>打分&nbsp;&nbsp;<img src="/Public/Activity/images/icon/colle2.svg"></p><p>' + data[i].e_text + '</p><p><span>' + data[i].e_keywords + '</span></p><span>' + data[i].e_time + ' 发表</span></div></li>';
						}

					}
					$('#ulul').html(html);
					$("#divdiv").show();
				}else {
					$("#divdiv").hide();
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	}
	/*评论联动筛选*/
	function evaluatefl(obj,cid,name){
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Activity/collecadd');?>",
			data: {
				cid:cid,
				a_id:cid,
				cardid:name,
			},
			dataType: 'json',
			success: function(data){
				if (data.state == 1){
					//此处请求后台程序，下方是成功后的前台处理……

					$(obj).parents(".sc").find("p").prepend('<a onclick="admin_start(this,'+data.a_id+','+data.cardid+')" href="javascript:;"><img src="/Public/Activity/images/icon/colle1.svg"><span>收藏</span></a>');
					// $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
					$(obj).remove();
					layer.msg('已取消!',{icon: 5,time:1000});
				}else{
					layer.msg('哎呦，运气不好哦，取消失败咯！',function(){});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	}
	/*管理员-停用*/
	function admin_stop(obj,cid,aid,cardid){
		layer.confirm('确认要取消收藏吗？',function(index){
			$.ajax({
				type: 'POST',
				url: "<?php echo U('Activity/collecadd');?>",
				data: {
					cid:cid,
					a_id:aid,
					cardid:cardid,
				},
				dataType: 'json',
				success: function(data){
					if (data.state == 1){
						//此处请求后台程序，下方是成功后的前台处理……

						$(obj).parents(".sc").find("p").prepend('<a onclick="admin_start(this,'+data.a_id+','+data.cardid+')" href="javascript:;"><img src="/Public/Activity/images/icon/colle1.svg"><span>收藏</span></a>');
						// $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
						$(obj).remove();
						layer.msg('已取消!',{icon: 5,time:1000});
					}else{
						layer.msg('哎呦，运气不好哦，取消失败咯！',function(){});
					}
				},
				error:function(data) {
					console.log(data.msg);
				},
			});

		});
	}

	/*管理员-启用*/
	function admin_start(obj,id,cardid){
		layer.confirm('确认要收藏吗？',function(index){
			//alert(JSON.stringify(cardid));
			$.ajax({
				type: 'POST',
				url: "<?php echo U('Activity/collecadd');?>",
				data: {
					a_id:id,
					cardid:cardid,
				},
				dataType: 'json',
				success: function(data){
					//alert(JSON.stringify(data));
					if (data.state == 1){
						//此处请求后台程序，下方是成功后的前台处理……

						$(obj).parents(".sc").find("p").prepend('<a onclick="admin_stop(this,'+data.c_id+','+data.a_id+','+data.cardid+')" href="javascript:;"><img src="/Public/Activity/images/icon/colle2.svg"><span>取消收藏</span></a>');
						// $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
						$(obj).remove();
						layer.msg('已收藏!', {icon: 6,time:1000});
					}else{
						layer.msg('哎呦，运气不好哦，收藏失败咯！',function(){});
					}
				},
				error:function(data) {
					console.log(data.msg);
				},
			});
		});
	}
</script>
<!-- the end -->
<!-- 请在上方写相关业务脚本 -->
<script type="text/javascript" src="/Public/Activity/js/jquery-1.10.1.min.js"></script>
<!-- 轮播 -->
<script type="text/javascript" src="/Public/Activity/js/jflex.min.js"></script>
<script type="text/javascript">
	$('.banner').jFlex({
		autoplay: true
	});
</script>
<!-- 请在上方写相关业务代码 -->
<script src="/Public/Activity/js/jquery-labelauty.js"></script>
<script>
	$(function(){
		$('.xinput').labelauty();
	});
</script>
</body>
</html>