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
        <style>
            .table-goods-image{
                width: 72px;
                height: 54px;
                float: left;
            }

            .table-goods-image img{
                width: 100%;
            }

            .table-goods-info{
                overflow: hidden;
                float: left;
                height: 54px;
                margin-left: 4px;
                min-width: 120px;
            }
            .table-goods-info p{
                margin: 5px 2px;
                padding: 0px;
                text-align: left;
            }

        </style>
    </head>
    <style>

    </style>
    
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">演示</a>
                <a>
                    <cite>导航元素</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input class="layui-input" placeholder="开始日" name="start" id="start"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input class="layui-input" placeholder="截止日" name="end" id="end"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="username" placeholder="商品名称" autocomplete="off" class="layui-input"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">
                                        <i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <a href="/Admin/Goods/add">
                                <button class="layui-btn" >
                                    <i class="layui-icon"></i>添加
                                </button>
                            </a>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="text-align: center">序号</th>
                                        <th style="text-align: center">COMMON_ID</th>
                                        <th style="text-align: center">商品编号</th>
                                        <th style="text-align: center">商品信息</th>
                                        <th style="text-align: center">添加时间</th>
                                        <th style="text-align: center">商品状态</th>
                                        <th style="text-align: center">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($goodsList)): $k = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                                            <td><input type="checkbox" name="" lay-skin="primary"></td>

                                            <td><?php echo ($k); ?></td>
                                            <td><?php echo ($vo["goods_common_id"]); ?></td>
                                            <td><?php echo ($vo["goods_code"]); ?></td>
                                            <td style="min-width: 200px;padding: 4px;">
                                                <div class="table-goods-image" style="overflow-y: hidden;">
                                                    <img src="<?php echo ($vo["main_img"]); ?>" >
                                                </div>
                                                <div class="table-goods-info">
                                                    <p>名称: <?php echo ($vo["goods_name"]); ?></p>
                                                    <p>分类: <?php echo ($vo["goods_category"]); ?></p>
                                                </div>
                                            </td>

                                            <td><?php echo (date('Y-m-d H:i:s',$vo["goods_addtime"])); ?></td>
                                            <td>
                                                <?php switch($vo["goods_status"]): case "1": ?>下架<?php break;?>
                                                    <?php case "2": ?>上架<?php break;?>
                                                    <?php default: endswitch;?>
                                            </td>
                                            <td class="td-manage" style="font-size: 14px;">
                                                <a class="check-goods-detail" title="商品详情-<?php echo ($vo["goods_name"]); ?>" _href="/Admin/Goods/goods_detail/?goods_id=<?php echo ($vo["goods_common_id"]); ?>">
                                                    查 看
                                                </a>
                                                <span>  |  </span>
                                                <?php switch($vo["goods_status"]): case "1": ?><a class="line" data-goods-id="<?php echo ($vo["goods_common_id"]); ?>" data-status="<?php echo ($vo["goods_status"]); ?>" href="javascript:;"> 上 架 </a><?php break;?>
                                                    <?php case "2": ?><a class="line" data-goods-id="<?php echo ($vo["goods_common_id"]); ?>" data-status="<?php echo ($vo["goods_status"]); ?>"  href="javascript:;"> 下 架 </a><?php break;?>
                                                    <?php default: endswitch;?>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                    <?php echo ($goods_page); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </body>
    <script type="text/javascript">
        layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });
        
        //查看详情
        $(document).on('click',".check-goods-detail",function () {
            var url = $(this).attr('_href');
            var title = $(this).attr('title');
            var index = $(".check-goods-detail").index($(this)) + 1000;//避免与左侧重复
            console.log(url, title, index);
            var tab_list = [];
            // var is_refresh = $(this).attr('date-refresh')?true:false;

            // console.log(window.parent.$('.x-iframe'));
            var frames = window.parent.$('.x-iframe');

            for (var i = 0; i <frames.length; i++) {
                var j = frames.eq(i).attr('tab-id');
                if(j == index) {
                    window.parent.tab.tabChange(index);
                    event.stopPropagation();
                    frames.eq(i).attr("src",frames.eq(i).attr('src'));
                    return;
                }
            }

            if(getCookie('tab_list')){
                tab_list = getCookie('tab_list').split(',');
            }else{
                tab_list = [];
            }

            var is_exist = false;

            for (var i in tab_list) {
                if(tab_list[i]==index)
                    is_exist = true;
            }

            if(!is_exist){
                tab_list.push(index);
            }

            setCookie('tab_list',tab_list);

            window.parent.tab.tabAdd(title,url,index);
            window.parent.tab.tabChange(index);
            event.stopPropagation();
        });


        //商品上下架
        $(".line").click(function () {
            var gc_id = $(this).attr('data-goods-id');
            var gc_status = $(this).attr('data-status');
            layer.confirm('确认要操作吗？',function(index) {
                $.ajax({
                    type : 'post',
                    url  :  '/Admin/Goods/line',
                    data : {
                        gc_id     : gc_id,
                        gc_status : gc_status
                    },
                    dataType : 'json',
                    success : function (res) {
                       if (res.code == '200'){
                           location.reload();
                        }else{
                           layer.msg("操作失败",{icon:5,time:2000});
                       }
                    }
                });
            })
        })
    </script>
</html>