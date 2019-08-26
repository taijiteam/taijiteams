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
    .layui-tab-content  .layui-form-item {
        margin-top: 60px;
        margin-left: 40px;
}
    .layui-textarea{
        width: 600px;
    }
</style>

<body>
<div class="x-body">
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li id="goods-common-li">商品基本信息</li>
            <li id="goods-spec-li">商品详情信息</li>
            <li id="goods-image-li">图片详细信息</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item" id="goods-common-page">
                <form class="layui-form" id="goods-common-form">

    <?php if(empty($res)): ?><!--   商品添加       -->
        <div class="layui-form-item">
            <label for="goods_category" class="layui-form-label">
                <span class="x-red">*</span>商品类别
            </label>
            <div class="layui-input-inline">
                <select id="goods_category" name="goods_category"  autocomplete="off" class="layui-input">
                    <option value="珠宝首饰">珠宝首饰</option>
                    <option value="工艺礼品">工艺礼品</option>
                    <option value="甄选名酒">甄选名酒</option>
                    <option value="艺术文化">艺术文化</option>
                    <option value="营养保健">营养保健</option>
                    <option value="私人定制">私人定制</option>
                    <option value="积分兑换">积分兑换</option>
                </select>
            </div>
            <label for="goods_code" class="layui-form-label">
                <span class="x-red">*</span>商品编码
            </label>
            <div class="layui-input-inline">
                <input type="text" id="goods_code" name="goods_code" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                *<span class="x-red" style="color: #7d7d7d">类型首字母大写+数字编号</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="goods_name" class="layui-form-label"><span class="x-red">*</span>商品名称</label>
            <div class="layui-input-inline">
                <input type="text" id="goods_name" name="goods_name" required="" lay-verify="nikename"autocomplete="off" class="layui-input">
            </div>
            <label for="is_hidden" class="layui-form-label">是否隐藏</label>
            <div class="layui-input-inline">
                <select id="is_hidden" name="is_hidden" autocomplete="off" class="layui-input">
                    <option selected="selected" value="0">否</option>
                    <option value="1">是</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="goods_unit" class="layui-form-label"><span class="x-red">*</span>商品单位</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline">
                    <input type="text" id="goods_unit" name="goods_unit" autocomplete="off" class="layui-input">
                    *<span class="x-red" style="color: #7d7d7d">商品单位: 个, 只, 件, 箱...</span>
                </div>
            </div>
            <label for="goods_pocket_type" class="layui-form-label">使用积分</label>
            <div class="layui-input-inline">
                <select id="goods_pocket_type" name="goods_pocket_type" autocomplete="off" class="layui-input">
                    <option selected="selected" value="0">不使用</option>
                    <!--<option value="1">A积分</option>-->
                    <option value="201" title="B1积分">酒积分</option>
                    <!--<option value="C">C</option>
                    <option value="D">D</option>-->
                </select>
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 100px">
            <legend>商品简介</legend>
            <div class="layui-form-label">
                <div class="layui-input-block">
                    <textarea name="desc" id="goods_remark"  placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
            </div>
        </fieldset>

    <?php else: ?>

        <!--  商品详情带参数  -->
        <div class="layui-form-item">
            <label for="goods_categorys" class="layui-form-label">
                <span class="x-red">*</span>商品类别
            </label>
            <div class="layui-input-inline">
                <select id="goods_categorys" name="goods_categorys"  autocomplete="off" class="layui-input">
                    <?php if($res["goods_category"] =='珠宝首饰' ): ?><option  selected='selected' value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='工艺礼品' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option selected="selected" value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='甄选名酒' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option selected="selected" value="甄选名酒">甄选名酒</option>
                        <option value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='艺术文化' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option selected="selected" value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='营养保健' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option selected="selected" value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='私人定制' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option selected="selected" value="私人定制">私人定制</option>
                        <option value="积分兑换">积分兑换</option>
                        <?php elseif($res["goods_category"] =='私人定制' ): ?>
                        <option value="珠宝首饰">珠宝首饰</option>
                        <option value="工艺礼品">工艺礼品</option>
                        <option value="甄选名酒">甄选名酒</option>
                        <option value="艺术文化">艺术文化</option>
                        <option value="营养保健">营养保健</option>
                        <option  value="私人定制">私人定制</option>
                        <option selected="selected" value="积分兑换">积分兑换</option><?php endif; ?>
                </select>
            </div>
            <label for="goods_codes" class="layui-form-label">
                <span class="x-red">*</span>商品编码
            </label>
            <div class="layui-input-inline">
                <input type="text" id="goods_codes" disabled name="goods_codes" value="<?php echo ($res["goods_code"]); ?>" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                *<span class="x-red" style="color: #7d7d7d">类型首字母大写+数字编号</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="goods_names" class="layui-form-label"><span class="x-red">*</span>商品名称</label>
            <div class="layui-input-inline">
                <input type="text" id="goods_names" disabled name="goods_names" value="<?php echo ($res["goods_name"]); ?>" required="" lay-verify="nikename"autocomplete="off" class="layui-input">
            </div>
            <label for="is_hiddens" class="layui-form-label">是否隐藏</label>
            <div class="layui-input-inline">
                <select id="is_hiddens" name="is_hiddens" autocomplete="off" class="layui-input">
                    <?php if($res["is_hidden"] =='0' ): ?><option selected="selected" value="0">否</option>
                        <option value="1">是</option>
                        <?php else: ?>
                        <option value="0">否</option>
                        <option selected="selected" value="1">是</option><?php endif; ?>
                </select>
            </div>
            <!--<label for="goods_status" class="layui-form-label"><span class="x-red">*</span>展示状态</label>
            <div class="layui-input-inline">
                <select id="goods_status" name="goods_status" autocomplete="off" class="layui-input">
                    <option value="2">上架</option>
                    <option value="1">下架</option>
                </select>
            </div>-->

        </div>

        <div class="layui-form-item">
            <label for="goods_units" class="layui-form-label"><span class="x-red">*</span>商品单位</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline">
                    <input type="text" id="goods_units" name="goods_units" value="<?php echo ($res["goods_unit"]); ?>" autocomplete="off" class="layui-input">
                    *<span class="x-red" style="color: #7d7d7d">商品单位: 个, 只, 件, 箱...</span>
                </div>
            </div>
            <label for="goods_pocket_types" class="layui-form-label">使用积分</label>
            <div class="layui-input-inline">
                <select id="goods_pocket_types" name="goods_pocket_types" autocomplete="off" class="layui-input">
                    <?php if($res["goods_pocket_type"] == '0' ): ?><option selected="selected" value="0">不使用</option>
                        <option value="201">B积分</option>
                        <?php elseif($res["goods_pocket_type"] == '201'): ?>
                        <option value="0">不使用</option>
                        <option selected="selected" value="201">B积分</option><?php endif; ?>
                    <!--<option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>-->
                </select>
            </div>
        </div>

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 100px">
            <legend>商品简介</legend>
            <div class="layui-form-label">
                <div class="layui-input-block">
                    <textarea name="desc" id="goods_remarks"  placeholder="请输入内容" class="layui-textarea"><?php echo ($res["goods_remark"]); ?></textarea>
                </div>
            </div>
        </fieldset>
        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" id="saveGoods" style="width:70% ;height: 50px">更 新</button>
        </div><?php endif; ?>
</form>

             </div>
            <div class="layui-tab-item" id="goods-spec-page">
                <form class="layui-form" id="goods-class-form">
    <?php if(empty($res)): ?><!-- 添加规格商品  -->
        <div class="layui-form-item">
            <label class="layui-form-label">商品类型</label>
            <div class="layui-input-block">
                <?php if(is_array($spec_list)): $k = 0; $__LIST__ = $spec_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><input type="checkbox" name="spec_class_ids" value="<?php echo ($vo["id"]); ?>" title="<?php echo ($vo["spec_class_name"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn  layui-btn-lg" id="spec-table-btn">生成表格</button>
            </div>
        </div>

        <hr>

        <!-- spec_table -->
        <form class="layui-form">
            <table class="layui-table" style="margin-top: 60px" id="spec-table">
                <tr id="spec-th">
                </tr>
            </table>
        </form>
        <div class="layui-form-item">
            <button class="layui-btn" id="addOneRow" >添加一行</button>
        </div>
    <?php else: ?>
        <!-- 管理规格商品  -->
        <table class="layui-table">
            <tr>
                <th>名称</th>
                <!--<th>规格</th>-->
                <?php if(is_array($spec_name)): $k = 0; $__LIST__ = $spec_name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><th><?php echo ($vo); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                <th>价格</th>
                <th>库存</th>
                <th>A积分</th>
                <th>类型积分</th>
                <th>添加时间</th>
                <th>修改时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>

            <?php if(is_array($goods_list)): $k = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($vo["goods_name"]); ?></td>
                    <!-- 规格生成 -->
                    <?php
 foreach($spec_name as $spec_class_id => $spec_class_name){ foreach($vo['goods_spec'] as $spec_id => $spec){ if(in_array(current($spec),$spec_val[$spec_class_id])){ echo "<td>".current($spec)."</td>"; } } } ?>
                    <td><?php echo ($vo["goods_price"]); ?></td>
                    <td><?php echo ($vo["goods_storage"]); ?></td>
                    <td><?php echo ($vo["goods_pocket_a"]); ?></td>
                    <td><?php echo ($vo["goods_pocket"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                    <td><?php echo (date('Y-m-d H:i:s',$vo["edittime"])); ?></td>
                    <td>
                        <?php switch($vo["goods_status"]): case "1": ?>仓库<?php break;?>
                            <?php case "2": ?>在售<?php break;?>
                            <?php default: endswitch;?>
                    </td>
                    <td>
                        <?php switch($vo["goods_status"]): case "1": ?><a title="上架" class="online" data-goods-id="<?php echo ($vo["goods_id"]); ?>" data-common="<?php echo ($vo["goods_common_id"]); ?>" data-status="<?php echo ($vo["goods_status"]); ?>" href="javascript:;"> 上 架 </a><?php break;?>
                            <?php case "2": ?><a title="下架" class="offline" data-goods-id="<?php echo ($vo["goods_id"]); ?>" data-common="<?php echo ($vo["goods_common_id"]); ?>" data-status="<?php echo ($vo["goods_status"]); ?>" href="javascript:;"> 下 架 </a><?php break;?>
                            <?php default: endswitch;?>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>

        <div class="layui-form-item">
            <span class="layui-btn" id="addNewGoodsItem"  >上架新商品</span>
        </div><?php endif; ?>
</form>

<script>
    $(function(){
        var spec_class_ids = {};
        var table_line = 1;
        var _td = new Array();//一行数据的原始值
        var th = "<th>序号</th>";
        var td = "";

        //生成table
        $("#spec-table-btn").click(function(){
            $("input:checkbox[name='spec_class_ids']:checked").each(function(){
                spec_class_ids[$(this).val()] = $(this).attr('title');
            });

            console.log(spec_class_ids);
            if($.isEmptyObject(spec_class_ids)){
                alert("请选择一个规格后再生成表单");
                return false;
            }
            $.ajax({
                type: "post",
                url: "/Admin/GoodsSpec/spec_table",
                data: {
                    'spec_class_ids':spec_class_ids
                },
                dataType: 'json',
                success: function (ret) {
                    console.log(ret);
                    if(ret.code != '200'){
                        alert("生成失败");
                        return false;
                    }

                    res = ret.data;
                    //生成表格头部  th
                    $.each(res.spec_class_name, function(i, val)
                    {
                        th += ' <th>' + val +'</th>';
                    });

                    $('#spec-table').html("<tr id=\"spec-th\"></tr>");
                    $('#spec-th').html(th);
                    th = "<th>序号</th>";
                    td = "";
                    _td = new Array();
                    table_line = 1;

                    //生成表格原型
                    $.each(res.spec_class_id, function(i, val)
                    {
                        _td[i] = val+'" value=""></td>';
                    });
                    addOneRow();

                }
            });
            return false;
        });

        //添加一行
        $('#addOneRow').click(function(){
            addOneRow()
        });

        function addOneRow(){
            $.each(_td,function(i,val){
                td = td + '<td><input class="spec-table-item layui-input" name="' + table_line +'.' + _td[i];
            });

            td = '<tr><td>'+table_line+'</td>' + td + '</tr>';
            $('#spec-table').append(td);
            td = "";

            table_line = table_line+1;
        }

        //添加一行新商品
        $("#addNewGoodsItem").click(function(){
            layer.open({
                type: 2,
                title: '添加新商品',
                area: ['720px', '540px'],
                shade: 0,
                maxmin: true,
                offset: 'auto', //[50,200],
                content: '/Admin/Goods/addNewGoodsItem?gc_id=<?php echo ($res["goods_common_id"]); ?>'
            });
        });


        //商品上下架
        $(".online").click(function () {
            var goods_id = $(this).attr('data-goods-id');
            var gc_id = $(this).attr("data-common");
            $.ajax({
                type : 'post',
                url  :  '/Admin/Goods/goods_online',
                data : {
                    goods_id     : goods_id
                },
                dataType : 'json',
                success : function (res) {
                    if(res.code == "200"){
                        layer.msg("上架成功",{time:1500});
                        window.location.href = "/Admin/Goods/goods_detail?goods_id="+gc_id+"&tab=spec";
                    }
                }
            })
        })

        //商品上下架
        $(".offline").click(function () {
            var goods_id = $(this).attr('data-goods-id');
            var gc_id = $(this).attr("data-common");
            $.ajax({
                type : 'post',
                url  :  '/Admin/Goods/goods_offline',
                data : {
                    goods_id     : goods_id
                },
                dataType : 'json',
                success : function (res) {
                    if(res.code == "200"){
                        layer.msg("下架成功",{time:1500});
                        window.location.href = "/Admin/Goods/goods_detail?goods_id="+gc_id+"&tab=spec";
                    }
                }
            })
        })
    })
</script>






            </div>
            <div class="layui-tab-item" id="goods-image-page">
                <div class="up" style="width: 100%;border: none;">
    <div class="layui-form-item" style="margin: 8px 80px 0 0;display: inline-block;">
        <label for="goods-main-image-url" class="layui-form-label">商品主图</label>
        <div class="layui-input-inline" style="width: 375px;text-align: center;">
            <button type="button" class="layui-btn" id="goods-main-image">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <div style="width:375px;height:250px;border: 1px #7c7c7c dashed;margin: 20px 0 0 10px;overflow: hidden;">
                <img id="goods-main-image-show" src="<?php echo ($res["main_img"]); ?>"  width="100%" />
                <input type="hidden" id="goods-main-image-url" name="goods-main-image-url" value="<?php echo ($res["main_img"]); ?>">
            </div>
        </div>
    </div>
    <div class="layui-form-item" style="margin: 8px 80px 0 0;display: inline-block;">
        <div class="layui-input-inline" style="width: 375px;text-align: center;margin-top: 39px;">
            <button type="button" class="layui-btn" id="goods-main-image2">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <div style="width:375px;height:250px;border: 1px #7c7c7c dashed;margin: 20px 0 0 10px;overflow: hidden;">
                <img id="goods-main-image-show2" src="<?php echo ($res["main2_img"]); ?>"  width="100%"/>
                <input type="hidden" id="goods-main-image-url2" name="goods-main-image-url2" value="<?php echo ($res["main2_img"]); ?>">
            </div>
        </div>
    </div>
    <div class="layui-form-item" style="margin: 8px 80px 0 0;display: inline-block;">
        <div class="layui-input-inline" style="width: 375px;text-align: center;margin-top: 39px;">
            <button type="button" class="layui-btn" id="goods-main-image3">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <div style="width:375px;height:250px;border: 1px #7c7c7c dashed;margin: 20px 0 0 10px;overflow: hidden;">
                <img id="goods-main-image-show3" src="<?php echo ($res["main3_img"]); ?>"  width="100%" />
                <input type="hidden" id="goods-main-image-url3" name="goods-main-image-url3" value="<?php echo ($res["main3_img"]); ?>">
            </div>
        </div>
    </div>
    <div class="up-a" style="width: 86%;border: none;margin: 0 auto;">
        <div class="layui-form-item" style="margin: 8px 80px 0 0;display: inline-block;">
            <div class="layui-input-inline" style="width: 375px;text-align: center;margin-top: 39px;">
                <button type="button" class="layui-btn" id="goods-main-image4">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
                <div style="width:375px;height:250px;border: 1px #7c7c7c dashed;margin: 20px 0 0 10px;overflow: hidden;">
                    <img id="goods-main-image-show4" src="<?php echo ($res["main4_img"]); ?>"  width="100%" />
                    <input type="hidden" id="goods-main-image-url4" name="goods-main-image-url4" value="<?php echo ($res["main4_img"]); ?>">
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin: 8px 80px 0 0;display: inline-block;">
            <div class="layui-input-inline" style="width: 375px;text-align: center;margin-top: 39px;">
                <button type="button" class="layui-btn" id="goods-main-image5">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
                <div style="width:375px;height:250px;border: 1px #7c7c7c dashed;margin: 20px 0 0 10px;overflow: hidden;">
                    <img id="goods-main-image-show5" src="<?php echo ($res["main5_img"]); ?>"  width="100%" />
                    <input type="hidden" id="goods-main-image-url5" name="goods-main-image-url5" value="<?php echo ($res["main5_img"]); ?>">
                </div>
            </div>
        </div>
    </div>
</div>





<div class="layui-form-item" style="margin-left: 0;margin-top: 15%" >
    <label for="goods-desc-image-url" class="layui-form-label" style="margin-left: 100px">商品详情图</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="goods-desc-image">
            <i class="layui-icon">&#xe67c;</i>上传图片
        </button>
        <div style="width:375px;min-height:500px;border: 1px #7c7c7c dashed;margin-top: 20px">
            <img id="goods-desc-image-show" src="<?php echo ($res["desc_img"]); ?>"  width="100%" />
            <input type="hidden" id="goods-desc-image-url" name="goods-desc-image-url" value="<?php echo ($res["desc_img"]); ?>">
        </div>
    </div>
</div>

<!--   广告图    -->
<div class="layui-form-item" style="margin-left: 100px">
    <label for="goods-adve-image-url" class="layui-form-label">广告图</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="goods-adve-image">
            <i class="layui-icon">&#xe67c;</i>上传图片
        </button>
        <div style="width:375px;height:375px;border: 1px #7c7c7c dashed;margin-top: 20px; overflow: hidden">
            <img id="goods-adve-image-show" src="<?php echo ($res["adve_img"]); ?>"  width="100%" />
            <input type="hidden" id="goods-adve-image-url" name="goods-adve-image-url" value="<?php echo ($res["adve_img"]); ?>">
        </div>
    </div>
</div>




<?php if(empty($res)): ?><div class="layui-form-item">
        <button class="layui-btn layui-btn-fluid" id="addGoods" style="width:70% ;height: 50px">提 交</button>
    </div>
    <?php else: ?>
    <div class="layui-form-item">
        <button class="layui-btn layui-btn-fluid" id="saveGoodsImg" data-goods-id="<?php echo ($res["goods_common_id"]); ?>" style="width:70% ;height: 50px">上传图片</button>
    </div><?php endif; ?>
<script type="text/javascript">
    $(function(){
        //图片上传
        layui.use('upload', function(){
            var upload = layui.upload;
            //商品主图
            var uploadMainImage = upload.render({
                elem: '#goods-main-image',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-main-image-show").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });
            var uploadMainImage = upload.render({
                elem: '#goods-main-image2',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-main-image-show2").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });
            var uploadMainImage = upload.render({
                elem: '#goods-main-image3',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-main-image-show3").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });
            var uploadMainImage = upload.render({
                elem: '#goods-main-image4',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-main-image-show4").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });
            var uploadMainImage = upload.render({
                elem: '#goods-main-image5',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-main-image-show5").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });

            //商品描述图
            var uploadDesc = upload.render({
                elem: '#goods-desc-image',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-desc-image-show").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });

            /**  广告图 **/
            var uploadadveImage = upload.render({
                elem: '#goods-adve-image',
                url: "/Admin/Upload/image",
                done: function(res){
                    console.log(res);
                    if(res.code == "200"){
                        $("#goods-adve-image-show").attr("src",res.data.photo);
                    }else{
                        layer.msg("上传失败");
                    }
                }
            });
        });
    })
</script>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>



<script type="text/javascript" >

    $(function(){
        var show_page = '<?php echo ($show_page); ?>';

        init();
        function init() {
            $.ajax ({
                type:'get',
                url:'/Admin/Goods/goodsInfo/?gc_id=<?php echo ($res["goods_common_id"]); ?>',
                success: function(res){
                    var main_img ='';
                    main_img += '<img src="/Public/Uploads/Goods/' + res.data.main_img + ' "  width="375px" height="250px" />'
                    $('#photo').html(main_img);
                    var desc_img ='';
                    desc_img += '<img src="/Public/Uploads/Goods/' + res.data.desc_img + ' "  width="375px" />'
                    $('#photo2').html(desc_img);
                }
                ,error: function(){
                        //请求异常回调
                    }
                });

            if(show_page == 'spec'){
                $("#goods-spec-li").addClass("layui-this");
                $("#goods-spec-page").addClass("layui-show");
            } else{
                $("#goods-common-li").addClass("layui-this");
                $("#goods-common-page").addClass("layui-show");
            }
        }

        layui.use(['form','layer','element','upload'], function(){
            $ = layui.jquery;
            var form = layui.form,layer = layui.layer;
            //自定义验证规则
            form.verify({
                nikenames: function(value){
                    if(value.length < 2){
                        return '编码格式不正确';
                    }
                }

            });
            //监听提交
        });

        //提交
        $(document).on("click","#addGoods",function () {
            var goods_category          =   $("#goods_category option:checked").val();		//商品类别
            var goods_code              =   $('input[name="goods_code"]').val();		    //商品编号
            var goods_name              =   $('input[name="goods_name"]').val();		    //商品名称
            var main_img                =   $('#goods-main-image-show').attr("src");		//商品主图
            var main2_img               =   $('#goods-main-image-show2').attr("src");		//商品主图2
            var main3_img               =   $('#goods-main-image-show3').attr("src");		//商品主图3
            var main4_img               =   $('#goods-main-image-show4').attr("src");		//商品主图4
            var main5_img               =   $('#goods-main-image-show5').attr("src");		//商品主图5
            var desc_img                =   $('#goods-desc-image-show').attr("src");		//商品详情图
            var adve_img                =   $('#goods-adve-image-show').attr("src");		//商品详情图
            var goods_unit              =   $('input[name="goods_unit"]').val();	    	//商品单位
            var goods_pocket_type       =   $("#goods_pocket_type option:checked").val();	//商品积分
            var goods_remark            =   $('#goods_remark').val();	                    //商品详情
            var is_hidden               =   $('#is_hidden option:checked').val();		    //是否隐藏
            $.ajax({
                type:'post',
                url :"/Admin/Goods/add",
                data:{

                    'goods_category': goods_category,
                    'goods_code'    : goods_code,
                    'goods_name'    : goods_name,
                    'goods_unit'    : goods_unit,
                    'goods_pocket_type'  : goods_pocket_type,
                    'goods_remark'  : goods_remark,
                    'is_hidden'     : is_hidden,
                    'spec_info'     : getSpecTableData(),
                    'main_img'      : main_img,
                    'main2_img'     : main2_img,
                    'main3_img'     : main3_img,
                    'main4_img'     : main4_img,
                    'main5_img'     : main5_img,
                    'desc_img'      : desc_img,
                    'adve_img'      : adve_img
                },
                dataType: 'json',
                success : function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        layer.msg("添加成功",{
                            icon:1,
                            time:2000,
                            shade:[0.6,'#000000']
                        },function(){
                            window.location.href = "/Admin/Goods/goodsList"
                        });
                    } else {
                        layer.msg(res.data.message,{
                            icon:2,
                            time:2000,
                            shade:[0.6,'#000000']
                        });
                    }
                }
            });
            return false;
        });

        //提交
        $(document).on("click","#saveGoods",function () {
            var goods_categorys          =   $("#goods_categorys option:checked").val();	//商品类别
            var goods_codes              =   $('input[name="goods_codes"]').val();		    //商品编号
            var goods_names              =   $('input[name="goods_names"]').val();		    //商品名称
            //var main_img                 =   $('#goods-main-image-show').attr("src");		//商品主图
            //var desc_img                 =   $('#goods-desc-image-show').attr("src");		//商品详情图
            //var adve_img                 =   $('#goods-adve-image-show').attr("src");		//商品详情图
            var goods_units              =   $('input[name="goods_units"]').val();	    	//商品单位
            var goods_pocket_types       =    $("#goods_pocket_types option:checked").val();		//商品积分
            var goods_remarks            =   $('#goods_remarks').val();	                    //商品详情
            var is_hiddens               =   $('#is_hiddens option:checked').val();		    //是否隐藏
            console.log(main2_img);
            $.ajax({
                type:'post',
                url :"/Admin/Goods/saveGoods/?gc_id=<?php echo ($res["goods_common_id"]); ?>",
                data:{
                    'goods_category': goods_categorys,
                    'goods_code'    : goods_codes,
                    'goods_name'    : goods_names,
                    'goods_unit'    : goods_units,
                    'goods_pocket_type'  : goods_pocket_types,
                    'goods_remark'  : goods_remarks,
                    'is_hidden'     : is_hiddens,
                    //'main_img'      : main_img,
                    //'desc_img'      : desc_img,
                    //'adve_img'      : adve_img
                },
                dataType: 'json',
                success : function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        layer.msg("编辑成功", {icon: 1,shade:[0.6,'#000000'],time:2000},function(){
                            window.location.href = "/Admin/Goods/goodsList";
                        });
                    } else {
                        layer.msg(res.message,{
                            icon:2,
                            time:2000,
                            shade:[0.6,'#000000']
                        });
                    }
                }
            });
            return false;
        });

        //提交
        $(document).on("click","#saveGoodsImg",function () {
            //var gc_id                    =   $(this).attr('data-goods-id');                 //商品id
            var main_img                 =   $('#goods-main-image-show').attr("src");		//商品主图
            var main2_img                 =   $('#goods-main-image-show2').attr("src");		//商品主图
            var main3_img                 =   $('#goods-main-image-show3').attr("src");		//商品主图
            var main4_img                 =   $('#goods-main-image-show4').attr("src");		//商品主图
            var main5_img                 =   $('#goods-main-image-show5').attr("src");		//商品主图
            var desc_img                 =   $('#goods-desc-image-show').attr("src");		//商品详情图
            var adve_img                 =   $('#goods-adve-image-show').attr("src");		//商品详情图
            $.ajax({
                type:'post',
                url :"/Admin/Goods/save_img/?gc_id=<?php echo ($res["goods_common_id"]); ?>",
                data:{
                    'main_img'      : main_img,
                    'main2_img'     : main2_img,
                    'main3_img'     : main3_img,
                    'main4_img'     : main4_img,
                    'main5_img'     : main5_img,
                    'desc_img'      : desc_img,
                    'adve_img'      : adve_img
                },
                dataType: 'json',
                success : function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        layer.msg("上传成功", {icon: 1,shade:[0.6,'#000000'],time:2000},function(){
                            window.location.href = "/Admin/Goods/goodsList";
                        });
                    } else {
                        layer.msg(res.message,{
                            icon:2,
                            time:2000,
                            shade:[0.6,'#000000']
                        });
                    }
                }
            });
            return false;
        });



        //获取规格表里的商品信息 spec_table
        function getSpecTableData()
        {
            var t = $('.spec-table-item').serializeArray();
            var d = {};
            console.log(t);
            $.each(t, function () {
                d[this.name] = this.value;
            });
            console.log(d);

            return d;
        }
    })
</script>
</body>

</html>