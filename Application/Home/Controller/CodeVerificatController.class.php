<?php
/**
  * HOPY GOGOGO优惠码生成核销
  */
namespace Home\Controller;
use Think\Controller;
class CodeVerificatController extends AdminController {

  /**
    * codes() 生成优惠码
    * 优惠码前缀(一 月:Jan;二月:Feb;三月:Mar;四月:Apr;五月:May;六月:Jun;七月:Jul;八月:Aug;九月:Sep;十月:Oct;十一月:Nov;十二月:Dec;)
    * 4位随机数
    * 001-499编号
    */
  public function codes(){
    $getCode = $this->generateCode( '500','','4','APR','' );
    foreach ($getCode as $key => $value) {
      if ( strlen($key)=='1') {
        $p[$key] = $value.'00'.$key;
      }
      if ( strlen($key)=='2') {
        $p[$key] = $value.'0'.$key;
      }
      if ( strlen($key)=='3') {
        $p[$key] = $value.$key;
      }
    }
    if ($p) {
      $fp = fopen("codes.json", "w");
      fwrite($fp, json_encode($p,JSON_FORCE_OBJECT));
      fclose($fp);
    }
    echo json_encode($p,JSON_FORCE_OBJECT);
  }

  /**
    * lookcode() 查看生成的优惠码
    */
  public function lookcode(){
    $code_arr = json_decode(file_get_contents("codes.json"),true);

    $this->assign('code_arr',$code_arr);
    $this->display();
  }

  /**
    * verificat() 检查优惠码是否存在
    */
  public function verificat(){
    // $code = $_REQUEST['code'];
    $code = 'Apr2785000';
    $code_arr = json_decode(file_get_contents("codes.json"),true);
    if (!in_array($code,$code_arr)) {
      $data['code'] = '0';
      $data['message'] = '优惠码错误';
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }else {
      $data['code'] = '1';
      $data['message'] = '优惠码正确';
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
  }

  /**
    * cancleCode() 核销优惠码
    */
  public function cancleCode(){
    if (IS_POST) {
      $canCode = $_REQUEST['canCode'];
      $code_arr = json_decode(file_get_contents("codes.json"),true);
      if (in_array($canCode,$code_arr)) {
        foreach ($code_arr as $key => $value) {
          if ($value==$canCode) {
            $code_arr[$key] = 'UN'.$canCode;
          }
        }
        if ($code_arr) {
          $fp = fopen("codes.json", "w");
          fwrite($fp, json_encode($code_arr,JSON_FORCE_OBJECT));
          fclose($fp);
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
                 'template_id'=>"KbSUxSImI6DvPWSR3NKQCBgKFMsVzCUNSCpk21vFkHk",
                 'url'=>"",
                 'miniprogram'=>array(
                   'appid'=>"",
                   'pagepath'=>""
                 ),
                 'data'=>array(
                   'first'=> array( 'value'=>urlencode('HOPY GOGOGO 与 渠道plus合作项目'),
                                    'color'=>"#173177"
                                  ),
                   'keyword1'=> array( 'value'=>urlencode($canCode),
                                       'color'=>"#173177"
                                     ),
                   'keyword2'=> array( 'value'=>urlencode('HOPY GOGOGO 优惠码核销'),
                                       'color'=>"#173177"
                                     ),
                   'keyword3'=> array( 'value'=>urlencode(date('Y-m-d H:i:s')),
                                       'color'=>"#173177"
                                     ),
                   'keyword4'=> array( 'value'=>urlencode('HOPY GOGOGO上海大型室内亲子运动中心'),
                                       'color'=>"#173177"
                                     ),
                   'remark'=> array( 'value'=>urlencode(),
                                     'color'=>"#173177"
                                   ),
                 )
             );
             if (isset($tokenArr['access_token'])){
               $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
               $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
             }
          }
          $data['code'] = '1';
          $data['message'] = '优惠码核销成功';
          echo json_encode($data,JSON_UNESCAPED_UNICODE);
          die;
        }else {
          $data['code'] = '0';
          $data['message'] = '优惠码核销失败';
          echo json_encode($data,JSON_UNESCAPED_UNICODE);
          die;
        }
      }else {
        $data['code'] = '0';
        $data['message'] = '优惠码错误';
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die;
      }


    }else {

      $this->display();
    }
  }

}
