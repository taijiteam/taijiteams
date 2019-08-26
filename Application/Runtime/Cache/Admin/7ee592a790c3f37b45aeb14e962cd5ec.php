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
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="cname" class="layui-form-label"><span class="x-red">*</span>姓名</label>
            <div class="layui-input-inline">
                <input type="text"  value="<?php echo ($res['m_cname']); ?>" id="cname" name="cname" required="" lay-verify="nikename" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="phone" class="layui-form-label"><span class="x-red">*</span>手机</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['m_phone']); ?>" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="workunits" class="layui-form-label">单位 职务</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['m_workunits']); ?>" id="workunits" lay-verify="workunits" name="workunits" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>泰基企业 董事长,泰基企业 总经理</div>
        </div>
        <div class="layui-form-item">
            <label for="socialposition" class="layui-form-label">社会职务</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['m_socialposition']); ?>" id="socialposition" lay-verify="socialposition" name="socialposition" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>泰基企业 董事长,泰基企业 总经理</div>
        </div>
        <div class="layui-form-item">
            <label for="sort" class="layui-form-label">选中排序</label>
            <div class="layui-input-inline">
                <input type="number" value="<?php echo ($res['m_sort']); ?>" id="sort" lay-verify="sort" name="sort" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>排序按照1～100从小到大(非要求,不填写)</div>
        </div>

        <div class="layui-form-item">
            <label for="address" class="layui-form-label">联系地址</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['m_address']); ?>" id="address" lay-verify="address"  name="address" autocomplete="off" class="layui-input">
            </div>
        </div>


        <!--<div class="layui-form-item">-->
        <!--<label for="L_pass" class="layui-form-label"><span class="x-red">*</span>密码</label>-->
        <!--<div class="layui-input-inline">-->
        <!--<input type="password" id="L_pass" name="pass" required="" lay-verify="pass" autocomplete="off" class="layui-input">-->
        <!--</div>-->
        <!--<div class="layui-form-mid layui-word-aux">6到16个字符</div>-->
        <!--</div>-->
        <!--<div class="layui-form-item">-->
        <!--<label for="L_repass" class="layui-form-label"><span class="x-red">*</span>确认密码</label>-->
        <!--<div class="layui-input-inline">-->
        <!--<input type="password" id="L_repass" name="repass" required="" lay-verify="repass" autocomplete="off" class="layui-input">-->
        <!--</div>-->
        <!--</div>-->
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <input type="button" name="btn" id="<?php echo ($res['m_id']); ?>" class="layui-btn" lay-filter="add" lay-submit="" value="增加">
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
                                return '姓名至少两个字';
                            }
                        },
                        workunits: function(value){
                            if(value.length < 2){
                                return '请填写正确的职位';
                            }
                        },
                       
                        address: function(value){
                            if(value.length < 4){
                                return '请填写正确的地址';
                            }
                        }

                    });
                    //监听提交
                    form.on('submit(add)', function(data){
                        // alert(JSON.stringify(data));
                        //发异步，把数据提交给php
                        var id  = $('input[name="btn"]').attr('id');			//姓名
                        var cname  = $('input[name="cname"]').val();			//姓名
                        var phone  = $('input[name="phone"]').val();			//手机
                        var workunits  = $('input[name="workunits"]').val();		//单位 职务
                        var socialposition  = $('input[name="socialposition"]').val();	//社会职务
                        var sort  = $('input[name="sort"]').val();	//选中排序
                        var address  = $('input[name="address"]').val();		//联系地址
                        //接收
                        // alert(JSON.stringify(introduce));
                        // return false;
                        $.ajax({
                            type:"post",
                            url:"<?php echo U('Index/memberEditSave');?>",//根据自己项目的需要写请求地址
                            data:{
                                'id':id,
                                'cname':cname,
                                'phone':phone,
                                'workunits':workunits,
                                'socialposition':socialposition,
                                'sort':sort,
                                'address':address,
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

</body>

</html>