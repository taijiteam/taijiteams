<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商户详情页</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../../../Public/Admin/layui-v2.5.4/layui/css/layui.css">
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
			list-style: none;
		}
		.container-fluid{
			margin: 50px 0;
		}
		.header{
			width: 100%;
			background: #efeef0;
			font-size: 20px;
			font-weight: bold;
			line-height: 60px;
			padding-left: 100px;
		}
		.section{
			width: 90%;
			margin: 50px auto;
		}
		.section_left{
			text-align: right;
			line-height: 60px;
		}
		.section_right>input{
			width: 200px;
			height: 60px;
			text-align: center;
			border: 1px solid #979797;
		}
		.form-control{
			width: 200px;
			height: 60px;
			text-align: center;
			border: 1px solid #979797;
		}
		.photo{
			width: 300px;
			height: 180px;
			border: 1px solid #979797;
		}
		.Boot_btn{
			width: 300px;
			text-align: center;
			margin: 20px 0;
		}
		.title{
			width: 90%;
			margin: 50px auto;
		}
		.section_photo>.photo{
			width: 200px;
			height: 120px;
		}
		.section_photo>.Boot_btn{
			width: 200px;
		}
		.section_photo{
			margin: 0 20px;
		}
		.Writing{
			width: 95%;
			text-align: left;
		}
		.footer_bottom{
			text-align: center;
			margin-bottom: 20px;
		}
		.bottom_left{
			width: 100px;
			height: 35px;
			background: #e2e2e2;
			border-radius: 4px;
		}
		.bottom_right{
			width: 100px;
			height: 35px;
			background: #19c199;
			border-radius: 4px;
		}
	</style>
</head>
<body>
<form action="">
	<div class="container-fluid">
		<!-- 商户基础信息 -->
		<div class="header">商户基础信息</div>
		<div class="section row">
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">商户名称</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="shanghu"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">商户ID</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="id"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">开户时间</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="kaihu"></div>
		  	</div>
		</div>
		<div class="section row">
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">联系人</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="name"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">联系电话</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="dianhua"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">手机</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" id="shouji"></div>
		  	</div>
		</div>
		<div class="section row">
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">地址</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" style="width: 300px;" id="dizhi"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">备注</div>
		  		<div class="section_right col-xs-6 col-md-8"><input type="text" name="" value="" style="width: 300px;"></div>
		  	</div>
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">账户状态</div>
		  		<div class="section_right col-xs-6 col-md-8">
		  			<select class="form-control">
					  	<option>开启</option>
					  	<option>停用</option>
					</select>
		  		</div>
		  	</div>
		</div>
		<div class="section row">
		  	<div class="col-xs-12 col-md-4 row">
		  		<div class="section_left col-xs-6 col-md-4">营业执照</div>
		  		<div class="section_right col-xs-6 col-md-8">
		  			<div class="photo">
		  				<img id="goods-main-image-show" src=""  width="100%" />
	            		<input type="hidden" id="goods-main-image-url" name="goods-main-image-url" value="">
		  			</div>
		  			<div class="Boot_btn">
		  				<button type="button" class="btn btn-info" id="goods-main-image">
				            上传图片
				        </button>
		  			</div>
		  		</div>
		  	</div>
		</div>
		<!-- 商户详情页编辑 -->
		<div class="header">商户详情页编辑</div>
		<p class="title">餐厅Banner图</p>
		<div class="section">
			<div class="section_photo col-xs-12 col-sm-6 col-md-2">
		  		<div class="photo">
		  			<img id="goods-main-image-show1" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url1" name="goods-main-image-url1" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image1">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2">
		  		<div class="photo">
		  			<img id="goods-main-image-show2" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url2" name="goods-main-image-url2" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image2">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2">
		  		<div class="photo">
		  			<img id="goods-main-image-show3" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url3" name="goods-main-image-url3" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image3">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2">
		  		<div class="photo">
		  			<img id="goods-main-image-show4" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url4" name="goods-main-image-url4" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image4">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2">
		  		<div class="photo">
		  			<img id="goods-main-image-show5" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url5" name="goods-main-image-url5" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image5">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		</div>
		<!-- 餐厅简介 -->
		<div class="section row">
		  	<div class="col-xs-12 col-md-12 row" style="margin: 50px 0;">
		  		<div class="section_left col-xs-6 col-md-1">餐厅简介</div>
		  		<div class="section_right col-xs-6 col-md-11">
		  			<textarea class="form-control Writing" rows="8" placeholder="请输入" id="textarea1"></textarea>
		  		</div>
		  	</div>
		</div>
		<!-- 餐厅展示图 -->
		<p class="title">餐厅展示图</p>
		<div class="section">
			<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show6" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url6" name="goods-main-image-url6" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image6">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show7" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url7" name="goods-main-image-url7" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image7">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show8" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url8" name="goods-main-image-url8" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image8">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show9" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url9" name="goods-main-image-url9" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image9">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show10" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url10" name="goods-main-image-url10" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image10">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show11" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url11" name="goods-main-image-url11" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image11">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		</div>
		<!-- 餐厅简介 -->
		<div class="section row">
		  	<div class="col-xs-12 col-md-12 row" style="margin: 50px 0;">
		  		<div class="section_left col-xs-6 col-md-1">美食推荐</div>
		  		<div class="section_right col-xs-6 col-md-11">
		  			<textarea class="form-control Writing" rows="8" placeholder="请输入"></textarea>
		  		</div>
		  	</div>
		</div>
		<!-- 餐厅推荐菜 -->
		<p class="title">餐厅推荐菜</p>
		<div class="section">
			<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show12" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url12" name="goods-main-image-url12" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image12">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show13" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url13" name="goods-main-image-url13" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image13">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show14" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url14" name="goods-main-image-url14" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image14">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show15" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url15" name="goods-main-image-url15" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image15">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show16" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url16" name="goods-main-image-url16" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image16">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		  	<div class="section_photo col-xs-12 col-sm-6 col-md-2" style="margin: 0;">
		  		<div class="photo">
		  			<img id="goods-main-image-show17" src=""  width="100%" />
	            	<input type="hidden" id="goods-main-image-url17" name="goods-main-image-url17" value="">
		  		</div>
		  		<div class="Boot_btn">
		  			<button type="button" class="btn btn-info" id="goods-main-image17">
				        上传图片
				    </button>
		  		</div>
		  	</div>
		</div>
		<!-- 餐厅简介 -->
		<div class="section row">
		  	<div class="col-xs-12 col-md-12 row" style="margin: 50px 0;">
		  		<div class="section_left col-xs-6 col-md-1">成员专享</div>
		  		<div class="section_right col-xs-6 col-md-11">
		  			<textarea class="form-control Writing" rows="8" placeholder="请输入"></textarea>
		  		</div>
		  	</div>
		</div>
		<!-- footer -->
		<div class="footer_bottom">
			<button class="bottom_left">取消</button>
			<button class="bottom_right" id="TiJiao">提交</button>
		</div>
	</div>
</form>
</body>
<script type="text/javascript" src="../../../../Public/Admin/layui-v2.5.4/layui/layui.js"></script>
<script type="text/javascript">
	var TiJiao = document.getElementById("TiJiao");
	layui.use('laydate', function(){
  		var laydate = layui.laydate;
  
  		//执行一个laydate实例
  		laydate.render({
    		elem: '#kaihu' //指定元素
  		});
	});
	TiJiao.onclick = function(){
		//验证图片是否上传
		if(!document.getElementsByTagName("img").value){    
		        alert("对不起，请上传图片!"); 
		    }    
		// 验证商户ID5位数字
    	if(document.getElementById('id').value.length!=0){    
		    reg=/^\d{5}$/;    
		    if(!reg.test(document.getElementById('id').value)){    
		        alert("对不起，您输入的商户ID不正确!"); 
		    }    
		}
    	// 验证开户时间
		if(document.getElementById('kaihu').value.length!=0){    
		    reg= /((?!0000)[0-9]{4}-((0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-8])|(0[13-9]|1[0-2])-(29|30)|(0[13578]|1[02])-31)|([0-9]{2}(0[48]|[2468][048]|[13579][26])|(0[48]|[2468][048]|[13579][26])00)-02-29)/;   
		    if(!reg.test(document.getElementById('kaihu').value)){    
		        alert("对不起，请输入正确时间!"); 
		    }    
		} 
		// 验证姓名 
    	if(document.getElementById('name').value.length!=0){  
		    reg= /^[\u4E00-\u9FA5\uf900-\ufa2d·s]{2,20}$/;;    
		    if(!reg.test(document.getElementById('name').value)){    
		        alert("对不起，您输入的姓名不正确!"); 
		    }    
		} 
		// 验证联系电话
		if(document.getElementById('dianhua').value.length!=0){    
		    reg= /^0\d{2,3}-?\d{7,8}$/;   
		    if(!reg.test(document.getElementById('dianhua').value)){    
		        alert("对不起，您输入的联系电话不正确!"); 
		    }    
		} 
		// 验证手机
		if(document.getElementById('shouji').value.length!=0){    
		    reg= /^[1]+[3,5,7,8]+\d{9}$/;   
		    if(!reg.test(document.getElementById('shouji').value)){    
		        alert("对不起，您输入的手机号码不正确!"); 
		    }    
		} 
		// 验证餐厅地址
		if(document.getElementById('dizhi').value.length!=0){    
		    reg= /^(?=.*?[\u4E00-\u9FA5])[\dA-Za-z\u4E00-\u9FA5]+(?=.*?[\u4E00-\u9FA5])/;   
		    if(!reg.test(document.getElementById('dizhi').value)){    
		        alert("对不起，请输入正确地址!"); 
		    }    
		} 
	}
</script>
<script type="text/javascript">
	$(function(){
		//图片上传
		layui.use('upload', function(){
			var upload = layui.upload;
			//商品主图
			var uploadMainImage = upload.render({
				elem: '#goods-main-image',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-main-image-show").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});
			var uploadMainImage = upload.render({
				elem: '#goods-main-image2',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-main-image-show2").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});
			var uploadMainImage = upload.render({
				elem: '#goods-main-image3',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-main-image-show3").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});
			var uploadMainImage = upload.render({
				elem: '#goods-main-image4',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-main-image-show4").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});
			var uploadMainImage = upload.render({
				elem: '#goods-main-image5',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-main-image-show5").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});

			//商品描述图
			var uploadDesc = upload.render({
				elem: '#goods-desc-image',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-desc-image-show").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});

			/**  广告图 **/
			var uploadadveImage = upload.render({
				elem: '#goods-adve-image',
				url: "/Admin/Upload/image",
				done: function(res){
					console.log(res);
					if(res.code == "200"){
						$("#goods-adve-image-show").attr("src",res.data.photo);
					}else{
						layer.msg("上传失败");
					}
				}
			});
		});
	})
</script>
</html>