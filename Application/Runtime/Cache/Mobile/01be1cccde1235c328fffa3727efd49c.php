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
    <style>
        .font-gold {
            color: #D1B771;
        }
    </style>
</head>
<body>

<div class="container-fluid  hybag">
    <img src="/Public/Mobile/images/fghy.png">
</div>
<div class="zxdks container">
    <img src="/Public/Mobile/images/4722.png">
    <div class="zx_lt fl">
        <div class="ovh fl">
            <?php if(empty($member['m_img'])): ?><img src="/Public/Mobile/images/4ds3.png">
                <?php else: ?>
                <img src="/Public/Uploads/Member/<?php echo ($member['m_img']); ?>"><?php endif; ?>
        </div>
        <div  class="anso fl">
            <h3><?php echo ($member['m_cname']); ?></h3>
            <p><?php echo ($member['m_groupname']); ?></p>
        </div>
    </div>
    <div  class="zx_rt fr">
        <a href="javascript:void(0);">签到</a>
    </div>

    <div class="zx_c">
        <h4><?php echo ($member['m_groupname']); ?></h4>
    </div>
    <div class="zx_d">
        NO:<?php if(empty($member['m_num'])): ?>待审核
        <?php else: ?>
        <?php echo ($member['m_num']); endif; ?>
    </div>
</div>

<div  class="cyzsfl container">
    <img src="/Public/Mobile/images/2215442.png">
</div>


<div class="allds  container">
    <div  class="allds_a">
        <span class="fl">我的订单</span>

       <!-- <span class="fr"><a href="/Mobile/Order/order_list">全部订单</a></span>-->

    </div>
    <div class="alllistds">
        <ul>
            <li>
                <a href="/Mobile/Order/order_obligation">
                    <img src="/Public/Mobile/images/center_icon/obligation.png">
                    <p class="font-gold">待付款 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Order/order_paid">
                    <img src="/Public/Mobile/images/center_icon/paid.png">
                    <p class="font-gold">待收货 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Order/order_received">
                    <img src="/Public/Mobile/images/center_icon/received.png">
                    <p class="font-gold">待评价 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Order/order_closed">
                    <img src="/Public/Mobile/images/center_icon/closed.png">
                    <p class="font-gold">已关闭</p>
                </a>
            </li>
        </ul>
    </div>
</div>


<div class="allds  container" style="padding-top:20px;padding-bottom: 20px;">
    <div  class="allds_a">
        <span class="fl">我的服务</span>

    </div>
    <div class="alllistds">
        <ul>
            <li>
                <a href="/Mobile/Address/index">
                    <img src="/Public/Mobile/images/center_icon/address.png">
                    <p class="font-gold">地址管理 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Member/integral">
                    <img src="/Public/Mobile/images/center_icon/integral.png">
                    <p class="font-gold">我的积分 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Member/service_rules">
                    <img src="/Public/Mobile/images/center_icon/rules.png">
                    <p class="font-gold">协议规则 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Index/contact_us">
                    <img src="/Public/Mobile/images/center_icon/contact_us.png">
                    <p class="font-gold">联系我们 </p>
                </a>
            </li>
            <li>
                <a href="/Mobile/Member/collect">
                    <img src="/Public/Mobile/images/center_icon/collect.png">
                    <p class="font-gold">收藏 </p>
                </a>
            </li>
            <!-- <li>
            <a href="#">-->
            <!--<img src="/Public/Mobile/images/1011.png">-->
            <!--<p class="font-gold">用户反馈 </p>-->
            <!--</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="#">-->
            <!--<img src="/Public/Mobile/images/221041.png">-->
            <!--<p class="font-gold">系统消息 </p>-->
            <!--</a>
            </li>-->
            <li>
                <a href="/Mobile/Order/order_list">
                    <img src="/Public/Mobile/images/center_icon/all_order.png">
                    <p class="font-gold">全部订单 </p>
                </a>
            </li>
        </ul>
    </div>
</div>

<div  class="basetel container" style="line-height: 40px;">
    <p>客服电话：<a href="tel:02153067999">021 - 53067999</a></p>
</div>

<!--占位元素通用-->

<div class="ftbase container-fluid">
</div>

<!--publicfooter-->
<div class="container-fluid foots" style="padding-top: 4px;padding-bottom: 10px;height: 100px;bottom: -51px;">
    <ul>
        <?php if(Member == 'Home'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/home">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/home_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/home_1.png">
					</span>
                <p>首页</p>
            </a>
        </li>
        <?php if(Member == 'Category'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Index/category">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/category_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/category_1.png">
					</span>
                <p>分类</p>
            </a>
        </li>
        <?php if(Member == 'Cart'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
            <a href="/Mobile/Cart/index">
					<span>
						<img class="foimg_a" src="/Public/Mobile/images/nav_icon/cart_2.png">
						<img class="foimg_b" src="/Public/Mobile/images/nav_icon/cart_1.png">
					</span>
                <p>购物车</p>
            </a>
        </li>
        <?php if(Member == 'Member'): ?><li class="active"> <?php else: ?> <li><?php endif; ?>
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
</html>