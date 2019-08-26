<?php
namespace Home\Controller;
use Think\Controller;
use Think\Log;

class ClubController extends AdminController {
    public function _initialize()
    {
      Vendor('phpSDK.OpenApiClient');
    }

    public function wechatRegister(){
      $client = new \OpenApiClient ();

      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if( $info ){
        $id = $info['openid'];
      }else {
        if ( !session('id') ) {
          $url_data = array(
              "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/club/wechatRegister"
          );
          $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
          if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
            redirect($response_url['oAuthUrl']);
          }
          $id = $_REQUEST['identity'];
        }else {
          $id = session("id");
        }
      }
      echo $id;
    }

    public function login(){
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

/**
  *二级菜单判断是否登陆
  */
    //商业房源
    public function merberPorperty(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      }

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        redirect("http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=27");
      }else{
        redirect( $this->Register );
      }
    }

    //房源预约看铺
    public function property(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      }

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
          redirect( $this->groupUpdate );
        }else{
          redirect("http://www.qudaoplus.cn/merber_all_show/index.php/home/reserve/property");
        }
      }else{
        redirect( $this->Register );
      }
    }

    //私享空间
    public function merberspace(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      }

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        redirect("http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=36");
      }else{
        redirect( $this->Register );
      }
    }

    //项目对接
    public function merberProject(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
              "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/merberProject"
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

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        redirect("http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=30");
      }else{
        redirect( $this->Register );
      }
    }

    //项目对接预约
    public function project(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
            "redirectUrl"=>"/Home/Club/project"
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

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGrou
          echo "<script>alert(\'成员级别不支持此功能，请升级成员卡！\')</script>";pName'];
        if ($group == '待审核') {
          redirect( $this->groupUpdate );
        }else{
          redirect("http://www.qudaoplus.cn/merber_all_show/index.php/home/reserve/project");
        }
      }else{
        redirect( $this->Register );
      }
    }

    //珍品商城
    public function shopping(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      Log::write(json_encode($info),"DEBUG",'File',APP_PATH.'../log/'.date('Ymd').'.log');

      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/shopping"
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

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      Log::write(json_encode($response_data),"DEBUG",'File',APP_PATH.'../log/'.date('Ymd').'.log');
      if( $response_data['status'] == 0 ){
        $group = $response_data['data'][0]['MemberGroupName'];
        if ($group == '待审核') {
          echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
          redirect( $this->groupUpdate );
        }else{
          redirect("http://qudaoclub.m.yunhuiyuan.cn/Shop/GoodsList?bid=80d02f3a-fad2-425d-a70a-28550275e04f");
        }
      }else{
        redirect( $this->Register );
      }
    }

    //才智礼遇购买
    public function courtesyShopping(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/courtesyShopping"
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
          redirect( $this->groupUpdate );
        }else{ redirect("http://qudaoclub.m.yunhuiyuan.cn/shop/goodsdetail?bid=80d02f3a-fad2-425d-a70a-28550275e04f&guid=7e482338-0d9a-e711-b841-0010186c9142");
        }
      }else{
        echo "<script>alert('此功能只为成员开放，请前往注册')</script>";
        redirect( $this->Register );
      }
    }

    //企业咨询
    public function resource(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);
      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/resource"
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
          redirect( $this->groupUpdate );
        }else{
          redirect("http://www.qudaoplus.cn/merber_all_show/index.php/home/reserve/advis");
        }
      }else{
        redirect( $this->Register );
      }
    }







    // 成员风采是否登陆
    public function loginWeChat(){
      $client = new \OpenApiClient ();
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $info = $this->wechat($url2);

      if ($info['openid']) {
        $id = $info['openid'];
      } else {
        if ( !session('id') ) {
          $url_data = array(
            "redirectUrl"=>"http://qudaoplus.cn/merber_all_show/index.php/home/club/loginWeChat"
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
            redirect( $this->groupUpdate );
          }elseif ($status==2) {
            cookie( 'status' , $response_data['status'] );
            redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/index/details.html?cardid=".$cardid);
          }else{
            cookie( 'status' , $response_data['status'] );
            $this->display('Index/index');
            redirect("http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/index/index.html?group=".$group);
          }
        }else{
          redirect( $this->Register );
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
