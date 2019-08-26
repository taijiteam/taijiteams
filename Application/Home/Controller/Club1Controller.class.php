<?php
namespace Home\Controller;
use Think\Controller;
class ClubController extends AdminController {

    public function wechatRegister(){
      echo '111111';
    }

    public function login(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      if(IS_POST){
        $cardId = $_POST['cardid'];
        $password = $_POST['password'];
        if( empty($cardId) ){
          //ajax by value
          $re['code']  = '-1';
          $re['state'] = '账号不能为空';
          echo json_encode( $re, JSON_UNESCAPED_UNICODE );
          die;
        }
        if( empty($password) ){
          //ajax by value
          $re['code']  = '-1';
          $re['state'] = '密码不能为空';
          echo json_encode( $re, JSON_UNESCAPED_UNICODE );
          die;
        }

        $data = array (
        		"cardId" => $cardId,
        		"password" => $password,
        );
        $response_data = $client->CallHttpPost ( "MemberLogin", $data );
        if ($response_data ["status"] === 0) {
          $data = $response_data;
          // var_dump ( $data ); //您可以将$data打印出来方便调试
        	// 返回的数据中可能会有多条结果,下方的的$data [0]表示读取返回的数据中第一个成员
        	//获取返回的成员个数
        	$rowCount = count($response_data);
          if($rowCount > 0){
            session('card',$cardId);
            session('password',$password);

            $datavip = array (
            		"userAccount" => "10000",
            	 	"where" => "CardId = '".session('card')."' ",
            		"pageIndex" => 0,
            		"pageSize" => 1,
            		"orderBy" => ""
            );
            // 2.发起请求
            $info = $client->CallHttpPost ( "Get_MembersPagedV2", $datavip );
            $infos = $info["data"]['0'];
            session('head',$infos['ImagePath']);  //头像
            session('name',$infos['TrueName']);  //姓名
            session('sex',$infos['sex']);  //性别
            session('group',$infos['MemberGroupName']);  //级别
            if( session('group')!='待审核' ){
              //ajax by value
              $re['code']  = $info ["status"];
              $re['state'] = "http://".$_SERVER['SERVER_NAME'].__ROOT__;
              echo json_encode( $re, JSON_UNESCAPED_UNICODE );
              die;
            }else {
              $re['code']  = '-1';
              $re['state'] = '您的成员级别过低！';
              echo json_encode( $re, JSON_UNESCAPED_UNICODE );
              die;
            }
          }
        } else {
            //ajax by value
            $re['code']  = $response_data ["status"];
            $re['state'] = $response_data ["message"];
            echo json_encode( $re, JSON_UNESCAPED_UNICODE );
            die;
        }
  	  }
  	  else{
  		  $this->display();
  	  }
    }

    // 注册信息查询
    public function register() {
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      // 获取省份列表
      $pro_data = array(
        "userAccount" => "10000"
      );
      $provinces_data = $client->CallHttpPost ( "Get_Provinces", $pro_data );

      $this->assign( 'provinces' , $provinces_data['data'] );

      // 获取地级市列表
      if( $provinces_data['status']==0 ){

        if( $_REQUEST['proId'] ){
          $proId = $_REQUEST['proId'];
        }else {
          $proId = 0;
        }

        $cit_data = array(
          'userAccount' => "10000",
          'provinceId' => 15
        );
        $cities_data = $client->CallHttpPost ( "Get_CitiesByProvince", $cit_data );
        $this->assign( 'cities' , $cities_data['data'] );
      }

      // 获取区县列表
      if( $cities_data['status']==0 ){

        if( $_REQUEST['couId'] ){
          $couId = $_REQUEST['couId'];
        }else {
          $couId = 0;
        }

        $cou_data = array(
          'userAccount' => "10000",
          'cityId' => 147
        );
        $county_data = $client->CallHttpPost ( "Get_CountyByCity", $cou_data );
        $this->assign( 'county' , $county_data );
      }
      $this->display();
    }

    // 下发短信验证码
    public function sendSms(){
      header ( "Content-Type: text/html; charset=UTF-8" );
      Vendor('phpSDK.OpenApiClient');
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
      // $_REQUEST['mobile'] = '13105398389';

      //获取手机号
      $mobile = $_REQUEST['mobile'];

      // 获取验证码
      $smsyzm = $_REQUEST['smsyzm'];

      //生成的随机数
      $mobile_code = random(4,1);
      session('smsyzm',$mobile_code);  //验证码

      $content = "验证码".$mobile_code.",有效时间为5分钟。如非本人操作，请忽略此短信。";

      if($_REQUEST['state']==2){
        $data = array (
            "userAccount" => "10000",
            "mobile" => $mobile,
            "content" => $content
        );
        // 2.发起请求
        $response_data = $client->CallHttpPost ( "SendSms", $data );
        if( $response_data['status']==0 ){
          $re['code'] = $response_data['status'];
          $re['message'] = $response_data['message'];
        }else{
          $re['code'] = $response_data['status'];
          $re['message'] = $response_data['message'];
        }
      } else {
        $mobile_arr = array (
        		"userAccount" => "10000",
        	 	"where" => "CardId = '$mobile'",
        		"pageIndex" => "0",
        		"pageSize" => "1",
        		"orderBy" => ""
        );
        $response_mobile = $client->CallHttpPost ( "Get_MembersPagedV2", $mobile_arr );
        if( $response_mobile['status']==0 && $response_mobile['total']==0 ){
          $data = array (
          		"userAccount" => "10000",
          	 	"mobile" => $mobile,
          		"content" => $content
          );
          // 2.发起请求
          $response_data = $client->CallHttpPost ( "SendSms", $data );
          if( $response_data['status']==0 ){
            $re['code'] = $response_data['status'];
            $re['message'] = $response_data['message'];
          }else{
            $re['code'] = $response_data['status'];
            $re['message'] = $response_data['message'];
          }
        }else {
          $re['code'] = '-2';
          $re['message'] = '手机号已注册请直接登录';
        }
      }
      $con = json_encode($re,JSON_UNESCAPED_UNICODE);
      echo $con;
    }


    // 成员注册
    public function merberRegister(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      if(IS_POST){

        $cardId = $_REQUEST['cardId'];                // 卡号
        $password = $_REQUEST['password'];                //  密码
        $trueName = $_REQUEST['trueName'];                //  姓名
        $sex = $_REQUEST['sex'];                      // 性别
        $birth = $_REQUEST['birth'];                //  生日
        $recommendCardId = $_REQUEST['recommendCardId'];                //  推荐人卡号

        $service1 = $_REQUEST['service1'];
        $service2 = $_REQUEST['service2'];
        $service3 = $_REQUEST['service3'];
        $service4 = $_REQUEST['service4'];
        $personal = $_REQUEST['personal'];
        $work = $_REQUEST['work'];
        $social = $_REQUEST['social'];
        $livelihood = $_REQUEST['livelihood'];
        $art = $_REQUEST['art'];
        $activity = $_REQUEST['activity'];

        $thirdOpenId = $_REQUEST['thirdOpenId'];      //微信id

        $smsyzm = $_REQUEST['smsyzm'];                //  验证码

        // 验证验证码
        if( session('smsyzm') != $smsyzm ){
          $re['code'] = '-2';
          $re['message'] = '验证码错误！';
          $yzm = json_encode($re,JSON_UNESCAPED_UNICODE);
          echo $yzm;
          die;
        }else {
          $data = array (
          		"cardId" => $cardId,
          	 	"password" => $password,
          		"memberGroupName" => "",
          	 	"trueName" => $trueName,
          		"userAccount" => "10000",
          	 	"sex" => $sex,
          		"birth" => $birth,
          	 	"mobile" => $cardId,
          		"provinceId" => "",
          		"cityId" => "",
          	 	"countyId" => "",
          		"address" => "",
          	 	"recommendCardId" => $recommendCardId,
          		"meno" => "",
          	 	"openid" => "",
          		"extValue" => array(
                '0' => array(
                    "高端人脉" => $service1,
                    "名医特约" => $service2,
                    "机场特享" => $service3,
                    "金融支持" => $service4,
                    "私人订制" => $personal,
                    "工作类" => $work,
                    "社交类" => $social,
                    "生活类" => $livelihood,
                    "艺术类" => $art,
                    "感兴趣活动" => $activity,
                    "会员风采展示" => '1'
                )
              )
          );
          $response_data = $client->CallHttpPost ( "Add_Member", $data );
          if( $response_data['status']==0 ){
            $bindata = array(
              "deviceType" => 1,          //1表示微信登录
              'thirdOpenId' => $thirdOpenId,        // 微信的openid
              "cardId" => $cardId              // 卡号
            );
            $response_bin = $client->CallHttpPost ( "BindMember", $bindata );      //微信号绑定
            session( 'smsyzm' , null );
            $re['code'] = $response_data['status'];
            $re['message'] = $response_data['message'];
          }else{
            $re['code'] = $response_data['status'];
            $re['message'] = $response_data['message'];
          }
          $con = json_encode($re,JSON_UNESCAPED_UNICODE);
          echo $con;
        }
      }else {
        $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/merberRegister"
        );
        $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
        if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
          redirect($response_url['oAuthUrl']);
        }

        $this->display('register');
      }
    }


    // 成员密码登录
    public function merberLogin(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      if (IS_POST) {
        $thirdOpenId = $_REQUEST['thirdOpenId'];
        $cardId = $_REQUEST['cardId'];
        $password = $_REQUEST['password'];

        if( $password ){
          $log_data = array(
            "cardId" => $cardId,
            "password" => $password
          );
          $response_log = $client->CallHttpPost ( "MemberLogin", $log_data );

          if( $response_log['status']==0 ){
            $data = array(
              "deviceType" => 1,          //1表示微信登录
              'thirdOpenId' => $thirdOpenId,        // 微信的openid
              "cardId" => $cardId              // 卡号
            );
            $response_data = $client->CallHttpPost ( "BindMember", $data );      //微信号绑定

            $re['code'] = $response_log['status'];
            $re['message'] = $response_log['message'];
          }else {
            $re['code'] = $response_log['status'];
            $re['message'] = $response_log['message'];
          }
          $con = json_encode($re,JSON_UNESCAPED_UNICODE);
          echo $con;
          die;
        }
      }else {
        $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/merberLogin"
        );
        $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
        if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
          redirect($response_url['oAuthUrl']);
        }

        $this->display('login');
      }
    }

    // 手机短信验证码登录
    public function mobileLogin(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();
      if (IS_POST) {
        $thirdOpenId = $_REQUEST['thirdOpenId'];
        $cardId = $_REQUEST['mobile'];
        $smsyzm = $_REQUEST['smsyzm'];

        if ( $smsyzm ) {
          if( session('smsyzm') != $smsyzm ){
            $re['code'] = '-2';
            $re['message'] = '验证码错误！';
            $yzm = json_encode($re,JSON_UNESCAPED_UNICODE);
            echo $yzm;
            die;
          }else {
            $data = array(
              "deviceType" => 1,          //1表示微信登录
              'thirdOpenId' => $thirdOpenId,        // 微信的openid
              "cardId" => $cardId              // 卡号
            );
            $response_data = $client->CallHttpPost ( "BindMember", $data );      //微信号绑定
            if ( $response_data['status']==0 ) {
              session( 'smsyzm' , null );
            }
            $re['code'] = $response_data['status'];
            $re['message'] = $response_data['message'];

            $con = json_encode($re,JSON_UNESCAPED_UNICODE);
            echo $con;
            die;
          }
        }
      } else {
        $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/mobileLogin"
        );
        $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
        if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
          redirect($response_url['oAuthUrl']);
        }
        $this->display('mobile_login');
      }
    }

/**
  *二级菜单判断是否登陆
  */
    //商业房源
    public function merberPorperty(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/merberPorperty"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        redirect("http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=27");
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //房源预约看铺
    public function property(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/property"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
        }else{
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Pay/SubmitBookingOrder?guid=b439597e-f899-e711-b841-0010186c9142");
        }
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //项目对接
    public function merberProject(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/merberProject"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        redirect("http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=30");
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //项目对接预约
    public function project(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/project"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
        }else{
          redirect("https://qudaoclub.m.yunhuiyuan.cn/Pay/SubmitBookingOrder?guid=db5523aa-d8a1-e711-b841-0010186c9142");
        }
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //珍品商城
    public function shopping(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/shopping"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
        }else{
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Shop/GoodsList?bid=80d02f3a-fad2-425d-a70a-28550275e04f");
        }
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //才智礼遇购买
    public function courtesyShopping(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/courtesyShopping"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
        }else{ redirect("http://qudaoclub.m.yunhuiyuan.cn/shop/goodsdetail?bid=80d02f3a-fad2-425d-a70a-28550275e04f&guid=7e482338-0d9a-e711-b841-0010186c9142");
        }
      }else{
        echo "<script>alert('此功能只为成员开放，请前往注册')</script>";
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    //资源对接
    public function resource(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/resource"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
        }else{
          redirect("https://qudaoclub.m.yunhuiyuan.cn/Pay/SubmitBookingOrder?guid=89543e18-d8a1-e711-b841-0010186c9142");
        }
      }else{
        redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
      }
    }

    // 成员风采是否登陆
    public function loginWeChat(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();

      $url_data = array(
          "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/loginWeChat"
      );
      $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
      if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
        redirect($response_url['oAuthUrl']);
      }

      $id = $_REQUEST['identity'];

      $cardid = $_REQUEST['cardid'];
      $status = $_REQUEST['status'];

        $data = array (
      		"deviceType" => "1",
      	 	"thirdOpenId" => $id
        );
        // 2.发起请求
        $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
        if( $response_data['status'] == 0 ){
          $group = $response_data['data'][0]['MemberGroupName'];
          if ($group == '待审核') {
            echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
            redirect("http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/");
          }elseif ($status==2) {
            cookie( 'status' , $response_data['status'] );
            redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/index/details.html?cardid=".$cardid);
          }else{
            cookie( 'status' , $response_data['status'] );
            redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/index/index.html");
          }
        }else{
          redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/club/merberRegister");
        }
    }

    //退出登录
    public function logout()
    {
        // session("cardid", null);
        // session("password", null);
        session_destroy();
        $this->redirect('Club/Club/login');

    }
    //验证码
    public function verify()
    {
      ob_clean();
      $Verify = new \Think\Verify();
      $Verify->fontSize = 14;         //字体大小
      $Verify->length   = 4;           //位数
      $Verify->codeSet   = '0123456789';   //字符集和
      $Verify->useNoise = false;           //是否添加杂点
      $Verify->useImgBg = false;           //是否使用背景图片
      $Verify->useCurve = false;           //是否使用混淆曲线
      $Verify->entry();
    }
}
