<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="viewport"
          content="target-densitydpi=device-dpi, width=375px, user-scalable=no">
    <title>详情页</title>
    <link rel="stylesheet" type="text/css" href="/Public/Airport/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/Airport/css/css.css">
    <link rel="stylesheet" type="text/css" href="http://www.qudaoplus.cn/statics/css/allfooter.css">
    <script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
</head>
<body>
<div class="index-top">
    <img src="/Public/Airport/images/banner.png">
</div>
<div class="show-content">
    <div class="show-content-top">
        <p>渠道PLUS专享服务-VVIP服务</p>
    </div>
    <p>VIP服务：上海两机场内一楼通道直接进出机坪的接送机服务。包括协助办票和行李托运或提取、安排VVIP贵宾室休息、机坪内车辆摆渡、贵宾室现场安检(国际航班不含联检手续协办)、客人车辆停放安排等。</p>
    <h3 class="h3">服务项目</h3>
    <div class="show-content-img">
        <img src="/Public/Airport/images/VVIP.jpg" width="335px" height="330px" alt="">
    </div>
    <p>VIP服务：上海两机场内一楼通道直接进出机坪的接送机服务。包括协助办票和行李托运或提取、安排VVIP贵宾室休息、机坪内车辆摆渡、贵宾室现场安检(国际航班不含联检手续协办)、客人车辆停放安排等。</p>
</div>
    <div class="item-bottom">
        <h3>机场交通</h3>
        <?php if($type == '1'): ?><a href="http://api.map.baidu.com/geocoder?address=上海浦东机场&output=html" target='_blank'>
                <img  height="230" src="http://api.map.baidu.com/staticimage?
                        width=400&height=300&zoom=11&center=上海浦东机场">
            </a>
            <?php else: ?>
            <a href="http://api.map.baidu.com/geocoder?address=上海虹桥机场&output=html" target='_blank'>
                <img  height="230" src="http://api.map.baidu.com/staticimage?
                        width=400&height=300&zoom=11&center=上海虹桥机场">
            </a><?php endif; ?>
    </div>


    <div class="show-bottom" style="position: fixed;z-index: 99999;bottom: 0;width: 100%;">
        <div class="tell">
            <a href="tel:021-53067999">联系我们</a>
        </div>
        <div id="btn">
            <a href="/Home/Airport/population?type=<?php echo ($type); ?>">预订服务</a>
        </div>

    </div>

</body>
<script type="text/javascript" src="/Public/Airport/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Airport/js/superslide.2.1.js"></script>

</html>