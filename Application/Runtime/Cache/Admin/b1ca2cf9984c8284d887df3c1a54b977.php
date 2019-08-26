<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="x-admin-sm">
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.1</title>
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
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="L_username"  class="layui-form-label">
                管理员账号
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_username" name="username" disabled="" value="<?php echo ($res['a_admin']); ?>" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="oldpass" class="layui-form-label">
                  <span class="x-red">*</span>旧密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="oldpass" name="oldpass" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>新密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <input type="button" name="btn" id="<?php echo ($res['a_id']); ?>" class="layui-btn" lay-filter="add" lay-submit="" value="增加">
            </div>
      </form>
    </div>
    <script type="text/javascript" >
        //提交
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form,layer = layui.layer;
            //自定义验证规则
            form.verify({
                nikename: function(value){
                    if(value.length < 2){
                        return '昵称至少得2个字符啊';
                    }
                }
                ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
            });

            //监听提交
            form.on('submit(add)', function(data){
                // alert(JSON.stringify(data));
                //发异步，把数据提交给php
                var id  = $('input[name="btn"]').attr('id');			//姓名
                var oldpass  = $('input[name="oldpass"]').val();			 //密码
                var pass  = $('input[name="pass"]').val();			        //密码
                var repass  = $('input[name="repass"]').val();			    //确认密码
                //接收
                // alert(JSON.stringify(introduce));
                // return false;
                $.ajax({
                    type:"post",
                    url:"<?php echo U('Admin/adminSave');?>",//根据自己项目的需要写请求地址
                    data:{
                        'id':id,
                        'oldpass':oldpass,
                        'pass':pass,
                        'repass':repass,
                    },
                    dataType:'json',
                    success:function(data){
                        // alert(JSON.stringify(data));
                        if (data['status']==';'){
                            parent.layer.msg(data['content'],{
                                icon:1,
                                time:2000,
                                shade:[0.6,'#000000']
                            },function(){
                                //关闭当前frame
                                x_admin_close();
                                // 可以对父窗口进行刷新
                                x_admin_father_reload();
                            });
                        }else{
                            parent.layer.msg(data['content'],{
                                icon:5,
                                time:2000,
                                shade:[0.6,'#000000']
                            });
                        }
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                })
            });
        });
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>