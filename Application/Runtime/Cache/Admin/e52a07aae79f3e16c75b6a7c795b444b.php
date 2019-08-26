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
                <label for="admin" class="layui-form-label"><span class="x-red">*</span>登录账号</label>
                <div class="layui-input-inline">
                    <input type="text" id="admin" name="admin" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>密码
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
                <label for="cname" class="layui-form-label"><span class="x-red">*</span>姓名</label>
                <div class="layui-input-inline">
                    <input type="text" id="cname" name="cname" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="groupname" class="layui-form-label"><span class="x-red">*</span>管理员角色</label>
                <div class="layui-input-inline">
                    <!--<input type="text" id="m_groupname" name="m_groupname" required="" lay-verify="nikename"autocomplete="off" class="layui-input">-->
                    <select id="groupname" name="groupname" autocomplete="off" class="layui-input">
                        <option value="超级管理员">超级管理员</option>
                        <option value="成员管理员">成员管理员</option>
                        <option value="文章管理员">文章管理员</option>
                        <option value="积分管理员">积分管理员</option>
                        <option value="财务管理员">财务管理员</option>
                        <option value="人事管理员">人事管理员</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="sex" class="layui-form-label"><span class="x-red">*</span>性别</label>
                <div class="layui-input-inline">
                    <!--<input type="text" id="m_sex" name="m_sex" required="" lay-verify="nikename"autocomplete="off" class="layui-input">-->
                    <select id="sex" name="sex" autocomplete="off" class="layui-input">
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="phone" class="layui-form-label"><span class="x-red">*</span>手机</label>
                <div class="layui-input-inline">
                    <input type="text" id="phone" name="phone" required="" lay-verify="phone"autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="email" class="layui-form-label"><span class="x-red">*</span>邮箱</label>
                <div class="layui-input-inline">
                    <input type="text" id="email" name="email" lay-verify="email" autocomplete="off" class="layui-input">
                </div>
                <!--<div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>将会成为您唯一的登入名</div>-->
            </div>
            <div class="layui-form-item">
                <label for="duty" class="layui-form-label"><span class="x-red">*</span>职务</label>
                <div class="layui-input-inline">
                    <input type="text" id="duty" name="duty" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>公司职务</div>
            </div>


            <div class="layui-form-item">
                <label for="note" class="layui-form-label"><span class="x-red">*</span>备注</label>
                <div class="layui-input-inline">
                    <input type="text" id="note" name="note" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>职务详细描述</div>
            </div>
            <div class="layui-form-item">
                <label for="starte" class="layui-form-label"><span class="x-red">*</span>状态</label>
                <div class="layui-input-inline">
                    <select id="starte" name="starte" autocomplete="off" class="layui-input">
                        <option value="0">激活</option>
                        <option value="1">禁用</option>
                    </select>
                </div>
            </div>






            <div class="layui-form-item">
                <label for="time" class="layui-form-label"><span class="x-red">*</span>登记时间</label>
                <div class="layui-input-inline">
                    <input class="layui-input"  autocomplete="off" placeholder="请输入" name="time" id="time">
                    <!--<input type="time" id="m_time" name="m_time" autocomplete="off" class="layui-input">-->
                </div>
            </div>

          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <input type="button" class="layui-btn" lay-filter="add" lay-submit="" value="增加">
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
                if(value.length < 2){
                    return '昵称至少得2个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,phone: [/^1([38]\d|5[0-35-9]|7[3678])\d{8}$/, '手机号码格式不正确']
            ,email: [/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/, '邮箱格式不正确']
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
        var groupname  = $("#groupname option:checked").val();		//会员级别
        var admin  = $('input[name="admin"]').val();			//账号
        var cname  = $('input[name="cname"]').val();			//姓名
        var sex  = $("#sex option:checked").val();				//性别
        var phone  = $('input[name="phone"]').val();			//手机
        var email  = $('input[name="email"]').val();			//邮箱
        var duty  = $('input[name="duty"]').val();		//单位 职务
        var starte  = $("#starte option:checked").val();				//展示状态
        var time  = $('input[name="time"]').val();			//登记时间
        var note  = $('input[name="note"]').val();			//职务详细描述
        var pass  = $('input[name="pass"]').val();			        //密码
        var repass  = $('input[name="repass"]').val();			    //确认密码
        //接收
        // alert(JSON.stringify(introduce));
        // return false;
        $.ajax({
            type:"post",
            url:"<?php echo U('Admin/adminAdd');?>",//根据自己项目的需要写请求地址
            data:{
                'groupname':groupname,
                'cname':cname,
                'admin':admin,
                'sex':sex,
                'phone':phone,
                'email':email,
                'duty':duty,
                'note':note,
                'starte':starte,
                'time':time,
                'pass':pass,
                'repass':repass,
            },
            dataType:'json',
            success:function(data){
                // alert(JSON.stringify(data));
                if (data.error == 1){
                    layer.confirm('信息添加成功！',function(index){
                        //关闭当前frame
                        x_admin_close();
                        // 可以对父窗口进行刷新
                        x_admin_father_reload();
                    });
                }else{
                    layer.msg('哎呦，运气不好哦，添加失败咯！',function(){});
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
<script>
layui.use('laydate', function(){
    var laydate = layui.laydate;
    //日期时间选择器
    laydate.render({
        elem: '#time'
        ,type: 'datetime'
    });
    laydate.render({
        elem: '#indate'
        ,type: 'datetime'
    });
    laydate.render({
        elem: '#birthday'
    });
});
</script>
</body>

</html>