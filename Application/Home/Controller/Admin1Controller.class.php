<?php
namespace Home\Controller;
use Think\Controller;
class Admin1Controller extends Controller{

    public function test(){
      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      // $url2 = "http://www.qudaoplus.cn/index.php?m=content&c=index&a=show&catid=32&id=71";
      $info = $this->wechat($url2);
      print_r($info);
    }

    public function wechat($url2){
        header("Content-type: text/html; charset=utf-8");
        // 回调地址
        $url = urlencode($url2);
        // 公众号的id和secret
        $appid = 'wxc0a07eb0a480bd56';
        $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';

      // 获取code码，用于和微信服务器申请token。 注：依据OAuth2.0要求，此处授权登录需要用户端操作
      if( !isset($_GET['code']) || $_SESSION['code']==$_GET['code'] ){
         redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$url&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect");
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
      if (isset($res['access_token'])){
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN";
        $userinfo = json_decode($this->httpGet($url),true);
      }
      $_SESSION['userinfo'] = $userinfo;

      return $_SESSION['userinfo'];
    }

    public function getUser(){
      header("Content-type: text/html; charset=utf-8");
      // 公众号的id和secret
      $appid = 'wxc0a07eb0a480bd56';
      $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';

      $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
      $tokenArr = json_decode($this->httpGet($token_url),true);
      // echo $getuser['access_token'];

      //  依据申请到的access_token和openid，申请Userinfo信息。
      // if (isset($tokenArr['access_token'])){
      //   $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$tokenArr['access_token'];
      //   $getuser = json_decode($this->httpGet($url),true);
      // }
      // if (isset($tokenArr['access_token'])){
      //   $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=".$tokenArr['access_token'];
      //   $get_industry = json_decode($this->httpGet($url),true);
      // }
      // if (isset($tokenArr['access_token'])){
      //   $url2 = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=".$tokenArr['access_token'];
      //   $api_add_template = json_decode($this->httpGet($url2),true);
      // }
      // print_r($api_add_template);
      // die();
      // o1xY9wm9JSfoPtX1QyFpK1TNSC4s
      // foreach ($getuser['data']['openid'] as $key => $value) {
      //   if ($value=='o1xY9wm9JSfoPtX1QyFpK1TNSC4s') {
      //     echo $key.':'.$value;
      //   }
      // }
      $openids[] = 'o1xY9wm9JSfoPtX1QyFpK1TNSC4s';
      // $openids[] = 'o1xY9wg26LFp9bUTLULQ71nn6qMg';
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
               'keyword2'=> array( 'value'=>urlencode("888888"),
                                   'color'=>"#173177"
                                 ),
               'keyword3'=> array( 'value'=>urlencode("待审核"),
                                   'color'=>"#173177"
                                 ),
               'keyword4'=> array( 'value'=>urlencode("1年有效期"),
                                   'color'=>"#173177"
                                 ),
               'remark'=> array( 'value'=>urlencode('推荐人号码:'.$recommendCardId.',姓名：'.$regisInfoRecommendName.''),
                                 'color'=>"#173177"
                               ),
             )
         );
         if (isset($tokenArr['access_token'])){
           $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
           $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
         }
      }
      print_r($send);
    }

    private function httpGet( $url,$data=null ) {
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

    public function recode(){
      $re = $this->generateCode( '50','','6','','' );
      $data = json_encode($re);
      echo $data;
      // echo '<pre>';
      // print_r( $re );
      // echo '</pre>';
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
        $promotion_codes = array();//这个数组用来接收生成的优惠码
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
              } else {
                  $promotion_codes[$j] = $prefix.$code.$prefoot;//将优惠码赋值给数组
              }
          } else {
              $j--;
          }
        }
        return $promotion_codes;
    }


}
