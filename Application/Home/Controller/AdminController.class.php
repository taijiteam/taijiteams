<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller{

    public function __construct(){
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        $this->id = session('id');
        // $this->groupUpdate = "http://qudaoclub.m.yunhuiyuan.cn/Member/MemberGroupUpdate/";
        $this->groupUpdate = "http://www.qudaoplus.cn/merber_all_show/index.php/home/MerberRank/";
        $this->Register = "http://".$_SERVER['SERVER_NAME'].__ROOT__."/index.php/home/admin/merberRegister";
    }
    public function api_success($data=[],$message='success'){

        $ret = [
            'code' => (string)200,
            'data' => $data,
            'message' => $message
        ];

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($ret);exit;
    }

    public function api_error($message='error',$code='000',$data=[]){
        $ret = [
            'code' => (string)$code,
            'message' => $message,
            'data'  => $data
        ];

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($ret);exit;
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

            $cardId = $_REQUEST['cardId'];                    // 卡号
            $password = $_REQUEST['password'];                //  密码
            $trueName = $_REQUEST['trueName'];                //  姓名
            $sex = $_REQUEST['sex'];                          // 性别
            $birth = $_REQUEST['birth'];                      //  生日
            $recommendCardId = $_REQUEST['recommendCardId'];  //  推荐人卡号

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
            session("id",$_REQUEST['thirdOpenId']);

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
                //dump($response_data);
                if( $response_data['status']==0 ){
                    $bindata = array(
                        "deviceType" => 1,          //1表示微信登录
                        'thirdOpenId' => $thirdOpenId,        // 微信的openid
                        "cardId" => $cardId              // 卡号
                    );
                    $response_bin = $client->CallHttpPost ( "BindMember", $bindata );      //微信号绑定
                    // dump($response_bin);

                    // 公众号的id和secret
                    $appid = 'wxc0a07eb0a480bd56';
                    $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
                    $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                    $tokenArr = json_decode($this->httpGet($token_url),true);

                    $openids[] = 'o1xY9wm9JSfoPtX1QyFpK1TNSC4s';   //liuhui openid
                    $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
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
                                'keyword1'=> array( 'value'=>urlencode($cardId),
                                    'color'=>"#173177"
                                ),
                                'keyword2'=> array( 'value'=>urlencode("成员密码保密"),
                                    'color'=>"#173177"
                                ),
                                'keyword3'=> array( 'value'=>urlencode("待审核"),
                                    'color'=>"#173177"
                                ),
                                'keyword4'=> array( 'value'=>urlencode("1年有效期"),
                                    'color'=>"#173177"
                                ),
                                'remark'=> array( 'value'=>urlencode('成员姓名：'.$trueName.'；推荐人号码:'.$recommendCardId.''),
                                    'color'=>"#173177"
                                ),
                            )
                        );
                        if (isset($tokenArr['access_token'])){
                            $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
                            $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
                        }
                    }

                    session( 'smsyzm' , null );
                    $data1['code'] = $response_data['status'];
                    $data1['message'] = $response_data['message'];
                    $data1['url'] = $this->groupUpdate;
                }else{
                    $data1['code'] = $response_data['status'];
                    $data1['message'] = $response_data['message'];
                }
                //$this->ajaxReturn($data1);
                $con = json_encode($data1,JSON_UNESCAPED_UNICODE);
                echo $con;
            }
        }else {
            if ($_GET['v']!='1') {
                $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                $info = $this->wechat($url2);
                if ($info['openid']) {
                    $id = $info['openid'];
                    $this->assign('id',$id);
                }else {
                    // 一卡易网页授权的方法
                    $url_data = array(
                        "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberRegister"
                    );
                    $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
                    if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
                        redirect($response_url['oAuthUrl']);
                    }
                }
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
            session("id",$_REQUEST['thirdOpenId']);
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
                    $re['url'] = $this->groupUpdate;
                }else {
                    $re['code'] = $response_log['status'];
                    $re['message'] = $response_log['message'];
                }
                $con = json_encode($re,JSON_UNESCAPED_UNICODE);
                echo $con;
                die;
            }
        }else {
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
            $info = $this->wechat($url2);
            if ($info['openid']) {
                $id = $info['openid'];
                $this->assign('id',$id);
            }else {
                // 一卡一网页授权
                $url_data = array(
                    "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"
                );
                $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
                if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
                    redirect($response_url['oAuthUrl']);
                }
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
            session("id",$_REQUEST['thirdOpenId']);
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
                    $re['url'] = $this->groupUpdate;

                    $con = json_encode($re,JSON_UNESCAPED_UNICODE);
                    echo $con;
                    die;
                }
            }
        } else {
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
            $info = $this->wechat($url2);
            if ($info['openid']) {
                $id = $info['openid'];
                $this->assign('id',$id);
            }else {
                // 一卡易网页授权
                $url_data = array(
                    "redirectUrl"=>"http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/mobileLogin"
                );
                $response_url = $client->CallHttpPost ( "GetOAuthUrl", $url_data );
                if( $response_url['status'] == 0 && !$_REQUEST['identity'] ){
                    redirect($response_url['oAuthUrl']);
                }
            }
            $this->display('mobile_login');
        }
    }

    // 获取微信的userinfo
    public function wechat($url2=''){
        header("Content-type: text/html; charset=utf-8");
        // 回调地址
        $url = urlencode($url2);
        // 公众号的id和secret
        $appid = 'wxc0a07eb0a480bd56';
        $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';

        // 获取code码，用于和微信服务器申请token。 注：依据OAuth2.0要求，此处授权登录需要用户端操作
        if( !isset($_GET['code']) || $_SESSION['code']==$_GET['code'] ){
            redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$url&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
            exit;
        }
        $_SESSION['code'] = $_GET['code'];
        // 依据code码去获取openid和access_token，自己的后台服务器直接向微信服务器申请即可
        if ( isset($_GET['code']) ){
            $data = json_decode(file_get_contents("access_token.json"));
            if ($data->expire_time < time()) {
                // 如果是企业号用以下URL获取access_token
                // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$_GET['code']."&grant_type=authorization_code";
                $res = json_decode($this->httpGet($url),true);
                $access_token = $res['access_token'];
                if ($access_token) {
                    $data->expire_time = time() + 7000;
                    $data->access_token = $access_token;
                    $data->state = '1';
                    $fp = fopen("http://www.qudaoplus.cn/merber_all_show/access_token.json", "w");
                    fwrite($fp, json_encode($data));
                    fclose($fp);
                }
            } else {
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$_GET['code']."&grant_type=authorization_code";
                $res = json_decode($this->httpGet($url),true);
            }
        }
        // echo $res['expires_in'];
        // print_r($res);

        //  依据申请到的access_token和openid，申请Userinfo信息。
        // if (isset($res['access_token'])){
        //   $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN";
        //   $userinfo = json_decode($this->httpGet($url),true);
        // }
        $_SESSION['userinfo'] = $res;
        // session_unset();
        return $_SESSION['userinfo'];
    }

    /**
     *获取access_token
     */
    public function gettoken(){

        // 公众号的id和secret
        $appid = 'wxc0a07eb0a480bd56';
        $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
        $urltoken ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
        $res = json_decode($this->httpGet($urltoken),true);
        return $res;

    }


    /**
     * 生成vip激活码
     * @param int $nums             生成多少个优惠码
     * @param array $exist_array     排除指定数组中的优惠码
     * @param int $code_length         生成优惠码的长度
     * @param int $prefix              生成指定前缀
     * @param int $prefoot              生成指定后缀
     * @return array                 返回优惠码数组
     */
    public function generateCode( $nums,$exist_array,$code_length,$prefix,$prefoot ) {
        $characters = "0123456789";
        $promotion_codes = array(); //这个数组用来接收生成的优惠码
        for($j = 0 ; $j < $nums; $j++) {
            $code = '';
            for ($i = 0; $i < $code_length; $i++) {
                $code .= $characters[mt_rand(0, strlen($characters)-1)];
            }
            //如果生成的4位随机数不再我们定义的$promotion_codes数组里面
            if( !in_array($code,$promotion_codes) ) {
                if( is_array($exist_array) ) {
                    if( !in_array($code,$exist_array) ) {//排除已经使用的优惠码
                        $promotion_codes[$j] = $prefix.$code.$prefoot; //将生成的新优惠码赋值给promotion_codes数组
                    } else {
                        $j--;
                    }
                }else {
                    $promotion_codes[$j] = $prefix.$code.$prefoot;//将优惠码赋值给数组
                }
            }else {
                $j--;
            }
        }
        return $promotion_codes;
    }

    // 获取微信执行后的参数
    public function httpGet( $url,$data=null ) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if ( !empty($data) ) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}
