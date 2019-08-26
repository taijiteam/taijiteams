<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>渠道•机场服务</title>
    <link rel="stylesheet" type="text/css" href="/Public/Airport/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/Airport/css/css.css">
    <link rel="stylesheet" type="text/css" href="http://www.qudaoplus.cn/statics/css/allfooter.css">
</head>
<body style="overflow-x:hidden;overflow-y:auto;">
<div class="fullSlide">
    <div class="bd">
        <ul>
            <li _src="url(/Public/Airport/images/1.jpg)" style="background:#E2025E center 0 no-repeat;background-size: 200%;"><a href="#"></a></li>
            <li _src="url(/Public/Airport/images/2.jpg)" style="background:#DED5A1 center 0 no-repeat;background-size: 200%;"><a href="#"></a></li>
            <li _src="url(/Public/Airport/images/3.jpg)" style="background:#B8CED1 center 0 no-repeat;background-size: 200%;"><a href="#"></a></li>
        </ul>
    </div>
    <div class="hd"><ul></ul></div>
    <span class="prev"></span>
    <span class="next"></span>
</div>
<div class="show-warp">
    <ul>
        <li style="background: #959595">
            <a href="index.html">浦东机场</a>
        </li>
        <li><a href="javascript:;">虹桥机场</a></li>
    </ul>
</div>
<div class="show-lists">
    <div class="show-img-left">
        <span style="background: #efc694"><a href="content_vip.html">VIP尊享服务</a></span>
        <span><a href="content_vvip.html">VVIP尊享服务</a></span>
        <span style="height: 60px;line-height: 60px;"><a href="reserve.html">预定须知</a></span>
    </div>
    <div class="show-img-right">
        <div class="show-top-img">
            <img src="/Public/Airport/images/index1.png" alt="">
            <img src="/Public/Airport/images/index2.png" alt="">
            <img src="/Public/Airport/images/index3.png" alt="">
        </div>
        <div class="show-bottom-img">
            <img src="/Public/Airport/images/index4.png" alt="">
            <img src="/Public/Airport/images/index5.png" alt="">
        </div>
    </div>
</div>
<div class="item-bottom">
    <h3>机场交通</h3>
    <img src="/Public/Airport/images/map.png">
</div>
<footer>
    <ul>
        <a href="index.html"><li><img src="/Public/Airport/images/icon/index.png"><span>首页</span></li></a>
        <a href="order.html"><li><img src="/Public/Airport/images/icon/order-copy2.png"><span>订单</span></li></a>
        <a href="center.html"><li><img src="/Public/Airport/images/icon/merber.png"><span>个人中心</span></li></a>
    </ul>
</footer>
</body>
<script type="text/javascript" src="/Public/Airport/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Airport/js/superslide.2.1.js"></script>
<script type="text/javascript">
    $(".fullSlide").hover(function(){
            $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
        },
        function(){
            $(this).find(".prev,.next").fadeOut()
        });
    $(".fullSlide").slide({
        titCell: ".hd ul",
        mainCell: ".bd ul",
        effect: "fold",
        autoPlay: true,
        autoPage: true,
        trigger: "click",
        startFun: function(i) {
            var curLi = jQuery(".fullSlide .bd li").eq(i);
            if ( !! curLi.attr("_src")) {
                curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
            }
        }
    });
</script>
</html>