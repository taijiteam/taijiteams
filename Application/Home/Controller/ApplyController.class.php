<?php
namespace Home\Controller;
use Think\Controller;
class ApplyController extends AdminController{

  public function _initialize()
  {
    Vendor('phpSDK.OpenApiClient');
  }

  // 获取微信的userinfo
  public function wechatCms(){
      header("Content-type: text/html; charset=utf-8");
      // 公众号的id和secret
      $appid = 'wxc0a07eb0a480bd56';
      $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
      echo '11111';
      die;
    if ($_SESSION['code'] == $_GET['code']) {
      echo json_encode( $_SESSION['userinfo'] );
      die();
    }else {
      $_SESSION['code'] = $_GET['code'];
     // 依据code码去获取openid和access_token，自己的后台服务器直接向微信服务器申请即可
     if ( isset($_GET['code']) ){
      $data = json_decode( file_get_contents("access_token.json") );
      if ($data->expire_time < time()) {
          $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$_GET['code']."&grant_type=authorization_code";
          // $res = json_decode($this->httpGet($url),true);
          $res = json_decode($this->httpGet($url),true);
          $access_token = $res['access_token'];
          if ($access_token) {
            $data->expire_time = time() + 7000;
            $data->access_token = $access_token;
            $fp = fopen("access_token.json", "w");
            fwrite($fp, json_encode($data));
            fclose($fp);
          }
        } else {
          $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$_GET['code']."&grant_type=authorization_code";
          $res = json_decode($this->httpGet($url),true);
        }
      }
      //  依据申请到的access_token和openid，申请Userinfo信息。
      // if (isset($res['access_token'])){
      //   $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN";
      //   $userinfo = json_decode($this->httpGet($url),true);
      // }

      $_SESSION['userinfo'] = $res;

      echo json_encode( $_SESSION['userinfo'] );
      die();
    }
  }

  // 判断微信用户与一卡易是否绑定和是否已报名活动
  public function wechatBind(){

    $client = new \OpenApiClient ();

    $openid = $_REQUEST['openid'];        //微信的openid
    $title = $_REQUEST['title'];          //活动标题

    // 判断用户是否绑定了微信
    $wechat_data = array(
        "deviceType"=>"1",
        "thirdOpenId"=>$openid
    );
    $response_wechat = $client->CallHttpPost ( "GetMemberGuidByOpenId", $wechat_data );
    if ($response_wechat['status']==0) {
      // 已绑定
      $cardId = $response_wechat['data'][0]['CardId'];
      $info_data = array(
          "cardId"=> $cardId,
          "password"=>"",
          "isGetExtValue"=>"true"
      );
      $response_info = $client->CallHttpPost ( "Get_MemberInfo", $info_data );
      if ($response_info['status']==0) {
        $activeName = $response_info['extValue'][0]['精彩活动名称'];
        $actarr = explode('，',$activeName);
        if( !in_array($title,$actarr) ){
          $re['states']  = '1';
          $re['message'] = '未报名';
          $re['cardid']  = $response_info['data'][0]['CardId'];
          $re['name']    = $response_info['data'][0]['TrueName'];
          $re['mobile']  = $response_info['data'][0]['Mobile'];
          $re['group']   = $response_info['data'][0]['MemberGroupName'];
        }else {
          $re['states']  = '2';
          $re['message'] = '已报名';
          $re['cardid']  = $response_info['data'][0]['CardId'];
          $re['name']    = $response_info['data'][0]['TrueName'];
          $re['mobile']  = $response_info['data'][0]['Mobile'];
          $re['group']   = $response_info['data'][0]['MemberGroupName'];
        }
      }else {
        $re['states']  = "3";
        $re['message'] = "服务器繁忙，稍后重试…";
      }
    }else {
      // 未绑定
      $re['states']  = "4";
      $re['message'] = "未绑定";
    }
    echo json_encode( $re,JSON_UNESCAPED_UNICODE );
    die();
  }



  // 活动下发短信验证码
  public function activeSendSms(){

    $client = new \OpenApiClient ();

    //random() 函数返回随机整数。
    function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = '0123456789';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    //获取手机号
    $mobile = $_REQUEST['mobile'];

    //生成的随机数
    $mobile_code = random(4,1);
    session('smsyzm',$mobile_code);  //验证码

    $content = "验证码".$mobile_code.",有效时间为5分钟。如非本人操作，请忽略此短信。";

    // 获取短信验证码
    $data = array (
        "userAccount" => "10000",
        "mobile" => $mobile,
        "content" => $content
    );
    $response_data = $client->CallHttpPost ( "SendSms", $data );
    if( $response_data['status']==0 ){
      $re['states'] = $response_data['status'];
      $re['message'] = $response_data['message'];
    }else{
      $re['states'] = $response_data['status'];
      $re['message'] = $response_data['message'];
    }
    $con = json_encode($re,JSON_UNESCAPED_UNICODE);
    echo $con;
  }

  /**
    *判断是已有成员还是游客身份
    *游客直接注册绑定微信
    *已有成员绑定微信
    */
  public function applyWechat(){

    $client = new \OpenApiClient ();

    $openid = $_REQUEST['openid'];           //微信openid
    $mobile = $_REQUEST['mobile'];           //手机号
    $trueName = $_REQUEST['name'];           //姓名
    $smsyzm = $_REQUEST['smsyzm'];           //验证码

    $title = $_REQUEST['title'];           //活动标题
    $meno = "游客通过'".$title."'活动注册";

    if ( session('smsyzm') != $smsyzm ) {
      $re['states'] = '1';
      $re['message'] = '验证码输入错误！';

    }else {
      session('smsyzm',null);     //清除验证码session
      // 根据手机号查询成员信息
      $info_data = array(
          "cardId"=> $mobile,
          "password"=>"",
          "isGetExtValue"=>"true"
      );
      $response_info = $client->CallHttpPost ( "Get_MemberInfo", $info_data );
      if ($response_info['status']==0) {
        $cardid = $response_info['data'][0]['CardId'];
        // $activeName = $response_info['extValue'][0]['精彩活动名称'];
        // $actarr = explode('，',$activeName);
        // // 判断活动标题是否在精彩活动标题存在
        // if( in_array($title,$actarr) ){
        //   $re['states']  = '2';
        //   $re['message'] = '已报名';
        // } else {
          // 成员绑定微信
          $bind_data = array(
            "deviceType"=> 1,
            "thirdOpenId"=>$openid,
            "cardId"=>$cardid
          );
          $response_bind = $client->CallHttpPost ( "BindMember", $bind_data );
          if ($response_bind['status']==0) {
            $re['states'] = $response_bind['status'];
            $re['message'] = $response_bind['message'];
            $re['cardid'] = $response_info['data'][0]['CardId'];
          }else{
            $re['states'] = $response_bind['status'];
            $re['message'] = $response_bind['message'];
          }
        // }
      }else {
        // 成员注册
        $add_data = array(
            "cardId"=> $mobile,
            "trueName"=>$trueName,
            "mobile"=>$mobile,
            "meno"=>$meno
        );
        $response_add = $client->CallHttpPost ( "Add_Member", $add_data );
        if ($response_add['status']==0) {
          $addCard = $response_add['cardId'];
          // 成员绑定微信
          $bind_data2 = array(
              "deviceType"=> 1,
              "thirdOpenId"=>$openid,
              "cardId"=>$addCard
          );
          $response_bind2 = $client->CallHttpPost ( "BindMember", $bind_data2 );
          if ($response_bind2['status']==0) {
            $re['states'] = $response_bind2['status'];
            $re['message'] = $response_bind2['message'];
            $re['cardid'] = $response_add['cardId'];
          }else{
            $re['states'] = $response_bind2['status'];
            $re['message'] = $response_bind2['message'];
          }
          // end 成员绑定微信
        }else{
          $re['states'] = $response_add['status'];
          $re['message'] = $response_add['message'];
        }
        // end 成员注册
      }
    }
    echo json_encode($re,JSON_UNESCAPED_UNICODE);
    die();
  }

  /**
    *点击报名
    *修改精彩活动
    */
  public function activeEdit(){

    $client = new \OpenApiClient ();

    $cardId    = $_REQUEST['cardid'];
    $title     = $_REQUEST['title'];
    $group = $_REQUEST['group'];
    if ( isset($group) ) {
      $groupName = substr( $group,0,strrpos($group,'以') );
    }


    // 获取成员精彩活动字段数据
    $info_data2 = array(
        "cardId"=> $cardId,
        "password"=>"",
        "isGetExtValue"=>"true"
    );
    $response_info2 = $client->CallHttpPost ( "Get_MemberInfo", $info_data2 );
    if ($response_info2['status']==0) {
      $imcardId = $response_info2['data'][0]['CardId'];       //获取成员卡号防止被修改
      $merberGroup = $response_info2['data'][0]['MemberGroupName'];       //获取成员级别
      $activeName = $response_info2['extValue'][0]['精彩活动名称'];
      $actarr = explode('，',$activeName);
      // 判断活动标题是否在精彩活动标题存在
      if( !in_array($title,$actarr) ){
        $newActaa = array_push( $actarr,$title );     //将活动标题加入精彩活动中
        $activityTitles = implode($actarr,'，');
        // 修改活动标题
        if( $groupName==''){
          $update_data = array (
              "cardId" => $imcardId,
              "extValue" => array(
                '0' => array(
                    "精彩活动名称" => $activityTitles,
                    "会员风采展示" => '1'
                )
              )
          );
          $response_update = $client->CallHttpPost ( "Update_Member", $update_data );
          if ($response_update['status']==0) {
            $re['states'] = $response_update['status'];
            $re['message'] = $response_update['message'];
          }else{
            $re['states'] = $response_update['status'];
            $re['message'] = $response_update['message'];
          }
        } elseif( $groupName=='亦享成员' ) {             // 亦享会员
          if ( $merberGroup!='待审核' ) {
            $update_data = array (
                "cardId" => $imcardId,
                "extValue" => array(
                  '0' => array(
                      "精彩活动名称" => $activityTitles,
                      "会员风采展示" => '1'
                  )
                )
            );
            $response_update = $client->CallHttpPost ( "Update_Member", $update_data );
            if ($response_update['status']==0) {
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }else{
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }
          }else {
            $re['states']  = '3';
            $re['message'] = '成员级别不符合报名条件，请前往升级';
          }
        } elseif( $groupName=='至享成员' ) {             // 至享成员
          if ($merberGroup=='至享成员' || $merberGroup=='悦享成员' || $merberGroup=='真享成员' || $merberGroup=="内部测试" || $merberGroup=="尊享大咖" || $merberGroup=="尊享顾问" ) {
            $update_data = array (
                "cardId" => $imcardId,
                "extValue" => array(
                  '0' => array(
                      "精彩活动名称" => $activityTitles,
                      "会员风采展示" => '1'
                  )
                )
            );
            $response_update = $client->CallHttpPost ( "Update_Member", $update_data );
            if ($response_update['status']==0) {
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }else{
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }
          }else {
            $re['states']  = '3';
            $re['message'] = '成员级别不符合报名条件，请前往升级';
          }
        }elseif( $groupName=='悦享成员' ) {             // 悦享成员
          if ($merberGroup=='悦享成员' || $merberGroup=='真享成员' || $merberGroup=="内部测试" || $merberGroup=="尊享大咖" || $merberGroup=="尊享顾问" ) {
            $update_data = array (
                "cardId" => $imcardId,
                "extValue" => array(
                  '0' => array(
                      "精彩活动名称" => $activityTitles,
                      "会员风采展示" => '1'
                  )
                )
            );
            $response_update = $client->CallHttpPost ( "Update_Member", $update_data );
            if ($response_update['status']==0) {
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }else{
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }
          }else {
            $re['states']  = '3';
            $re['message'] = '成员级别不符合报名条件，请前往升级';
          }
        }elseif( $groupName=='真享成员') {             // 真享成员
          if ($merberGroup=='真享成员' || $merberGroup=="内部测试" || $merberGroup=="尊享大咖" || $merberGroup=="尊享顾问" ) {
            $update_data = array (
                "cardId" => $imcardId,
                "extValue" => array(
                  '0' => array(
                      "精彩活动名称" => $activityTitles,
                      "会员风采展示" => '1'
                  )
                )
            );
            $response_update = $client->CallHttpPost ( "Update_Member", $update_data );
            if ($response_update['status']==0) {
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }else{
              $re['states'] = $response_update['status'];
              $re['message'] = $response_update['message'];
            }
          }else {
            $re['states']  = '3';
            $re['message'] = '成员级别不符合报名条件，请前往升级';
          }
        }else {
          $re['states']  = '3';
          $re['message'] = '成员级别不符合报名条件，请前往升级';
        }
        // end 修改活动标题
      }else {
        $re['states']  = '2';
        $re['message'] = '已报名';
      }
    }else {
      $re['states'] = $response_info2['status'];
      $re['message'] = $response_info2['message'];
    }
    echo json_encode($re,JSON_UNESCAPED_UNICODE);
    die();
  }

  // 获取微信执行后的参数
  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
  }

}
