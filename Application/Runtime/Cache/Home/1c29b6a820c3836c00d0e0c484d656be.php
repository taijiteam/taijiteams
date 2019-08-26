<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>联系我们</title>
<link rel="stylesheet" type="text/css" href="/Public/Airport/css/style.css">
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=zlhzBss4C2XLAeDlKxNBdMfGwXk0qGPP"></script> -->
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<!-- 百度地图key -->
<style type="text/css">
.tellme{
  color: #fff;
}
.tellme>header>img{
  width: 100%;
}
.tellme>header>h3{
  font-size: 14px;
  width: 90%;
  margin: auto;
  margin-bottom: 10px;
  color: rgb(250,196,84);
  margin-top: 5px;
}
.tellme>header>h3>img{
  width: 15px;
}
.tellme>div{
  width: 90%;
  margin: 10px auto;
}
.tellme>div>div>h4{
  font-size: 14px;
  margin: 0px;
    margin-top: 20px;
}
.tellme>div>div>p{
  	font-size: 12px;
  	margin: 0px;
	margin-top: 5px;
}
#margin-bottom{
  height: 50px;
}
</style>
</head>
<body class="tellme">
	<!-- 这里是头部 -->
<header class="cheader">
  <div>
    <p><img src="/Public/Airport/images/slider-arrow.png"></p>
  </div>
  <p><span class="span1"><img src="/Public/Airport/images/icon/tellme.png">联系我们</span><img class="dao" src="/Public/Airport/images/icon/dao.png"><!-- <span class="span2"></span> --></p>
</header>
	<div id="map">
		<div style="width:100%;height:175px;" id="dituContent"></div>
	</div>
	<div>
		<div>
			<h4>联系方式</h4>
			<p>地址：上海市静安区延安西路300号静安大厦10层</p>
			<p>电话/传真：<a href="tel:021-53069999" style="color: #4587e8;text-decoration: underline;">021-53067999</a></p>
		</div>
    <div>
      <h4>房产经理</h4>
      <p>联系人：杨经理</p>
      <p>手机号：<a href="tel:18918199799" style="color: #4587e8;text-decoration: underline;">18918199799</a></p>
    </div>
		<div>
			<h4>商务联系</h4>
			<p>联系人：洪经理</p>
			<p>手机号：<a href="tel:18918199899" style="color: #4587e8;text-decoration: underline;">18918199899</a></p>
			<!-- <p>联系人：程经理</p>
			<p>手机号：<a href="tel:18918195199" style="color: #4587e8;text-decoration: underline;">18918195199</a></p> -->
		</div>
		<div>
			<h4>加入我们</h4>
			<p>联系人：汤经理</p>
			<p>电&nbsp;&nbsp;话：<a href="tel:021-53820808" style="color: #4587e8;text-decoration: underline;">021-53820808</a></p>
		</div>
	</div>
	<p id="margin-bottom"></p>
	<footer>
		<ul>
			<a href="index.html"><li><img src="/Public/Airport/images/icon/index.png"><span>首页</span></li></a>
			<a href="order.html"><li><img src="/Public/Airport/images/icon/order-copy2.png"><span>订单</span></li></a>
			<a href="center.html"><li><img src="/Public/Airport/images/icon/merber.png"><span>个人中心</span></li></a>
		</ul>
	</footer>
    <script type="text/javascript">
    //创建和初始化地图函数：
    function initMap(){
      createMap();//创建地图
      setMapEvent();//设置地图事件
      addMapControl();//向地图添加控件
      addMapOverlay();//向地图添加覆盖物
    }
    function createMap(){ 
      map = new BMap.Map("dituContent"); 
      map.centerAndZoom(new BMap.Point(121.445966,31.225575),18);
    }
    function setMapEvent(){
      map.enableScrollWheelZoom();
      map.enableKeyboard();
      map.enableDragging();
      map.enableDoubleClickZoom()
    }
    function addClickHandler(target,window){
      target.addEventListener("click",function(){
        target.openInfoWindow(window);
      });
    }
    function addMapOverlay(){
      var markers = [
        {content:"延安西路300号静安大厦10楼",title:"渠道PLUS",imageOffset: {width:0,height:3},position:{lat:31.22566,lng:121.445903}}
      ];
      for(var index = 0; index < markers.length; index++ ){
        var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
        var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap/images/icon.png",new BMap.Size(20,25),{
          imageOffset: new BMap.Size(markers[index].imageOffset.width,markers[index].imageOffset.height)
        })});
        var label = new BMap.Label(markers[index].title,{offset: new BMap.Size(25,5)});
        var opts = {
          width: 200,
          title: markers[index].title,
          enableMessage: false
        };
        var infoWindow = new BMap.InfoWindow(markers[index].content,opts);
        marker.setLabel(label);
        addClickHandler(marker,infoWindow);
        map.addOverlay(marker);
      };
    }
    //向地图添加控件
    function addMapControl(){
      var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
      scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
      map.addControl(scaleControl);
      var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
      map.addControl(navControl);
    }
    var map;
      initMap();
  </script>
</body>
</html>