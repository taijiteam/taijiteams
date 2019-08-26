<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/13
 * Time: 1:55 PM
 */

namespace Common\Service\Pay;

require_once (APP_PATH.'../ThinkPHP/Library/Vendor/payAPI/lib/WxPay.Notify.php');
require_once (APP_PATH.'../ThinkPHP/Library/Vendor/payAPI/lib/WxPay.Api.php');
require_once (APP_PATH.'../ThinkPHP/Library/Vendor/payAPI/lib/WxPay.Notify.php');

use WxPayNotify;
use Think\Log;
use Common\Logic\OrderLogic;
class WxPayNotifyService extends WxPayNotify
{
    //重写回调处理函数
    /**
     * @param WxPayNotifyResults $data 回调解释出的参数
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($data,&$msg)
    {
        if(!array_key_exists("return_code", $data) ||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            Log::write("错误的微信回调：异常".json_encode($data,JSON_UNESCAPED_UNICODE),"ERROR",'File',APP_PATH.'../log/WxNotify.log');
            $msg = "异常异常";
            return false;
        }
        if(!array_key_exists("transaction_id", $data)){
            Log::write("错误的微信回调：输入参数不正确".json_encode($data,JSON_UNESCAPED_UNICODE),"ERROR",'File',APP_PATH.'../log/WxNotify.log');
            $msg = "输入参数不正确";
            return false;
        }

        $pay_sn = $data['out_trade_no'];
        $success  = OrderLogic::instance($pay_sn,"pay_sn")->pay_success();
        if(!$success){
            Log::write("call back：".json_encode($data,JSON_UNESCAPED_UNICODE),"ERROR",'File',APP_PATH.'../log/WxNotify.log');
            return false;
        }
        return true;
    }
}