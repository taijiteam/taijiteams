<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/12
 * Time: 9:45 AM
 */
namespace Common\Service\Pay;
require (APP_PATH.'./Common/Service/Pay/IPay.class.php');
require (APP_PATH.'../ThinkPHP/Library/Vendor/payAPI/lib/WxPay.Data.php');
require (APP_PATH.'../ThinkPHP/Library/Vendor/payAPI/lib/WxPay.Api.php');

use Think\Log;
use WxPayApi;
use WxPayJsApiPay;
use WxPayException;
use WxPayUnifiedOrder;

class JsApiPayService implements Ipay
{
    //微信回调用地址
    const NOTIFY_URL  = MOBILE_SITE_URL . "/Mobile/notify/index";

    private $openid;

    public function __construct($openid)
    {
        $this->openid = $openid;
    }

    /**
     * @param $pay_sn   支付订单号  下单时生成
     * @param $fee      支付的费用 单位元
     * @param $body     商品名称
     * @return string
     * @throws \WxPayException
     */
    public function gen_pay($pay_sn,$fee,$body)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($pay_sn);
        $input->SetOut_trade_no($pay_sn);
//        $input->SetTotal_fee();  //测试使用 无论什么商品都只支付1分
        $input->SetTotal_fee(intval($fee*100));//正式价格

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));

        $input->SetNotify_url(self::NOTIFY_URL);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($this->openid);
        $order = WxPayApi::unifiedOrder($input);

        Log::write("微信支付：".json_encode($order,JSON_UNESCAPED_UNICODE),"DEBUG",'File',APP_PATH.'../log/wxJsApi.log');
        if(!array_key_exists("appid", $order) || !array_key_exists("prepay_id", $order) || $order['prepay_id'] == "")
        {
            throw new WxPayException("参数错误");
        }

        // GetJsApiParameters
        $jsapi = new WxPayJsApiPay();
        $jsapi->SetAppid($order["appid"]);
        $jsapi->SetTimeStamp(strval(time()));
        $jsapi->SetNonceStr(WxPayApi::getNonceStr());
        $jsapi->SetPackage("prepay_id=" . $order['prepay_id']);
        $jsapi->SetSignType("MD5");
        $jsapi->SetPaySign($jsapi->MakeSign());
        $params = $jsapi->GetValues();
        Log::write("微信支付param：".json_encode($params,JSON_UNESCAPED_UNICODE),"DEBUG",'File',APP_PATH.'../log/wxJsApi.log');

        return $params;
    }
}