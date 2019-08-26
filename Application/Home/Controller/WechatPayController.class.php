<?php
namespace Home\Controller;
use Think\Controller;
class WechatPayController extends Controller {

    public function _initialize()
    {
      header("Content-Type:text/html; charset=utf-8");
      Vendor('payAPI.JSAPI');
    }
    //成员卡购买
    public function index(){

      $tools = new \JsApiPay();
      $openid = $tools->GetOpenid();

      if ($_REQUEST['groupName']=='4') {
        $groupName = '亦享成员';
        $cardPrice = '2999';
      }elseif ($_REQUEST['groupName']=='3') {
        $groupName = '致享成员';
        $cardPrice = '9999';
      }elseif ($_REQUEST['groupName']=='0') {
        $groupName = '悦享成员';
        $cardPrice = '29999';
      }elseif ($_REQUEST['groupName']=='1') {
        $groupName = '真享成员';
        $cardPrice = '99999';
      }elseif ($_REQUEST['groupName']=='2') {
        $groupName = '君享成员';
        $cardPrice = '199999';
      }elseif ($_REQUEST['groupName']=='oo') {
        $groupName = '尊享大咖';
        $cardPrice = '0.01';
      }else {
        echo "<script>alert('服务器繁忙稍后重试')</script>";
        die();
      }

      if ($_REQUEST['guid']) {
        $guid = $_REQUEST['guid'];
      }else {
        echo "<script>alert('服务器繁忙稍后重试')</script>";
        die();
      }
      if ($_REQUEST['id']) {
        $id = $_REQUEST['id'];
      }else {
        echo "<script>alert('服务器繁忙稍后重试')</script>";
        die();
      }


      $Out_trade_no=date('YHis').rand(100,1000);
      $Total_fee='成员卡升级';
      $Body=$groupName.'卡';
      $Total_fee=$cardPrice;      //支付价格传值
      $input = new \WxPayUnifiedOrder();
      $input->SetBody($Body);
      $input->SetAttach($Body);
      $input->SetOut_trade_no($Out_trade_no);
      $input->SetTotal_fee($Total_fee*100);
      $input->SetTime_start(date("YmdHis"));
      $input->SetTime_expire(date("YmdHis", time() + 600));
      $input->SetGoods_tag($Body);
      $input->SetNotify_url("http://www.qudaoplus.cn/");
      $input->SetTrade_type("JSAPI");
      $input->SetOpenid($openid);
      $order = \WxPayApi::unifiedOrder($input);
      $this->jsApiParameters = $tools->GetJsApiParameters($order);
      $this->assign('openid',$openid);
      $this->assign('guid',$guid);
      $this->assign('groupName',$groupName);
      $this->assign('id',$id);
      $this->assign('cardPrice',$cardPrice);
      $this->display();
    }

    public function getOrder(){

      if ( IS_POST ) {
        // $tradeId = '20180128000905864017';
        $tradeId = $_REQUEST["trade"];

        $input = new \WxPayOrderQuery();
        $input->SetOut_trade_no($tradeId); // 设置好要查询的订单
        $order = \WxPayApi::orderQuery($input); // 进行查询

        $openid = $order['openid'];
        $dtime = strtotime($order['time_end']);

        if($order['err_code_des'] =="order not exist"){
          $re['code'] = "1";
          $re['message'] = "输入的订单号错误";
          echo json_encode( $re , JSON_UNESCAPED_UNICODE);
          die;
        }else{
          if($order['trade_state'] =="SUCCESS"){
            //支付成功
            $re['code'] = '0';
            $re['id'] = $openid;
            $re['time'] = $dtime;
            $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/GetWXOrder/index';
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="REFUND"){
            //已退款
            $re['code'] = "1";
            $re['message'] = "用户已退款";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="NOTPAY"){
            //用户还没支付
            $re['code'] = "1";
            $re['message'] = "用户还没支付";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="CLOSED"){
            //订单关闭
            $re['code'] = "1";
            $re['message'] = "订单关闭";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="REVOKED"){
            //已撤销（刷卡支付）
            $re['code'] = "1";
            $re['message'] = "已撤销（刷卡支付）";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="USERPAYING"){
            //用户支付中
            $re['code'] = "1";
            $re['message'] = "用户支付中";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }else if($order['trade_state'] =="PAYERROR"){
            //支付失败(其他原因，例如银行返回失败)
            $re['code'] = "1";
            $re['message'] = "支付失败(其他原因，例如银行返回失败)";
            echo json_encode( $re , JSON_UNESCAPED_UNICODE);
            die;
          }
        }
      }else {
        $this->display();
      }
    }
    public function order_content(){

    if(isset($_REQUEST['order_id'])){
        $_SESSION['premoney']=$_REQUEST['order_id'];
    }
      
      $tools = new \JsApiPay();
      // dump($tools);
      // die();
      $openid = $tools->GetOpenid();

      $order = M("order");
      $order_content=$order->table("my_order as o")->join("my_service as ser on ser.ser_id=o.order_choose")->where('order_id='.$_SESSION['premoney'])->find(); //获取订单详情   $_REQUEST['order_id']
      $number = $order_content['order_number'];
      $price  = $order_content['order_price'];
      $service  = $order_content['ser_service'];
      $Out_trade_no = $number;//订单号

      // //$Out_trade_no=date('YHis').rand(100,1000);
      // $Total_fee='预约挂号服务';
      // $Body=$groupName.'卡';
      // $Total_fee=$price;      //支付价格传值
      // $input = new \WxPayUnifiedOrder();
      // $input->SetBody($Body);
      // $input->SetAttach($Body);
      // $input->SetOut_trade_no($Out_trade_no);
      // $input->SetTotal_fee($Total_fee);
      // $input->SetTime_start(date("YmdHis"));
      // $input->SetTime_expire(date("YmdHis", time() + 600));
      // $input->SetGoods_tag($Body);
      // $input->SetNotify_url("http://www.qudaoplus.cn/");
      // $input->SetTrade_type("JSAPI");
      // $input->SetOpenid($openid);
      // $order = \WxPayApi::unifiedOrder($input);
      // $this->jsApiParameters = $tools->GetJsApiParameters($order);
      // $this->assign('openid',$openid);
      $this->assign("content",$order_content);
      $this->display();
    }
}
