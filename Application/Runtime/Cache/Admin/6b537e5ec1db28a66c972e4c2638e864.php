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
            <label for="num" class="layui-form-label"><span class="x-red">*</span>会员卡号</label>
            <div class="layui-input-inline">
                <input type="text" id="num" value="<?php echo ($res['m_num']); ?>" disabled name="num" required="" lay-verify="required"autocomplete="off" class="layui-input">
            </div>
        </div>
        <!--<div class="layui-form-item">
            <label for="groupname" class="layui-form-label"><span class="x-red">*</span>会员级别</label>
            <div class="layui-input-inline">
                <input type="text"id="groupname" name="groupname" value="<?php echo ($res['m_groupname']); ?>" required="" lay-verify="required"autocomplete="off" class="layui-input">
            </div>
        </div>-->
        <div class="layui-form-item">
            <label for="groupname" class="layui-form-label"><span class="x-red">*</span>会员级别</label>
            <div class="layui-input-inline">
                <!--<input type="text" id="m_groupname" name="m_groupname" required="" lay-verify="nikename"autocomplete="off" class="layui-input">-->
                <select id="groupname" name="groupname" autocomplete="off" class="layui-input">
                    <?php switch($res["m_groupname"]): case "尊享大咖": ?><option selected value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "高级顾问": ?><option value="尊享大咖">尊享大咖</option>
                            <option selected value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "君享成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option selected value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "真享成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option selected value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "悦享成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option selected value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "致享成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option selected value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "亦享成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option selected value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "临时成员": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option selected value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "待审核": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option selected value="待审核">待审核</option>
                            <option value="内部测试">内部测试</option><?php break;?>
                        <?php case "内部测试": ?><option value="尊享大咖">尊享大咖</option>
                            <option value="高级顾问">高级顾问</option>
                            <option value="君享成员">君享成员</option>
                            <option value="真享成员">真享成员</option>
                            <option value="悦享成员">悦享成员</option>
                            <option value="致享成员">致享成员</option>
                            <option value="亦享成员">亦享成员</option>
                            <option value="临时成员">临时成员</option>
                            <option value="待审核">待审核</option>
                            <option selected value="内部测试">内部测试</option><?php break;?>
                        <?php default: endswitch;?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="category" class="layui-form-label"><span class="x-red">*</span>会员类别</label>
            <div class="layui-input-inline">
                <select id="category" name="category" autocomplete="off" class="layui-input">
                    <?php switch($res["m_groupname"]): case "商政名流": ?><option selected value="商政名流">商政名流</option>
                            <option value="企业精英">企业精英</option>
                            <option value="文艺雅仕">文艺雅仕</option>
                            <option value="名医专家">名医专家</option><?php break;?>
                        <?php case "企业精英": ?><option value="商政名流">商政名流</option>
                            <option selected value="企业精英">企业精英</option>
                            <option value="文艺雅仕">文艺雅仕</option>
                            <option value="名医专家">名医专家</option><?php break;?>
                        <?php case "文艺雅仕": ?><option value="商政名流">商政名流</option>
                            <option value="企业精英">企业精英</option>
                            <option selected value="文艺雅仕">文艺雅仕</option>
                            <option value="名医专家">名医专家</option><?php break;?>
                        <?php case "名医专家": ?><option value="商政名流">商政名流</option>
                            <option value="企业精英">企业精英</option>
                            <option value="文艺雅仕">文艺雅仕</option>
                            <option selected value="名医专家">名医专家</option><?php break;?>
                        <?php default: endswitch;?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="photo" class="layui-form-label">照片</label>
            <div class="layui-input-inline">
                <!--<input type="file" id="m_img" name="m_img" autocomplete="off" class="layui-input">-->

                <button type="button" class="layui-btn" id="test1">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
                <div id="photo"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="cname" class="layui-form-label"><span class="x-red">*</span>姓名</label>
            <div class="layui-input-inline">
                <input type="text" id="cname" name="cname" value="<?php echo ($res['m_cname']); ?>" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="sex" class="layui-form-label"><span class="x-red">*</span>性别</label>
            <div class="layui-input-inline">
                <input type="text" id="sex" name="sex" value="<?php echo ($res['m_sex']); ?>" required="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label"><span class="x-red">*</span>手机</label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" value="<?php echo ($res['m_phone']); ?>" required="" lay-verify="phone"autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="birthday" class="layui-form-label">生日</label>
            <div class="layui-input-inline">
                <input type="text" id="birthday" name="birthday" value="<?php echo ($res['m_birthday']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="constellation" class="layui-form-label">星座</label>
            <div class="layui-input-inline">
                <input type="text" id="constellation" name="constellation" value="<?php echo ($res['m_constellation']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="zodiac" class="layui-form-label">属相</label>
            <div class="layui-input-inline">
                <input type="text" id="zodiac" name="zodiac" value="<?php echo ($res['m_zodiac']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="email" class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" id="email" name="email" value="<?php echo ($res['m_email']); ?>" autocomplete="off" class="layui-input">
            </div>
            <!--<div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>将会成为您唯一的登入名</div>-->
        </div>
        <div class="layui-form-item">
            <label for="workunits" class="layui-form-label">单位 职务</label>
            <div class="layui-input-inline">
                <input type="text" id="workunits" name="workunits" value="<?php echo ($res['m_workunits']); ?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>泰基企业 董事长,泰基企业 总经理</div>
        </div>
        <div class="layui-form-item">
            <label for="school" class="layui-form-label">毕业院校</label>
            <div class="layui-input-inline">
                <input type="text" id="school" name="school" value="<?php echo ($res['m_school']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="socialposition" class="layui-form-label">社会职务</label>
            <div class="layui-input-inline">
                <input type="text" id="socialposition" name="socialposition" value="<?php echo ($res['m_socialposition']); ?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>泰基企业 董事长,泰基企业 总经理</div>
        </div>
        <div class="layui-form-item">
            <label for="industry" class="layui-form-label">从事行业</label>
            <div class="layui-input-inline">
                <input type="text" id="industry" name="industry" value="<?php echo ($res['m_industry']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="pamanager" class="layui-form-label">服务经理</label>
            <div class="layui-input-inline">
                <input type="text" id="pamanager" name="pamanager" value="<?php echo ($res['m_pamanager']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="address" class="layui-form-label">联系地址</label>
            <div class="layui-input-inline">
                <input type="text" id="address" name="address" value="<?php echo ($res['m_address']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="works" class="layui-form-label">工作类</label>
            <div class="layui-input-inline">
                <input type="text" id="works" name="works" value="<?php echo ($res['m_works']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="integrals" class="layui-form-label">可用积分</label>
            <div class="layui-input-inline">
                <input type="text" id="integrals" name="integrals" value="<?php echo ($res['m_integrals']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="socials" class="layui-form-label">社交类</label>
            <div class="layui-input-inline">
                <input type="text" id="socials" name="socials" value="<?php echo ($res['m_socials']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="lifes" class="layui-form-label">生活类</label>
            <div class="layui-input-inline">
                <input type="text" id="lifes" name="lifes" value="<?php echo ($res['m_lifes']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="arts" class="layui-form-label">艺术类</label>
            <div class="layui-input-inline">
                <input type="text" id="arts" name="arts" value="<?php echo ($res['m_arts']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="starte" class="layui-form-label">展示状态</label>
            <div class="layui-input-inline">
                <input type="text" id="starte" name="starte" value="<?php echo ($res['m_starte']); ?>" autocomplete="off" class="layui-input">
            </div> <div class="layui-form-mid layui-word-aux"><span class="x-red">*</span>0:展示，1:禁用</div>
        </div>
        <div class="layui-form-item">
            <label for="indate" class="layui-form-label"><span class="x-red">*</span>有效期</label>
            <div class="layui-input-inline">
                <input class="layui-input"  autocomplete="off" value="<?php echo ($res['m_indate']); ?>" placeholder="请输入" name="indate" id="indate">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="time" class="layui-form-label"><span class="x-red">*</span>登记时间</label>
            <div class="layui-input-inline">
                <input class="layui-input"  autocomplete="off" value="<?php echo ($res['m_time']); ?>" placeholder="请输入" name="time" id="time">
                <!--<input type="time" id="m_time" name="m_time" autocomplete="off" class="layui-input">-->
            </div>
        </div>
        <div class="layui-form-item">
            <label for="referrername" class="layui-form-label">推荐人姓名</label>
            <div class="layui-input-inline">
                <input type="text" id="referrername" name="referrername" value="<?php echo ($res['m_referrername']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="doctors" class="layui-form-label">名医预约</label>
            <div class="layui-input-inline">
                <input type="text" id="doctors" name="doctors" value="<?php echo ($res['m_doctors']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="finance" class="layui-form-label">金融支持</label>
            <div class="layui-input-inline">
                <input type="text" id="finance" name="finance" value="<?php echo ($res['m_finance']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="magazine" class="layui-form-label">杂志专访</label>
            <div class="layui-input-inline">
                <input type="text" id="magazine" name="magazine" value="<?php echo ($res['m_magazine']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="wechattext" class="layui-form-label">推广服务</label>
            <div class="layui-input-inline">
                <input type="text" id="wechattext" name="wechattext" value="<?php echo ($res['m_wechattext']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="business" class="layui-form-label">经营范围</label>
            <div class="layui-input-inline">
                <input type="text" id="business" name="business" value="<?php echo ($res['m_business']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="brands" class="layui-form-label">品牌</label>
            <div class="layui-input-inline">
                <input type="text" id="brands" name="brands" value="<?php echo ($res['m_brands']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="wechatid" class="layui-form-label">微信号</label>
            <div class="layui-input-inline">
                <input type="text" id="wechatid" name="wechatid" value="<?php echo ($res['m_wechatid']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="storefront" class="layui-form-label">登记店面</label>
            <div class="layui-input-inline">
                <input type="text" id="storefront" name="storefront" value="<?php echo ($res['m_storefront']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="opened_people" class="layui-form-label">开卡人</label>
            <div class="layui-input-inline">
                <input type="text" id="opened_people" name="opened_people" value="<?php echo ($res['m_opened_people']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="cameras" class="layui-form-label">摄像</label>
            <div class="layui-input-inline">
                <input type="text" id="cameras" name="cameras" value="<?php echo ($res['m_cameras']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="wechatshow" class="layui-form-label">微信朋友圈展示</label>
            <div class="layui-input-inline">
                <input type="text" id="wechatshow" name="wechatshow" value="<?php echo ($res['m_wechatshow']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="actname" class="layui-form-label">精彩活动展示</label>
            <div class="layui-input-inline">
                <input type="text" id="actname" name="actname" value="<?php echo ($res['m_actname']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="tcspwdl" class="layui-form-label">天朝上品代理</label>
            <div class="layui-input-inline">
                <input type="text" id="tcspwdl" name="tcspwdl" value="<?php echo ($res['m_tcspwdl']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="goodat" class="layui-form-label">个人擅长</label>
            <div class="layui-input-inline">
                <input type="text" id="goodat" name="goodat" value="<?php echo ($res['m_goodat']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="brandstrat" class="layui-form-label">铭牌状态</label>
            <div class="layui-input-inline">
                <input type="text" id="brandstrat" name="brandstrat" value="<?php echo ($res['m_brandstrat']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="memberships" class="layui-form-label">会籍服务人</label>
            <div class="layui-input-inline">
                <input type="text" id="memberships" name="memberships" value="<?php echo ($res['m_memberships']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="recby" class="layui-form-label">推荐机构</label>
            <div class="layui-input-inline">
                <input type="text" id="recby" name="recby" value="<?php echo ($res['m_recby']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="degree" class="layui-form-label">最高学历</label>
            <div class="layui-input-inline">
                <input type="text" id="degree" name="degree" value="<?php echo ($res['m_degree']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="major" class="layui-form-label">专业</label>
            <div class="layui-input-inline">
                <input type="text" id="major" name="major" value="<?php echo ($res['m_major']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="bcardid" class="layui-form-label">名片</label>
            <div class="layui-input-inline">
                <input type="text" id="bcardid" name="bcardid" value="<?php echo ($res['m_bcardid']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="gifthand" class="layui-form-label">伴手礼</label>
            <div class="layui-input-inline">
                <input type="text" id="gifthand" name="gifthand" value="<?php echo ($res['m_gifthand']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="infop" class="layui-form-label">个人资料提供者</label>
            <div class="layui-input-inline">
                <input type="text" id="infop" name="infop" value="<?php echo ($res['m_infop']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="intactbest" class="layui-form-label">喜爱活动偏好</label>
            <div class="layui-input-inline">
                <input type="text" id="intactbest" name="intactbest" value="<?php echo ($res['m_intactbest']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>




        <div class="layui-form-item">
            <label for="zipaddress" class="layui-form-label">杂志寄送地址</label>
            <div class="layui-input-inline">
                <input type="text" id="zipaddress" name="zipaddress" value="<?php echo ($res['m_zipaddress']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="services" class="layui-form-label">其他服务</label>
            <div class="layui-input-inline">
                <input type="text" id="services" name="services" value="<?php echo ($res['m_services']); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="tablemer" class="layui-form-label">会员信息表</label>
            <div class="layui-input-inline">
                <input type="text" id="tablemer" name="tablemer" value="<?php echo ($res['m_tablemer']); ?>" autocomplete="off" class="layui-input">
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
            <label class="layui-form-label">个人介绍</label>
        </div>
        <div class="text">
            <script id="editor" type="text/plain"  style="width:90%;height:350px;margin: auto;"></script>
        </div>
                    
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <input type="button" class="layui-btn"  lay-filter="add" lay-submit="" value="增加">
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
                        elem: '#test1' //绑定元素
                        ,url: "<?php echo U('Index/memberPhoto');?>" //上传接口
                        ,done: function(data){
                            //上传完毕回调
                            layer.msg(''+data.msg+'',function(){
                                var html ='';
                                html += '<img src="/Public/Uploads/Member/'+data.photo+'" height="200px" /><input type="hidden"id="photo" name="photo" value='+data.photo+'>';
                                $('#photo').html(html);
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
                        }

                    });

                    //监听提交
                    form.on('submit(add)', function(data){
                        //alert(JSON.stringify(data));
                        //发异步，把数据提交给php
                        var num  = $('input[name="num"]').val();				//会员卡号
                        var groupname  = $("#groupname option:checked").val();		//会员级别
                        var category  = $('input[name="category"]').val();			//会员类别
                        var photo  = $('input[name="photo"]').val();			//照片
                        var cname  = $('input[name="cname"]').val();			//姓名
                        var sex  = $('input[name="sex"]').val();			//性别
                        //var sex  = $("#sex option:checked").val();				//性别
                        var phone  = $('input[name="phone"]').val();			//手机
                        var birthday  = $('input[name="birthday"]').val();		//生日
                        var constellation  = $('input[name="constellation"]').val();	//星座
                        var zodiac  = $('input[name="zodiac"]').val();			//属相
                        var email  = $('input[name="email"]').val();			//邮箱
                        var workunits  = $('input[name="workunits"]').val();		//单位 职务
                        var school  = $('input[name="school"]').val();			//毕业院校
                        var socialposition  = $('input[name="socialposition"]').val();	//社会职务
                        var industry  = $('input[name="industry"]').val();		//从事行业
                        var pamanager  = $('input[name="pamanager"]').val();		//服务经理
                        var address  = $('input[name="address"]').val();			//联系地址
                        var works  = $('input[name="works"]').val();			//工作类
                        var integrals  = $('input[name="integrals"]').val();			//工作类
                        var socials  = $('input[name="socials"]').val();			//社交类
                        var lifes  = $('input[name="lifes"]').val();			//生活类
                        var arts  = $('input[name="arts"]').val();			//艺术类
                        //var starte  = $("#starte option:checked").val();				//展示状态
                        var starte  = $('input[name="starte"]').val();			//展示状态
                        var indate  = $('input[name="indate"]').val();			//有效期
                        var time  = $('input[name="time"]').val();			//登记时间
                        var referrername  = $('input[name="referrername"]').val();	//推荐人姓名
                        var doctors  = $('input[name="doctors"]').val();			//名医预约
                        var finance  = $('input[name="finance"]').val();			//金融支持
                        var magazine  = $('input[name="magazine"]').val();		//杂志专访
                        var wechattext  = $('input[name="wechattext"]').val();		//推广服务
                        var business  = $('input[name="business"]').val();		//经营范围
                        var brands  = $('input[name="brands"]').val();			//品牌
                        var wechatid  = $('input[name="wechatid"]').val();		//微信号

                        var storefront  = $('input[name="storefront"]').val();		//登记店面
                        var opened_people  = $('input[name="opened_people"]').val();		//开卡人
                        var cameras  = $('input[name="cameras"]').val();		//摄像
                        var wechatshow  = $('input[name="wechatshow"]').val();		//微信朋友圈展示
                        var actname  = $('input[name="actname"]').val();		//精彩活动展示
                        var tcspwdl  = $('input[name="tcspwdl"]').val();		//天朝上品代理
                        var goodat  = $('input[name="goodat"]').val();		//个人擅长
                        var brandstrat  = $('input[name="brandstrat"]').val();		//名牌状态
                        var memberships  = $('input[name="memberships"]').val();		//会籍服务人
                        var recby  = $('input[name="recby"]').val();		//推荐机构
                        var degree  = $('input[name="degree"]').val();		//最高学历
                        var major  = $('input[name="major"]').val();		//专业
                        var bcardid  = $('input[name="bcardid"]').val();		//名片
                        var gifthand  = $('input[name="gifthand"]').val();		//伴手礼
                        var infop  = $('input[name="infop"]').val();		//个人资料提供者
                        var intactbest  = $('input[name="intactbest"]').val();		//喜爱活动偏好


                        var zipaddress  = $('input[name="zipaddress"]').val();		//杂志寄送地址
                        var tablemer  = $('input[name="tablemer"]').val();		//会员信息表
                        var services  = $('input[name="services"]').val();		//其他服务
                        var introduce = [];
                        introduce.push(UE.getEditor('editor').getContent());//个人介绍
                        //接收
                        // alert(JSON.stringify(introduce));
                        // return false;
                        $.ajax({
                            type:"post",
                            url:"<?php echo U('Index/memberChange');?>",//根据自己项目的需要写请求地址
                            data:{
                                'num':num,
                                'groupname':groupname,
                                'category':category,
                                'photo':photo,
                                'cname':cname,
                                'sex':sex,
                                'phone':phone,
                                'birthday':birthday,
                                'constellation':constellation,
                                'zodiac':zodiac,
                                'email':email,
                                'workunits':workunits,
                                'school':school,
                                'socialposition':socialposition,
                                'industry':industry,
                                'pamanager':pamanager,
                                'address':address,
                                'works':works,
                                'integrals':integrals,
                                'socials':socials,
                                'lifes':lifes,
                                'arts':arts,
                                'starte':starte,
                                'indate':indate,
                                'time':time,

                                'referrername':referrername,
                                'storefront':storefront,
                                'opened_people':opened_people,
                                'cameras':cameras,
                                'wechatshow':wechatshow,
                                'actname':actname,
                                'tcspwdl':tcspwdl,
                                'goodat':goodat,
                                'brandstrat':brandstrat,
                                'memberships':memberships,
                                'recby':recby,
                                'degree':degree,
                                'major':major,
                                'bcardid':bcardid,
                                'gifthand':gifthand,
                                'infop':infop,
                                'intactbest':intactbest,

                                'doctors':doctors,
                                'finance':finance,
                                'magazine':magazine,
                                'wechattext':wechattext,
                                'business':business,
                                'brands':brands,
                                'wechatid':wechatid,
                                'zipaddress':zipaddress,
                                'tablemer':tablemer,
                                'services':services,
                                'introduce':introduce,
                            },
                            dataType:'json',
                            success:function(data){
                                // alert(JSON.stringify(data));
                                if (data.error == 1){
                                    layer.confirm('信息更改成功！',function(index){
                                        // 可以对窗口进行刷新
                                        alert('信息提交成功！');
                                        window.location.reload()
                                    });
                                }else{
                                    layer.msg('哎呦，运气不好哦，更新失败咯！',function(){});
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