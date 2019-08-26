<?php


namespace Home\Controller;


use Common\Controller\BaseController;
use Common\Model\MemberModel;
use Common\Service\HttpService;
use Common\Service\WxOauthService;
use Think\Log;

class HomeController extends BaseController
{
    //接口
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }



    /********************* 授权登录 ************************************/
    private $home_url = MOBILE_SITE_URL."/Home/Home/home";
    //private $home_url = "http://www.taiji.com/Home/Home/home"; // 本地测试页面路径
//    private $groupUpdate = "http://www.qudaoplus.cn/merber_all_show/index.php/home/MerberRank/";
    private $Register    = "http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberRegister";

    public function index()
    {
        //设置登录后 前往商城首页 还是 自定义的重定向页面 $redirect_url
        $this->setHomeUrl();

        //微信授权 获取openid
        $WxOauthService = new WxOauthService();
        $WxUserInfo = $WxOauthService->WxUserInfo();
        $openid = $WxUserInfo['openid'];

        //检查本地用户数据完整性 进行跳转 => 商城首页 or 会员升级
        $this->checkLocalMemberInfo($openid);

        //调用一卡易 第三方数据  完善本地用户数据
        $this->cloneRemoteMemberInfo($openid);

    }
    //渠道PLUS 主页面
    public function home()
    {
        $this->display();
    }
    //联系管家页面
    public function tellMe()
    {
        $this->display();
    }










    //调用用户的信息

    private function setHomeUrl()
    {
        $redirect_url = trim(I('redirect_url'));
        if($redirect_url) $this->home_url = $redirect_url;
    }
    private function checkLocalMemberInfo($openid)
    {
        $Member = new MemberModel();
        $has_member = $Member->getMemberInfo(["m_openids" => $openid]);
        if(!empty($has_member))
        {
//            if($has_member["m_groupname"] == '待审核')
//            {
//
//            }else{
            session("member_id",$has_member['m_id']);
            redirect($this->home_url);
//            }
        }
    }

    private function cloneRemoteMemberInfo($openid)
    {
        $response_data = $this->getMemberInfoFrom1card1($openid);
        Log::write(json_encode($response_data),"DEBUG",'File',APP_PATH.'../log/member_login.log');

        //将open_id 和 mobile信息保存
        if( $response_data['status'] == 0 )
        {
            $has_member = $this->Member_model->getMemberInfo(["m_phone" => $response_data['data'][0]['Mobile']]);
            if(!empty($has_member)){
                $updata = [
                    "m_cname"       =>  $response_data['data'][0]['TrueName'],
                    "m_groupname"   =>  $response_data['data'][0]['MemberGroupName'],
                    "m_openids"     =>  $response_data['data'][0]['ThirdOpenId'],
                    "m_num"         =>  $response_data['data'][0]['CardId']
                ];
                $update = $this->Member_model->update_member(["m_id"=>$has_member['m_id']],$updata);
                session("member_id");
            }else{
                $member_id = $this->Member_model->add_member($response_data['data'][0]);
                session("member_id");
            }

//            $group = $response_data['data'][0]['MemberGroupName'];
//            if ($group == '待审核') {
//                echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
//                redirect( $this->groupUpdate );
//            }else{
            redirect($this->home_url);
//            }
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
}