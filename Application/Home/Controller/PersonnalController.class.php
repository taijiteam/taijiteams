<?php
namespace Home\Controller;
use Think\Controller;
class PersonnalController extends AdminController {

    public function _initialize()
    {
      Vendor('phpSDK.OpenApiClient');
    }

    //成员中心
    public function central(){
      $client = new \OpenApiClient ();

      $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];//获取当前的url地址
      $info = $this->wechat($url2);//
      if( $info['openid'] ){
        $id = $info['openid'];//获取用户id
      }

      $data = array (
    		"deviceType" => "1",
    	 	"thirdOpenId" => $id
      );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
      // 2.发起请求
      $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
      session("cardId", $response_data['data']['0']['CardId']);//存储在session
      $cardId = session("cardId");
      // print_r($response_data);
      // die();
      if( $response_data['status'] == 0 ){
        $card_data = array(
            "cardId"=>$cardId,
            "password"=>"",
            "isGetExtValue"=>"true"
        );//isGetExtValue更多扩展信息；一卡易扩展会员
        $response_card = $client->CallHttpPost ( "Get_MemberInfo", $card_data );
        $card_arr = $response_card['data']['0'];
        // 判断性别
        if ($response_card['data']['0']['Sex'] =='1' ) {
          $sex = "先生";
        }elseif ($response_card['data']['0']['Sex'] =='2' ) {
          $sex = "女士";
        }else {
          $sex = "未知";
        }
        // 判断成员卡图片
        if ( $response_card['data']['0']['MemberGroupName'] == '亦享成员' ) {
          $card_img = "https://files.1card1.cn/g1/M02/84/B8/CgoMA1pDAQOAGXryAACCa0SXK9w157.png";
          $cardname = '亦享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '致享成员' ) {
          $card_img = "https://files.1card1.cn/g1/M02/76/09/CgoMA1pDALWASKFSAADaYOHInSw624.png";
            $cardname = '致享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '悦享成员' ) {
          $card_img = "https://files.1card1.cn/g1/M02/E7/4B/CgoMA1mT2r6ALqUjAACMWuISPsQ315.png";
            $cardname = '悦享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '真享成员' ) {
          $card_img = "https://files.1card1.cn/g1/M02/87/F5/CgoMA1mT22uAfPkgAACbrQdNdeg308.png";
            $cardname = '真享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '君享成员' ) {
            $card_img = "https://files.1card1.cn/g1/M02/63/93/CgoMA1obtbOAawEuAADsCAi6_QU845.png";
            $cardname = '君享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '尊享大咖' ) {
          $card_img = "https://files.1card1.cn/g1/M02/1E/55/CgoMA1mT2R2AUwcsAADif52jgfc168.png";
            $cardname = '尊享';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '高级顾问' ) {
          $card_img = "https://files.1card1.cn/g1/M01/9B/65/CgoMA1mCmTGAWsbzAABqZvhl-oE620.png";
            $cardname = '顾问';
        } elseif ( $response_card['data']['0']['MemberGroupName'] == '待审核' ) {
          $card_img = "https://files.1card1.cn/g1/M02/CE/C8/CgoMA1mepR-ASxdNAACNQNpOT-c516.png";
        }else {
          $card_img = "https://files.1card1.cn/g1/M00/AD/C9/CgoMA1Xcb5KAHS66AAAyo46nUDk347.png";
        }
        // 页面映射
        $this->assign('card_arr',$card_arr);
        $this->assign('card_img',$card_img);
        $this->assign('cardname',$cardname);
        $this->assign('sex',$sex);
        $this->display();
      }else{
        redirect( $this->Register );
      }
    }


    // 成员卡升级支付成功修改成员级别
    public function updateGroup(){
      $client = new \OpenApiClient ();
      $cardId = $_REQUEST['cardId'];
      $groupName = $_REQUEST['groupName'];

      $cardId = $cardId;
      $memberGroupName = $groupName;

      $group_data = array(
          "cardId"=>$cardId,
          "memberGroupName"=>$memberGroupName
      );
      $response_group = $client->CallHttpPost ( "Update_Member", $group_data );
      if( $response_group['status'] == 0 ){
        $re['code'] = '0';
        $re['message'] = '成员级别修改成功！';
      } else {
        $re['code'] = '-1';
        $re['message'] = '成员级别修改失败！';
      }
      echo json_encode($re,JSON_UNESCAPED_UNICODE);
      die();
    }


    /**
     *  成员签到
     */
     public function signIn(){
       $client = new \OpenApiClient ();

       $integral = '1';     //签到赠送积分数量
       $cardid = $_REQUEST['cardid'];
       $openid = $_REQUEST['openid'];
       $inte = $_REQUEST['inte'];     //会员积分
       $name = $_REQUEST['name'];     //成员姓名
       // $cardid = '123145';
       $info = $this->todayData($cardid);
       if ($info) {
         $data['code']='1';
         $data['message']='您今天已签到';
         echo json_encode($data,JSON_UNESCAPED_UNICODE);
         die;
       }else {
         $point = array(
           "userAccount"=>'10000',
           "cardId"=>$cardid,
           "point"=>$integral,
           "meno"=>"每日签到赠送积分"
         );
         $response_point = $client->CallHttpPost ( "Update_MemberPoint", $point );
         if ($response_point['status']=='0') {
           $signadd['cardid'] = $cardid;       //成员卡号
           $signadd['name'] = $name;       //成员姓名
           $signadd['integral'] = $integral;       //赠送积分
           $signadd['time'] = time();          //当前时间戳

           $sadd = M('sign')->data($signadd)->add();    //数据插入
           if ( $sadd ) {
             // 公众号的id和secret
             $appid = 'wxc0a07eb0a480bd56';
             $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
             $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
             $tokenArr = json_decode($this->httpGet($token_url),true);

             $openids[] = 'o1xY9wm9JSfoPtX1QyFpK1TNSC4s';   //liuhui openid
             $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
             $openids[] = $openid;   //会员 openid
             foreach ($openids as $key => $value) {
               $template = array(
                    'touser'=> $value,
                    'template_id'=>"MAKu_tV0lpfBQk0BSeUYa_mL_ixeL9rZWnG_dxIHW_M",
                    'url'=>"",
                    'miniprogram'=>array(
                      'appid'=>"",
                      'pagepath'=>""
                    ),
                    'data'=>array(
                      'first'=> array( 'value'=>urlencode('您好，今天已经成功签到！'),
                                       'color'=>"#173177"
                                     ),
                      'keyword1'=> array( 'value'=>urlencode($signadd['integral']),
                                          'color'=>"#173177"
                                        ),
                      'keyword2'=> array( 'value'=>urlencode($inte+$signadd['integral']),
                                          'color'=>"#173177"
                                        ),
                      'remark'=> array( 'value'=>urlencode('签到时间：'.date('Y-m-d H:i:s',$signadd['time']).'\n积分可用于在珍品商城兑换/购买积分商品。'),
                                        'color'=>"#173177"
                                      ),
                    )
                );
                if (isset($tokenArr['access_token'])){
                  $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
                  $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
                }
             }
             $data['code']='0';
             $data['message']='签到成功';
             echo json_encode($data,JSON_UNESCAPED_UNICODE);
             die;
           }else {
             $data['code']='1';
             $data['message']='签到失败';
             echo json_encode($data,JSON_UNESCAPED_UNICODE);
             die;
           }
         }else {
           $data['code']='1';
           $data['message']=$response_point['message'];
           echo json_encode($data,JSON_UNESCAPED_UNICODE);
           die;
         }
       }
     }

     /**
      * 用户当天签到的数据
      * @return array 签到信息 cardid,time 等
      */
    public function todayData($cardid){
        $time = time();
        $start_stime    = strtotime(date('Y-m-d 0:0:0',$time))-1;
        $end_stime  = strtotime(date('Y-m-d 23:59:59',$time))+1;
        return M('sign')->where("cardid='".$cardid."' and time > $start_stime and time < $end_stime")->order('time desc')->find();
    }


}
