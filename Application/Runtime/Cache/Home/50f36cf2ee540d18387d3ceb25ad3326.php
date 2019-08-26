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
<link rel="stylesheet" type="text/css" href="/Public/Doctor/css/style.css">
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=zlhzBss4C2XLAeDlKxNBdMfGwXk0qGPP"></script> -->
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<!-- 百度地图key -->
</head>
<body>
		<header>
		<banner class="banner">
			<img src="/Public/Doctor/images/banner1.png">
		</banner>
	</header>
	<div class="tcontent">
		<h3><img src="/Public/Doctor/images/tell.png">联系我们</h3>
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
	</div>
		<footer>
		<ul>
			<a href="<?php echo U('Doctor/index');?>">
				<li>
					<img src="/Public/Doctor/images/home.png">
					<p>首页</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/message');?>?m_merber=<?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?>">
				<li>
					<?php if($_SESSION['message_state'] == 1): ?><span style="width: 10px;height: 10px;background: #f00;display: block;border-radius: 5px;float: left;position: fixed;left: 43%;"></span>
						<?php else: endif; ?>
					<img src="/Public/Doctor/images/xiaoxi.png">
					<p>系统消息</p>
				</li>
			</a>
			<a href="<?php echo U('Doctor/center');?>">
				<li>
					<img src="/Public/Doctor/images/merber.png">
					<p>个人中心</p>
				</li> 
			</a>
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
      map.centerAndZoom(new BMap.Point(121.445845,31.225602),16);
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
        {content:"上海市静安区延安西路300号静安大厦10层",title:"渠道PLUS",imageOffset: {width:0,height:3},position:{lat:31.225679,lng:121.445899}},
      ];
      for(var index = 0; index < markers.length; index++ ){
        var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
        var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap//Public/Doctor/images/icon.png",new BMap.Size(20,25),{
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
      var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:3});
      map.addControl(navControl);
      var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_TOP_RIGHT,isOpen:false});
      map.addControl(overviewControl);
    }
    var map;
      initMap();
  </script>
</body>
</html>