<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			list-style: none;
		}
		.header{
			width: 100%;
			background: #efeef0;
			line-height: 60px;
			font-size: 20px;
			font-weight: bold;
			padding-left: 100px;
			margin: 50px 0 0 0;
		}
		.header_section{
			margin: 3.125rem 0 0 3.125rem;
		}
		.section_one,.section_two{
			text-align: center;
			height: 3.75rem;
			line-height: 3.75rem;
		}
		.section_one{
			font-size: 1.2rem;
		}
		.section_two{
			border: 1px solid;
			font-size: 0.87rem;
			font-weight: bold;
		}
		.xiala{
			height: 3.75rem;
		}
		.header_header{
			font-size: 20px;
			font-weight: bold;
			padding-left: 100px;
			padding-top: 50px;
			padding-bottom: 10px;
		}
		.section_three{
			border: 1px solid;
			padding: 10px 0 10px 10px;
		}
		.section_three span{
			font-weight: bold;
		}
		.footer{
			width: 100%;
			text-align: center;
			margin: 100px 0;
		}
		.footer button{
			width: 100px;
			margin: 0 10px;
		}
		.btn1{
			background: #b2b2b2;
			color: #fff;
			text-align: center;
			line-height: 35px;
		}
		.btn2{
			background: #19c199;
			color: #fff;
			text-align: center;
			line-height: 35px;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="header">订单信息</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">序号</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['id']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">订单编号*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['order_sn']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">选择服务</div>
		  		<div class="section_two col-xs-4">如意算盘</div>
		  	</div>
		</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">用户名*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['member_name']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">电话*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['member_mobile']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">支付金额/元</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['member_payment']); ?></div>
		  	</div>
		</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">财务审核*</div>
		  		<div class="col-xs-4">
		  			<select class="form-control xiala">
						<?php if($orderInfo['order_status'] == 6): ?><option>已审核</option>
							<?php elseif($orderInfo['order_status'] == 7): ?>
							<option>未审核</option>
							<?php else: ?>
							<option>审核中</option><?php endif; ?>
					</select>
		  		</div>
		  	</div>
		</div>
		<div class="section">
			<div class="header">乘机人员信息</div>
			<p class="header_header">乘机人员01</p>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">姓名</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_name']); ?></div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">职务*</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_title']); ?></div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">性别</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_sex']); ?></div>
			  	</div>
			</div>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">国籍*</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_inter']); ?></div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">所在省市(或直辖市/区)*</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_city']); ?></div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">证件类型</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_card_type']); ?></div>
			  	</div>
			</div>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">证件号码*</div>
			  		<div class="section_two col-xs-4"><?php echo ($orderInfo['fruition_Id_card']); ?></div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">其他*</div>
			  		<div class="section_two col-xs-4">999</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">其他*</div>
			  		<div class="section_two col-xs-4">已发布</div>
			  	</div>
			</div>
			<!--<p class="header_header">乘机人员02</p>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">姓名</div>
			  		<div class="section_two col-xs-4">24455</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">职务*</div>
			  		<div class="section_two col-xs-4">RYSP00001</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">性别</div>
			  		<div class="section_two col-xs-4">如意算盘</div>
			  	</div>
			</div>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">国籍*</div>
			  		<div class="section_two col-xs-4">工艺礼品</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">所在省市(或直辖市/区)*</div>
			  		<div class="section_two col-xs-4">888</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">证件类型</div>
			  		<div class="section_two col-xs-4">件</div>
			  	</div>
			</div>
			<div class="row header_section">
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">证件号码*</div>
			  		<div class="section_two col-xs-4">渠道PLUS甄选商城</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">其他*</div>
			  		<div class="section_two col-xs-4">999</div>
			  	</div>
			  	<div class="col-xs-4 row">
			  		<div class="section_one col-xs-4">其他*</div>
			  		<div class="section_two col-xs-4">已发布</div>
			  	</div>
			</div>
			<div class="row header_section">
			  	<div class="col-xs-8 row">
			  		<div class="section_one col-xs-2">温馨提示</div>
			  		<div class="section_three col-xs-8">
			  			1:国内VIP进出港航班只需填写姓名，职务和证件号码。<br>
			  			2:国际VIP进出港航班需填写以上所有信息。<br>
			  			3:若乘机人数较多，可另附一页。<br>
			  			4:如有疑问请致电：<span>021-53829777</span>
			  		</div>
			  	</div>
			</div>-->
		</div>
		<div class="header">办证人员名单</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">姓名</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['work_name']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">职务*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['work_title']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">证件类型</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['work_card_type']); ?></div>
		  	</div>
		</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">证件号码*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['work_Id_card']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">商品价格/元*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['member_payment']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">其他</div>
		  		<div class="section_two col-xs-4">件</div>
		  	</div>
		</div>
		<div class="header">航班信息</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">航班号</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['flight_number']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">航程*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['flight_voyage']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">日期</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['flight_time']); ?></div>
		  	</div>
		</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">车号*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['flight_car_number']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">备注*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['remark']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">联系人</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['contact']); ?></div>
		  	</div>
		</div>
		<div class="row header_section">
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">接送单位或会员卡号*</div>
		  		<div class="section_two col-xs-4"><?php echo ($orderInfo['work_unit']); ?></div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="row">
			  		<div class="section_one col-xs-4">航班*</div>
			  		<div class="col-xs-4">
			  			<select class="form-control xiala">
						  	<option>国内</option>
						  	<option>国际</option>
						</select>
			  		</div>
			  	</div>
		  	</div>
		  	<div class="col-xs-4 row">
		  		<div class="section_one col-xs-4">其他</div>
		  		<div class="section_two col-xs-4">件</div>
		  	</div>
		</div>
		<div class="footer">
			<button class="btn1">返回</button>
			<button class="btn2">确定</button>
		</div>
	</div>
</body>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
	$(function () {
		$('.btn1').click(function () {
			window.location.href = "/Admin/Operation/airportList"
		});
		$('.btn2').click(function () {
			window.location.href = "/Admin/Operation/airportList"
		})
	})
</script>
</html>