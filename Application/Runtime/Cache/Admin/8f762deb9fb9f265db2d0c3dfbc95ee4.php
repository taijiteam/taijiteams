<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			list-style: none;
		}
		.container{
			width: 90%;
			margin: 0 auto;
			border-top: 5px solid #d1d1d1;
			margin-top: 50px;
		}
		.header_img{
			/*width: 375px;*/
			width: 30%;
			height: 250px;
			border: 1px solid;
			margin: 50px auto;
		}
		.Img{
			width: 100%;
			height: 100%;
		}
		.header_header{
			margin-top: 50px;
		}
		.section_list{
			width: 90%;
			margin: 0 auto;
			margin-bottom: 30px;
		}
		.section_name{
			text-align: center;
			line-height: 60px;
		}
		.section_int{
			width: 200px;
			height: 60px;
			border: 1px solid #979797;
			line-height: 60px;
			font-weight: bold;
			text-align: center;
		}
		.section_select{
			width: 200px;
			margin: 10px 0;
		}
		.footer{
			width: 100%;
			text-align: center;
			margin: 82px 0;
		}
		.footer_btn1{
			width: 100px;
			height: 35px;
			background: #666666;
			color: #fff;
			border-radius: 3px;
		}
		.footer_btn2{
			width: 100px;
			height: 35px;
			background: #19c199;
			color: #fff;
			border-radius: 3px;
		}
	</style>
</head>
<body>
	<div class="header_img">
		<img src="<?php echo ($orderInfo['main_img']); ?>" class="Img">
	</div>
	<div class="container">
		<div class="header_header">
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">序号</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['goods_common_id']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">商品编码*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['goods_common_id']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">商品名称</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['goods_common_id']); ?>">
			  		</div>
			  	</div>
			</div>
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">商品规格*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['goods_common_id']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">总金额</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['total_price']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">应付金额</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['member_payment']); ?>">
			  		</div>
			  	</div>
			</div>
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">收件人*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['member_name']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">联系电话*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['member_mobile']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">商品数量*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['goods_num']); ?>">
			  		</div>
			  	</div>
			</div>
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">收货地址*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo ($orderInfo['deliver_address']); ?>">
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">下单时间</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<input type="text" name="" class="section_int" disabled value="<?php echo (date('Y-m-d H:i:s',$orderInfo['addtime'])); ?>">
			  		</div>
			  	</div>
			</div>
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">发货审核*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>已审核</option>
						  	<option>未审核</option>
						</select>
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">支付状态*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>已支付</option>
						  	<option>未支付</option>
						</select>
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">支付方式*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>微信</option>
						  	<option>货到付款</option>
						  	<option>对公转账</option>
						</select>
			  		</div>
			  	</div>
			</div>
			<div class="row section_list">
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">发货状态*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>已发货</option>
						  	<option>未发货</option>
						</select>
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">配送方式</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>圆通快递</option>
						  	<option>顺丰快递</option>
						  	<option>自取</option>
						</select>
			  		</div>
			  	</div>
			  	<div class="col-md-6 col-lg-4 section_list_one row">
			  		<div class="section_name col-xs-6 col-md-4">订单确定*</div>
			  		<div class="section_value col-xs-12 col-sm-6 col-md-8">
			  			<select class="form-control section_select">
						  	<option>已确定</option>
						  	<option>未确定</option>
						</select>
			  		</div>
			  	</div>
			</div>
		</div>
		<div class="footer">
			<button class="footer_btn1">返回</button>
			<button class="footer_btn2">确定</button>
		</div>
	</div>
</body>
</html>