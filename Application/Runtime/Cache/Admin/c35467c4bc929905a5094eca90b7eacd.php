<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>已审核列表</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css" media="all">
</head>
<body>

<table id="demo" lay-filter="test"></table>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="del" id="btn">退回审核</a>
</script>
<script src="/Public/Admin/lib/layui/layui.js"></script>
<script>
    layui.use('table', function(){
        var table = layui.table;
        var $ = layui.jquery;
        //第一个实例
        table.render({
            elem: '#demo'
            ,height: 800
            ,url: '/Admin/Order/check_ProjectList?source=<?php echo ($source); ?>'//数据接口
            ,title: '医疗审核表'
            ,page: true //开启分页
            ,totalRow: true //开启合计行
            ,cols: [[ //表头
                {type: 'checkbox', fixed: 'left'}
                ,{field: 'o_id', title: 'ID', width:80, sort: true, fixed: 'left',totalRowText: '合计：'}
                ,{field: 'o_number', title: '订单号', width:177}
                ,{field: 'o_shopid', title: '预约餐厅', width:150}
                ,{field: 'o_user', title: '付款人', width:80}
                ,{field: 'o_phone', title: '手机号', width:177}
                ,{field: 'o_aprace', title: '订单总价', width: 100, sort: true,totalRow: true}
                ,{field: 'o_allrmb', title: '积分优惠价格', width: 130, sort: true,totalRow: true}
                ,{field: 'o_consumption', title: '订单结算时间', width:150}
                ,{field: 'source', title: '审核来源', width: 100}
                ,{field: 'mid', title: '审核人', width: 80}
                ,{field: 'pay', title: '审核支付方式', width: 100}
                ,{field: 'audit', title: '审核是否到账', width: 100}
                ,{field: 'add_time', title: '审核时间', width: 177}
                ,{fixed: 'right', width: 100, align:'center', toolbar: '#barDemo'}
            ]]
        });
        //监听行工具事件
        table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                ,layEvent = obj.event; //获得 lay-event 对应的值
            if(layEvent === 'del'){
                layer.confirm('确定退回审核吗？', function(index){
                    //向服务端发送删除指令
                    $.ajax({
                        type : "post",
                        url  : "/Admin/Order/doctorReject",
                        data :{
                            id : data.order_id,
                        },
                        dataType : "json",
                        success:function (res) {
                            if (res.code == "200"){
                                obj.del();      //删除对应行（tr）的DOM结构
                                layer.close(index);
                            }
                        }
                    })
                    //window.location.href = "/Admin/Order/reject/?id=" + data.order_id ;
                });
            }
        });
    });
</script>
</body>
</html>