<?php
namespace Home\Controller;
use Think\Controller;
class AcitiveController extends AdminController {

  public function _initialize(){
    Vendor('phpSDK.OpenApiClient');
  }

  /** 天朝上品代理销售
    * $id 成员微信的openid
    * $mobile 成员手机号
    * $smsyzm 手机短信验证码
    * $cdphone 代理人手机号（推荐人）
    * $registerEntry 成员注册入口写在备注中
    */
  public function convert(){
    $client = new \OpenApiClient ();

    if(IS_POST){
      $id = $_REQUEST['openid'];                     // 微信openid o1xY9wm9JSfoPtX1QyFpK1TNSC4s
      $mobile = $_REQUEST['mobile'];                 // 手机号
      $smsyzm = $_REQUEST['smsyzm'];                 // 验证码
      $cdkey  = $_REQUEST['cdkey'];              // 代理人手机号（推荐人）
      $groupName  = '待审成员';              // 成员卡级别
      $registerEntry  = '通过天朝上品代理人推荐入口注册';          // 注册入口
      // 验证验证码
      if( session('smsyzm') != $smsyzm ){
        $re['code'] = '-2';
        $re['message'] = '验证码错误,请重新输入';
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die();
      } else {
        // 通过代理人手机号判断输入是否正确
        $cdphone_arr = json_decode(file_get_contents("cdphone.json"),true);
        if ( in_array( $cdkey,$cdphone_arr ) ) {
          foreach ( $cdphone_arr as $key => $value ) {
            // 通过兑换码推荐人手机号后5位换取推荐人手机号
            if ( $cdkey==$value ) {
              $cdphone = $key;
            }
          }
          // 获取推荐人信息
          $getRecommInfo = $this->acitiveMemberInfo($cdphone);
          if ( $getRecommInfo['status']!='0' ) {
            $re['code'] = '-3';
            $re['message'] = '优惠码输入错误';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
          $reCardId = $getRecommInfo['data']['0']['CardId'];    //推荐人卡号
          $ReTrueName = $getRecommInfo['data']['0']['TrueName'];    //推荐人姓名
          // 获取成员信息
          $userInfo = $this->acitiveMemberInfo($mobile);
          if ($userInfo['status']=='0') {
            $userGroupName = $userInfo['data']['0']['MemberGroupName'];     //成员卡级别
            $userRecommendCardId = $userInfo['data']['0']['RecommendMemberCardId'];      //成员推荐人卡号
            if ($userGroupName!='待审核') {
              $re['code'] = '-4';
              $re['message'] = '您已享有优惠价格';
              $re['url'] = 'http://kaid.cn/gUBBn';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }elseif ($userGroupName=='待审核'||$userGroupName=='待审成员') {
              // 修改成员的推荐人
              $upGroupName = $this->UpdateMember($mobile,$cdphone,$groupName);
              if ($upGroupName['status']=='0') {
                $re['code'] = '0';
                $re['message'] = '注册成功';
                $re['url'] = 'http://kaid.cn/gUBBn';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
              }
            }
          }else {
            // 成员信息注册
            $register = $this->acitiveRegister($mobile,$groupName,$cdphone,$registerEntry,$recommend='');
            if ($register['status']!='0') {
              $re['code'] = '-5';
              $re['message'] = '注册失败';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }else {
              $this->ReTemplate($mobile,$cdphone,$ReTrueName,$groupName);
              $re['code'] = '0';
              $re['message'] = '注册成功';
              $re['url'] = 'http://kaid.cn/gUBBn';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
            }
          }
          session( 'smsyzm' , null );     //清除验证码session
          //获取成员是否绑定了微信
          $wechatOpenid = $this->acitiveOpenId($id);
          if ( $wechatOpenid['status']!='0' ) {
            $BindMember = $this->acitiveBindMember($id,$mobile);     //成员绑定微信
            if ( $BindMember['status']!='0' ) {
              $re['code'] = '-1';
              $re['message'] = '成员卡绑定微信失败！';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }
          }
        }else {
          $re['code'] = '-3';
          $re['message'] = '优惠码输入错误';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        }
      }
    } else {
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

  /** 领取抵用券
    * $id 成员微信的openid
    * $mobile 成员手机号
    * $smsyzm 手机短信验证码
    * $recommendCardId 推荐人卡号或手机号
    * $registerEntry 成员注册入口写在备注中
    * 抵用券guid ：6e15ca38-79d5-e711-b56c-0010186c9142
    */
  public function getCoupon(){
    $client = new \OpenApiClient ();

    if(IS_POST){
      $id = $_REQUEST['openid'];                                  // 微信openid
      $mobile = $_REQUEST['mobile'];                                  // 手机号
      $smsyzm = $_REQUEST['smsyzm'];                                  // 验证码
      $recommendCardId = $_REQUEST['recommend'];               // 推荐人卡号或手机号
      $registerEntry  = '领取抵用券入口注册';                           // 注册入口

      // 验证验证码
      if( session('smsyzm') != $smsyzm ){
        $re['code'] = '-2';
        $re['message'] = '验证码错误！';
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die();
      } else {
        $getRecommInfo = $this->acitiveMemberInfo($recommendCardId);    // 获取推荐人信息
        if ( $getRecommInfo['status']!='0' ) {
          $re['code'] = '-5';
          $re['message'] = '推荐人手机号输入错误';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        }
        $reCardId = $getRecommInfo['data']['0']['CardId'];    //推荐人卡号
        $ReGroupName = $getRecommInfo['data']['0']['MemberGroupName'];    //推荐人级别名称
        // 判断成员是否已经注册
        $getMemberInfo = $this->acitiveMemberInfo($mobile);       //获取注册人信息
        if ( $getMemberInfo['status'] != '0' ) {
          // 未注册
          $aRegister = $this->acitiveRegister($mobile,$groupName='',$reCardId,$registerEntry);
          if ($aRegister['status'] != '0' ) {
            $re['code'] = '-1';
            $re['message'] = '注册失败！';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
          //获取成员是否绑定了微信
          $wechatOpenid = $this->acitiveOpenId($id);
          if ( $wechatOpenid['status']!='0' ) {
            $BindMember = $this->acitiveBindMember($id,$mobile);     //成员绑定微信
            if ( $BindMember['status']!='0' ) {
              $re['code'] = '-1';
              $re['message'] = '成员卡绑定微信失败！';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }
          }

          $regisInfo = $this->acitiveMemberInfo($mobile);
          if ( $regisInfo['status']=='0' ) {
            $infoCardId = $regisInfo['data']['0']['CardId'];     //成员卡号
            $regisInfoRecommendCardId = $regisInfo['data']['0']['RecommendMemberCardId'];     //推荐人卡号
            $regisInfoRecommendName = $regisInfo['data']['0']['RecommendMemberName'];     //推荐人姓名
            $infoMemberGroupName = $regisInfo['data']['0']['MemberGroupName'];     //成员卡级别
            $infoRecommendOrgan = $regisInfo['extValue']['0']['推荐机构'];     //推荐机构
          }
          if ( $aRegister['status'] == '0' ) {
            $this->ReTemplate($mobile,$recommendCardId,$regisInfoRecommendName);
          }
        }else {
          //获取成员是否绑定了微信
          $wechatOpenid = $this->acitiveOpenId($id);
          if ( $wechatOpenid['status']!='0' ) {
            $BindMember = $this->acitiveBindMember($id,$mobile);     //成员绑定微信
            if ( $BindMember['status']!='0' ) {
              $re['code'] = '-1';
              $re['message'] = '成员卡绑定微信失败！';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }
          }
          $infoCardId = $getMemberInfo['data']['0']['CardId'];     //成员卡号
          $regisInfoRecommendCardId = $getMemberInfo['data']['0']['RecommendMemberCardId'];     //推荐人卡号
          $infoMemberGroupName = $getMemberInfo['data']['0']['MemberGroupName'];     //成员卡级别
          $infoRecommendOrgan = $getMemberInfo['extValue']['0']['推荐机构'];     //推荐机构
          // 判断是否有推荐人或者协会
          if ( $regisInfoRecommendCardId || $infoRecommendOrgan ) {
            $re['code'] = '-4';
            $re['message'] = '您已领取过抵用券';
            $re['url'] = 'http://kaid.cn/gUBBn';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
          // 如果没有推荐人就修改推荐人
          if ( !$regisInfoRecommendCardId ) {
            $update = $this->UpdateMember($infoCardId,$reCardId);
            if ( $update['status']!='0' ) {
              $re['code'] = '-5';
              $re['message'] = '推荐人手机号输入错误';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }
          }
        }

        if ( $infoMemberGroupName=='尊享大咖' ) {
          $re['code'] = '-4';
          $re['message'] = '您已享有优惠价格';
          $re['url'] = 'http://kaid.cn/gUBBn';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        }

        session( 'smsyzm' , null );     //清除验证码session
        // 领取抵用券
        $data_getCoupon = array (
          'userAccount' => '10000' ,
          'mobiles' => '' ,
          'cardIds' => $infoCardId ,
          'couponGuid' => '6e15ca38-79d5-e711-b56c-0010186c9142' ,            //抵用券唯一标识
          'sendCount' => '1'            //发送数量
        );
        $response_getCoupon = $client->CallHttpPost ( "SendCoupon", $data_getCoupon );
        if ( $response_getCoupon['status']=='0' ) {
          // 发送推荐人抵用券
          if( $ReGroupName!='尊享大咖' ){
            $data_recomm = array (
              'userAccount' => '10000' ,
              'mobiles' => '' ,
              'cardIds' => $reCardId ,
              'couponGuid' => '6e15ca38-79d5-e711-b56c-0010186c9142' ,            //抵用券唯一标识
              'sendCount' => '1'            //发送数量
            );
            $response_recomm = $client->CallHttpPost ( "SendCoupon", $data_recomm );
            if ( $response_recomm['status']!='0' ) {
              $re['code'] = '-1';
              $re['message'] = '发送推荐人抵用券失败';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
            }else {
              $content = "恭喜您，获得‘渠道PLUS丨天朝上品贵人酒300元抵用券’1张。您推荐的手机号为‘".$mobile."’的用户也将获得1张抵用券，请点击 http://kaid.cn/gUBBn 前往购买。";
              $acitiveSms = $this->acitiveSms($recommendCardId,$content);
              if ( $acitiveSms['status']!='0' ) {
                $re['code'] = '-1';
                $re['message'] = '短信下发失败';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
              }
            }
          }
          $re['code'] = '0';
          $re['message'] = '抵用券领取成功';
          $re['url'] = 'http://kaid.cn/gUBBn';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        } else {
          $re['code'] = '-3';
          $re['message'] = '抵用券领取失败';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        }
      }
    } else {
      // 获取微信openid
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if( $info['openid'] ){
        $id = $info['openid'];
      } else {
        if ( session('id') ) {
          $id = session("id");
        } else {
          $url_data = array(
              "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/Acitive/getCoupon"
          );
          $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
          if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
            redirect($response_url['oAuthUrl']);
            $this->display();
          }
          session('id',$_REQUEST['identity']);
          $id = session('id');
        }
      }

      //获取成员是否绑定了微信
      $wechatOpenid = $this->acitiveOpenId($id);
      if( $wechatOpenid['status']=='0' ){
        $CardId = $wechatOpenid['data']['0']['CardId'];
        $MemberGroupName = $wechatOpenid['data']['0']['MemberGroupName'];
        $recommendCardId = $wechatOpenid['data']['0']['RecommendMemberCardId'];
        $recommendOrgan = $regisInfo['extValue']['0']['推荐机构'];     //推荐机构
        if ( $MemberGroupName=='尊享大咖' ) {
          $re['code'] = '-4';
          $re['message'] = '您已享有优惠价格';
          $re['url'] = 'http://kaid.cn/gUBBn';
          $overJson = json_encode($re,JSON_UNESCAPED_UNICODE);
        } else if ( $recommendCardId || $recommendOrgan ) {
          $re['code'] = '-4';
          $re['message'] = '您已领取过抵用券';
          $re['url'] = 'http://kaid.cn/gUBBn';
          $overJson = json_encode($re,JSON_UNESCAPED_UNICODE);
        }
      }

      $this->assign('overJson',$overJson);
      $this->assign('openid',$id);
      $this->display();
    }
  }

  /**
    *下发短信验证码
    *$mobile 手机号
    */
  public function acitiveSms($mobile='',$content=''){
    $client = new \OpenApiClient ();

    $sms_data = array (
      "userAccount" => "10000",
      "mobile" => $mobile,
      "content" => $content
    );
    $response_sms = $client->CallHttpPost ( "SendSms", $sms_data );
    return $response_sms;
  }

  /**
    *判断手机号是否已经注册
    *$mobile 手机号
    */
  public function acitiveMemberInfo($mobile=''){
    $client = new \OpenApiClient ();

    $data_info = array (
        "cardId" => $mobile,
        "password	" => '',
        "isGetExtValue" => 'true'
    );
    $response_info = $client->CallHttpPost ( "Get_MemberInfo", $data_info );
    return $response_info;
  }

  /**
    *活动成员注册接口
    *$mobile 成员注册的手机号
    *$groupName 成员卡级别
    *$recommendCardId 推荐人卡号或者手机号
    *$registerEntry 注册入口
    *$recommend 推荐机构
    */
  public function acitiveRegister($mobile='',$groupName='',$recommendCardId='',$registerEntry='',$recommend=''){
    $client = new \OpenApiClient ();

    $data_add = array (
        "cardId" => $mobile,
        "memberGroupName" => $groupName,
        "trueName" => '',
        "userAccount" => "10000",
        "mobile" => $mobile,
        "recommendCardId" => $recommendCardId,
        "meno" => $registerEntry,
        "extValue" => array(
          '0' => array(
              "推荐机构" => $recommend,
              "会员风采展示" => '1'
          )
        )
    );
    $response_add = $client->CallHttpPost ( "Add_Member", $data_add );
    return $response_add;
  }

  /**
    *获取成员是否绑定微信接口
    *$openid 微信的openid
    */
  public function acitiveOpenId($openid=''){
    $client = new \OpenApiClient ();

    $data_openid = array (
        "deviceType" => '1',
        "thirdOpenId" => $openid
    );
    $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
    return $response_openid;
  }

  /**
    *成员绑定微信的接口
    *$openid 微信的openid
    *$mobile 成员手机号或卡号
    */
  public function acitiveBindMember($openid='',$mobile=''){
    $client = new \OpenApiClient ();

    $data_bind = array (
        "deviceType" => '1',
        "thirdOpenId" => $openid,
        "cardId" => $mobile
    );
    $response_bind = $client->CallHttpPost ( "BindMember", $data_bind );
    return $response_bind;
  }

  /**
    *编辑会员信息
    *$mobile 成员手机号或卡号
    *$recommendCardId 推荐人卡号
    *$recommend 推荐机构
    */
  public function UpdateMember($mobile='',$recommendCardId='',$GroupName=''){
    $client = new \OpenApiClient ();

    $data_update = array (
        "cardId" => $mobile,
        "memberGroupName" => $GroupName,
        "recommendMemberCardId" => $recommendCardId
    );
    $response_update = $client->CallHttpPost ( "Update_Member", $data_update );
    return $response_update;
  }

  /**
    *推送注册成功模版消息
    *$mobile 成员手机号或卡号
    *$recommendCardId 推荐人卡号
    *$regisInfoRecommendName 推荐人姓名
    */
    public function ReTemplate($mobile='',$recommendCardId='',$regisInfoRecommendName='',$groupName=''){
      // 公众号的id和secret
      $appid = 'wxc0a07eb0a480bd56';
      $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
      $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
      $tokenArr = json_decode($this->httpGet($token_url),true);
      $openids[] = 'o1xY9wm9JSfoPtX1QyFpK1TNSC4s';
      // $openids[] = 'o1xY9wg26LFp9bUTLULQ71nn6qMg';
      // $openids[] = 'o1xY9wgJa8Rw2MfWJPLc4fmqU37s';
      foreach ($openids as $key => $value) {
        $template = array(
             'touser'=> $value,
             'template_id'=>"AtJIxSuXCgKrUeTvTgajX1v5KkQnJbhp2JmBWI9BWp8",
             'url'=>"",
             'miniprogram'=>array(
               'appid'=>"",
               'pagepath'=>""
             ),
             'data'=>array(
               'first'=> array( 'value'=>urlencode("有新成员注册！"),
                                'color'=>"#173177"
                              ),
               'keyword1'=> array( 'value'=>urlencode($mobile),
                                   'color'=>"#173177"
                                 ),
               'keyword2'=> array( 'value'=>urlencode("系统默认密码"),
                                   'color'=>"#173177"
                                 ),
               'keyword3'=> array( 'value'=>urlencode("待审核"),
                                   'color'=>"#173177"
                                 ),
               'keyword4'=> array( 'value'=>urlencode("1年有效期"),
                                   'color'=>"#173177"
                                 ),
               'remark'=> array( 'value'=>urlencode('成员级别:'.$groupName.'\n推荐人号码:'.$recommendCardId.',姓名：'.$regisInfoRecommendName.''),
                                 'color'=>"#173177"
                               ),
             )
         );
         if (isset($tokenArr['access_token'])){
           $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
           $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
         }
      }
    }

}
