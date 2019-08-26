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
                <input type="text"  value="<?php echo ($res['m_cname']); ?>" id="cname" name="cname" disabled required="" lay-verify="nikename" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="a_jiu_sort" class="layui-form-label">酒积分</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['a_jiu_sort']); ?>" id="a_jiu_sort" name="a_jiu_sort" required="" lay-verify="a_jiu_sort" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="a_jichang_sort" class="layui-form-label">机场积分</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['a_jichang_sort']); ?>" id="a_jichang_sort" lay-verify="workunits" name="a_jichang_sort" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="a_doctor_sort" class="layui-form-label">医疗积分</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['a_doctor_sort']); ?>" id="a_doctor_sort" lay-verify="a_doctor_sort" name="a_doctor_sort" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="a_consume_sort" class="layui-form-label">兑换积分</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['a_consume_sort']); ?>" id="a_consume_sort" lay-verify="a_consume_sort" name="a_consume_sort" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
        </div>

        <div class="layui-form-item">
            <label for="a_jinbi_sort" class="layui-form-label">金币积分</label>
            <div class="layui-input-inline">
                <input type="text" value="<?php echo ($res['a_jinbi_sort']); ?>" id="a_jinbi_sort" lay-verify="a_jinbi_sort" name="a_jinbi_sort" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>积分作用重大，请慎重更改</div>
        </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <input type="button" name="btn" id="<?php echo ($res['a_aid']); ?>" class="layui-btn" lay-filter="add" lay-submit="" value="增加">
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
                    /*form.verify({
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

                    });*/
                    //监听提交
                    form.on('submit(add)', function(data){
                        // alert(JSON.stringify(data));
                        //发异步，把数据提交给php
                        var id  = $('input[name="btn"]').attr('id');			//id
                        var a_doctor_sort  = $('input[name="a_doctor_sort"]').val();			//医疗积分
                        var a_jiu_sort  = $('input[name="a_jiu_sort"]').val();			//酒积分
                        var a_jichang_sort  = $('input[name="a_jichang_sort"]').val();		//机场积分
                        var a_consume_sort  = $('input[name="a_consume_sort"]').val();		//兑换积分
                        var a_jinbi_sort  = $('input[name="a_jinbi_sort"]').val();		//金币积分
                        //接收
                        //alert(a_jinbi_sort);
                        // alert(JSON.stringify(introduce));
                        // return false;
                        $.ajax({
                            type:"post",
                            url:"<?php echo U('Sort/sortEditSave');?>",//根据自己项目的需要写请求地址
                            data:{
                                'id':id,
                                'a_doctor_sort':a_doctor_sort,
                                'a_jiu_sort':a_jiu_sort,
                                'a_jichang_sort':a_jichang_sort,
                                'a_consume_sort':a_consume_sort,
                                'a_jinbi_sort':a_jinbi_sort,
                            },
                            dataType:'json',
                            success:function(data){
                                // alert(JSON.stringify(data));
                                if (data.error == 1){
                                    layer.confirm('更改成功！',function(index){
                                        //关闭当前frame
                                        x_admin_close();
                                        // 可以对父窗口进行刷新
                                        x_admin_father_reload();
                                    });
                                }else{
                                    layer.msg('哎呦，运气不好哦，更改失败咯！',function(){});
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