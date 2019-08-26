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
	
    <div class="container-fluid index_a ixfenlei"  >
        <div class="container top_sh" id="search_goods">
	         <div class="top_sch">
	           <span></span>
	            <input type="text" placeholder="珍品商城 消费满5000送500积分" style="border-left: none;">
	         </div>
        </div>
    </div>
		
	<!--分类-->
	<div class="allpagions container-fluid">
		<div class="pagion_lt fl" data-cate="<?php echo ($cate['cate']); ?>">
			<ul id="cate-list">
				<li id="cate1" class="cate-list-item" data-cate-name="艺术文化"><a href="#">艺术文化</a></li>
				<li id="cate2" class="cate-list-item" data-cate-name="甄选名酒"><a href="#">甄选名酒</a></li>
				<li id="cate3" class="cate-list-item" data-cate-name="营养保健"><a href="#">营养保健</a></li>
				<li id="cate4" class="cate-list-item" data-cate-name="珠宝首饰"><a href="#">珠宝首饰</a></li>
				<li id="cate5" class="cate-list-item" data-cate-name="工艺礼品"><a href="#">工艺礼品</a></li>
				<li id="cate6" class="cate-list-item" data-cate-name="私人定制"><a href="#">私人定制</a></li>
			</ul>
		</div>
		<div class="paginon_rt fr">
			<div class="pagbanner">
				<img  id="cate_banner" src="/Public/Mobile/images/home/cate_artwork.png">
			</div>
			<div class="tit  tc" id="title">
				<span>
					<img src="/Public/Mobile/images/Rectangle3.png">
					<span id="cate-title">艺术文化</span>
					<img src="/Public/Mobile/images/Rectangle3.png">
				</span>
			</div>

			<div class="yswhfl">
				<ul id="cateList">

				</ul>
			</div>
		</div>
	</div>
	<!--publicfooter-->
	<div class="container-fluid foots" style="padding-top: 4px;padding-bottom: 10px;height: 100px;bottom: -51px;">
    <ul>
        <?php if(Category == 'Home'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/home">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/home_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/home_1.png">
					</span>
                <p>首页</p>
            </a>
        </li>
        <?php if(Category == 'Category'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/category">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/category_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/category_1.png">
					</span>
                <p>分类</p>
            </a>
        </li>
        <?php if(Category == 'Cart'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Cart/index">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/cart_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/cart_1.png">
					</span>
                <p>购物车</p>
            </a>
        </li>
        <?php if(Category == 'Member'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Member/index">
					<span>
                        <img class="foimg_b" src="/Public/Mobile/images/nav_icon/member_1.png">
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/member_2.png">
					</span>
                <p>我的</p>
            </a>
        </li>
    </ul>
</div>
	<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/jquery.SuperSlide.2.1.3.js"></script>
<script src="/Public/Mobile/js/all.js?v=<?php echo ($versions); ?>"></script>
</body>
<script type="text/javascript">
	$(function(){
		var cate = '<?php echo ($cate); ?>';
		init();
		function init() {
			$.ajax
			({
				type:'get',
				url:'/Mobile/Index/cate_goods',
				data:{
					cate:cate
				},
				dataType:'json',
				success:function (res) {
					if (res.code == 200)
					{
						var goods_html = create_goods_list(res.data);
						$('#cate-title').html(cate);
						$('.cate-list-item').removeClass('active');
						if(cate == '艺术文化'){
							$("#cate1").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_artwork.png");
						} else if(cate == '甄选名酒'){
							$("#cate2").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_liquor.png");
						}else if(cate == '营养保健'){
							$("#cate3").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_nutrition.png");
						}else if(cate == '珠宝首饰'){
							$("#cate4").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_jewelry.png");
						}else if(cate == '工艺礼品'){
							$("#cate5").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_gift.png");
						}else if(cate == '私人定制'){
							$("#cate6").addClass("active");
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_customize.png");
						}
						$('#cateList').append(goods_html);;
					}
				},
				error:function(data){
					console.log(data.message)
				}
			})
		}

        function create_goods_list(goods_list) {
            var html = '';

            for (i=0;i<goods_list.length;i++)
            {
                html = html +
                    '<li>\n' +
                    '<a href="/Mobile/Goods/detail?gc_id='+ goods_list[i].goods_common_id +'">\n' +
                    '<div class="ovh">\n' +
                    '<img src=" ' + goods_list[i].main_img+ '" style="width: 100%;max-height: 50px;">\n' +
                    '</div>\n' +
                    '<span> ' + goods_list[i].goods_name + '</span>\n' +
                    '</a>\n' +
                    '</li>'
            }

            return html;
        }

		$("#cate-list li").click(function() {
			var cate = $(this).attr('data-cate-name');
			var that = $(this);
			$.ajax({
				type:'get',
				url:'/Mobile/Index/cate_goods',
				data:{
					cate:cate
				},
				dataType:'json',
				success:function (res)
				{
					if (res.code == "200")
					{
						var goods_html = create_goods_list(res.data);
                        that.siblings('li').removeClass('active');
                        that.addClass('active');
						$('#cate-title').html(cate);
						$('#cateList').empty();
						$('#cateList').append(goods_html);

                        if(cate == '艺术文化'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_artwork.png");
                        } else if(cate == '甄选名酒'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_liquor.png");
                        }else if(cate == '营养保健'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_nutrition.png");
                        }else if(cate == '珠宝首饰'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_jewelry.png");
                        }else if(cate == '工艺礼品'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_gift.png");
                        }else if(cate == '私人定制'){
                            $("#cate_banner").attr("src","/Public/Mobile/images/home/cate_customize.png");
                        }
                    }
				},
				error:function(data){
					console.log(data.message)
				}
			})
		});
	});
</script>
<script type="text/javascript">
	$("#search_goods").click(function(){
		location.href = "/Mobile/Index/search_goods";
	});

</script>
</html>