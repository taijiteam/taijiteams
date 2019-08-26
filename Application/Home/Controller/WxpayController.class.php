<?php
namespace Home\Controller;
use Think\Controller;
class WxpayController extends Controller {

    public function _initialize()
    {
      header("Content-Type:text/html; charset=utf-8");
      Vendor('payAPI.JSAPI');
    }
    public function index(){
      $tools = new \JsApiPay();
      //$openid = $tools->GetOpenid();
      $openid = $_POST['openid'];
      $order_number=$_POST['order_number'];
      $ser_service=$_POST['ser_service'];
      $order_price=$_POST['order_price'];
      //dump($order_price);
      //dump($openid);
      $Out_trade_no=$order_number;
      //$Total_fee='成员卡升级';
      $Body=$ser_service.'服务';
      $Total_fee=$order_price;      //支付价格传值
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
      $this->assign(compact('openid','order_price','order_number'));
      $this->display();
    }
    public function my_order(){
      $order_number = $_REQUEST['order_number'];
      $data = array('order_state' => 3, );
      //$order_stateupdate = M()->query("update my_order set order_state=3 where order_number='$order_number'");
      $order_stateupdate=M()->table("my_order")->where("order_number=".$_REQUEST['order_number'])->save($data);
      // dump($order_stateupdate);
      // die();
      if($order_stateupdate){
        // $title="
        //   <h2>恭喜您支付成功！</h2>
        //   <div>
        //     <p>感谢您的支持，</p>
        //     <p>提升服务质量，优化平台</p>
        //     <p>界面，做出适于大众的好平台</p>
        //   </div>";
        //   $this->assign("title",$title);
          $this->display('Doctor/center');
      } else {
        $this->error("订单支付失败");
      }
    }
    /*
     *
     *  成员特惠支付
     *  Time:2019-01-02
     *  Author:Ertao
     *
     * */
    public function projectapi(){
        $tools = new \JsApiPay();
        //$openid = $tools->GetOpenid();
        $o_id = $_REQUEST['id'];
        $cate = $_REQUEST['cate'];
        if ($cate == '宾馆'){
            $ordercon = M()->table("my_th_order as o")->join("my_th_images as i on i.i_rid = o.o_rid")->join("my_th_project as p on p.p_id = o.o_pid")->join("my_th_room as r on r.r_id = o.o_rid")->where("o_id = '$o_id'")->find();
            $ser_service = '渠道PLUS成员特惠预定酒店';
            $order_price=$ordercon['o_allrmb'];
        }elseif ($cate == '旅游'){
            $ordercon = M()->table("my_th_order as o")->join("my_th_images as i on i.i_pid = o.o_pid")->join("my_th_project as p on p.p_id = o.o_pid")->where("o_id = '$o_id'")->find();
            $p_serves = explode(" ", $ordercon['p_serve']);//分割
            $mid = explode(" ", $ordercon['o_member']);//分割
            $date['m_id']=array('in',$mid);
            $merber = M()->table("my_th_merber")->where($date)->select();
            $iid = explode(" ", $ordercon['o_insurance']);//分割
            $data['in_id']=array('in',$iid);
            $insur = M()->table("my_th_insurance")->where($data)->select();
            //人数
            $aprace = ($ordercon['o_nop']-$ordercon['o_child']);//成人总数
            $ser_service = '渠道PLUS成员特惠旅游';
            $order_price=$ordercon['o_allrmb'];
        }elseif ($cate == '美食'){
            if ($_REQUEST['fstart'] == 1){
                $ordercon = M()->table("my_th_order as o")->join("my_th_images as i on i.i_pid = o.o_pid")->join("my_th_project as p on p.p_id = o.o_pid")->where("o_id = '$o_id'")->find();
                $ser_service = '渠道PLUS成员特惠餐厅消费';
                $order_price=$ordercon['o_allrmb'];

            }else{
                $ordercon = M()->table("my_th_order as o")->join("my_th_images as i on i.i_pid = o.o_pid")->join("my_th_project as p on p.p_id = o.o_pid")->where("o_id = '$o_id'")->find();
                $ser_service = '渠道PLUS成员特惠餐厅消费';
                $order_price=$ordercon['o_allrmb'];
                $data1 = array(
                    'o_foodstart' =>1,
                );
                $foder1 = M()->table("my_th_order")->where("o_id = '$o_id'")->save($data1);
//                dump($o_id);
//                dump($foder1);
//                dump($order_price);
//                dump($ordercon);
            }
        }
//        dump($order_price);
//        dump($ordercon);
//        die();
//        分类以上
        $openid = $ordercon['o_openid'];
        $order_number=$ordercon['o_number'];

        //$order_price="10010";
        //dump($order_price);
        //die();
        //dump($openid);
        //dump($openid);
        $Out_trade_no=$order_number;
        //$Total_fee='成员卡升级';
        $Body=$ser_service.'服务';
        $Total_fee=$order_price;      //支付价格传值
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
        $this->assign(compact('openid','order_price','order_number','ordercon','p_serves','merber','insur','aprace'));
        $this->display();
    }

    /*
     *
     *  精彩活动支付
     *  Time:2019-01-05
     *  Author:Ertao
     *
     * */
    public function activityapi(){
        $tools = new \JsApiPay();
        //$openid = $tools->GetOpenid();
        $o_id = $_REQUEST['id'];
        $actorder = M()->table("my_hd_order as o")->join("my_hd_activity as a on a.a_id = o.o_aid")->where("o_id = '$o_id'")->find();

//        分类以上
        $ser_service = '渠道PLUS精彩活动报名';
        $order_price = $actorder['o_price'];
        $openid = $actorder['o_openid'];
        $order_number = $actorder['o_number'];
//        dump($order_price);
//        dump($openid);
//        dump($order_number);
//
//        die();
        $Out_trade_no=$order_number;
        //$Total_fee='成员卡升级';
        $Body=$ser_service.'服务';
        $Total_fee=$order_price;      //支付价格传值
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
        $this->assign(compact('openid','order_price','order_number','actorder'));
        $this->display();
    }
    //精彩活动支付返回
    public function activityorder(){
        $number = $_REQUEST['o_number'];
        $wechat = $_REQUEST['wechat'];
        $data = array(
            'o_state'=>3,
//            'o_wechatnum'=>3, //微信订单号
//            'o_wechatmc'=>3, //商户单号
//            'o_wechattime'=>3, //微信订单时间
        );
//        dump($number);
//        dump($wechat);
//       die();
        $order = M()->table("my_hd_order")->where("o_number = '$number'")->save($data);
        if ($order){
            echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/Home/Activity"</script>';
        }else{
            $this->error("订单支付失败,请联系客服人员！！！");
        }

    }
}