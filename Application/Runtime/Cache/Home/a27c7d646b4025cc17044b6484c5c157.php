<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>渠道PLUS</title>
        <meta name="keywords" content="高端服务|订制化服务|高端人脉社交">
        <meta name="description" content="仅以订制化为5%的高端人群提供地址化服务">
        <meta name="renderer" content="webkit">
        <meta http-equiv="x-ua-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0,user-scalable=yes">
        <meta name="wap-font-scale" content="no">
        <link rel="shortcut icon" href="http://www.qudaoplus.cn/images/favicon.ico?v=1" type="image/x-icon">
        <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/jquery.min.js"></script>
        <!-- 加载更多插件 -->
        <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/jquery.scroll.loading.js"></script>
        <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/jquery.touchSwipe.min.js"></script>
        <script type="text/javascript">
            function pushHistory() {
                var state = {
                    title: "title",
                    url: "#"
                };
                window.history.pushState(state, "title", "#");
            }
            pushHistory();

            setTimeout(function(){
                window.addEventListener("popstate", function(e){
                    setTimeout(function(){
                        location.href="/Home/Home/home"
                    },1000)
                }, false)
            },1000);

        </script><link rel="stylesheet" href="http://www.qudaoplus.cn/statics/css/customized.css"></head>
</head>
<body>
<body>
<div class="content magazine" style="margin-bottom: 0px; height: 603px;">
    <div class="title">企业咨询</div>
    <em>
        <img src="http://www.qudaoplus.cn/statics/images/magazine/resource.jpg" alt="资源对接">
        <div class="num">渠道PLUS为成员们提供了税务、工商、消防、卫生、法律、金融等多方面私密咨询服务。<br>全力协助成员处理各类危机。</div>
    </em>
    <!--<a href="http://shop.qudaoplus.cn/Mobile/Index/index">商城测试</a>-->
    <a href="javascript:;">更多项目</a>
</div>

<link href="http://www.qudaoplus.cn/statics/css/footer.css?v=1" rel="stylesheet" type="text/css">          <!-- 底部导航 -->


<link rel="stylesheet" type="text/css" href="http://www.qudaoplus.cn/statics/css/allfooter.css">
<footer id="footer">
  <ul>
      <a href="http://www.qudaoplus.cn/merber_all_show/index.php/home/Personnal/central"><li class="core li"><em></em><span>成员中心</span></li></a>
      <a href="/Home/Home/home"><li class="vip on li"><em></em><span>成员专享</span></li></a>
      <!-- <a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=32"><li class="activity"><em></em><span>精彩活动</span></li></a> -->
      <a href="/Home/Home/tellMe"><li class="steward li"><em></em><span>联系管家</span></li></a>
  </ul>
</footer>





<script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/jquery.min.js"></script>
<script>

    $(document).ready(function(){
        $('.content').css({marginBottom: 0, height: $(window).height()});
    });

</script>
</body>
</body>
</html>