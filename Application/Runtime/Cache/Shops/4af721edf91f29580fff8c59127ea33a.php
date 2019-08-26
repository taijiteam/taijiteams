<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>渠道PLUS微管家商户平台V1.0-<?php echo ($_SESSION["s_name"]); ?></title>
</head>
<link rel="stylesheet" type="text/css" href="/Public/AdminShops/ertao/icon/iconfont.css">
<link rel="stylesheet" type="text/css" href="/Public/AdminShops/css/erTaoStyle.css">
<!-- zk -->
<link type="text/css" rel="stylesheet" href="/Public/AdminShops/css/theme.css">
<!-- the end -->
<body class="public">
<header>
	<!-- logo -->
	<!-- logo -->
	<a href="" class="logo"><img src="/Public/AdminShops/images/icon/logo.png"><span>渠道PLUS微管家商户平台V1.0</span></a>
	<div class="top">
		<a href="<?php echo U('Index/logout');?>"><i class="iconfont"><img src="/Public/AdminShops/images/icon/logout.png" style="width: 40px;"></i></a>
	</div>
	<div class="top">
		<a href=""><i class="iconfont">&#xe6fc;</i></a>
		<div>
			<h3><?php echo ($_SESSION["s_name"]); ?></h3>
			<p>ID:<?php echo ($_SESSION["s_shopid"]); ?></p>
		</div>
</header>
<div class="shops">
	<div class="service">
		<img src="/Public/AdminShops/images/icon/Logo2.jpg">
		<img src="/Public/AdminShops/images/icon/qudaoewm.jpg">
		<h3><i class="iconfont">&#xe613;</i>客服电话</h3>
		<h3>021-52839777</h3>
	</div>
	<div class="content">
		<div class="left">
			<div class="content_left">
				<div class="title"><span><?php echo ($_SESSION["s_name"]); ?></span></div>
				<div class="left_nav">
					<ul>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/index');?>">未结算订单</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/order');?>">已结算订单</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/member');?>">会员查询</a></div>
						</li>
						<li>
							<div class="t"><i></i><a href="<?php echo U('Index/memberSave');?>">后台管理</a></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="list">
			<div>
				<div class="title-1">
					<span>会员查询</span>
					<!-- 全局检索 -->
					<!-- <div class="search">
						<form>
							<input type="text" class="text" name="" placeholder="搜索..."><input class="sub" type="submit" value="" name="">
						</form>
					</div> -->
					<!-- the end -->
				</div>
				<!-- <div class="top-3">
					<div class="oper">
						<a href="" class="xz">新增</a>
						<a href="" class="plsc">批量删除</a>
					</div>
				</div> -->
				<div class="member">
					<h3>请输入会员账号</h3>
					<form action="" method="post" class="layui-form">
						<input type="number" class="text" name="cardid" placeholder="请输入会员ID/手机号">
						<!--<input class="sub" type="submit" value="查询">-->
						<a href="javascript:;" onclick="memberSel()" class="sub">查询</a>
					</form>
					<div id="info">
						<p>渠道PLUS微管家</p>
						<p>尊享大咖</p>
						<p>姓名：张三</p>
						<p>性别：男</p>
						<p>年龄：35岁</p>
						<p>生日：1980-02-08</p>
						<p>联系电话：021-52829777</p>
					</div>
				</div>
				<div class="member">
					<h3>请输入消费金额</h3>
					<form action="" method="post" class="layui-form">
						<input type="number" class="text" name="money" placeholder="请输入消费金额">
						<input type="hidden" name="shopid" value="<?php echo ($_SESSION['s_shopid']); ?>">
						<!--<input class="sub" type="submit" value="查询">-->
						<a href="javascript:;" onclick="moneyCardid()" class="sub">结算</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- zhankai  -->
<script charset="utf-8" type="text/javascript" src="/Public/AdminShops/js/jquery.js"></script>
<script charset="utf-8" type="text/javascript" src="/Public/AdminShops/js/theme.js"></script>
<!-- 请在下方写相关业务代码 -->
<link rel="stylesheet" type="text/css" href="/Public/Project/css/H-ui.min.css" />
<script type="text/javascript" src="/Public/Project/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<script src="/Public/Project/hui/lib/layui/layui.js" charset="utf-8"></script>
<!-- 请在上方写相关业务脚本 -->
<script type="text/javascript">
function memberSel() {
	var cardid = $('input[name="cardid"]').val();	//出行时间
	if(cardid == ''){
		$.Huimodalalert('请输入会员ID/手机号！',1500);
	}else{
		$.ajax({
			type:"post",
			url:"<?php echo U('Index/memberSel');?>",//根据自己项目的需要写请求地址
			data:{
				'cardid':cardid,
			},
			dataType:'json',
			success:function(data){
				//alert(JSON.stringify(data));
				if (data['status'] == 0){
					var sex = data['data']['0']['Sex']==1?"先生":"女士";
					var birth = data['data']['0']['Birthday']==undefined?" ":data['data']['0']['Birthday'];
					var age = data['data']['0']['Birthday']==undefined?" ":jsGetAge(data['data']['0']['Birthday'])+'岁';
				    var	html="<input type='hidden' name='cardida' value="+data['data']['0']['CardId']+"><p>渠道PLUS微管家</p><p>"+data['data']['0']['MemberGroupName']+"</p><p>姓名："+data['data']['0']['TrueName']+"</p><p>性别："+sex+"</p><p>年龄："+age+"</p><p>生日："+birth+"</p><p>联系电话："+data['data']['0']['Mobile']+"</p>";
					$('#info').html(html);
				}else{
					layer.msg('不好意思查询不到哦，请验证后在查询！',function(){});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		})
	}
}
function moneyCardid() {
	var cardida = $('input[name="cardida"]').val();	//出行时间
	var money = $('input[name="money"]').val();	//出行时间
	var shopid = $('input[name="shopid"]').val();	//出行时间
	if(cardida == '' || cardida == undefined){
		$.Huimodalalert('未验证会员身份无法结算！',1500);
	}else if(money == ''){
		$.Huimodalalert('请输入结算金额！',1500);
	}else if(shopid == ''){
		$.Huimodalalert('您登陆超时，请重新登陆后操作！',1500);
	}else{
		layer.confirm("<span style='display: block;text-align:center;'>您的结算金额为￥<span style='color: #f00'>"+money+"</span>！</span>",function(index){
		$.ajax({
			type:"post",
			url:"<?php echo U('Index/moneyCardid');?>",//根据自己项目的需要写请求地址
			data:{
				'cardid':cardida,
				'money':money,
				'shopid':shopid,
			},
			dataType:'json',
			success:function(data){
				//alert(JSON.stringify(data));
				if (data == 1){
					layer.confirm('订单结算成功！',function(index){
						window.parent.location.reload();
					});
				}else{
					layer.msg('订单结算失败，请稍后重试！',function(){});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		})
		});
	}
}
/*根据出生日期算出年龄*/
function jsGetAge(strBirthday){
	var returnAge;
	var strBirthdayArr=strBirthday.split("-");
	var birthYear = strBirthdayArr[0];
	var birthMonth = strBirthdayArr[1];
	var birthDay = strBirthdayArr[2];

	d = new Date();
	var nowYear = d.getFullYear();
	var nowMonth = d.getMonth() + 1;
	var nowDay = d.getDate();

	if(nowYear == birthYear){
		returnAge = 0;//同年 则为0岁
	}
	else{
		var ageDiff = nowYear - birthYear ; //年之差
		if(ageDiff > 0){
			if(nowMonth == birthMonth) {
				var dayDiff = nowDay - birthDay;//日之差
				if(dayDiff < 0){
					returnAge = ageDiff - 1;
				}
				else{
					returnAge = ageDiff ;
				}
			}
			else{
				var monthDiff = nowMonth - birthMonth;//月之差
				if(monthDiff < 0){
					returnAge = ageDiff - 1;
				}
				else{
					returnAge = ageDiff ;
				}
			}
		}
		else{
			returnAge = -1;//返回-1 表示出生日期输入错误 晚于今天
		}
	}
	return returnAge;//返回周岁年龄
}
</script>
</body>
</html>