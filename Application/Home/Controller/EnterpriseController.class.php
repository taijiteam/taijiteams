<?php


namespace Home\Controller;


use Common\Model\MemberModel;
use Common\Service\HttpService;
use Common\Service\WxOauthService;
use Think\Log;

class EnterpriseController extends AdminController
{


    /*******************************  微信授权  开始****************************************************/
    //微信授权
    public function wxOther()
    {
        //微信授权 获取openid
        $WxOauthService = new WxOauthService();
        $WxUserInfo = $WxOauthService->WxUserInfo();
        $openid = $WxUserInfo['openid'];
        session("openid", $openid);//存储在session
        session("information", $WxUserInfo);//存储在session
        $response_data = $this->cloneRemoteMemberInfo($openid);
        if($response_data['data']['0']['MemberGroupName'] == "亦享成员" || $response_data['data']['0']['MemberGroupName'] == "待审核"){
            echo '<script charset="utf-8">alert("温馨提示：您的成员卡不支持此功能，请升级成员卡");location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22";</script>';
        }
        session("cardId", $response_data['data']['0']['CardId']);
        $cardId = session("cardId");
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
    //  获取用户的openid  和 一卡易信息
    private function cloneRemoteMemberInfo($openid)
    {
        $response_data = $this->getMemberInfoFrom1card1($openid);
        Log::write(json_encode($response_data),"DEBUG",'File',APP_PATH.'../log/member_login.log');

        //将open_id 和 mobile信息保存
        $Member_model = new MemberModel();
        if( $response_data['status'] == 0 )
        {
            $has_member = $Member_model->getMemberInfo(["m_phone" => $response_data['data'][0]['Mobile']]);
            if(!empty($has_member)){
                $updata = [
                    "m_cname"       =>  $response_data['data'][0]['TrueName'],
                    "m_groupname"   =>  $response_data['data'][0]['MemberGroupName'],
                    "m_openids"     =>  $response_data['data'][0]['ThirdOpenId'],
                    "m_num"         =>  $response_data['data'][0]['CardId']
                ];
                $update = $Member_model->update_member(["m_id"=>$has_member['m_id']],$updata);
                session("member_id");
            }else{
                $member_id = $Member_model->add_member($response_data['data'][0]);
                session("member_id");
            }
            return $response_data;
        }else{
            redirect( $this->Register );
        }
    }
    private function getMemberInfoFrom1card1($open_id)
    {
        $_1card1OpenId = '80D02F3AFAD2425DA70A28550275E04F';
        $_1card1Secret = "6BWPQ9";

        $data = ["deviceType" => "1", "thirdOpenId" => $open_id];
        $json_data = json_encode ( $data );

        $TimeStamp = time ();
        $Signature = strtoupper ( md5 ( $_1card1OpenId . $_1card1Secret . $TimeStamp . $json_data ) );

        $url = "http://openapi.1card1.cn/VipCloud/GetMemberGuidByOpenId?openId=" . $_1card1OpenId . "&signature=" . $Signature . "&timestamp=" . $TimeStamp;
        $postData = "data=" . $json_data;
        $result_data = HttpService::httpGet($url,$postData);
        $array = json_decode ( $result_data, true );
        return $array;
    }

    /*******************************  微信授权 结束****************************************************/



    public function index(){
        //$this->wxOther();
        $this->display();
    }
}