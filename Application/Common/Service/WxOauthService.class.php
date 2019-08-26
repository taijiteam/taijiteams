<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/12
 * Time: 10:38 AM
 */

namespace Common\Service;

use Think\Log;

class WxOauthService
{
    //渠道Plus服务号
    const APP_ID = 'wxc0a07eb0a480bd56';
    const APP_SECRET = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';

    public function WxUserInfo()
    {
        return $this->WxOauth();
    }


    private function WxOauth($scope = "snsapi_userinfo")
    {
        //无授权码就去授权  授权成功回跳回来后 往下执行
        if( !isset($_GET['code'])) {
            $this->getOauthCode($scope);
    }

        //执行授权
        if($scope == "snsapi_userinfo")
        {
            //通过授权码去获取用户的授权access_token
            $token = $this->getOauthToken($_GET['code']);
            //用户个人信息
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token['access_token']."&openid=".$token['openid']."&lang=zh_CN";
            $userInfo = json_decode(HttpService::httpGet($url),true);

            Log::write("微信认证授权信息：".json_encode($userInfo),"DEBUG",'File',APP_PATH.'../log/member_login.log');
            session('userinfo',$userInfo);

            return $userInfo;
        }
        else // $scope == "snsapi_base"  只需要openid 静默授权
        {
            $token = $this->getOauthToken($_GET['code']);
            return $token;
        }

    }

    private function getOauthToken($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::APP_ID."&secret=".self::APP_SECRET."&code=".$code."&grant_type=authorization_code";
        $res = json_decode(HttpService::httpGet($url),true);
        if(isset($res['access_token'])) {
            return $res;
        }else{
            Log::write("微信认证授权错误：".json_encode($res),"ERROR",'File',APP_PATH.'../log/member_login.log');
            return false;
        }
    }

    private function getOauthCode($scope)
    {
        $current_url = MOBILE_SITE_URL.$_SERVER["REQUEST_URI"];
        redirect("https://open.weixin.qq.com/connect/oauth2/authorize".
            "?appid=" . self::APP_ID .
            "&redirect_uri=" . urlencode($current_url) .
            "&response_type=code" .
            "&scope=" . $scope .
            "&state=1#wechat_redirect"
        );
    }
}