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

<div class="container-fluid index_a">
	<div class="container top_sh">
		<a href="/Mobile/Index/home">
			<div class="back fl">
				<img src="/Public/Mobile/images/back.png">
			</div>
		</a>
		<div class="top_sch fl">
			<span><img src="/Public/Mobile/images/copy.png"></span>
			<input type="text" id="search_goods" placeholder="稀世之珍，至臻品质！" style="border-left: none;">
		</div>
		<div  class="sch_b fr" style="width: 50px">
			<input type="submit" id="search" value="搜索" style="width: 100%;">
		</div>
	</div>

	<!--banner-->
	<div class="banner container mt10">
		<div class="swiper-container ">
		    <div class="swiper-wrapper">
				<?php if($goodsList['0']['goods_category'] == '艺术文化' ): ?><div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_artwork.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '甄选名酒'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_liquor.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '营养保健'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_nutrition.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '珠宝首饰'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_jewelry.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '工艺礼品'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_gift.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '私人定制'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/cate_customize.png"></a></div>
					<?php elseif($goodsList['0']['goods_category'] == '积分兑换'): ?>
						<div class="swiper-slide"><a href="#"><img src="/Public/Mobile/images/home/index_banner2.png"></a></div><?php endif; ?>
		    </div>
		</div>
	</div>

	<!--pb-->
	<div class="tit container tc">
		<span><img src="/Public/Mobile/images/Rectangle3.png"><?php echo ($cate_name); ?><img src="/Public/Mobile/images/Rectangle3.png"></span>
	</div>

	<!--all list-->
	<div class="allpro container">
		<ul>
			<?php if(is_array($goodsList)): $k = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li>
					<div class="ovh">
					 <a  href="/Mobile/Goods/detail?gc_id=<?php echo ($vo["goods_common_id"]); ?>">
						<img src="<?php echo ($vo['main_img']); ?>" style="width: 167px;height: 110px">
					 </a>
					</div>
					<div class="pr_text">
						<h1><?php echo ($vo['goods_name']); ?></h1>
						<?php if($vo['goods_remark'] != ''): ?><p><?php echo ($vo['goods_remark']); ?></p>
						<?php else: endif; ?>

						<div  class="pr_txt_a">
							<div class="pr_ice fl">
								<span><img src="/Public/Mobile/images/rw.png"></span>
								<span class="ice_b"><?php echo ($vo['goods_price']); ?>.00</span>
								<?php if($cate_name == '积分兑换'): ?><span class="ice_c">积分</span>
								<?php else: ?>
									<span class="ice_c">元</span><?php endif; ?>
							</div>
							<!--<div class="pr_gwc fr">
								<a href="#"><img src="/Public/Mobile/images/gwc.png"></a>
							</div>-->
						</div>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			<!--<li>
				<div class="ovh">
					<a  href="#">
						<img src="/Public/Mobile/images/CQwlg341.jpg">
					</a>
				</div>
				<div class="pr_text">
					<h1>如意算盘</h1>
					<p>稀世珍木/代代相传</p>
					<div  class="pr_txt_a">
						<div class="pr_ice fl">
							<span><img src="/Public/Mobile/images/rw.png"></span>
							<span class="ice_b">399.00</span>
							<span class="ice_c">元</span>
						</div>
						<div class="pr_gwc fr">
							<a href="#"><img src="/Public/Mobile/images/gwc.png"></a>
						</div>
					</div>
				</div>
			</li>-->
		</ul>
	</div>
	<!--line-->

<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/all.js"></script>
</body>

</html>