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
		<span class="active"><a href="/Mobile/Order/order_obligation">待付款</a></span>
		<span><a href="/Mobile/Order/order_paid">待收货</a></span>
		<!--<span><a href="/Mobile/Order/order_list/?id=9">退款订单</a></span>-->
		<span ><a href="/Mobile/Order/order_received">待评价</a></span>
		<span><a href="/Mobile/Order/order_closed">已关闭</a></span>
	</div>
</div>

<?php if(is_array($res)): foreach($res as $key=>$vo): ?><div class="rysplists container-fluid order-item" data-order-sn="<?php echo ($vo["order_sn"]); ?>">
		<?php switch($vo["order_status"]): case "1": ?><div class="ry_aa">
					<div class="container">
						<div class="ovh fl">
							<a href="/Mobile/Goods/detail?gc_id=<?php echo ($vo["goods_common_id"]); ?>">
								<img src="<?php echo ($vo["main_img"]); ?>" style="width: 120px;height: 80px">
							</a>
						</div>
						<div class="rynrr fl">
							<div class="rynrr_a mt0">
								<span><?php echo ($vo["goods_name"]); ?></span>
								<div class="m_zfzt">
									<a href="/Mobile/Order/order_confirm?goods_id=<?php echo ($vo["goods_id"]); ?>&num=<?php echo ($vo["goods_num"]); ?>">去支付</a>
									<a style="margin-top: 4px" href="javascript:;" data-order-sn="<?php echo ($vo["order_sn"]); ?>" class="order_close">取消</a>
								</div>
							</div>
							<div class="rynrr_b">
								<div class="ys_nr_b  mt10">
									<span><img src="/Public/Mobile/images/rs1.png"></span>
									<span class="ice_b"><?php echo ($vo["goods_price"]); ?>.00</span>
								</div>
								<p>
									<?php echo ($vo["goods_remark"]); ?>
								</p>
							</div>
						</div>
					</div>
				</div><?php break;?>
			<?php case "2": ?><div class="ry_aa">
					<div class="container">
						<div class="ovh fl">
							<a href="/Mobile/Goods/detail?gc_id=<?php echo ($vo["goods_common_id"]); ?>">
								<img src="<?php echo ($vo["main_img"]); ?>" style="width: 120px;height: 80px">
							</a>
						</div>
						<div class="rynrr fl">
							<div class="rynrr_a mt0">
								<span><?php echo ($vo["goods_name"]); ?></span>
								<div class="m_zfzt">
									<a href="/Mobile/Order/order_confirm?goods_id=<?php echo ($vo["goods_id"]); ?>&num=<?php echo ($vo["goods_num"]); ?>">已支付</a>
								</div>
							</div>
							<div class="rynrr_b">
								<div class="ys_nr_b  mt10">
									<span><img src="/Public/Mobile/images/rs1.png"></span>
									<span class="ice_b"><?php echo ($vo["goods_price"]); ?>.00</span>
								</div>
								<p>
									<?php echo ($vo["goods_remark"]); ?>
								</p>
							</div>
						</div>
					</div>
				</div><?php break; endswitch;?>
	</div><?php endforeach; endif; ?>




<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/all.js"></script>
</body>
</html>
<script>
	$(function(){
		$(document).on("click",".order-item",function(){
			var order_sn = $(this).attr("data-order-sn");
			if(order_sn){
				window.location.href = "/Mobile/Order/order_detail?order_sn="+order_sn;
			}else{
				return false;
			}
		});

		$('.order_close').click(function () {
			var order_sn = $(this).attr('data-order-sn');
			$.ajax({
				type : "get",
				url  : '/Mobile/Order/cancel_order',
				data : {
					id : order_sn,
				},
				dataType : 'json',
				success : function (res) {
					if (res.code == "200")
					{

					}

				}
			})
		})
	})
</script>