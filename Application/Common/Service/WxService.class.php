<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/3
 * Time: 8:54 AM
 */


namespace Common\Service;

//公众号 开发 暂时没有使用
class WxService
{

    const APP_ID = 'wxc0a07eb0a480bd56';
    const APP_SECRET = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';


    private $access_token;
    private $token_path = APP_PATH."/access_token.json";


    ///////////////////////////////////////
    public function __construct()
    {
        $this->access_token();
    }

    private function access_token()
    {
        $json = file_get_contents($this->token_path);
        $token_info = json_decode($json,true);
        if($token_info['expire_time'] <= time()+100) {
            $this->access_token = $this->get_access_token();
        }else{
            $this->access_token = $token_info['access_token'];
        }
    }

    private function get_access_token()
    {
        $url = "";
        $json = HttpService::http_request($url);
        $res  = json_decode($json,true);
        if ($res['code'])
        {
            $this->access_token = $res['access_token'];
            $f = fopen($this->token_path, "w");
            fwrite($f,$res);
            fclose($f);
            return $res['access_token'];
        }else{
            //请求失败
        }
    }

}