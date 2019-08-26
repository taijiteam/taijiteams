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
</head>
<body  >
<div class="index-top">
	<img src="/Public/Airport/images/banner.png">
</div>
<form>
<div class="population-button">
	<?php if($type == '1' ): ?><h2>浦东机场</h2>
		<?php else: ?>
		<h2>虹桥机场</h2><?php endif; ?>
</div>
<div class="population-menu">
	<h2>乘机人员信息</h2>
	<div class="menu-list">
		<label class="menu-list-label">姓名</label>
		<div class="menu-div">
			<input type="text" name="fruition_name" value="<?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?>" class="menu-input" />
		</div>

	</div>
	<div class="menu-list">
		<label class="menu-list-label">职务</label>
		<div class="menu-div">
			<input type="text" name="fruition_title" value="<?php echo ($res['fruition_title']); ?>"  class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">性别</label>
		<div class="menu-div">
			<input type="text" name="fruition_sex" value="<?php echo ($res['fruition_sex']); ?>"  class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">国籍</label>
		<div class="menu-div">
			<input type="text" name="fruition_inter"  value="<?php echo ($res['fruition_inter']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label" style="margin-left: -3px;">所属省/市</label>
		<div class="menu-div">
			<input type="text" name="fruition_city" value="<?php echo ($res['fruition_city']); ?>"  class="menu-input" />
		</div>            <!--<br/>
            <label class="menu-list-label">(或直辖市/区）</label> -->

	</div>
	<div class="menu-list">
		<label class="menu-list-label">证件类别</label>
		<div class="menu-div">
			<input type="text" name="fruition_type" value="<?php echo ($res['fruition_card_type']); ?>"  class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">证件号码</label>
		<div class="menu-div">
			<input type="text" name="fruition_number" value="<?php echo ($res['fruition_Id_card']); ?>"  class="menu-input" />
		</div>
	</div>
	<h3 class="menu-title">温馨提示</h3>
	<div class="title-hint">
		<ol>
			<li>国内VIP进出港航班只需填写姓名、职务和证件号码。</li>
			<li>国际VIP进出港航班需填写以上所有信息。</li>
			<li>若乘机人数较多，可另附一页。</li>
			<li>如有疑问请致电：021-53067999</li>
		</ol>
	</div>
	<h3 class="menu-title">办证人员名单</h3>
	<div class="menu-list">
		<label class="menu-list-label">姓名</label>
		<div class="menu-div">
			<input type="text" name="work_name" value="<?php echo ($res['work_name']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">职务</label>
		<div class="menu-div">
			<input type="text" name="work_title" value="<?php echo ($res['work_title']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">证件类别</label>
		<div class="menu-div">
			<input type="text" name="work_type" value="<?php echo ($res['work_type']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">证件号码</label>
		<div class="menu-div">
			<input type="text" name="work_number" value="<?php echo ($res['work_number']); ?>" class="menu-input" />
		</div>
	</div>
	<h3 class="menu-title">航班信息</h3>
	<div class="menu-list">
		<label class="menu-list-label">航班号</label>
		<div class="menu-div">
			<input type="text" name="flight_number" value="<?php echo ($res['flight_number']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">航程</label>
		<div class="menu-div">
			<input type="text" name="flight_voyage" value="<?php echo ($res['flight_voyage']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">日期 </label>
		<div class="menu-div">
			<input type="text" name="flight_time" value="<?php echo ($res['flight_time']); ?>" id="datetime" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">车号</label>
		<div class="menu-div">
			<input type="text" name="flight_car_number" value="<?php echo ($res['flight_car_number']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">备注 </label>
		<div class="menu-div">
			<input type="text" name="remark" value="<?php echo ($res['remark']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">联系人 </label>
		<div class="menu-div">
			<input type="text" name="contacts" value="<?php echo ($_SESSION['infor']['data'][0]['TrueName']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="menu-list">
		<label class="menu-list-label">接单单位</label>
		<div class="menu-div">
			<input type="text" name="work_unit" value="<?php echo ($res['work_unit']); ?>" class="menu-input" />
		</div>
	</div>
	<div class="agreement">
		<label id="tkty"><input id="tkty11" type="checkbox"></label>
		<a href="javascript:;" onclick="tkshow()">渠道PLUS服务条款</a>
	</div>
</div>

<div class="btn1">
	<!--<button>提交</button>-->
	<input type="button" id="submit" lay-filter="add" lay-submit="" value="增加">
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Airport/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Airport/js/superslide.2.1.js"></script>
<script>
	layui.use(['laydate','form'], function(){
		var laydate = layui.laydate;
		$ = layui.jquery;
		var form = layui.form,layer = layui.layer;
		//执行一个laydate实例
		laydate.render({
			elem: '#datetime' //指定元素
			,type : "datetime"
			,min : -7
			,max : 60
		});

		//监听提交
		form.on('submit(add)', function(data) {
			//var order_sn	  = $("#fruition_name").attr('data-order-sn');
			var fruition_name = $("input[name='fruition_name']").val();	    //商品编号
			var fruition_title = $("input[name='fruition_title']").val();		    //商品编号
			var fruition_sex = $("input[name='fruition_sex']").val();		    //商品编号
			var fruition_inter = $("input[name='fruition_inter']").val();		    //商品编号
			var fruition_city = $("input[name='fruition_city']").val();		    //商品编号
			var fruition_type = $("input[name='fruition_type']").val();		    //商品编号
			var fruition_number = $("input[name='fruition_number']").val();		    //商品编号
			var work_name = $("input[name='work_name']").val();		    //商品编号
			var work_title = $("input[name='work_title']").val();		    //商品编号
			var work_type = $("input[name='work_type']").val();		    //商品编号
			var work_number = $("input[name='work_number']").val();		    //商品编号
			var flight_number = $("input[name='flight_number']").val();		    //商品编号
			var flight_voyage = $("input[name='flight_voyage']").val();		    //商品编号
			var flight_time = $("input[name='flight_time']").val();		    //商品编号
			var flight_car_number = $("input[name='flight_car_number']").val();		    //商品编号
			var remark = $("input[name='remark']").val();		    //商品编号
			var contacts = $("input[name='contacts']").val();		    //商品编号
			var work_unit = $("input[name='work_unit']").val();		    //商品编号
			var tkty11 = $('#tkty11').is(':checked');		    //商品编号
			//验证
			if(tkty11 == false){
				alert('请☑️渠道PLUS条款！')
			}else if(fruition_name == ""){
				alert('姓名不能为空！')
			}else if(fruition_title == ""){
				alert('职位不能为空！')
			}else if(fruition_sex == ""){
				alert('性别不能为空！')
			}else if(fruition_inter == ""){
				alert('国籍不能为空！')
			}else if(fruition_city == ""){
				alert('所属城市不能为空！')
			}else if(fruition_type == ""){
				alert('证件类别不能为空！')
			}else if(fruition_number == ""){
				alert('证件号码不能为空！')
			}else if(flight_number == ""){
				alert('航班号不能为空！')
			}else if(flight_voyage == ""){
				alert('航程不能为空！')
			}else if(flight_time == ""){
				alert('航班日期不能为空！')
			}else{
				//提交数据
				$.ajax({
					type : 'post',
					url : '/Home/Airport/addFlight?type=<?php echo ($type); ?>',
					data :{
						fruition_name: fruition_name,
						fruition_title:fruition_title,
						fruition_sex:fruition_sex,
						fruition_inter:fruition_inter,
						fruition_city:fruition_city,
						fruition_type:fruition_type,
						fruition_number:fruition_number,
						work_name:work_name,
						work_title:work_title,
						work_type:work_type,
						work_number:work_number,
						flight_number:flight_number,
						flight_voyage:flight_voyage,
						flight_time:flight_time,
						flight_car_number:flight_car_number,
						remark:remark,
						contacts:contacts,
						work_unit:work_unit,
					},
					dataType:'json',
					success:function (res) {
						if (res.code == "200"){
							alert('信息提交成功');
							window.location.href= "/Home/Airport/window?type=<?php echo ($type); ?>&order_sn=" + res.data;
						}else{
							alert('航程正在查询，请稍后再试');
						}
					}
				})
			}
		})
	});

</script>
</html>