<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/3
 * Time: 9:12 AM
 */

namespace Common\Service;

class HttpService
{
    /**
     *
     * @param $url
     * @param null $data
     * @return mixed
     */
    public static function httpGet( $url,$data=null )
    {
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