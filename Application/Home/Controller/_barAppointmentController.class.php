<?php
namespace Home\Controller;
use Think\Controller;
class AppointmentController extends AdminController {

  public function _initialize()
  {
    Vendor('phpSDK.OpenApiClient');
  }

  //机场优惠券预约
  // VVIP guid : d0483cec-e9d0-e711-b56c-0010186c9142
  // VIP guid :
  public function airport(){
    $client = new \OpenApiClient ();

    $this->display();
  }

  //名医优惠券预约
  // 检查guid（9c7f0c18-100b-e811-b56c-0010186c9142）
  // 就诊guid（2865a6e1-0f0b-e811-b56c-0010186c9142）
  // 住院guid（bded5048-100b-e811-b56c-0010186c9142）
  public function dorctor(){
    $client = new \OpenApiClient ();
    $acitive = A('Acitive');
    if (IS_POST) {
      $id = $_REQUEST['id'];
      $type = $_REQUEST['type'];        // (检查：1；就诊：2；住院：3；)
      if ($type=='1') {
        $goodsItemGuid = '9c7f0c18-100b-e811-b56c-0010186c9142';
        $itemUrl = "http://kaid.cn/gXDE3";
      }elseif ($type=='2') {
        $goodsItemGuid = '2865a6e1-0f0b-e811-b56c-0010186c9142';
        $itemUrl = "http://kaid.cn/gXDFM";
      }elseif ($type=='3') {
        $goodsItemGuid = 'bded5048-100b-e811-b56c-0010186c9142';
        $itemUrl = "http://kaid.cn/gXDEZ";
      }

      // 判断是否登录
      $aOpenid = $acitive->acitiveOpenId($id);
      if ($aOpenid['status']!='0') {
        $re['code']='-1';
        $re['message']='前往注册';
        $re['url']= $this->Register;
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die;
      }elseif ($aOpenid['data']['0']['MemberGroupName']=='待审核') {
        $re['code']='-1';
        $re['message']='成员级别不支持此功能，请升级成员卡';
        $re['url']= $this->groupUpdate;
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die;
      }else {
        $cardId = $aOpenid['data']['0']['CardId'];  //成员卡号
        $countList = array (
           "userAccount" => '10000',
           "cardId" => $cardId,
           "memberPassword" => '',
           "where" => " Count>0 and Flag=1 and GoodsItemGuid='".$goodsItemGuid."'",
           "pageIndex" => '0',
           "pageSize" => "200",
           "orderBy" => 'OperateTime asc'
        );
        $response_countList = $client->CallHttpPost ( "Get_CountListPagedV2",$countList );
        if ( $response_countList['status']=='0'&&$response_countList['total']>'0' ) {
          $guid = $response_countList['data']['0']['Guid'];
          $re['code']='1';
          $re['message']='前往填写预约信息';
          $re['url']= "http://www.qudaoplus.cn/merber_all_show/index.php/home/reserve/hospital?guid=$guid&itemguid=$goodsItemGuid&type=$type";
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die;
        }elseif ( $response_countList['status']=='0'&&$response_countList['total']=='0' ) {
          $re['code']='-1';
          $re['message']='无可用权益请前往购买';
          $re['url']= $itemUrl;
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die;
        }else {
          $re['code']='-1';
          $re['message']='获取计次次数错误';
          $re['url']= '';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die;
        }
      }
    }else {
      // 获取微信openid
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if( $info['openid'] ){
        $id = $info['openid'];
      }
      $this->assign('openid',$id);
      $this->display();
    }
  }

}
