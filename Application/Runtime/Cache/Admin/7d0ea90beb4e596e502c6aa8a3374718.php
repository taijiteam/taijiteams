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
    <script type="text/javascript" src="/Public/Admin/js/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/webuploader/webuploader.js"></script>



    <link rel="stylesheet" href="/Public/Admin/easyUpload/main.css">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>

<body>
<div class="x-body">
   <!-- <div class="layui-form-item">
        <label for="shopid" class="layui-form-label"><span class="x-red">*</span>商家账号</label>
        <div class="layui-input-inline">
            <input type="text" id="shopid" name="shopid" value="<?php echo ($res['s_shopid']); ?>" disabled required="" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>上传成功后，不可更改</div>
    </div>
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="user" class="layui-form-label"><span class="x-red">*</span>商家名称</label>
            <div class="layui-input-inline">
                <input type="text" id="user" name="user"  required="" lay-verify="nikename" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="groupname" class="layui-form-label"><span class="x-red">*</span>商铺类型</label>
            <div class="layui-input-inline">
                &lt;!&ndash;<input type="text" id="m_groupname" name="m_groupname" required="" lay-verify="nikename"autocomplete="off" class="layui-input">&ndash;&gt;
                <select id="groupname" name="groupname" autocomplete="off" class="layui-input">
                    <option value="美食">美食</option>
                    <option value="旅游">旅游</option>
                    <option value="宾馆">宾馆</option>
                </select>
            </div>
        </div>

        &lt;!&ndash;后面未编辑name值&ndash;&gt;

        <div class="layui-form-item">
            <label for="linkman" class="layui-form-label"><span class="x-red">*</span>联系人</label>
            <div class="layui-input-inline">
                <input type="text" id="linkman" name="linkman" required=""  autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label"><span class="x-red">*</span>联系电话</label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="telephone" class="layui-form-label"><span class="x-red">*</span>商铺电话</label>
            <div class="layui-input-inline">
                <input type="text" id="telephone" name="telephone" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="address" class="layui-form-label"><span class="x-red">*</span>商铺地址</label>
            <div class="layui-input-inline">
                <input type="text" id="address" name="address" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="active" class="layui-form-label"><span class="x-red">*</span>启用状态</label>
            <div class="layui-input-inline">
                <input type="text" id="active" name="active" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>0代表开启，1代表禁用</div>
        </div>
        <div class="layui-form-item">
            <label for="time" class="layui-form-label"><span class="x-red">*</span>开户时间</label>
            <div class="layui-input-inline">
                <input type="text" id="time" name="time" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>-->
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>餐厅bander图</label>
            <div class="layui-input-inline">
                <div id="uploader"></div>
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-form-item">
                <label class="layui-form-label">餐厅简介</label>
            </div>
            <div class="test">
                <script id="editor" type="text/plain" style="width: 90%;height: 300px;margin: auto"></script>
                </div>
                </div>


        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>餐厅展示图</label>
            <div class="layui-input-inline">
                <div id="uploader1"></div>
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-form-item">
                <label class="layui-form-label">美食推荐</label>
            </div>
            <div class="test">
                <script id="editor1" type="text/plain" style="width: 90%;height: 300px;margin: auto"></script>
                </div>
                </div>


        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>餐厅菜品图</label>
            <div class="layui-input-inline">
                <div id="uploader2"></div>
            </div>
        </div>



        <div class="layui-form-item">
            <div class="layui-form-item">
                <label class="layui-form-label">成员专享</label>
            </div>
            <div class="test">
                <script id="editor2" type="text/plain" style="width: 90%;height: 300px;margin: auto"></script>
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
    layui.use('upload', function(){
        var upload = layui.upload;
        //执行实例
        var uploadInst = upload.render({
            elem: '#doc' //绑定元素
            ,url: "<?php echo U('Business/memberPhoto');?>" //上传接口
            ,done: function(data){
                //上传完毕回调
                layer.msg(''+data.msg+'',function(){
                    /*var html ='';
                    html += '<img src="/Public/Uploads/Member/'+data.photo+'" height="200px" /><input type="hidden"id="photo" name="photo" value='+data.photo+'>';
                    $('#photo').html(html);*/
                });
            }
            ,error: function(){
                //请求异常回调
            }
        });
    });
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
    var ue = UE.getEditor('editor1');
    var ue = UE.getEditor('editor2');
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
            var groupname  = $("#groupname option:checked").val();		//商铺类型
            var user  = $('input[name="user"]').val();			        //商铺名字
            var shopid  = $('input[name="shopid"]').val();			    //商铺id
            var linkman  = $('input[name="linkman"]').val();			//联系人
            var pass  = $('input[name="pass"]').val();			        //密码
            var repass  = $('input[name="repass"]').val();			    //确认密码
            var phone  = $('input[name="phone"]').val();			    //手机
            var telephone  = $('input[name="telephone"]').val();		//商铺电话
            var address  = $('input[name="address"]').val();			//商铺地址
            var active  = $('input[name="active"]').val();			    //状态
            var time  = $('input[name="time"]').val();			        //开户时间
            var introduce = [];
            introduce.push(UE.getEditor('editor').getContent());        //餐厅简介
            var introduce1 = [];
            introduce.push(UE.getEditor('editor1').getContent());        //美食推荐
            var introduce2 = [];
            introduce.push(UE.getEditor('editor2').getContent());        //成员专享

            //接收
            //alert(JSON.stringify(introduce));
            //alert(introduce);
            //return false;
            $.ajax({
                type:"post",
                url:"<?php echo U('Business/BusinessSave');?>",//根据自己项目的需要写请求地址
                data:{
                    'groupname':groupname,          //商铺类型
                    'user':user,                    //商铺名字
                    'shopid':shopid,                //商铺id
                    'pass':pass,                    //商铺密码
                    'repass':repass,                //商铺确认密码
                    'linkman':linkman,              //联系人
                    'phone':phone,                  //联系人电话
                    'telephone':telephone,          //商铺电话
                    'address':address,              //商铺电话
                    'active':active,                //启用状态
                    'time':time,                    //添加时间
                    'introduce':introduce,          //餐厅简介
                    'introduce1':introduce1,          //美食推荐
                    'introduce2':introduce2,          //成员专享
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
<!--<script>
    //餐厅简介富文本编辑器
    $(document).ready(function(e) {
        //加载富文本编辑器
        KindEditor.ready(function(K){
            K.create('#content', {
                allowFileManager : true,
                filterMode:true,
                afterBlur:function(){
                    this.sync("#content");
                }
            });
        });
    });
    //美食推荐富文本编辑器
    $(document).ready(function(e) {
        //加载富文本编辑器
        KindEditor.ready(function(K){
            K.create('#content1', {
                allowFileManager : true,
                filterMode:true,
                afterBlur:function(){
                    this.sync("#content1");
                }
            });
        });
    });
    //成员专享富文本编辑器
    $(document).ready(function(e) {
        //加载富文本编辑器
        KindEditor.ready(function(K){
            K.create('#content2', {
                allowFileManager : true,
                filterMode:true,
                afterBlur:function(){
                    this.sync("#content2");
                }
            });
        });
    });
</script>-->
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
<script src="/Public/Admin/easyUpload/easyUploader.jq.js"></script>
<script>
    var uploader = easyUploader({
        id: "uploader",
        accept: '.jpg,.png,.doc,.docx',
        action: "<?php echo U('Business/BusinessPhoto1');?>?id=<?php echo ($id); ?>",
        dataFormat: 'formData',
        maxCount: 20,
        maxSize: 3,
        multiple: true,
        data: null,
       /* beforeUpload: function(file, data, args) {
            /!* dataFormat为formData时配置发送数据的方式 *!/
            data.append('token', '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT');
            data.append('otherKey', 'otherValue');

            /!* dataFormat为base64时配置发送数据的方式 *!/
            // data.base = file.base;
            // data.token = '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT';
            // data.otherKey = 'otherValue';
        },
        onChange: function(fileList) {
            /!* input选中时触发 *!/
        },
        onRemove: function(removedFiles, files) {
            console.log('onRemove', removedFiles);
        },
        onSuccess: function(res) {
            console.log('onSuccess', res);*/

            /**
             * 注意，接口调通不代表视图会展示成功，接口调通时视图要展示成功需要满足以下两点条件
             * 1. 返回数据必须由对象包裹，如 { code: 200, data: null }
             * 2. 必须有一个用于标识成功状态的属性，默认属性是code，默认成功属性值是200，配置项分别对应successKey和successValue，可视情况自行配置
             */

            /**
             * 可以在onSuccess/onError等回调函数中通过实例的files属性可以访问上传文件，如 var files = uploader.files; console.log一下就会发现files数组中每个元素由以下属性构成
             * 1. ajaxResponse: ajax的的响应结果
             * 2. base: 文件的base64编码
             * 3. checked: 该文件是否被选中
             * 4. file: 文件对象
             * 5. id: 插件内部标识的文件id
             * 6. isImg: 插件内部标识文件时否是图片
             * 7. previewBase: 文件压缩后的base64编码，用于插件内部展示预览图
             * 8. uploadPercentage: 文件上传进度百分比值
             * 9. uploadStatus: 文件上传状态
             */
        //},
        onError: function(err) {
            console.log('onError', err);
        },
    });
</script>
<script>
    var uploader = easyUploader({
        id: "uploader1",
        accept: '.jpg,.png,.doc,.docx',
        action: "<?php echo U('Business/BusinessPhoto2');?>?id=<?php echo ($id); ?>",
        dataFormat: 'formData',
        maxCount: 20,
        maxSize: 3,
        multiple: true,
        data: null,
        /*beforeUpload: function(file, data, args) {
            /!* dataFormat为formData时配置发送数据的方式 *!/
            data.append('token', '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT');
            data.append('otherKey', 'otherValue');

            /!* dataFormat为base64时配置发送数据的方式 *!/
            // data.base = file.base;
            // data.token = '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT';
            // data.otherKey = 'otherValue';
        },
        onChange: function(fileList) {
            /!* input选中时触发 *!/
        },
        onRemove: function(removedFiles, files) {
            console.log('onRemove', removedFiles);
        },
        onSuccess: function(res) {
            console.log('onSuccess', res);

            /**
             * 注意，接口调通不代表视图会展示成功，接口调通时视图要展示成功需要满足以下两点条件
             * 1. 返回数据必须由对象包裹，如 { code: 200, data: null }
             * 2. 必须有一个用于标识成功状态的属性，默认属性是code，默认成功属性值是200，配置项分别对应successKey和successValue，可视情况自行配置
             */

            /**
             * 可以在onSuccess/onError等回调函数中通过实例的files属性可以访问上传文件，如 var files = uploader.files; console.log一下就会发现files数组中每个元素由以下属性构成
             * 1. ajaxResponse: ajax的的响应结果
             * 2. base: 文件的base64编码
             * 3. checked: 该文件是否被选中
             * 4. file: 文件对象
             * 5. id: 插件内部标识的文件id
             * 6. isImg: 插件内部标识文件时否是图片
             * 7. previewBase: 文件压缩后的base64编码，用于插件内部展示预览图
             * 8. uploadPercentage: 文件上传进度百分比值
             * 9. uploadStatus: 文件上传状态
             */
        //},
        onError: function(err) {
            console.log('onError', err);
        },
    });
</script>
<script>
    var uploader = easyUploader({
        id: "uploader2",
        accept: '.jpg,.png,.doc,.docx',
        action: "<?php echo U('Business/BusinessPhoto3');?>?id=<?php echo ($id); ?>",
        dataFormat: 'formData',
        maxCount: 20,
        maxSize: 3,
        multiple: true,
        data: null,
        beforeUpload: function(file, data, args) {
            /* dataFormat为formData时配置发送数据的方式 */
            data.append('token', '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT');
            data.append('otherKey', 'otherValue');

            /* dataFormat为base64时配置发送数据的方式 */
            // data.base = file.base;
            // data.token = '387126b0-7b3e-4a2a-86ad-ae5c5edd0ae6TT';
            // data.otherKey = 'otherValue';
        },
        /*onChange: function(fileList) {
            /!* input选中时触发 *!/
        },
        onRemove: function(removedFiles, files) {
            console.log('onRemove', removedFiles);
        },
        onSuccess: function(res) {
            console.log('onSuccess', res);

            /!**
             * 注意，接口调通不代表视图会展示成功，接口调通时视图要展示成功需要满足以下两点条件
             * 1. 返回数据必须由对象包裹，如 { code: 200, data: null }
             * 2. 必须有一个用于标识成功状态的属性，默认属性是code，默认成功属性值是200，配置项分别对应successKey和successValue，可视情况自行配置
             *!/

            /!**
             * 可以在onSuccess/onError等回调函数中通过实例的files属性可以访问上传文件，如 var files = uploader.files; console.log一下就会发现files数组中每个元素由以下属性构成
             * 1. ajaxResponse: ajax的的响应结果
             * 2. base: 文件的base64编码
             * 3. checked: 该文件是否被选中
             * 4. file: 文件对象
             * 5. id: 插件内部标识的文件id
             * 6. isImg: 插件内部标识文件时否是图片
             * 7. previewBase: 文件压缩后的base64编码，用于插件内部展示预览图
             * 8. uploadPercentage: 文件上传进度百分比值
             * 9. uploadStatus: 文件上传状态
             *!/
        },*/
        onError: function(err) {
            console.log('onError', err);
        },
    });
</script>
</body>

</html>