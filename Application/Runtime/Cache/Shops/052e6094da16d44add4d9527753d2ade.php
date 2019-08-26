<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>渠道PLUS微管家商户平台V1.0-<?php echo ($_SESSION["s_name"]); ?></title>
</head>
<link rel="stylesheet" type="text/css" href="/Public/AdminShops/ertao/icon/iconfont.css">
<link rel="stylesheet" type="text/css" href="/Public/AdminShops/css/erTaoStyle.css">
<!-- zk -->
<link type="text/css" rel="stylesheet" href="/Public/AdminShops/css/theme.css">
<!-- the end -->
<body class="public">
<header>
	<!-- logo -->
	<!-- logo -->
	<a href="" class="logo"><img src="/Public/AdminShops/images/icon/logo.png"><span>渠道PLUS微管家商户平台V1.0</span></a>
	<div class="top">
		<a href="<?php echo U('Index/logout');?>"><i class="iconfont"><img src="/Public/AdminShops/images/icon/logout.png" style="width: 40px;"></i></a>
	</div>
	<div class="top">
		<a href=""><i class="iconfont">&#xe6fc;</i></a>
		<div>
			<h3><?php echo ($_SESSION["s_name"]); ?></h3>
			<p>ID:<?php echo ($_SESSION["s_shopid"]); ?></p>
		</div>
</header>
<div class="shops">
	<div class="service">
		<img src="/Public/AdminShops/images/icon/Logo2.jpg">
		<img src="/Public/AdminShops/images/icon/qudaoewm.jpg">
		<h3><i class="iconfont">&#xe613;</i>客服电话</h3>
		<h3>021-52839777</h3>
	</div>
	<div class="content">
		<div class="left">
			<div class="content_left">
				<div class="title"><span><?php echo ($_SESSION["s_name"]); ?></span></div>
				<div class="left_nav">
					<ul>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/index');?>">未结算订单</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/order');?>">已结算订单</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/member');?>">会员查询</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/memberSave');?>">后台管理</a></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="list">
			<div>
				<div class="title-1">
					<span>订单列表</span>
					<!-- 全局检索 -->
					<!--<div class="search">-->
						<!--<form>-->
							<!--<input type="text" class="text" name="" placeholder="搜索..."><input class="sub" type="submit" value="" name="">-->
						<!--</form>-->
					<!--</div>-->
					<!-- the end -->
				</div>
				<!-- <div class="top-3">
					<div class="oper">
						<a href="" class="xz">新增</a>
						<a href="" class="plsc">批量删除</a>
					</div>
				</div> -->
				<div class="list-1">
					<table>
						<thead>
							<tr>
								<td>序号</td>
								<td>订单号</td>
								<td>姓名</td>
								<td>联系电话</td>
								<td>就餐时间</td>
								<td>到店时间</td>
								<td>就餐人数</td>
								<td>特殊要求</td>
								<td>订单来源</td>
								<td>下单时间</td>
								<td>操作</td>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($mlist)): $i = 0; $__LIST__ = $mlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($key+1); ?></td>
								<td><?php echo ($order["o_number"]); ?></td>
								<td><?php echo ($order["o_user"]); ?></td>
								<td><?php echo ($order["o_phone"]); ?></td>
								<td><?php echo ($order["o_start"]); ?></td>
								<td><?php echo ($order["o_atime"]); ?></td>
								<td><?php echo ($order["o_nop"]); ?></td>
								<td><?php echo ($order["o_content"]); ?></td>
								<td><?php echo ($order["o_source"]); ?></td>
								<td><?php echo ($order["o_time"]); ?></td>
								<td><a href="javascript:;" onclick="money(this,'<?php echo ($order["o_number"]); ?>','<?php echo ($order["o_openid"]); ?>')">结算</a>|<a href="">查看</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							<!--<tr>-->
								<!--<td>2</td>-->
								<!--<td>24455</td>-->
								<!--<td>刘德华</td>-->
								<!--<td>17546569875</td>-->
								<!--<td>2019-03-16</td>-->
								<!--<td>18:00</td>-->
								<!--<td>3人</td>-->
								<!--<td>13755566644</td>-->
								<!--<td>还请安排一个安静的位置，谢谢</td>-->
								<!--<td><a href="javascript:;" onclick="money()">结算</a>|<a href="">查看</a></td>-->
							<!--</tr>-->
							<!--<tr>-->
								<!--<td>3</td>-->
								<!--<td>24455</td>-->
								<!--<td>刘德华</td>-->
								<!--<td>17546569875</td>-->
								<!--<td>2019-03-16</td>-->
								<!--<td>18:00</td>-->
								<!--<td>3人</td>-->
								<!--<td>13755566644</td>-->
								<!--<td>还请安排一个安静的位置，谢谢</td>-->
								<!--<td><a href="javascript:;" onclick="money()">结算</a>|<a href="">查看</a></td>-->
							<!--</tr>-->
						</tbody>
					</table>
					<div class="page">
						<?php echo ($page); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- zhankai  -->
<script charset="utf-8" type="text/javascript" src="/Public/AdminShops/js/jquery.js"></script>
<script charset="utf-8" type="text/javascript" src="/Public/AdminShops/js/theme.js"></script>
<!-- 请在下方写相关业务代码 -->
<link rel="stylesheet" type="text/css" href="/Public/Project/css/H-ui.min.css" />
<script type="text/javascript" src="/Public/Project/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<script src="/Public/Project/hui/lib/layui/layui.js" charset="utf-8"></script>
<!-- 请在上方写相关业务脚本 -->
<script>
function money(obj,id,openid) {
	var	html="结算消费：<input type='hidden' name='number' value="+id+"><input type='hidden' name='openid' value="+openid+">";
	$('#money_1').html(html);
	 setTimeout(function(){$("#money").fadeIn()}, (10));
}
function moneyclos(){
	setTimeout( function(){$("#money").fadeOut();}, (10));
}
function orderSave() {
	var money = $('input[name="money"]').val();	//出行时间
	var number = $('input[name="number"]').val();	//出行时间
	var openid = $('input[name="openid"]').val();	//出行时间
	var shopname = $('input[name="shopname"]').val();	//出行时间

	if(money == ''){
		$.Huimodalalert('请输入结算金额！',1500);
	}else{
		layer.confirm("<span style='display: block;text-align:center;'>您的结算金额为￥<span style='color: #f00'>"+money+"</span>！</span>",function(index){
		$.ajax({
			type:"post",
			url:"<?php echo U('Index/orderSave');?>",//根据自己项目的需要写请求地址
			data:{
				'money':money,
				'number':number,
				'openid':openid,
				'shopname':shopname,
			},
			dataType:'json',
			success:function(data){
				//alert(JSON.stringify(data));
				if (data == 1){
					layer.confirm('订单结算成功！',function(index){
						window.parent.location.reload();
					});
				}else{
					layer.msg('订单结算失败，请稍后重试！',function(){});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		})
		});
	}

}
</script>
<div id="money">
	<form action="" method="post">
		<h3 id="money_1">结算消费：</h3>
		<input type="hidden" name="shopname" value="<?php echo ($_SESSION['s_name']); ?>">
		<input type="number" name="money" placeholder="请输入消费金额" class="text"/>
		<input type="button" onclick="orderSave()" value="确认" class="sub"><a href="javascript:;" class="close" onclick="moneyclos()">关闭</a>
	</form>
</div>
</body>
</html>