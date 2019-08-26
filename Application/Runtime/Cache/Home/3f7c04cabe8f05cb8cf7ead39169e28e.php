<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- 防止手机点击放大问题 -->
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-- the end -->
<title>活动报名</title>
<link rel="stylesheet" href="/Public/Activity/css/jflex.min.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="/Public/Activity/css/ertaostyle.css">
</head>
<style type="text/css">
.site>.body{
	color: #fff;
	margin-bottom: 60px;
	margin-top: 10px;
}
.site>.body>div{
	overflow: hidden;
	border: 1px solid #fff;
	width: 90%;
	margin: 0 auto;
}
.site>.body>div>span{
	display: block;
	float: left;
	width: 40%;
	height: 25vw;
	background: rgb(216,216,216);
}
.site>.body>div>span>img{
	width: 100%;
	height: 25vw;
}
.site>.body>div>div{
	width: 55%;
	display: block;
	float: left;
	margin-left: 5%;
}
.site>.body>div>div>p{
	font-size: 14px;
	margin: 0px;
	line-height: 20px;
}
.site>.body>div>div>p>span{
	font-size: 12px;
}
.site>.body>div>div>p>.rmb{
	color: rgb(137,203,63);
	padding-left: 20px;
}
.site>.body>form{
	overflow: hidden;
	margin: 20px auto;
	width: 90%;
}
.site>.body>form>p{
	margin: 10px 0;
	line-height: 25px;
	overflow: hidden;
}
.site>.body>form>p>span{
	color: rgb(243,194,84);
	font-size: 14px;
	text-align: right;
	display: block;
	float: left;
	width: 25%;
}
.site>.body>form>p>input{
	background: none;
	border: 1px solid rgb(65,117,5);
	display: block;
	float: left;
	color: #fff;
	line-height: 23px;
	border-radius: 5px;
	padding-left: 6px;
	margin-left: 5%;
}
.site>.body>form>h5{
	color: rgb(248,194,84);
	font-size: 14px;
	margin: 0;
	line-height: 25px;
}
.site>.body>form>textarea{
	width: 100%;
	padding: 2%;
	color: #fff;
	background: rgb(65,64,64);
	border: 1px solid rgb(65,117,5);
}
.site>.body>form>span{
	font-size: 12px;
	display: block;
}
.site>.body>form>span>span{
	color: rgb(248,194,84);
}
.site>.body>form>div{
	text-align: center;
	font-size: 12px;
	overflow: hidden;
	margin-top: 15px
}
.site>.body>form>div>input{
	display: block;
	float: left;
	margin: 2px 2px 0px 20%;
}
.site>.body>form>div>a{
	display: block;
	float: left;
	color: #325eb7;
}
.site>footer>.sc{
	width: 50%;
	color: #fff;
	background: rgb(62,62,62);
	display: block;
	float: left;
	text-align: center;
	line-height: 45px;
}
.site>footer>.sc>p{
	margin: 0px;
	overflow: hidden;
}
.site>footer>.sc>p>a{
	width: 100%;
	height: 100%;
	overflow: hidden;
	display: inline-block;
}
.site>footer>.sc>p>a>img{
	width: 20px;
	display: block;
	float: left;
	margin-top: 13px;
	margin-left: 32%;
}
.site>footer>.sc>p>a>span{
	display: block;
	float: left;
}
.site>footer>a{
	width: 50%;
	margin: 0;
	color: #fff;
	background: rgb(65,117,5);
	display: block;
	float: left;
	text-align: center;
	line-height: 45px;
}

/*the end*/
</style>
<body class="site">
<div class="body">
	<div>
		<span><img src="/Public/Uploads/Activity/<?php echo ($content["a_img"]); ?>"></span>
		<div>
			<p style="font-weight: bold;color: rgb(243,194,84);"><?php echo ($content["a_title"]); ?></p>
			<p><span><?php echo ($content["a_start"]); ?></span></p>
			<p><span><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($content["a_address"])),0,4,'utf-8')); ?></span> <span class="rmb"><?php if($content["a_price"] == ''): ?>免费<?php else: ?>￥<?php echo ($content["a_price"]); ?>起<?php endif; ?></span></p>
		</div>
	</div>
	<form>
		<p><span>联系人</span><input type="text" name="name" value="<?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?>"></p>
		<p><span>联系电话</span><input type="text" name="phone" value="<?php echo ($_SESSION['infor']['data'][0]['Mobile']); ?>"></p>
		<p><span>公司</span><input type="text" name="work" value="<?php echo ($_SESSION['infor']['data'][0]['ExtValue3']); ?>"></p>
		<p><span>职位</span><input type="text" name="position" value="<?php echo ($_SESSION['infor']['data'][0]['ExtValue8']); ?>"></p>
		<h4 style="font-size: 14px;color: rgb(243,194,84);margin-bottom: 5px;">特殊要求(选填)</h4>
		<textarea rows="8" id="text" cols="20" placeholder="请输入"></textarea>
		<span>温馨提示：</span>
		<span>需求提交成功后请注意关注【<span>渠道PLUS微管家公众号</span>】</span>
		<div><input type="checkbox" name="o_around" value="1" checked="checked"><a href="cluase.html">【渠道PLUS微管家平台服务条款】</a></div>
		<input type="hidden" name="id" value="<?php echo ($content["a_id"]); ?>">
		<input type="hidden" name="price" value="<?php echo ($content["a_price"]); ?>">
		<input type="hidden" name="cardid" value="<?php echo ($_SESSION['cardId']); ?>">
		<input type="hidden" name="openid" value="<?php echo ($_SESSION['openid']); ?>">
	</form>
</div>
<footer style="height: 45px;">
	<div class="sc">
		<p>
			<a href="tel:021-53069999"><img src="/Public/Activity/images/icon/tellme.png"><span>&nbsp;联系我们</span></a>
		</p>
	</div>
	<a href="javascript:;" onclick="actsub()">提交报名</a>
</footer>
<link rel="stylesheet" type="text/css" href="/Public/Project/css/H-ui.min.css" />
<script type="text/javascript" src="/Public/Project/hui/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Project/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Project/hui/lib/layer/2.4/layer.js"></script>
<!-- 请在上方写相关业务脚本 -->
<script type="text/javascript">
function actsub(){
	var name = $('input[name="name"]').val();	//出行时间
	var phone = $('input[name="phone"]').val();	//请输入到店时间
	var work = $('input[name="work"]').val();	//请输入就餐人数
	var position = $('input[name="position"]').val();			//联系人
	var o_around = $('input[name="o_around"]:checked').val();//就餐环境
	var text = $("#text").val();					//特殊需求
	var cardid = $('input[name="cardid"]').val();		//openid
	var id = $('input[name="id"]').val();			//p_id
	var price = $('input[name="price"]').val();			//p_id
	var openid = $('input[name="openid"]').val();			//openid
	if(o_around == undefined){
		$.Huimodalalert('警告：如果您拒绝《渠道PLUS微管家平台服务条款》，将无法继续享受服务！！',2000);
	}else if(name == ''){
		$.Huimodalalert('警告：请输入您的姓名！！',2000);
	}else if(phone == ''){
		$.Huimodalalert('警告：请填写您的联系电话！！',2000);
	}else if(work == ''){
		$.Huimodalalert('警告：请填写您的单位！！',2000);
	}else if(position == ''){
		$.Huimodalalert('警告：请填写您的职务！！',2000);
	}else if (cardid == ''){
		$.Huimodalalert('警告：登录超时，或未登录！<br>请重新登录！！',2000);
	}else if (id == ''){
		$.Huimodalalert('警告：登录超时，或未登录！<br>请重新登录！！',2000);
	}else{
		$.ajax({
			type:"post",
			url:"/HomeActivity/actsub",
			data:{
				'name':name,
				'phone':phone,
				'work':work,
				'position':position,
				'text':text,
				'cardid':cardid,
				'id':id,
				'price':price,
				'openid':openid,
			},
			dataType:'json',
			success:function(data){
				//alert(JSON.stringify(data));
				if (data == 1){
					layer.confirm('恭喜您报名成功！',function(index){
						location.href="http://www.qudaoplus.cn/merber_all_show/index.php/Home/Activity/center/"
						//window.parent.location.reload();
						// var index = parent.layer.getFrameIndex(window.name);
						// parent.layer.close(index);
					});
				}else{
					layer.msg('哎呦，运气不好哦，报名失败咯！',function(){});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		})
	}
}
</script>
</body>
</html>