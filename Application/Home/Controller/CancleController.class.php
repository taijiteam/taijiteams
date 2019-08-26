<?php
namespace Home\Controller;
use Think\Controller;
class CancleController extends AdminController {

    public function _initialize()
    {
      Vendor('phpSDK.OpenApiClient');
    }
    //机场优惠券使用
    public function index(){
      $client = new \OpenApiClient ();

      $couponSendGuid = $_REQUEST['cancleguid'];     //优惠券唯一标识
      if( $couponSendGuid ){
        $couponurl = strstr ( $couponSendGuid ,  '?' ,true );
        $guid = substr( $couponurl , -36 );
      }
      // echo $guid;
      // die;
      $subCount = $_REQUEST['subCount'];                 //核销优惠券数量

      // 如果没有传 核销数量默认核销一张
      if( $subCount ){
        $count = $subCount;
      }else {
        $count = '1';
      }

      $data = array (
      		"userAccount" => "10000",
      	 	"couponSendGuid" => $guid,     //优惠券发送记录唯一标识
      		"subCount" => $count            //核销数量
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "SubCoupon", $data );

      if( $response_data['status'] == 0 ){
        redirect("https://qudaoclub.m.yunhuiyuan.cn/Pay/SubmitBookingOrder?guid=515dd277-40ae-e711-b841-0010186c9142&bid=80d02f3a-fad2-425d-a70a-28550275e04f");
      }else{
        echo "<script> alert('此张优惠券无法核销,请联系客服'); </script>";
        redirect("http://qudaoclub.m.yunhuiyuan.cn/Coupon/MyCoupon/?bid=80d02f3a-fad2-425d-a70a-28550275e04f");
      }

    }


    //名医特约优惠券使用
    public function doctors(){
      $client = new \OpenApiClient ();

      $couponSendGuid = $_REQUEST['cancleguid'];     //优惠券唯一标识
      if( $couponSendGuid ){
        $couponurl = strstr ( $couponSendGuid ,  '?' ,true );
        $guid = substr( $couponurl , -36 );
      }
      $subCount = $_REQUEST['subCount'];                 //核销优惠券数量

      // 如果没有传 核销数量默认核销一张
      if( $subCount ){
        $count = $subCount;
      }else {
        $count = '1';
      }

      $data = array (
      		"userAccount" => "10000",
      	 	"couponSendGuid" => $guid,     //优惠券发送记录唯一标识
      		"subCount" => $count            //核销数量
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "SubCoupon", $data );

      if( $response_data['status'] == 0 ){
        redirect("http://qudaoclub.m.yunhuiyuan.cn/Pay/SubmitBookingOrder?guid=b73d8bcb-2978-e711-832b-0010185de866&bid=80d02f3a-fad2-425d-a70a-28550275e04f");
      }else{
        echo "<script> alert('此张优惠券无法核销,请联系客服'); </script>";
        redirect("http://qudaoclub.m.yunhuiyuan.cn/Coupon/MyCoupon/?bid=80d02f3a-fad2-425d-a70a-28550275e04f");
      }

    }
}
