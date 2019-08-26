<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends AdminController {

  public function _initialize(){
    Vendor('phpSDK.OpenApiClient');
  }

  public function groupOrder(){
    $client = new \OpenApiClient ();
    $acitive = A('Acitive');

    // 获取微信openid
    $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $info = $this->wechat($url2);
    if( $info['openid'] ){
      $id = $info['openid'];
    }
    //获取成员是否绑定了微信
    $wechatOpenid = $acitive->acitiveOpenId($id);
    if ( $wechatOpenid['status']!='0' ) {
      // 成员没有绑定，跳转注册
      redirect( $this->Register );
    }else {
      $cardId = $wechatOpenid['data']['0']['CardId'];        //成员卡号
      $mobile = $wechatOpenid['data']['0']['Mobile'];        //成员手机号
      $memberImage = $wechatOpenid['data']['0']['ImagePath'];        //成员头像路径
      if ($memberImage = '/Images/Male.png') {
        $memberImage = '';
      }
      $sex = $wechatOpenid['data']['0']['Sex'];        //成员性别
      if ($sex=='1') {
        $sex = '先生';
      } elseif ($sex=='2') {
        $sex = '女士';
      } else {
        $sex ='未知';
      }
      $name = $wechatOpenid['data']['0']['TrueName'];        //成员姓名
      $groupName = $wechatOpenid['data']['0']['MemberGroupName'];        //成员卡级别名称
      $cdphone_arr = json_decode(file_get_contents("cdphone.json"),true);
      $phoneArr = array();
      foreach ( $cdphone_arr as $key => $value ) {
        $phoneArr[] = $key;
      }
      if ( in_array( $cardId,$phoneArr ) || in_array( $mobile,$phoneArr ) ) {
        
        $memberWhere = "RecommendCardId ='".$cardId."' ";
        $orderBy = "SubmitTime desc";
        $recommendUser = array();
        $orderWhere = array();
        $getOrders = array();

        // 获取被推荐人列表
        $getMember = $this->getMembers($memberWhere);
        if ($getMember['total']==0) {
          $re['code'] = '-6';
          $re['message'] = '您还没有推荐给别人哦';
          $this->assign('reArr',$re);
        }
        // 获取被推荐人卡号
        foreach ($getMember['data'] as $reId => $reCardId) {
          $reommendCardId[] = $reCardId['CardId'];
        }
        array_push($reommendCardId,$cardId);
        $strCardId = join(',',$reommendCardId);
        $inStrCardId = "'".str_replace(",","','",$strCardId)."'";    //将数组中的每个元素加‘’

        // 所有订单列表
        $where ="CardId in (".$inStrCardId.")";
        $getOrders = $this->getOrderInfo($where,$orderBy);
        foreach ($getOrders['data'] as $key => $gOrders) {
            if ($gOrders['ItemList']['0']['BarCode']=='PWSH-0012' ) {
              $getOrderinfo[] = $gOrders;
              // print_r($getOrderinfo);
              // die;
            }else {
              $re['code'] = '-6';
              $re['message'] = '您还没有订单';
              $this->assign('reArr',$re);
            }
        }
        // 总销量
        foreach ($getOrderinfo as $key => $vaOrder) {
          $getMembers[] = $vaOrder['ItemList'];
          $getNumbers[] = $getMembers[$key]['0']['Number'];
        }
        $getOrdersSum = array_sum($getNumbers);
        if (!$getOrdersSum) {
          $getOrdersSum = '0';
        }
        // end

        // 当月订单列表
        $mStart=date('Y-m-01 00:00:00');    //当前月初
        $mEnd = date('Y-m-d H:i:s');               //当前时间
        $mWhere ="CardId in (".$inStrCardId.") and '".$mStart."' < SubmitTime and SubmitTime < '".$mEnd."' ";
        $getMOrders = $this->getOrderInfo($mWhere,$orderBy);
        foreach ($getMOrders['data'] as $key => $gMOrders) {
            if ($gMOrders['ItemList']['0']['BarCode']=='PWSH-0012' ) {
              $getMOrderinfo[] = $gMOrders;
              // print_r($gOrders);
            }else {
              $re['code'] = '-6';
              $re['message'] = '您当月订单量为空！';
              $this->assign('reArr',$re);
            }
        }
        // 当月订单销量
        foreach ($getMOrderinfo as $key => $vaMOrder) {
          $getMMembers[] = $vaMOrder['ItemList'];
          $getMNumbers[] = $getMMembers[$key]['0']['Number'];
        }
        $getMOrdersSum = array_sum($getMNumbers);
        if (!$getMOrdersSum) {
          $getMOrdersSum = '0';
        }
        // end

        // 日订单列表
        $dStart=date('Y-m-d 00:00:00');    //当前月初
        $dEnd = date('Y-m-d H:i:s');               //当前时间
        $dWhere ="CardId in (".$inStrCardId.") and '".$dStart."' < SubmitTime and SubmitTime < '".$dEnd."' ";
        $getDOrders = $this->getOrderInfo($dWhere,$orderBy);
        foreach ($getDOrders['data'] as $key => $gDOrders) {
            if ($gDOrders['ItemList']['0']['BarCode']=='PWSH-0012' ) {
              $getDOrderinfo[] = $gDOrders;
              // print_r($gOrders);
            }
        }
        // 当日订单销量
        foreach ($getDOrderinfo as $key => $vaDOrder) {
          $getDMembers[] = $vaDOrder['ItemList'];
          $getDNumbers[] = $getDMembers[$key]['0']['Number'];
        }
        $getDOrdersSum = array_sum($getDNumbers);
        if (!$getDOrdersSum) {
          $getDOrdersSum = '0';
        }
        // end

        $this->assign('getOrders',$getMOrderinfo);             //当月销量列表
        $this->assign('memberImage',$memberImage);
        $this->assign('sex',$sex);
        $this->assign('name',$name);
        $this->assign('groupName',$groupName);
        $this->assign('getOrdersSum',$getOrdersSum);         //总销量
        $this->assign('getMOrdersSum',$getMOrdersSum);       //当月销量
        $this->assign('getDOrdersSum',$getDOrdersSum);       //当日销量
        $this->assign('y',date('Y'));       //当年
        $this->assign('m',date('m'));       //当月
        $this->assign('openid',$id);
      } else {
        $re['code'] = '-1';
        $re['message'] = '您不是代理人无权访问该页面，请联系客服！';
        $json = json_encode($re,JSON_UNESCAPED_UNICODE);
        $this->assign('json',$json);
      }
    }
    $this->display();
  }

  public function seOrder(){
    $client = new \OpenApiClient ();
    $acitive = A('Acitive');
    if (IS_POST) {
      $seStart = $_REQUEST['start'];
      $seEnd   = $_REQUEST['end'];
      $id      = $_REQUEST['openid'];

      //获取成员是否绑定了微信
      $wechatOpenid = $acitive->acitiveOpenId($id);
      if ($wechatOpenid['status']!='0') {
        $re['code'] = '-1';
        $re['message'] = '服务器请求失败';
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
      }else {
        $cardId = $wechatOpenid['data']['0']['CardId'];        //成员卡号
        $mobile = $wechatOpenid['data']['0']['Mobile'];        //成员手机号
        $memberWhere = "RecommendCardId ='".$cardId."' ";
        $orderBy = "SubmitTime desc";
        $recommendUser = array();
        $orderWhere = array();
        $getOrders = array();

        // 获取被推荐人列表
        $getMember = $this->getMembers($memberWhere);
        if ($getMember['total']==0) {
          $re['code'] = '-1';
          $re['message'] = '您还没有推荐给别人哦';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
        }
        // 获取被推荐人卡号
        foreach ($getMember['data'] as $reId => $reCardId) {
          $reommendCardId[] = $reCardId['CardId'];
        }
        array_push($reommendCardId,$cardId);
        $strCardId = join(',',$reommendCardId);
        $inStrCardId = "'".str_replace(",","','",$strCardId)."'";    //将数组中的每个元素加‘’

        $seWhere ="CardId in (".$inStrCardId.") and '".$seStart."' < SubmitTime and SubmitTime < '".$seEnd."' ";
        $getSeOrders = $this->getOrderInfo($seWhere,$orderBy);
        if ($getSeOrders['total']==0 || $getSeOrders['status']!=0) {
          $re['code'] = '-1';
          $re['message'] = '您还没有订单';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
        }else {
          echo json_encode($getSeOrders['data'],JSON_UNESCAPED_UNICODE);
        }
      }
    }
  }

  /**
   * 获取商品订单信息
   * $where    查询条件
   * $pageIndex   页码
   * $pageSize    页大小
   * $orderBy    排序规则
   */
   public function getOrderInfo($where="",$orderBy="",$pageIndex,$pageSize){
     $client = new \OpenApiClient ();
     if (!$pageIndex) {
       $pageIndex = '0';
     }
     if (!$pageSize) {
       $pageSize = '200';
     }
     $data = array (
         "userAccount" => '10000',
         "where" => $where,
         "pageIndex" => $pageIndex,
         "pageSize" => $pageSize,
         "orderBy" => $orderBy
     );
     $response = $client->CallHttpPost ( "Get_GoodsBillPaged",$data );
     return $response;
   }
  /**
   * 获取会员列表
   * $where    查询条件
   * $pageIndex   页码
   * $pageSize    页大小
   * $orderBy    排序规则
   */
   public function getMembers($where="",$orderBy="",$pageIndex,$pageSize){
     $client = new \OpenApiClient ();
     if (!$pageIndex) {
       $pageIndex = '0';
     }
     if (!$pageSize) {
       $pageSize = '200';
     }
     $data = array (
         "userAccount" => '10000',
         "where" => $where,
         "pageIndex" => $pageIndex,
         "pageSize" => $pageSize,
         "orderBy" => $orderBy
     );
     $response = $client->CallHttpPost ( "Get_MembersPagedV2",$data );
     return $response;
   }

   function quotes($str) {
    return("'".$str."'");
   }
}
