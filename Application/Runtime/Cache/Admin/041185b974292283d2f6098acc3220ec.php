<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>渠道plus微管家</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/Admin/css/font.css">
	<link rel="stylesheet" href="/Public/Admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/Admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/cookie.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/layer/layer.js"></script>

</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">渠道plus微管家</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" id="form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit" id="btn">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              layer.msg('玩命加载中', function(){
                //关闭后的操作
                 });
              //监听提交
                $('#btn').click(function (){
                    $.post("/Admin/Index/login",$('form').serialize(),function (data){
                        if(data['status']=='ok'){
                            layer.msg(data['content'],{
                                icon:1,
                                time:2000,
                                shade:[0.6,'#000000']
                            },function(){
                                location.href="/Admin/Index/index";
                            });
                        }else{
                            layer.msg(data['content'],{
                                icon:2,
                                time:2000,
                                shade:[0.6,'#000000']
                            });
                        }
                    },'json');
                    return false;
                })
            });
        })

        
    </script>

    
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>