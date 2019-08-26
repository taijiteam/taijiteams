<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>编辑</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="/Public/Admin/css/font.css">
    <link rel="stylesheet" href="/Public/Admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/Admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/cookie.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<h1 style="text-align: center">订单审核</h1>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="pay" class="layui-form-label">支付方式</label>
            <div class="layui-input-block" style="width: 200px">
                <select id="pay" name="pay" lay-verify="nikename">
                    <option value="">请确认支付方式</option>
                    <option value="微信支付">微信支付</option>
                    <option value="支付宝支付">支付宝支付</option>
                    <option value="pos机支付">pos机支付</option>
                    <option value="银行卡支付">银行卡支付</option>
                </select>
            </div>

        </div>
        <div class="layui-form-item">
            <label for="money" class="layui-form-label">到账信息</label>
            <div id="money" class="layui-input-block">
                <input type="radio" name="sex" value="已到账" title="已到账" checked="">
                <input type="radio" name="sex" value="未到账" title="未到账">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <input type="button" name="btn" data-order-id="<?php echo ($order_id); ?>" data-source-order="<?php echo ($source); ?>" data-goods-id="<?php echo ($res["goods_common_id"]); ?>" class="layui-btn layui-btn-fluid" lay-filter="add" lay-submit="" value="确认审核">
        </div>
    </form>
</div>

<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" >
    //提交
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form,layer = layui.layer;
        //自定义验证规则
        form.verify({
            nikename: function(value){
                if(value == ''){
                    return '请选择支付方式';
                }
            },
        });
        //监听提交
        form.on('submit(add)', function(data){
            // alert(JSON.stringify(data));
            //发异步，把数据提交给php
             var order_id   = $('input[name="btn"]').attr('data-order-id');			//订单id
             var gc_id      = $('input[name="btn"]').attr('data-goods-id');		    //商品id
             var source     = $('input[name="btn"]').attr('data-source-order');		//订单来源
             var pay        = $("#pay option:checked").val();	                    //支付方式
             var money      = $('#money input[name="sex"]:checked ').val();         //获取选中的值
            //接收
            $.ajax({
                type:"post",
                url:"/Admin/Order/addAudit",//根据自己项目的需要写请求地址
                data:{
                    'order_id'  : order_id,
                    'source'    : source,
                    'pay'       : pay,
                    'gc_id'     : gc_id,
                    'money'     : money,
                },
                dataType:'json',
                success:function(res){
                    // alert(JSON.stringify(data));
                    //console.log(res);
                    if (res.code == "200"){
                        layer.confirm('确认审核！',function(index){
                            //关闭当前frame
                            x_admin_close();
                            // 可以对父窗口进行刷新
                            x_admin_father_reload();
                        });
                    }else{
                        layer.msg('审核失败喽，稍后再试！',function(){});
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            })
        });
    });
</script>
<script>
    var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>

</html>