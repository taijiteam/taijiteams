<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
<link href="/favicon.ico" rel="shortcut icon">
<meta name="viewport" content="target-densitydpi=device-dpi, width=375px, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>渠道Plus - 商城</title>
<meta name="keywords" content="关键词">
<meta name="description" content="描述">
<link rel="stylesheet" href="/Public/Mobile/css/swiper.min.css" />
<link rel="stylesheet" href="/Public/Mobile/css/common.css?v=<?php echo ($versions); ?>" />
<link rel="stylesheet" href="/Public/Mobile/css/style.css?v=<?php echo ($versions); ?>" />
</head>
<body>

<!--  <div class="pb_tp_a">
   <h1>已关闭 </h1>
     <a href="#" class="pbjta"><img src="/Public/Mobile/images/01322.png"></a>
 </div> -->
<div class="jyzttops container-fluid">
	<div class="container">
		<dbo><a href="/Mobile/Member/index"><img src="/Public/Mobile/images/sss.png"></a></dbo>
		<span><a href="/Mobile/Order/order_list">全部订单</a></span>
		<span><a href="/Mobile/Order/order_obligation">待付款</a></span>
		<span class="active"><a href="/Mobile/Order/order_paid">待收货</a></span>
		<!--<span><a href="/Mobile/Order/order_list/?id=9">退款订单</a></span>-->
		<span><a href="/Mobile/Order/order_received">待评价</a></span>
		<span><a href="/Mobile/Order/order_closed">已关闭</a></span>
	</div>
</div>


<?php if(is_array($res)): foreach($res as $key=>$vo): ?><div class="rysplists container-fluid">
		<div class="ry_aa">
			<div class="container">
				<div class="ovh fl">
					<a href="/Mobile/Goods/detail?gc_id=<?php echo ($vo["goods_common_id"]); ?>">
						<img src="<?php echo ($vo["main_img"]); ?>" style="width: 120px;height: 80px">
					</a>
				</div>
				<div class="rynrr fl">
					<div class="rynrr_a">
						<span><?php echo ($vo["goods_name"]); ?></span>
						<a href="#" class="nmir_j">积分消费</a>
					</div>
					<div class="rynrr_b">
						<p>
							<?php echo ($vo["goods_remark"]); ?>
						</p>
					</div>
					<div class="rynrr_c">
						<a href="/Mobile/Order/goods_received/?order_sn=<?php echo ($vo["order_sn"]); ?>">确认收货</a>
						<a class="wlxqbtn" href="javascript:void(0);">物流详情<img src="/Public/Mobile/images/sss.png"></a>
					</div>
				</div>
			</div>
		</div>
		<!--物流 信息-->
		<div class="wlzts">
			<div class="container">
				<div  class="wlzt_a">
					<div class="ovh fl">
						<img src="/Public/Mobile/images/4ds3.png">
					</div>
					<div  class="gftel fl">
						<h3>顺丰快递</h3>
						<p>官方电话  95338</p>
					</div>
				</div>

				<div  class="wlzt_b">
					<p>顺丰快递&nbsp;&nbsp;&nbsp;<span>246555558455</span><img src="/Public/Mobile/images/cy.png"></p>
				</div>
				<div class="wliu">
					<div class="wliulist">
						<div class="wliu_a fl">
						</div>
						<div class="wliu_b fl">
							<img src="/Public/Mobile/images/shou.png">
							<!-- <img src="/Public/Mobile/images/hc.png">
                            <img src="/Public/Mobile/images/zc.png">
                            <img src="/Public/Mobile/images/fh.png"> -->
						</div>
						<div class="wliu_c fl">
							<p>[收货地址] 上海上海市静安区延安西路300号
								10层前台</p>
						</div>
					</div>
					<div class="wliulist active">
						<div class="wliu_a fl">
							<p>下午</p>
							<p>15:12</p>
						</div>
						<div class="wliu_b fl">
							<img src="/Public/Mobile/images/hc.png">
						</div>
						<div class="wliu_c fl">
							<h3>运输中</h3>
							<p>快件在 [芜湖家电项目营业部分] 已装车，准备
								发往 [芜湖鸿鹄江集散中心]</p>
						</div>
					</div>
					<div class="wliulist">
						<div class="wliu_a fl">
							<p>下午</p>
							<p>14:55</p>
						</div>
						<div class="wliu_b fl">
							<img src="/Public/Mobile/images/zc.png">
						</div>
						<div class="wliu_c fl">
							<h3>已揽件</h3>
							<p>顺丰快运 已收取快件</p>
						</div>
					</div>
					<div class="wliulist">
						<div class="wliu_a fl">
							<p>下午</p>
							<p>14:02</p>
						</div>
						<div class="wliu_b fl">
							<img src="/Public/Mobile/images/fh.png">
						</div>
						<div class="wliu_c fl">
							<h3>已发货</h3>
							<p>包裹正在等待揽收</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><?php endforeach; endif; ?>


<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/all.js"></script>
</body>
</html>