<?php
namespace Home\Controller;
use Think\Controller;
class GetWXOrderController extends Controller {

  public function _initialize(){
    Vendor('phpSDK.OpenApiClient');
  }

  /**
   * 通过微信商户订单号获取订单信息
   */
   public function index(){
     $client = new \OpenApiClient ();

     $openid = $_REQUEST['id'];
     $time = $_REQUEST['time'];

     $startTime = date('Y-m-d H:i:s',$time-60);
     $endTime   = date('Y-m-d H:i:s',$time+60);

     $data = array (
       "deviceType" => '1',
       "thirdOpenId" => $openid
     );
     $response_by = $client->CallHttpPost ( "GetMemberGuidByOpenId",$data );
     if ($response_by['status']!='0') {
       echo "<script>alert('您查询该订单的用户未绑定微信')</script>";
     }else {
       $info = $response_by['data']['0'];

       $name = $info['TrueName'];     //成员姓名
       $cardid = $info['CardId'];     //成员卡号
       // $state = '审核通过';
       $data = array (
           "userAccount" => '10000',
           "where" => "CardId = '".$cardid."' and SubmitTime > '".$startTime."' and SubmitTime < '".$endTime."' ",
           "pageIndex" => '0',
           "pageSize" => "200",
           "orderBy" => ''
       );
       $response_page = $client->CallHttpPost ( "Get_GoodsBillPaged",$data );
       if ($response_page['status']=='0'&&$response_page['total'] > '0') {
         $this->assign('data',$response_page['data']);
         $this->display();
       }else {
         echo "<script>alert('您查询该订单未完成支付')</script>";
       }

     }
   }

}
