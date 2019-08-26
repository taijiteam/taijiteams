<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html  class="x-admin-sm">
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
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="<?php echo U('Index/index');?>">渠道plus微管家</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <!--<ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> &lt;!&ndash; 二级菜单 &ndash;&gt;
              <dd><a onclick="x_admin_show('资讯','https://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
              <dd><a onclick="x_admin_show('图片','https://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
               <dd><a onclick="x_admin_show('用户','https://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
               <dd><a onclick="x_admin_add_to_tab('在tab打开','https://www.baidu.com',true)"><i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
            </dl>
          </li>
        </ul>-->
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;"><?php echo ($res); ?></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <!--<dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
              <dd><a onclick="x_admin_show('切换帐号','http://www.baidu.com')">切换帐号</a></dd>-->
              <dd><a href="<?php echo U('Index/logout');?>">退出</a></dd>
            </dl>
          </li>
          <!--<li class="layui-nav-item to-index"><a href="<?php echo U('Index/index');?>">前台首页</a></li>-->
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>成员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="<?php echo U('Index/memberList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>成员列表</cite>
                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="/Admin/Index/memberAdd">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加成员</cite>
                        </a>
                    </li >
                    <!--<li>
                        <a _href="member-list1.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表(动态表格)</cite>

                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="member-del.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员删除</cite>

                        </a>
                    </li>-->
                    <!--<li>
                        <a href="javascript:;">
                            <i class="iconfont">&#xe70b;</i>
                            <cite>会员管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a _href="xxx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员列表</cite>

                                </a>
                            </li >
                            <li>
                                <a _href="xx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员删除</cite>

                                </a>
                            </li>
                            <li>
                                <a _href="xx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>等级管理</cite>

                                </a>
                            </li>

                        </ul>
                    </li>-->
                </ul>

            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>精选生活</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="<?php echo U('Business/BusinessList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商家管理</cite>

                        </a>
                    </li >
                </ul>
            <li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>积分管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="<?php echo U('Sort/sortList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>积分列表</cite>
                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="/Admin/Sort/sortAll">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>积分使用记录</cite>
                        </a>
                    </li >
                </ul>
            <li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>运营管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="/Admin/Operation/shopList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商城订单列表</cite>
                        </a>
                    </li >
                    <li date-refresh="2">
                        <a _href="<?php echo U('Sort/sortList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>活动订单列表</cite>
                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="<?php echo U('Sort/sortList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>医疗订单列表</cite>
                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="/Admin/Operation/airportList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>机场订单列表</cite>
                        </a>
                    </li >
                </ul>
            <li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>财务审核列表</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="/Admin/Order/completed?source=商城">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商城审核列表</cite>
                        </a>
                    </li>
                    <li date-refresh="1">
                        <a _href="/Admin/Order/activityCompleted?source=活动">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>活动审核列表</cite>
                        </a>
                    </li>
                    <li date-refresh="1">
                        <a _href="/Admin/Order/doctorCompleted?source=医疗">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>医疗审核列表</cite>
                        </a>
                    </li>
                    <li date-refresh="1">
                        <a _href="/Admin/Order/projectCompleted?source=餐厅">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>餐厅审核列表</cite>
                        </a>
                    </li>
                    <li date-refresh="1">
                        <a _href="/Admin/Order/airportCompleted?source=机场">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>机场审核列表</cite>
                        </a>
                    </li>
                </ul>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>财务订单管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/Admin/Order/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商城订单</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="/Admin/Order/activity">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>活动订单</cite>
                        </a>
                    </li>
                   <li>
                        <a _href="/Admin/Order/doctor">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>医疗订单</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="/Admin/Order/project">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>餐厅订单</cite>
                        </a>
                    </li>
                       <li>
                       <a _href="/Admin/Order/airport">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>机场订单</cite>
                        </a>
                    </li>
                    <!--<li>
                        <a _href="/Admin/Order/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>餐厅订单</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="/Admin/Order/index">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>贷款订单</cite>
                        </a>
                    </li>-->
                </ul>
            </li>
            <!--<li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>规格管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>

            </li>-->
            <!--<li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>房产管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>三级地区联动</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>私享空间</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>三级地区联动</cite>
                        </a>
                    </li >
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>精彩活动</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>三级地区联动</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>精彩活动</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>三级地区联动</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>企业咨询</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>三级地区联动</cite>
                        </a>
                    </li >
                </ul>
            </li>-->
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>商城管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/Admin/Goods/goodsList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/Admin/Goods/add">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品添加</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/Admin/GoodsSpec/class_list">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>规格分类</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/Admin/GoodsSpec/spec_list">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>分类详情</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="<?php echo U('Admin/AdminManage');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="<?php echo U('Admin/adminList');?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员登录记录</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-role.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-cate.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限分类</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-rule.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <!--<li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ce;</i>
                    <cite>系统统计</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="echarts1.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>拆线图</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="echarts2.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>柱状图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts3.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>地图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts4.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>饼图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts5.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>雷达图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts6.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>k线图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts7.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>热力图</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="echarts8.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>仪表图</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b4;</i>
                    <cite>图标字体</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="unicode.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>图标对应字体</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b4;</i>
                    <cite>其它页面</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="login.html" target="_blank">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>登录页面</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="error.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>错误页面</cite>
                        </a>
                    </li>
                </ul>
            </li>-->
        </ul>
    </div>
</div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
          </div>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='./welcome.html' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
          <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <!--<div class="footer">-->
        <!--<div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>  -->
    <!--</div>-->
    <!-- 底部结束 -->
</body>
</html>