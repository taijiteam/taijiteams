<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
<link href="/favicon.ico" rel="shortcut icon">
<meta name="viewport" content="target-densitydpi=device-dpi, width=375px, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>渠道Plus - 商城</title>
<meta name="keywords" content="关键词">
<meta name="description" content="描述">
<link rel="stylesheet" href="/Public/Mobile/css/swiper.min.css" />
<link rel="stylesheet" href="/Public/Mobile/css/common.css?v=<?php echo ($versions); ?>" />
<link rel="stylesheet" href="/Public/Mobile/css/style.css?v=<?php echo ($versions); ?>" />
</head>
<body>

<div  class="screenht">

    <div class="pb_tp_a">
    <h1>收货地址</h1>
    <!--<a href="<?php echo (urldecode($frm)); ?>" class="pbjta"><img src="/Public/Mobile/images/01322.png"></a>-->
</div>

    <div class="shouhads container-fluid" style="margin-bottom: 120px">
        <?php if(empty($address)): ?><!-- 没有地址情况 -->
            <?php else: ?>
            <?php if(is_array($address)): $k = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($vo["is_default"] == 1): ?><div  class="shadlist  shadliston">
                        <div class="fl  shad_a checkbox">
                            <label><input type="radio" checked name="地址选择" value="<?php echo ($vo["id"]); ?>"></label>
                        </div>
                        <div  class="fl shad_b">
                            <h1><?php echo ($vo["consignee"]); ?><span>默认</span></h1>
                            <p><?php echo ($vo["address"]); ?></p>
                        </div>
                        <div class="fr shad_c">
                            <p><?php echo ($vo["mobile"]); ?></p>
                            <a href="/Mobile/Address/edit?id=<?php echo ($vo["id"]); ?>"><img src="/Public/Mobile/images/3315.png"></a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div  class="shadlist ">
                        <div class="fl  shad_a checkbox">
                            <label><input type="radio" name="地址选择" value="<?php echo ($vo["id"]); ?>"></label>
                        </div>
                        <div  class="fl shad_b">
                            <h1><?php echo ($vo["consignee"]); ?><span>默认</span></h1>
                            <p><?php echo ($vo["address"]); ?></p>
                        </div>
                        <div class="fr shad_c">
                            <p><?php echo ($vo["mobile"]); ?></p>
                            <a href="/Mobile/Address/edit?id=<?php echo ($vo["id"]); ?>"><img src="/Public/Mobile/images/3315.png"></a>
                        </div>
                    </div><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>

    <div class="screenft_a" style="position: fixed; z-index:9999;bottom: 30px">
        <a href="/Mobile/Address/add?redirect_url=<?php echo ($frm); ?>"><img src="/Public/Mobile/images/jia.png">&nbsp;&nbsp;添加地址</a>
    </div>
</div>

<script src="/Public/Mobile/js/jquery-1.11.0.min.js"></script>
<script src="/Public/Mobile/js/swiper.min.js"></script>
<script src="/Public/Mobile/js/jquery.SuperSlide.2.1.3.js"></script>
<script src="/Public/Mobile/js/all.js?v=<?php echo ($versions); ?>"></script>
</body>
</html>

<script>
    $(function(){
        var redirect_url = "<?php echo (urldecode($frm )); ?>";

        $('input[type="radio"]').click(function(){
            var address_id = $(this).val();
            $.ajax
            ({
                type:'get',
                url:'/Mobile/Address/set_default',
                data:{
                    address_id:address_id
                },
                dataType:'json',
                success:function (res) {
                    if (res.code == 200)
                    {
                        window.location.href = redirect_url;
                    }else{
                        alert(res.message);
                    }
                }
            });
        });
    });
</script>