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

<div class="pb_tp_a">
    <a href="/Mobile/Member/index" class="pbjta" style="margin-top: 0px"><img src="/Public/Mobile/images/01322.png"></a>
    <span style="font-size: 16px;margin-left: -36px;">我的积分</span>
    <a href="/Mobile/Member/service_rules" style="position:absolute;top:0px;right:8px;font-size: 12px;color: #d8d8d8;"><span style="text-decoration: underline ;" >积分规则</span></a>
</div>


<div class="jfbanner container">
    <img src="/Public/Mobile/images/55.png">
</div>
<div class="jyzttops jyztt container-fluid">
    <div class="container">
        <?php switch($memberInfo['m_groupname']): case "内部测试": ?><span class="pocket_0"><a href="/Mobile/Member/integral">总积分</a></span>
                <span class="pocket_1"><a href="/Mobile/Member/integral?integral_type=1">消费积分</a></span>
                <span class="pocket_201"><a href="/Mobile/Member/integral?integral_type=201">尊享积分</a></span><?php break;?>
            <?php case "尊享大咖": ?><span class="pocket_0"><a href="/Mobile/Member/integral">总积分</a></span>
                <span class="pocket_1"><a href="/Mobile/Member/integral?integral_type=1">消费积分</a></span>
                <span class="pocket_201"><a href="/Mobile/Member/integral?integral_type=201">尊享积分</a></span><?php break;?>
            <?php case "悦享成员": ?><span class="pocket_0"><a href="/Mobile/Member/integral">总积分</a></span>
                <span class="pocket_1"><a href="/Mobile/Member/integral?integral_type=1">消费积分</a></span><?php break; endswitch;?>
        <?php if($memberInfo['m_recognize'] == 1): ?><span class="pocket_4"><a href="/Mobile/Member/integral?integral_type=4">奖励积分</a></span><?php endif; ?>
    </div>
</div>
<div class="jifenxs container">
    <h3>积分情况</h3>
    <?php switch($integral_type): case "1": ?><p><span class="fl">消费积分</span><span class="fr"><?php echo ($info['a_consume_sort']); ?>积分</span></p><?php break;?>
        <?php case "201": ?><p><span class="fl">尊享积分</span><span class="fr"><?php echo ($info['a_jiu_sort']); ?>积分</span></p><?php break;?>
        <?php case "4": ?><p><span class="fl">奖励积分</span><span class="fr"><?php echo ($info['a_winning_sort']); ?>积分</span></p><?php break;?>
        <?php default: ?>
            <p><span class="fl">消费积分</span><span class="fr"><?php echo ($info['a_consume_sort']); ?>积分</span></p>
            <p><span class="fl">尊享积分</span><span class="fr"><?php echo ($info['a_jiu_sort']); ?>积分</span></p>
            <?php if($memberInfo['m_recognize'] == 1): ?><p><span class="fl">奖励积分</span><span class="fr"><?php echo ($info['a_winning_sort']); ?>积分</span></p><?php endif; endswitch;?>
    <?php if($integral_type == 0): elseif($integral_type == 1): ?>
        <p><span class="fl">消费积分</span><span class="fr"><?php echo ($info['a_consume_sort']); ?>积分</span></p><?php endif; ?>

</div>
<div class="jifenxs container">
    <h3>积分消费记录</h3>
<?php if(is_array($consumption)): foreach($consumption as $key=>$vo): ?><p>
        <?php if($vo["pocket_frm"] == 'dsign'): ?><span class="fl">签到积分</span>
            <?php elseif($vo["pocket_frm"] == 'order'): ?>
            <span class="fl">购买消费</span>
            <?php elseif($vo["pocket_frm"] == 'bonus'): ?>
            <span class="fl">下单返利</span>
            <?php elseif($vo["pocket_frm"] == 'admin'): ?>
            <span class="fl">商城赠送</span>
            <?php elseif($vo["pocket_frm"] == 'order_cancel'): ?>
            <span class="fl">订单返还</span><?php endif; ?>
        <span class="fr">
                <?php if($vo["pocket_frm"] == 'dsign'): ?>+
            <?php elseif($vo["pocket_frm"] == 'order'): ?>
                    -
            <?php elseif($vo["pocket_frm"] == 'bonus'): ?>
                    +
            <?php elseif($vo["pocket_frm"] == 'admin'): ?>
                    +
            <?php elseif($vo["pocket_frm"] == 'order_cancel'): ?>
                    +<?php endif; ?>
                <?php echo ($vo["pocket_value"]); ?></span></p><?php endforeach; endif; ?>
</div>

<!-- 导航栏 -->
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
<script>
    $(function(){
        var pocket_type = '<?php echo ($integral_type); ?>';

        init();


        function init(){
            $('.pocket_'+pocket_type).addClass("active");
        }
    })
</script>
</html>