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
    <style>
        .input-text{
            padding-left: 10px;
            text-align: left;
            line-height: 28px;
            font-size: 14px;
            color: #fff;
            border: none;
            border-bottom: 1px solid #979797;
            background: #000;
            width: 200px;
        }
    </style>
</head>
<body>

<div class="pb_tp_a">
    <h1>订单支付</h1>
    <!--<a href="javascript:history.go(-1);" class="pbjta"><img src="/Public/Mobile/images/01322.png"></a>-->
</div>

<!-- 地址信息 -->
<?php if(empty($address)): ?><div  class="shadlist  shadliston choose-address-btn" >
            <div  class="fl shad_b">
                <h1>暂无地址</h1>
                <p>请添加地址</p>
            </div>
            <div class="fr shad_c">
                <p></p>
                <a href="/Mobile/Address/choose"><img style="width:auto;margin-top:5px;" src="/Public/Mobile/images/rcopy.png"></a>
            </div>
        </div>
    <?php else: ?>
        <div  class="shadlist  shadliston choose-address-btn" id="choosed-address" data-address-id="<?php echo ($address["id"]); ?>">
            <div  class="fl shad_b">
                <h1><?php echo ($address["consignee"]); ?></h1>
                <p><?php echo ($address["address"]); ?></p>
            </div>
            <div class="fr shad_c">
                <p><?php echo ($address["mobile"]); ?></p>
                <a href="/Mobile/Address/choose"><img style="width:auto;margin-top:5px;" src="/Public/Mobile/images/rcopy.png"></a>
            </div>
        </div><?php endif; ?>



<!--积分 使用-->
<div class="jfuses container-fluid">
    <?php if(($goods['goods_pocket_type'] < 2) AND ($goods['goods_pocket_a'] == 0) AND ($goods['goods_pocket_d'] == 0)): ?><div class="jfuselist container">
            <div class="jfus_a fl">
                <img src="/Public/Mobile/images/6134024.png"><span>促销商品</span>
            </div>
            <div  class="jfus_b fl">
                本商品不可享受积分优惠
            </div>
        </div>
    <?php else: ?>
        <!-- A积分 -->
        <?php if($goods['goods_pocket_a'] > 0): ?><!--<div class="jfuselist container">-->
                <!--<div class="jfus_a fl">-->
                    <!--<img src="/Public/Mobile/images/6134024.png"><span>积分使用</span>-->
                <!--</div>-->
                <!--<div  class="jfus_b fl">-->
                    <!--A积分余额-->
                <!--</div>-->
                <!--<div  class="jfus_c fr" data-user-ajf-max="<?php echo ($member['a_consume_sort']); ?>">-->
                    <!--<?php echo ($member['a_consume_sort']); ?>-->
                <!--</div>-->
            <!--</div>-->
            <div class="jfuselist container">
                <div class="jfus_a fl">
                    <img src="/Public/Mobile/images/6134024.png"><span>消费积分抵扣</span>
                </div>
                <div  class="jfus_e fl">
                    <ul class="btn-numbox" style="margin-left: 10px;display: none;" id="input-jf-1">
                        <li>
                            <ul class="count">
                                <li><span class="num-jian" data-jf-type="ajf" >-</span></li>
                                <li><input type="number" class="input-num"
                                           data-user-max-jf="<?php echo ($member['a_consume_sort']); ?>"
                                           data-goods-max-jf="<?php echo ($goods['goods_pocket_a'] * $num); ?>"
                                           id="input-num-ajf" value="0" /></li>
                                <li><span class="num-jia" data-jf-type="ajf">+</span></li>
                            </ul>
                        </li>
            　　　  </ul>
                </div>
                <div  class="jfus_d fr">
                    <div class="fr   checkbox">
                        <label><input type="radio" name="积分使用" class="use-jf" data-pocket-type="1" ></label>
                    </div>
                </div>
            </div>
            <!--<div class="jfuselist container">-->
                <!--<div class="jfus_a fl">-->
                    <!--<img src="/Public/Mobile/images/6134024.png"><span>优惠政策</span>-->
                <!--</div>-->
                <!--<div class="jfus_b fl">最大可用积分额度</div><div class="jfus_c fr"><?php echo ($goods['goods_pocket_a'] * $num); ?>.00</div>-->
            <!--</div>--><?php endif; ?>
        <!-- D积分-->
        <?php if(($goods['goods_pocket_d'] > 0) && ($can_use_winning_sort > 0)): ?><div class="jfuselist container">
                <div class="jfus_a fl">
                    <img src="/Public/Mobile/images/6134024.png"><span>奖励积分抵扣</span>
                </div>
                <div  class="jfus_e fl">
                    <ul class="btn-numbox" style="margin-left: 10px;display: none;" id="input-jf-4">
                        <li>
                            <ul class="count">
                                <li><span class="num-jian" data-jf-type="djf">-</span></li>
                                <li><input type="number" class="input-num"
                                           data-user-max-jf="<?php echo ($member['a_winning_sort']); ?>"
                                           data-goods-max-jf="<?php echo ($goods['goods_pocket_d'] * $num); ?>"
                                           id="input-num-djf" value="0" /></li>
                                <li><span class="num-jia" data-jf-type="djf">+</span></li>
                            </ul>
                        </li>
            　　　  </ul>
                </div>
                <div  class="jfus_d fr">
                    <div class="fr   checkbox">
                        <label><input type="radio" name="积分使用" class="use-jf" data-pocket-type="4"></label>
                    </div>
                </div>
            </div><?php endif; ?>
        <!-- B1积分-->
        <?php if(($goods['goods_pocket_type'] == 201) AND ($goods['goods_pocket'] > 0 AND ($default_jiu_sort > 0))): ?><div class="jfuselist container">
                <div class="jfus_a fl">
                    <img src="/Public/Mobile/images/6134024.png"><span>尊享积分抵扣</span>
                </div>
                <div  class="jfus_e fl">
                    <ul class="btn-numbox" style="margin-left: 10px;display: none;" id="input-jf-201">
                        <li>
                            <ul class="count">
                                <li>
                                    <span>可使用 <?php echo ($default_jiu_sort); ?> 点</span>
                                    <input type="number" style="display: none" id="input-num-b1jf" value="<?php echo ($default_jiu_sort); ?>" />
                               </li>
                            </ul>
                        </li>
            　　　  </ul>
                </div>
                <div  class="jfus_d fr">
                    <div class="fr   checkbox">
                        <label><input type="radio" name="积分使用" class="use-jf" data-pocket-type="<?php echo ($goods['goods_pocket_type']); ?>"></label>
                    </div>
                </div>
            </div><?php endif; ?>
        <!-- 不使用积分-->
        <div class="jfuselist container">
            <div class="jfus_a fl">
                <img src="/Public/Mobile/images/6134024.png">不使用积分</span>
            </div>
            <div  class="jfus_e fl">
            </div>
            <div  class="jfus_d fr">
                <div class="fr   checkbox">
                    <label><input type="radio" name="积分使用" id="no-use-ajf" checked></label>
                </div>
            </div>
        </div><?php endif; ?>
</div>

<!-- 推荐人 -->
<?php if($member_info['m_groupname'] == '待审核'): ?><div class="jfuses container-fluid" style="margin-top: 14px">
        <div class="jfuselist container">
            <div class="jfus_a fl">
                <span style="margin-left: 20px"><span style="color: red">*</span>推荐人信息:</span>

            </div>
            <div  class="fl">
                <input type="text" class="input-text" id="introduce_member" name="introduce_member" value="" title="推荐人" placeholder="非成员用户需要填写推荐人姓名">
            </div>
        </div>
        <div class="jfuselist container">
            <div class="jfus_a fl">
                <span style="margin-left: 20px">备注:</span>

            </div>
            <div  class="fl">
                <input type="text" class="input-text" id="introduce_remark" name="introduce_remark" value="" title="备注">
            </div>
        </div>
    </div><?php endif; ?>


<!--商品详情-->
<div class="spags_arts container-fluid">
    <div  class="spag_list spag_a ">
        <div class="container">
            <h1>商品详情</h1>
        </div>
    </div>
    <div  class="spag_list spag_b">
        <div class="container" id="goods-info" data-goods-id="<?php echo ($goods['goods_id']); ?>" data-buy-num="<?php echo ($num); ?>">
            <div class="fl  ovh">
                <img src="<?php echo ($goods['main_img']); ?>" style="width:80px;height:auto;">
            </div>
            <div  class="fl spbnr">
                <h1><?php echo ($goods['goods_name']); ?></h1>
                <h2><span class="fl"><img src="/Public/Mobile/images/rw.png"><?php echo ($goods['goods_price']); ?>.00</span> <dbo class="fr">×<?php echo ($num); ?></dbo></h2>
                <p><?php echo ($goods['goods_remark']); ?></p>
            </div>
        </div>
    </div>

    <div class="container-fluid fs_away">
        <div class="spag_list pbsfeng">
            <div class="container">
                <div class="sfe_a fl">
                    支付方式
                </div>
                <div class="sfe_b fr">
                    <a href="javascript:void(0);">微信支付<img src="/Public/Mobile/images/rcopy.png"></a>
                </div>
            </div>
        </div>
        <div class="psfangshi container-fluid">
            <div class="psfslist">
                <label><input type="radio" name="支付方式" checked>微信支付</label>
            </div>
            <!--<div class="psfslist">-->
                <!--<label><input type="radio" name="支付方式">云闪付(其他)</label>-->
            <!--</div>-->
            <!--<div class="psfslist">-->
                <!--<label><input type="radio" name="支付方式">其他</label>-->
            <!--</div>-->
        </div>
    </div>

    <div class="spag_list pbsfeng">
        <div class="container">
            <div class="sfe_a fl">
                配送方式
            </div>
            <div  class="sfe_b fr">
                <a href="#">快递发货<img src="/Public/Mobile/images/rcopy.png" style="opacity: 0"></a>
            </div>
        </div>
    </div>
    <div class="spag_list pbsfeng">
        <div class="container">
            <div class="sfe_a fl">
                发票类型
            </div>
            <div  class="sfe_b fr">
                <a href="#">不开发票<img src="/Public/Mobile/images/rcopy.png" style="opacity: 0"></a>
            </div>
        </div>
    </div>
    <div  class="mjly">
        <div class="container">
            <div class="sfe_a fl">
                买家留言
            </div>
            <div  class="mlys">
                <textarea placeholder="填写内容需与商家协商并确认，45字以内" id="member_remark"></textarea>
            </div>
        </div>
    </div>
</div>

<!--价格结算-->
<div class="shangp_zjs contianer-fluid">
    <div class="sppcall container">
        <div  class="spcelist spcelistaa">
            <span class="fl">商品总价</span>
            <span class="fr"><dbo>¥</dbo><?php echo ($goods['goods_price'] * $num); ?>.00</span>
        </div>
        <!--<div  class="spcelist">-->
            <!--<span class="fl">活动</span>-->
            <!--<span class="fr">+<dbo>¥</dbo>0.00</span>-->
        <!--</div>-->
        <!--<div  class="spcelist">-->
            <!--<span class="fl">活动优惠</span>-->
            <!--<span class="fr">-<dbo>¥</dbo>40.00</span>-->
        <!--</div>-->
        <div  class="spcelist">
            <span class="fl">积分抵扣</span>
            <span class="fr">-<dbo>¥</dbo><span id="user-use-jf">0</span>.00</span>
        </div>
    </div>
</div>

<!--去支付-->
<div class="qzhbt container-fluid">
    <div class="qz_lt fl">
        <span>合计<dbo>¥</dbo><b id="need-to-pay"></b>.00</span>
    </div>
    <div class="qz_rt  fr">
        <a href="javascript:;" id="create-order-btn">去支付</a>
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

        /************ 积分优惠 **********************************************/
        var goods_price = "<?php echo ($goods['goods_price']); ?>";
        var num         = "<?php echo ($num); ?>";

        init();

        function init(){
            need_to_pay(0,false);
        }


        //减积分 500
        $(document).on("click",".num-jian",function (m) {
            var jf_type = $(this).attr("data-jf-type");
            var obj     = $("#input-num-"+jf_type);
            var user_use_jf = parseInt(obj.val()) - 500;
            user_use_jf = user_use_jf <= 0 ? 0: user_use_jf;
            obj.val(user_use_jf);
            obj.change();
            need_to_pay(user_use_jf,jf_type);
        });
        //加积分 500
        $(document).on("click",".num-jia",function (m) {
            var jf_type = $(this).attr("data-jf-type");
            var obj = $("#input-num-"+jf_type);
            var  user_use_jf = parseInt(obj.val()) + 500;
            var goods_max_jf = parseInt(obj.attr("data-goods-max-jf"));
            var  user_max_jf = parseInt(obj.attr("data-user-max-jf"));

            user_use_jf = user_use_jf >= goods_max_jf ? goods_max_jf : user_use_jf;
            user_use_jf = user_use_jf >= user_max_jf ?  user_max_jf  : user_use_jf;

            obj.val(user_use_jf);
            obj.change();
            need_to_pay(user_use_jf,jf_type);
        });
        //不使用积分
        $(document).on("click","#no-use-ajf",function () {
            $(".btn-numbox").hide();
            need_to_pay(0,false);
        });
        //使用积分
        $(document).on("click",".use-jf",function () {
            $(".btn-numbox").hide();
            var t = $(this).attr("data-pocket-type");
            console.log(t);
            if(t == '1'){
                var input_ajf = $("#input-num-ajf");
                var user_max_ajf = parseInt(input_ajf.attr("data-user-max-jf"));
                var goods_max_ajf = parseInt(input_ajf.attr("data-goods-max-jf"));
                var v = user_max_ajf > goods_max_ajf ? goods_max_ajf : user_max_ajf;
                var k = 'ajf';
                input_ajf.val(v);
                $("#input-jf-"+t).show(); //显示输入框
            }else if(t == '201'){
                var input_b1jf = $("#input-num-b1jf");
                var v = input_b1jf.val();
                var k = 'b1jf';
                $("#input-jf-"+t).show(); //显示优惠金额
            }else if(t == '4'){
                var input_djf = $("#input-num-djf");
                var user_max_djf = parseInt(input_djf.attr("data-user-max-jf"));
                var goods_max_djf = parseInt(input_djf.attr("data-goods-max-jf"));
                var v = user_max_djf > goods_max_djf ? goods_max_djf : user_max_djf;
                input_djf.val(v);
                var k = 'djf';
                $("#input-jf-"+t).show(); //显示优惠金额
            }
            else{
                return false;
            }

            need_to_pay(v,k);
        });
        //监听键盘输入积分值
        $(document).on("input propertychange",".input-num",function(){
            var input_point = parseInt($(this).val());
            if(isNaN(input_point)){
                input_point = 0;
            }
            console.log(input_point);
            var goods_max_jf = parseInt($(this).attr("data-goods-max-jf"));
            var  user_max_jf = parseInt($(this).attr("data-user-max-jf"));

            input_point = input_point >= goods_max_jf ? goods_max_jf : input_point;
            input_point = input_point >= user_max_jf ?  user_max_jf  : input_point;

            need_to_pay(input_point,false);
            $(this).val(input_point);
        });

        //计算显示的价格
        function need_to_pay(user_use_jf,jf_type)
        {
            var total_price = parseInt(goods_price * num);
            var need_pay = parseInt(total_price - user_use_jf);

            if(need_pay <= 0){
                need_pay = 0;
                user_use_jf = total_price;
            }

            if(jf_type){
                $("#input-num-"+jf_type).val(user_use_jf);
            }else{
                $(".input-num").val(0);
            }

            $("#user-use-jf").html(user_use_jf);
            $('#need-to-pay').html(need_pay);
        }

        /************ 地址选择 **********************************************/
        $(document).on("click",".choose-address-btn",function () {
            window.location.href = "/Mobile/Address/choose";
        });



        /************ 下单结算 **********************************************/
        $(document).on("click","#create-order-btn",function () {
            var goods_info = $("#goods-info");
            var address_id = $("#choosed-address").attr("data-address-id");
            var member_remark = $("#member_remark").text();

            var pocket_type = get_pocket_type();
            var pocket_val = get_pocket(pocket_type);
            console.log('type:'+pocket_type,'val:'+pocket_val);

            var introduce_member = $('#introduce_member').val();
            var introduce_remark = $('#introduce_remark').val();

            $.ajax({
                type:'get',
                url:'/Mobile/Order/create_order',
                data:{
                    goods_id:goods_info.attr("data-goods-id"),
                    num:goods_info.attr("data-buy-num"),
                    address_id:address_id,
                    member_remark:member_remark,
                    poctet_type:pocket_type,
                    pocket_val:pocket_val,
                    introduce_member:introduce_member,
                    introduce_remark:introduce_remark
                },
                dataType:'json',
                success:function (res) {
                    if (res.code == 200)
                    {
                        // alert("下单成功,准备唤起支付...");
                        handlePayInfo(res.data.order_sn);
                    }else{
                        alert(res.message);
                        window.location.reload();
                    }
                },
                error:function(data){
                    console.log(data.message)
                }
            })
            return false;
        });


        function get_pocket_type() {
            if($(".use-jf").is(":checked")){
                return $(".use-jf:checked").attr("data-pocket-type");
            }else{
                return 0;
            }
        }

        function get_pocket(pock_type) {
            switch (pock_type)
            {
                case "1"://A积分 消费积分
                    return $("#input-num-ajf").val();
                case "201"://b1酒积分 尊享积分
                    return $("#input-num-b1jf").val();
                case "4"://D积分 奖励积分
                    return $("#input-num-djf").val();
                default:
                    return 0;
            }
        }


        /********** 微信支付  **************************/
        function handlePayInfo(order_sn) {
            $.ajax({
                type:'get',
                url:'/Mobile/Order/payInfo',
                data:{
                    order_sn:order_sn
                },
                dataType:'json',
                success:function (res) {
                    if (res.code == 200)
                    {
                        var data = res.data;
                        var success_url = "/Mobile/Order/order_detail?order_sn="+order_sn;
                        if(data.need_pay)
                        {
                            callWxpay(data.param,success_url);
                        }else{
                            window.location.href = success_url;
                        }
                    }
                    else
                    {
                        alert(res.msg);
                    }
                }
            });
            return false;
        }

        function callWxpay(param,success_url) {
            if(isWeixin())
            {
                // alert('恭喜您提交成功\n'+'温馨提示：\n'+'因微信交易限额\n'+'推荐使用对公转账方式支付\n'+'公司名:上海渠道商务咨询有限公司\n'+'账号：32494708010140751\n'+'开户行：农商银行康桥支行\n'+'转账成功后三个工作日内，\n'+'会开放正式会员权益及功能\n'+'如有疑问或无法对公转账，\n'+'可以联系客户经理\n'+'或拨打客服热线：\n'+'021-53829777。');die;
                if (typeof WeixinJSBridge == "undefined"){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    }else if (document.attachEvent){
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                }else{
                    jsApiCall(param,success_url);
                }
            }else{
                alert("请在微信浏览器中支付");
            }
        }

        function jsApiCall(param,success_url) {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                {
                    "appId": param.appId,     //公众号名称，由商户传入
                    "timeStamp": param.timeStamp,         //时间戳，自1970年以来的秒数
                    "nonceStr": param.nonceStr, //随机串
                    "package": param.package,
                    "signType": param.signType,         //微信签名方式：
                    "paySign": param.paySign //微信签名
                },
                function(res){
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        alert("支付成功");
                        window.location.href = success_url;
                    }else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                        alert("已取消微信支付!");
                    } else {
                        alert("系统繁忙稍后再试……");
                    };
                }
            );
        }

        function isWeixin() {
            var ua = window.navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == 'micromessenger') {
                return true;
            } else {
                return false;
            }
        }

        /********** 微信支付  **************************/
    })
</script>