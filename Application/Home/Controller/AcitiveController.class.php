<?php
namespace Home\Controller;
use http\Cookie;
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
      $id = $_REQUEST['openid'];                  // 微信openid o1xY9wm9JSfoPtX1QyFpK1TNSC4s
      $mobile = $_REQUEST['mobile'];              // 手机号
      $smsyzm = $_REQUEST['smsyzm'];              // 验证码
      $cdkey  = $_REQUEST['cdkey'];               // 代理人手机号（推荐人）
      $groupName  = '待审成员';                    // 成员卡级别
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
            $register = $this->acitiveRegister($mobile,$trueName,$groupName,$cdphone,$address,$registerEntry,$recommend='');
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

  /** 天朝上品购买注册
    * $id 成员微信的openid
    * $mobile 成员手机号
    * $smsyzm 手机短信验证码
    * $recommendCardId 推荐人卡号或手机号
    * $registerEntry 成员注册入口写在备注中
    */
  public function getCoupon(){
    $client = new \OpenApiClient ();

    if(IS_POST){
      $id = $_REQUEST['openid'];                                  // 微信openid
      $mobile = $_REQUEST['mobile'];                              // 手机号
      $smsyzm = $_REQUEST['smsyzm'];                              // 验证码
      $recommenkey = $_REQUEST['recommend'];                      // 推荐人卡号或手机号
      $userName = $_REQUEST['userName'];                      // 成员姓名
      $address = $_REQUEST['address'];                      // 成员地址
      $registerEntry  = '天朝上品购买注册';                        // 注册入口

      // 验证验证码
      if( session('smsyzm') != $smsyzm ){
        $re['code'] = '-2';
        $re['message'] = '验证码错误！';
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die();
      } else {
        $jsonArr = $this->keyJson();
        if ( in_array( $recommenkey,$jsonArr ) ) {
          foreach ( $jsonArr as $key => $value ) {
            // 通过兑换码推荐人手机号后5位换取推荐人手机号
            if ( $recommenkey==$value ) {
              $recommendCardId = $key;
            }
          }
        }else {
          $re['code'] = '-5';
          $re['message'] = '你输入的推荐码错误';
          echo json_encode($re,JSON_UNESCAPED_UNICODE);
          die();
        }
        if ( $recommendCardId ) {
          $getRecommInfo = $this->acitiveMemberInfo($recommendCardId);    // 获取推荐人信息
          if ( $getRecommInfo['status']!='0' ) {
            $re['code'] = '-5';
            $re['message'] = '你输入的推荐码错误';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
          $reCardId = $getRecommInfo['data']['0']['CardId'];    //推荐人卡号
          $reTrueName = $getRecommInfo['data']['0']['TrueName'];    //推荐人姓名
          $ReGroupName = $getRecommInfo['data']['0']['MemberGroupName'];    //推荐人级别名称
          if ($ReGroupName=='待审核') {
            $re['code'] = '-5';
            $re['message'] = '该手机号不具备推荐资格';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
        }
        // 判断成员是否已经注册
        $getMemberInfo = $this->acitiveMemberInfo($mobile);       //获取注册人信息
        if ( $getMemberInfo['status'] != '0' ) {
          // 未注册
          $aRegister = $this->acitiveRegister($mobile,$userName,$groupName='',$recommendCardId,$address,$registerEntry,$recommend='');
          if ($aRegister['status'] != '0' ) {
            $re['code'] = '-1';
            $re['message'] = '注册失败！';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
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
            $this->ReTemplate($mobile,$recommendCardId,$reTrueName,$registerEntry);
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

          if ( $infoMemberGroupName!='待审核' ) {
            $re['code'] = '-4';
            $re['message'] = '您已享有优惠价格';
            $re['url'] = 'http://kaid.cn/gUBBn';
            echo json_encode($re,JSON_UNESCAPED_UNICODE);
            die();
          }
          // 如果有推荐人就修改推荐人
          if ( $recommendCardId ) {
            $update = $this->UpdateMember($infoCardId,$recommendCardId);
            if ( $update['status']!='0' ) {
              $re['code'] = '-5';
              $re['message'] = '你输入的推荐码错误';
              echo json_encode($re,JSON_UNESCAPED_UNICODE);
              die();
            }
          }
        }
        session( 'smsyzm' , null );     //清除验证码session
        $re['code'] = '0';
        $re['message'] = '注册成功！';
        $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/WechatPay/index?guid=e4e17498-6077-e711-832b-0010185de866&id=13105398389&groupName=0';
        echo json_encode($re,JSON_UNESCAPED_UNICODE);
        die();
      }
    } else {
        $audo = $_REQUEST['audo'];
        //$audo = 111;
        //dump($audo);
        if ($audo == 11111){
            $audo1 = 111;
            $audocookie = cookie('audo',$audo1);
            session('audo',$audo1);
        }

//        die();
      // 获取微信openid
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
//      if( $info['openid'] ){
//        $id = $info['openid'];
//      } else {
//        $re['code'] = '-1';
//        $re['message'] = '服务器请求出错，请稍后重试';
//        $errorJson = json_encode($re,JSON_UNESCAPED_UNICODE);
//      }

      //获取成员是否绑定了微信
      $wechatOpenid = $this->acitiveOpenId($id);
      if( $wechatOpenid['status']=='0' ){
        $CardId = $wechatOpenid['data']['0']['CardId'];
        $MemberGroupName = $wechatOpenid['data']['0']['MemberGroupName'];
        $recommendCardId = $wechatOpenid['data']['0']['RecommendMemberCardId'];
        $recommendOrgan = $regisInfo['extValue']['0']['推荐机构'];     //推荐机构
        if ( $MemberGroupName!='待审核' ) {
          // $re['code'] = '-4';
          // $re['message'] = '您已享有优惠价格';
          // $re['url'] = 'http://kaid.cn/gUBBn';
          // $overJson = json_encode($re,JSON_UNESCAPED_UNICODE);
          redirect("http://kaid.cn/gUBBn");
        }
      }

      $this->assign('errorJson',$errorJson);
      $this->assign('audo',$audocookie);
      // $this->assign('overJson',$overJson);
      $this->assign('openid',$id);
      $this->display();
    }
  }
    /** 名流杂志购买注册
     * $id 成员微信的openid
     * $mobile 成员手机号
     * $smsyzm 手机短信验证码
     * $recommendCardId 推荐人卡号或手机号
     * $registerEntry 成员注册入口写在备注中
     */
    public function personage(){
        $client = new \OpenApiClient ();

        if(IS_POST){
            $id = $_REQUEST['openid'];                                  // 微信openid
            $mobile = $_REQUEST['mobile'];                              // 手机号
            $smsyzm = $_REQUEST['smsyzm'];                              // 验证码
//            $recommenkey = $_REQUEST['recommend'];                      // 推荐人卡号或手机号
            $userName = $_REQUEST['userName'];                      // 成员姓名
            $address = $_REQUEST['address'];                      // 成员地址
            $registerEntry  = '名流杂志购买注册';                        // 注册入口
            $zhiwei  = $_REQUEST['zhiye'];                        // 注册入口

            // 验证验证码
            if( session('smsyzm') != $smsyzm ){
                $re['code'] = '-2';
                $re['message'] = '验证码错误！';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die();
            } else {
                // 判断成员是否已经注册
                $getMemberInfo = $this->acitiveMemberInfo($mobile);       //获取注册人信息
                if ( $getMemberInfo['status'] != '0' ) {
                    // 未注册
                    $aRegister = $this->perRegister($mobile,$userName,$groupName='',$address,$registerEntry,$recommend='',$zhiwei);

                    if ($aRegister['status'] != '0' ) {

                        $re['code'] = '-1';
                        $re['message'] = '注册失败！';
                        echo json_encode($aRegister,JSON_UNESCAPED_UNICODE);
                        //echo json_encode($re,JSON_UNESCAPED_UNICODE);
                        die();
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
                        $this->ReTemplate($mobile,$registerEntry);
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

                    if ( $infoMemberGroupName!='待审核' ) {
                        $re['code'] = '-4';
                        $re['message'] = '您已享有优惠价格';
                        $re['url'] = 'http://kaid.cn/gUBBn';
                        echo json_encode($re,JSON_UNESCAPED_UNICODE);
                        die();
                    }
                    // 如果有推荐人就修改推荐人
//                    if ( $recommendCardId ) {
//                        $update = $this->UpdateMember($infoCardId,$recommendCardId);
//                        if ( $update['status']!='0' ) {
//                            $re['code'] = '-5';
//                            $re['message'] = '你输入的推荐码错误';
//                            echo json_encode($re,JSON_UNESCAPED_UNICODE);
//                            die();
//                        }
//                    }
                }
                session( 'smsyzm' , null );     //清除验证码session
                $re['code'] = '0';
                $re['message'] = '注册成功！';
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/Home/acitive/persel';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die();
            }
        } else {
            $audo = $_REQUEST['audo'];
            //$audo = 111;
            //dump($audo);
            if ($audo == 11111){
                $audo1 = 111;
                $audocookie = cookie('audo',$audo1);
                session('audo',$audo1);
            }

//        die();
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
            $info = $this->wechat($url2);
//      if( $info['openid'] ){
//        $id = $info['openid'];
//      } else {
//        $re['code'] = '-1';
//        $re['message'] = '服务器请求出错，请稍后重试';
//        $errorJson = json_encode($re,JSON_UNESCAPED_UNICODE);
//      }

            //获取成员是否绑定了微信
            $wechatOpenid = $this->acitiveOpenId($id);
            if( $wechatOpenid['status']=='0' ){
                $CardId = $wechatOpenid['data']['0']['CardId'];
                $MemberGroupName = $wechatOpenid['data']['0']['MemberGroupName'];
                $recommendCardId = $wechatOpenid['data']['0']['RecommendMemberCardId'];
                $recommendOrgan = $regisInfo['extValue']['0']['推荐机构'];     //推荐机构
                if ( $MemberGroupName!='待审核' ) {
                    // $re['code'] = '-4';
                    // $re['message'] = '您已享有优惠价格';
                    // $re['url'] = 'http://kaid.cn/gUBBn';
                    // $overJson = json_encode($re,JSON_UNESCAPED_UNICODE);
                    redirect("http://kaid.cn/gUBBn");
                }
            }
            $this->assign('errorJson',$errorJson);
            $this->assign('audo',$audocookie);
            // $this->assign('overJson',$overJson);
            $this->assign('openid',$id);
            $this->display();
        }
    }
/**
 *名流杂志购买通道选择购买界面
 *时间：2019-03-04
 */
    public function persel(){
        if($_SESSION['cardId']&&$_SESSION['infor']['data'][0]['Mobile']&&$_SESSION['openid']){
//            dump($_SESSION['cardId']);
//            dump($_SESSION['openid']);
//            dump($_SESSION['infor']['data'][0]['Mobile']);
            $this->display();
        }else{
            $client = new \OpenApiClient ();
            $url2 	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];//获取当前的url地址
            $info 	= $this->wechat($url2);//
            if( $info['openid'] ){
                $id = $info['openid'];//获取用户id
                session("openid", $id);//存储在session
            }
            //dump($id);
            // 获取用户信息
            // 公众号的id和secret
            $openid = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';//yangkanglong openid
            $appid = 'wxc0a07eb0a480bd56';
            $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
            $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $tokenArr = json_decode($this->httpGet($access_token),true);
            $information_1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$tokenArr['access_token']."&openid=".$id."&lang=zh_CN";
            $information_2 = json_decode($this->httpGet($information_1),true);
            //dump($information_2);
            session("information", $information_2);//存储在session
            // the end
            $data = array (
                "deviceType" => "1",
                "thirdOpenId" => $id
            );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
            // 2.发起请求
            $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
    //        if($response_data['data']['0']['MemberGroupName'] != "内部测试"){
    //            echo '<script charset="utf-8">alert("温馨提示：此板块正在维护中……");location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22";</script>';
    //        }
            //dump($response_data);
            session("infor", $response_data);//存储在session
            $jifen = $response_data['data']['0']['EnablePoint'];
            $jfrmb = ($jifen/100);
            session("jfrmb", $jfrmb);
            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");
            //dump($_SESSION['cardId']);
            //die();
            // 判断是否登录
            if ($cardId) {
                $this->display();
            }else {
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/acitive/personage"</script>';
            }
        }
    }
    //提交信息名流杂志
    public function persub(){
        $time=Date('Y-m-d H:i:s');
        $data = array(
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'num' => $_POST['num'],
            'cardid' => $_POST['cardid'],
            'openid' => $_POST['openid'],
            'time' => $time,
        );
        $order = M()->table("my_personal")->add($data);
        if ($order) {
            $this->ajaxReturn(1);
        }else {
            $this->ajaxReturn(0);
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
    *查询单个会员信息
    *$cardId 会员卡号或手机号
    *$password 密码 （如果密码为空不验证密码）
    *$isGetExtValue 是否获取扩展字段（true/false,默认是false，不获取）
    */
  public function memberInfo($cardId='',$password='',$isGetExtValue=true){
    $client = new \OpenApiClient ();
    $data = array (
      "cardId" => $cardId,
      "password" => $password,
      "isGetExtValue" => $isGetExtValue
    );
    $response = $client->CallHttpPost ( "Get_MemberInfo", $data );
    return $response;
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
     *名流杂志购买注册接口
     *$mobile 成员注册的手机号
     *$trueName 成员姓名
     *$groupName 成员卡级别
     *$recommendCardId 推荐人卡号或者手机号
     *$address 成员地址
     *$registerEntry 注册入口
     *$recommend 推荐机构
     */
    public function perRegister($mobile='',$trueName='',$groupName='',$address='',$registerEntry='',$recommend='',$zhiwei=''){
        $client = new \OpenApiClient ();

        $data_add = array (
            "cardId" => $mobile,
            "memberGroupName" => $groupName,
            "trueName" => $trueName,
            "userAccount" => "10000",
            "mobile" => $mobile,
            "provinceId" => '',
            "cityId" => '',
            "countyId" => '',
            "address" => $address,
            "meno" => $registerEntry,
            "extValue" => array(
                '0' => array(
                    "推荐机构" => $recommend,
                    "会员风采展示" => '1',
                    "职位" => $zhiwei
                )
            )
        );
        $response_add = $client->CallHttpPost ( "Add_Member", $data_add );
        return $response_add;
    }
  /**
    *活动成员注册接口
    *$mobile 成员注册的手机号
    *$trueName 成员姓名
    *$groupName 成员卡级别
    *$recommendCardId 推荐人卡号或者手机号
    *$address 成员地址
    *$registerEntry 注册入口
    *$recommend 推荐机构
    */
  public function acitiveRegister($mobile='',$trueName='',$groupName='',$recommendCardId='',$address='',$registerEntry='',$recommend=''){
    $client = new \OpenApiClient ();

    $data_add = array (
        "cardId" => $mobile,
        "memberGroupName" => $groupName,
        "trueName" => $trueName,
        "userAccount" => "10000",
        "mobile" => $mobile,
        "provinceId" => '',
        "cityId" => '',
        "countyId" => '',
        "address" => $address,
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
   * 获取所有成员的手机号及手机号后六位
   */
   public function keyJson(){
     $client = new \OpenApiClient ();

     $data = array (
         "userAccount" => '10000',
         "where" => "",
         "pageIndex" => '0',
         "pageSize" => "200",
         "orderBy" => ''
     );
     $response_data = $client->CallHttpPost ( "Get_MembersPagedV2",$data );
     foreach ($response_data['data'] as $key => $value) {
        $re[$value['Mobile']] = substr($value['Mobile'],-6);
     }
     return $re;
   }



  /**
    *推送注册成功模版消息
    *$mobile 成员手机号或卡号
    *$recommendCardId 推荐人卡号
    *$regisInfoRecommendName 推荐人姓名
    *$registerEntry 注册入口
    *$groupName 成员卡级别
    */
    public function ReTemplate($mobile='',$recommendCardId='',$regisInfoRecommendName='',$registerEntry='',$groupName=''){
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
               'keyword3'=> array( 'value'=>urlencode('待审核'),
                                   'color'=>"#173177"
                                 ),
               'keyword4'=> array( 'value'=>urlencode("1年有效期"),
                                   'color'=>"#173177"
                                 ),
               'remark'=> array( 'value'=>urlencode('推荐人号码:'.$recommendCardId.',姓名：'.$regisInfoRecommendName.'\n注册入口:'.$registerEntry.''),
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
