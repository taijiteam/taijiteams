<?php
namespace Home\Controller;
use Think\Controller;
class MerberRankController extends AdminController {

    public function _initialize()
    {
      Vendor('phpSDK.OpenApiClient');
    }

    //会员级别查询
    public function index(){

      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      }else {
        if ( !session('id') ) {
          $url_data = array(
              "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/MerberRank/index"
          );
          $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
          if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
            redirect($response_url['oAuthUrl']);
          }
          session('id',$_REQUEST['identity']);
          $id = session('id');
        }else {
          $id = session("id");
        }
      }

      $data_OpenId = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_OpenId = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_OpenId );
      if( $response_OpenId['status'] == 0 ){
        $data_v = array(
            "userAccount"=>"10000",
            "where"=>" CardPrice!=0 ",
            "pageIndex"=>"0",
            "pageSize"=>"200",
            "orderBy"=>"CardPrice asc"
        );
        $response_v = $client->CallHttpPost ( "Get_MemberGroupPagedV2", $data_v );
        if ( $response_v['status'] == 0 ) {
          $this->assign('data' , $response_v['data']);
          $this->assign('CardId' , $response_OpenId['data'][0]['CardId']);
        }
        $this->display();
      }else {
        redirect( $this->Register );
      }
    }

    // 会员级别详情
    public function detail(){

      $client = new \OpenApiClient ();

      $guid = $_REQUEST['guid'];
      $cardid = $_REQUEST['id'];

      $data = array(
          "userAccount"=>"10000",
          "where"=>" Guid='".$guid."' ",
          "pageIndex"=>"0",
          "pageSize"=>"1",
          "orderBy"=>""
      );
      $response_one = $client->CallHttpPost( "Get_MemberGroupPagedV2", $data );

      // 判断成员卡图片
      if ( $response_one['data']['0']['GroupName'] == '亦享成员' ) {
        $card_img = "https://files.1card1.cn/g1/M02/84/B8/CgoMA1pDAQOAGXryAACCa0SXK9w157.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '致享成员' ) {
        $card_img = "https://files.1card1.cn/g1/M02/76/09/CgoMA1pDALWASKFSAADaYOHInSw624.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '悦享成员' ) {
        $card_img = "https://files.1card1.cn/g1/M02/E7/4B/CgoMA1mT2r6ALqUjAACMWuISPsQ315.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '真享成员' ) {
        $card_img = "https://files.1card1.cn/g1/M02/87/F5/CgoMA1mT22uAfPkgAACbrQdNdeg308.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '君享成员' ) {
        $card_img = "https://files.1card1.cn/g1/M02/63/93/CgoMA1obtbOAawEuAADsCAi6_QU845.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '尊享大咖' ) {
        $card_img = "https://files.1card1.cn/g1/M02/1E/55/CgoMA1mT2R2AUwcsAADif52jgfc168.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '高级顾问' ) {
        $card_img = "https://files.1card1.cn/g1/M01/9B/65/CgoMA1mCmTGAWsbzAABqZvhl-oE620.png";
      } elseif ( $response_one['data']['0']['GroupName'] == '待审核' ) {
        $card_img = "https://files.1card1.cn/g1/M02/CE/C8/CgoMA1mepR-ASxdNAACNQNpOT-c516.png";
      }else {
        $card_img = "https://files.1card1.cn/g1/M00/AD/C9/CgoMA1Xcb5KAHS66AAAyo46nUDk347.png";
      }

      $this->assign( 'arr',$response_one['data']['0'] );
      $this->assign( 'card_img',$card_img );
      $this->assign( 'cardid',$cardid );
      $this->display();
    }
}
