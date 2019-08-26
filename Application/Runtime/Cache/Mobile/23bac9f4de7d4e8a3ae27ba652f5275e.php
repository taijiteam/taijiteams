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

<style>
    .img a img
    {
        width: 54px;
        height: 53px;
    }
    .js_tit {
        color: #FFF;
        margin-top: 15px;
    }
    .font-gold {
        color: #D1B771;
    }
    .cnxh + container-fluid {
        margin-bottom:20px !important;
    }
    .gglist + container {
        margin-bottom:20px !important;
    }
</style>
<body>


<!--搜索-->
<div class="container-fluid index_a index">
    <div class="container top_sh" id="search_goods">
        <div class="back fl">
            <a href="/Home/Home/home">
                <img class="foimg_a" src="/Public/Mobile/images/home/go_back.png" style="width: 32px;height: 32px;padding: 7px">
            </a>
        </div>
        <div class="top_sch fl" style="border-color:#D1B771">
	           <span>
				<input type="submit" value=" " class="sch_a" >
	           </span>
            <input type="text" placeholder="稀世之珍，至臻品质！" style="border-left: none;" >
        </div>
    </div>
</div>



<!--index_banner-->
<?php if(!empty($show["index_banner"])): ?><div class="banner ixbanner container ">
        <div class="swiper-container ">
            <div class="swiper-wrapper">
                <?php if(is_array($show["index_banner"])): foreach($show["index_banner"] as $k=>$vo): ?><div class="swiper-slide">
                        <a href="javascript:;">
                            <img src="<?php echo ($vo['image']); ?>" height="250px">
                        </a>
                    </div><?php endforeach; endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div><?php endif; ?>

<!--banner-->
<?php if(!empty($show["banner"])): ?><div class="banner ixbanner container ">
        <div class="swiper-container ">
            <div class="swiper-wrapper">
                <?php if(is_array($show["banner"])): foreach($show["banner"] as $k=>$vo): if($vo['data_type'] == goods): ?><div class="swiper-slide">
                            <a href="/Mobile/Goods/detail?gc_id=<?php echo ($vo['data']); ?>">
                                <img src="<?php echo ($vo['goods_info']['main_img']); ?>" height="250px">
                            </a>
                        </div>
                        <?php elseif($vo['data_type'] == url): ?>
                        <div class="swiper-slide" style="height: 250px;">
                            <a href="<?php echo ($vo['data']); ?>">
                                <img src="<?php echo ($vo['image']); ?>">
                            </a>
                        </div><?php endif; ?>-->
                    <div class="swiper-slide">
                        <a href="javascript:;">
                            <img src="<?php echo ($vo['image']); ?>" height="250px">
                        </a>
                    </div><?php endforeach; endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div><?php endif; ?>


<!--商城公告-->
<!--<div class="bf scgg container-fluid mt10">-->
    <!--<div class="container">-->
        <!--<div class="scgg_a fl">-->
            <!--商城公告-->
        <!--</div>-->
        <!--<div class="scgg_b fl">-->
            <!--珍品商城 消费满5000送500积分-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->

<div style="background-color:#333333">
    <div style="line-height: 40px">
        <div style="float: left;width:88px;font-weight: 500;text-align: center;color: white;border-right:1px white solid;">
            商城公告
        </div>
        <div style="float: left;width:285px;">
            <div id="txtMarquee-left">
                <div class="hd">
                    <a class="next"></a>
                    <a class="prev"></a>
                </div>
                <div class="bd">
                    <div class="tempWrap" style="overflow:hidden; position:relative; width:270px">
                        <ul class="infoList" style="width:100%;overflow-x: hidden; position: relative; overflow: hidden; padding: 0px; margin: 0px; left: -270px;">
                            <li style="float: left; width: 1000px;overflow-x: hidden;">稀世之珍，至臻品质！我们将竭诚为广大成员推出最精致的商品。以热忱精心的服务回馈每一位成员！</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---->
<div class="gglist container" style="margin-bottom: 20px">
    <ul>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=艺术文化">
                <img src="/Public/Mobile/images/home/icon_artwork.png">
                <p class="font-gold">艺术文化</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=甄选名酒">
                <img src="/Public/Mobile/images/home/icon_liquor.png">
                <p class="font-gold">甄选名酒</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=营养保健">
                <img src="/Public/Mobile/images/home/icon_nutrition.png">
                <p class="font-gold">营养保健</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=珠宝首饰">
                <img src="/Public/Mobile/images/home/icon_jewelry.png">
                <p class="font-gold">珠宝首饰</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=工艺礼品">
                <img src="/Public/Mobile/images/home/icon_gift.png">
                <p class="font-gold">工艺礼品</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=私人定制">
                <img src="/Public/Mobile/images/home/icon_customize.png">
                <p class="font-gold">私人定制</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/cateList/?cate=积分兑换">
                <img src="/Public/Mobile/images/home/icon_pocket.png">
                <p class="font-gold">积分兑换</p>
            </a>
        </li>
        <li class="img">
            <a href="/Mobile/Index/category">
                <img src="/Public/Mobile/images/home/icon_all.jpg">
                <p class="font-gold">全部</p>
            </a>
        </li>
    </ul>
</div>
<!--每日甄选-->
<!--<div class="mr_jxs container">-->
    <!--<div class="js_tit">-->
        <!--每日甄选-->
    <!--</div>-->

    <!--<div class="mr_jx">-->
        <!--<ul>-->
            <!--<?php if(is_array($show["selected"])): foreach($show["selected"] as $k=>$vo): ?>-->
                <!--<li>-->
                    <!--<a href="<?php echo ($vo['data']); ?>">-->
                        <!--<div class="zoomImage" style="background-image:url(/Public/Mobile/images/121558024357.jpg)">-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
            <!--<?php endforeach; endif; ?>-->
        <!--</ul>-->
    <!--</div>-->
<!--</div>-->
<!--<div class="xsgs container">
    <div class="js_tit">
        每日甄选
    </div>
    <ul>
        <li><a href="#">
            <img src="/Public/Mobile/images/M752.jpg">
            <p>戒指2380元</p>
        </a></li>
        <li><a href="#">
            <img src="/Public/Mobile/images/M752.jpg">
            <p>戒指2380元</p>
        </a></li>
        <li><a href="#">
            <img src="/Public/Mobile/images/M752.jpg">
            <p>戒指2380元</p>
        </a></li>
        <li><a href="#">
            <img src="/Public/Mobile/images/M752.jpg">
            <p>戒指2380元</p>
        </a></li>
    </ul>
</div>-->
<div class="rmtjs container">
    <div class="js_tit">
        热门推荐
    </div>
    <div class="rmt">
        <img src="/Public/Mobile/images/ketch.jpg">
    </div>
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["selected"])): foreach($show["selected"] as $key=>$vo): ?><li>
                    <div class="ovh" style="overflow-y: hidden">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>
<!--<div class="rmtjs container">
    <div class="js_tit">
        品味生活
    </div>
    <div class="rmt">
        <img src="/Public/Mobile/images/sdtch.jpg">
    </div>
    <div class="rmtj">
        <ul>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
            <li><a href="#">
                <img src="/Public/Mobile/images/dsch.jpg">
                <h2>五福临门</h2>
                <p>quanzhan</p>
            </a></li>
        </ul>
    </div>
</div>-->
<div class="container">
    <div class="js_tit ">
        艺术文化
    </div>
</div>
<div class="cnxh container-fluid">
    <img src="/Public/Mobile/images/home/cate_artwork.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["artwork"])): foreach($show["artwork"] as $key=>$vo): ?><li>
                    <div class="ovh" style="overflow-y: hidden">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['artwork']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=艺术文化">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_artwork.png">
                        <p>更多艺术文化商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="container">
    <div class="js_tit ">
        甄选名酒
    </div>
</div>
<div class="cnxh container-fluid">
    <img src="/Public/Mobile/images/home/cate_liquor.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["liquor"])): foreach($show["liquor"] as $key=>$vo): ?><li>
                    <div class="ovh">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['liquor']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=甄选名酒">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_liquor.png">
                        <p>更多甄选名酒商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="container">
    <div class="js_tit ">
        营养保健
    </div>
</div>
<div class="cnxh container-fluid">
    <img src="/Public/Mobile/images/home/cate_nutrition.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["nutrition"])): foreach($show["nutrition"] as $key=>$vo): ?><li>
                    <div class="ovh">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['nutrition']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=营养保健">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_nutrition.png">
                        <p>更多营养保健商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="container">
    <div class="js_tit ">
        珠宝首饰
    </div>
</div>
<div class="cnxh container-fluid">
    <img src="/Public/Mobile/images/home/cate_jewelry.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["jewelry"])): foreach($show["jewelry"] as $key=>$vo): ?><li>
                    <div class="ovh">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['jewelry']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=珠宝首饰">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_jewelry.png">
                        <p>更多珠宝首饰商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="container">
    <div class="js_tit ">
        工艺礼品
    </div>
</div>
<div class="cnxh container-fluid">
    <img src="/Public/Mobile/images/home/cate_gift.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["gift"])): foreach($show["gift"] as $key=>$vo): ?><li>
                    <div class="ovh">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['gift']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=工艺礼品">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_gift.png">
                        <p>更多工艺礼品商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>


<div class="container">
    <div class="js_tit ">
        私人定制
    </div>
</div>
<div class="cnxh container-fluid" style="margin-bottom: 70px;">
    <img src="/Public/Mobile/images/home/cate_customize.png">
    <div class="allpro container">
        <ul>
            <?php if(is_array($show["customize"])): foreach($show["customize"] as $key=>$vo): ?><li>
                    <div class="ovh">
                        <a  href="<?php echo ($vo['data']); ?>">
                            <img src="<?php echo ($vo['goods_info']['main_img']); ?>" style="height: 150px">
                        </a>
                    </div>
                    <div class="pr_text">
                        <h1><?php echo ($vo['goods_info']['goods_name']); ?></h1>
                        <p><?php echo ($vo['goods_info']['goods_remark']); ?></p>
                        <div  class="pr_txt_a">
                            <div class="pr_ice fl">
                                <span><img src="/Public/Mobile/images/rw.png"></span>
                                <span class="ice_b"><?php echo ($vo['goods_info']['goods_price']); ?>.00</span>
                                <span class="ice_c">元</span>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
            <?php if(count($show['customize']) > 2): ?><li class="morelast">
                    <a href="/Mobile/Index/category/?cate=私人定制">
                        <img class="more_imga" src="/Public/Mobile/images/home/icon_customize.png">
                        <p>更多私人定制商品</p>
                        <img class="more_imgb" src="/Public/Mobile/images/home/has_more.png">
                    </a>
                </li><?php endif; ?>
        </ul>
    </div>
</div>


<!--悬浮-->
<div class="returntop">
    <img src="/Public/Mobile/images/725.png">
</div>
<!--publicfooter-->


<div class="container-fluid foots" style="padding-top: 4px;padding-bottom: 10px;height: 100px;bottom: -51px;">
    <ul>
        <?php if(Home == 'Home'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/home">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/home_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/home_1.png">
					</span>
                <p>首页</p>
            </a>
        </li>
        <?php if(Home == 'Category'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/category">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/category_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/category_1.png">
					</span>
                <p>分类</p>
            </a>
        </li>
        <?php if(Home == 'Cart'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Cart/index">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/cart_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/cart_1.png">
					</span>
                <p>购物车</p>
            </a>
        </li>
        <?php if(Home == 'Member'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
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
        $("#search_goods").click(function(){
            location.href = "/Mobile/Index/search_goods";
        });

        $("#txtMarquee-left").slide({
            mainCell:".bd ul",
            autoPlay:true,
            effect:"leftMarquee",
            interTime:50,
            trigger:"click"
        });
    })

</script>
</html>