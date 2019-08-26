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
	<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
</head>
<body style="overflow-x:hidden;overflow-y:auto;">
<div class="fullSlide">
	<div class="bd">
		<ul>
			<li _src="url(/Public/Airport/images/1.jpg)" style="background:#E2025E center 0 no-repeat;background-size: 100%;"><a href="javascript:;"></a></li>
			<li _src="url(/Public/Airport/images/2.jpg)" style="background:#DED5A1 center 0 no-repeat;background-size: 100%;"><a href="javascript:;"></a></li>
			<li _src="url(/Public/Airport/images/3.jpg)" style="background:#B8CED1 center 0 no-repeat;background-size: 100%;"><a href="javascript:;"></a></li>

		</ul>
	</div>
	<div class="hd"><ul></ul></div>
	<span class="prev"></span>
	<span class="next"></span>
</div>
<div class="show-warp">
	<ul>
		<li>
			<a href="javascript:;">浦东机场</a>
		</li>
		<li style="background: #959595"><a href="/Home/Airport/index_copy">虹桥机场</a></li>
	</ul>
</div>
<div class="show-lists">
	<div class="show-img-left">
		<span style="background: #efc694"><a href="/Home/Airport/content_vip?type=1">VIP尊享服务</a></span>
		<span><a href="/Home/Airport/content_vvip?type=1">VVIP尊享服务</a></span>
		<span style="height: 60px;line-height: 60px;"><a href="/Home/Airport/reserve">预定须知</a></span>
	</div>
	<div class="show-img-right">
		<div class="show-top-img">
			<img src="/Public/Airport/images/index1.jpg" alt="">
			<img src="/Public/Airport/images/index2.jpg" alt="">
			<img src="/Public/Airport/images/index3.jpg" alt="">
		</div>
		<div class="show-bottom-img">
			<img src="/Public/Airport/images/index4.jpg" alt="">
			<img src="/Public/Airport/images/index5.jpg" alt="">
		</div>
	</div>
</div>
<div class="item-bottom">
	<h3>机场交通</h3>
	<div style="width: 334px;height:175px;margin: 0 0.8em" id="dituContent"></div>
</div>

<!-- 这里是底部 -->
<footer>
    <ul>
        <a href="/Home/Airport/index?openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/index.png"><span>首页</span></li></a>
        <a href="/Home/Airport/order/Home/Airport/order?o_state&openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/order-copy2.png"><span>订单</span></li></a>
        <a href="/Home/Airport/center?openid=<?php echo ($_SESSION['openid']); ?>"><li><img src="/Public/Airport/images/icon/merber.png"><span>个人中心</span></li></a>
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
		map.centerAndZoom(new BMap.Point(121.861218,31.142566),11);
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
			{content:"浦东机场",title:"浦东机场",imageOffset: {width:0,height:3},position:{lat:31.22566,lng:121.445903}}
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
</html>