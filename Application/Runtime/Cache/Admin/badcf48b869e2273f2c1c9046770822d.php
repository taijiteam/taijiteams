<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
<title>渠道plus微管家</title>
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
        <style type="text/css">
              .layui-row .layui-form-item{
                  margin-top: 60px;
                  margin-left: 40px;
              }
        </style>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label for="order_sn" class="layui-form-label">
                            <span class="x-red">*</span>订单编号</label>
                        <div class="layui-input-inline">
                            <input type="text" id="order_sn" name="order_sn" value="<?php echo ($res["order_sn"]); ?>" required="" disabled lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <!--<label for="phone" class="layui-form-label">
                            <span class="x-red">*</span>手 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机</label>
                        <div class="layui-input-inline">
                            <input type="text" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off" class="layui-input">
                        </div>-->
                    </div>

                    <div class="layui-form-item">
                        <label for="member_name" class="layui-form-label">
                            <span class="x-red">*</span>用&nbsp;&nbsp;户&nbsp;&nbsp;名</label>
                        <div class="layui-input-inline">
                            <input type="text" id="member_name" name="member_name" value="<?php echo ($res["member_name"]); ?>" disabled required="" lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <label for="member_mobile" class="layui-form-label">
                            <span class="x-red">*</span>手 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机</label>
                        <div class="layui-input-inline">
                            <input type="text" id="member_mobile" name="member_mobile" value="<?php echo ($res["member_mobile"]); ?>" disabled required="" lay-verify="phone" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                       <label for="pay_style" class="layui-form-label">
                            <span class="x-red">*</span>支付方式
                       </label>
                        <div class="layui-input-inline">
                            <?php if($res["pay_style"] == 1): ?><input type="text" id="pay_style" name="pay_style" value="微信支付" required="" disabled lay-verify="required" autocomplete="off" class="layui-input"><?php endif; ?>
                        </div>
                        <label for="total_price" class="layui-form-label">
                            <span class="x-red">*</span>支付金额
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="total_price" name="total_price" value="<?php echo ($res["total_price"]); ?>" disabled required="" lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <label for="L_email" class="layui-form-label">
                        </label>
                    </div>
                    <div class="layui-form-item">
                       <label for="pocket_type" class="layui-form-label">
                            <span class="x-red">*</span>积分类型
                       </label>
                        <div class="layui-input-inline">
                            <input type="text" id="pocket_type" name="pocket_type" value="<?php echo ($res["pocket_type"]); ?>" disabled required="" lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <label for="pocket_value" class="layui-form-label">
                            <span class="x-red">*</span>积分金额
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="pocket_value" name="pocket_value" value="<?php echo ($res["pocket_value"]); ?>" disabled required="" lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <label for="L_email" class="layui-form-label">
                        </label>
                    </div>


                    <!--    收货地址   收货地址
                    <div class="layui-form-item">
                        <label for="address" class="layui-form-label">
                            <span class="x-red">*</span>收货地址
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="address" name="address" required="" lay-verify="required" autocomplete="off" class="layui-input">
                        </div>

                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>发票抬头
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>
                        </div>
                    </div>-->

                    <div class="layui-form-item layui-form-text">
                        <label for="spec" class="layui-form-label">商品订单详情</label>
                        <div class="layui-input-block">
                            <table class="layui-table">
                                <tbody>
                                    <tr>
                                        <td>haier海尔 BC-93TMPF 93升单门冰箱</td>
                                        <td>0.01</td>
                                        <td>984</td>
                                        <td>1</td>
                                        <td>删除</td>
                                    </tr>
                                    <tr>
                                        <td>haier海尔 BC-93TMPF 93升单门冰箱</td>
                                        <td>0.01</td>
                                        <td>984</td>
                                        <td>1</td>
                                        <td>删除</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label for="member_remark" class="layui-form-label">用户订单备注</label>
                        <div class="layui-input-block">
                            <textarea placeholder="用户无备注内容" id="member_remark" name="desc" disabled class="layui-textarea"><?php echo ($res["member_remark"]); ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <!--<label for="L_repass" class="layui-form-label"></label>-->
                        <!--<button class="layui-btn layui-btn-fluid" id="go-back" style="height: 50px">确 认</button>-->
                       <?php if($res['order_status'] == 2): ?><span class="layui-btn" id="deliver-goods-btn"> 点击发货 </span>
                       <?php elseif($res['order_status'] < 2): ?>
                           <span>待付款 </span>
                       <?php elseif($res['order_status'] == 9): ?>
                           <span> 已取消 </span>
                       <?php elseif($res['order_status'] > 2): ?>
                           <span>已发货 </span>
                       <?php else: endif; ?>

                    </div>
                    </form>
            </div>
        </div>
    <script>
        $(function () {
            var order_sn = "<?php echo ($res["order_sn"]); ?>";

            // layui.use(['form', 'layer'], function() {
            //     var form = layui.form,
            //         layer = layui.layer;
            //
            //     //监听提交
            //     /* form.on('submit(add)',
            //      function(data) {
            //          console.log(data);
            //          //发异步，把数据提交给php
            //          layer.alert("增加成功", {
            //              icon: 6
            //          },
            //          function() {
            //              // 获得frame索引
            //              var index = parent.layer.getFrameIndex(window.name);
            //              //关闭当前frame
            //              parent.layer.close(index);
            //          });
            //          return false;
            //      });*/
            //     $("#go-back").click(function () {
            //         window.location.href = "/Admin/Order/index";
            //     });
            // });

            $(document).on("click",'#deliver-goods-btn',function () {
                $.ajax ({
                    type:'get',
                    url:'/Admin/Order/order_delivered/?order_sn='+order_sn,
                    success: function(res){
                        if(res.code == "200"){
                            window.location.reload();
                        }
                    }
                });
            })
        })
    </script>
</body>

</html>