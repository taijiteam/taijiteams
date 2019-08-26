<?php
namespace Home\Controller;


class FinancialController extends AdminController {



    // 项目对接页面
    public function index(){
      // Vendor('phpSDK.OpenApiClient');
      // $client = new \OpenApiClient ();

      // if( IS_POST ){
      //   $id = $_REQUEST['openid'];

      //   $data = array (
      // 		"deviceType" => "1",
      // 	 	"thirdOpenId" => $id
      //   );
      //   // 2.发起请求
      //   $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      //   if( $response_data['status'] == 0 ){
      //     $group = $response_data['data'][0]['MemberGroupName'];
      //     if ($group == '待审核') {
      //       $re['code'] = '-2';
      //       $re['message'] = "会员级别不支持此功能，请先升级会员卡！";
      //       $re['url'] = $this->groupUpdate;
      //       $con = json_encode($re,JSON_UNESCAPED_UNICODE);
      //       echo $con;
      //       die;
      //     }else{
      //       $re['code'] = '0';
      //       $re['message'] = "";
      //       $re['url'] = "http://www.qudaoplus.cn/merber_all_show/index.php/home/reserve/loans";//跳转预约表单
      //       $con = json_encode($re,JSON_UNESCAPED_UNICODE);
      //       echo $con;
      //       die;
      //     }
      //   }else{
      //     $re['code'] = '-1';
      //     $re['message'] = "请先注册！";
      //     $re['url'] = $this->Register;
      //     $con = json_encode($re,JSON_UNESCAPED_UNICODE);
      //     echo $con;
      //     die;
      //   }
      // }else {
      //   // 获取微信openid
      //   $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      //   $info = $this->wechat($url2);
      //   if( $info['openid'] ){
      //     $id = $info['openid'];
      //   } else {
      //     if ( session('id') ) {
      //       $id = session("id");
      //     } else {
      //       $url_data = array(
      //           "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/Acitive/getCoupon"
      //       );
      //       $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      //       if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
      //         redirect($response_url['oAuthUrl']);
      //         $this->display();
      //       }
      //       session('id',$_REQUEST['identity']);
      //       $id = session('id');
      //     }
      //   }
      //   $this->assign('openid',$id);
        $this->display();
      //}
    }

}
