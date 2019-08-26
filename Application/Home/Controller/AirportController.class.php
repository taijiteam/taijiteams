<?php
namespace Home\Controller;

use Common\Logic\OrderLogic;
use Common\Model\MemberModel;
use Common\Model\OrderModel;
use Common\Service\HttpService;
use Common\Service\Pay\JsApiPayService;
use Common\Service\WxOauthService;
use Think\Controller;
use Think\Log;
use Think\Model;

header("Content-type: text/html; charset=utf-8");
class AirportController extends AdminController {
    private $OrderModel;

    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }

    public function __construct()
    {
        parent::__construct();
        $this->OrderModel = new OrderModel();
    }


    //生成订单号
    private function createOrderSn()
    {
        $d = date('Ymd');
        $cnt = $this->OrderModel->cnt(['addtime'=>['gt',strtotime($d)]]);
        $order_sns=sprintf("%04d", $cnt);
        return date('YmdHis') . $order_sns . rand(111,999);
    }
//根据生日计算年龄函数
    public function getAge($birthday){
        //格式化出生时间年月日
        $byear=date('Y',$birthday);
        $bmonth=date('m',$birthday);
        $bday=date('d',$birthday);

        //格式化当前时间年月日
        $tyear=date('Y');
        $tmonth=date('m');
        $tday=date('d');

        //开始计算年龄
        $age=$tyear-$byear;
        if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){
            $age--;
        }
        return $age;
    }
    public function wxLogin(){
        //微信授权 获取openid
        $WxOauthService = new WxOauthService();
        $WxUserInfo = $WxOauthService->WxUserInfo();
        $openid = $WxUserInfo['openid'];
        session("openid", $openid);//存储在session
        session("information", $WxUserInfo);//存储在session

        $response_data = $this->cloneRemoteMemberInfo($openid);
        $jifen = $response_data['data']['0']['EnablePoint'];
        $jfrmb = ($jifen/100);
        session("jfrmb", $jfrmb);

        session("cardId", $response_data['data']['0']['CardId']);
        session("response_data",$response_data);
        $cardId = session("cardId");
        if ($cardId) {
            $this->assign("conven_1",$response_data);
            $this->display();
        }else{
            echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
        }
    }
    /*******************************  机场页面 开始****************************************************/
    public function index(){
        $openid= I('get.openid');
        if ($openid){
            $this->display();
        }else{
            $this->wxLogin();
        }
    }
    public function index_copy(){
        $this->display();
    }
    public function content_vip(){
        $type = I('get.type');
        $this->assign('type',$type);
        $this->display();
    }
    public function content_vvip(){
        $type = I('get.type');
        $this->assign('type',$type);
        $this->display();
    }
    public function reserve(){
        $this->display();
    }
    public function population(){
        $openid =session('openid');
        $res = M('jc_reserve')->where(['openid' => $openid,'status'=>'1'])->find();
        $type = I('get.type');
        $this->assign('type',$type);
        $this->assign('res',$res);
        $this->display();
    }
    public function addFlight(){
        $order_sn = $this->createOrderSn();
        $openid =session('openid');
        $response_data =session('response_data');
        $type = I('get.type') == '1' ? "浦东机场" : "虹桥机场";
        if ($_POST){
            $data = [
                    'order_sn'          => $order_sn,
                    'fruition_name'     => I('fruition_name'),
                    'fruition_title'    => I('fruition_title'),
					"fruition_sex"      => I("fruition_sex"),
					"fruition_inter"    => I("fruition_inter"),
					"fruition_city"     => I("fruition_city"),
					"fruition_card_type"     => I("fruition_type"),
					"fruition_Id_card"   => I("fruition_number"),
					"work_name"         => I("work_name"),
					"work_title"        => I("work_title"),
					"work_card_type"      => I("work_type"),
					"work_Id_card"       => I("work_number"),
					"flight_number"     => I("flight_number"),
					"flight_voyage"     => I("flight_voyage"),
					"flight_time"       => I("flight_time"),
					"flight_car_number" => I("flight_car_number"),
					"remark"            => I("remark"),
					"contact"          => I("contacts"),
					"work_unit"         => I("work_unit"),
					"type"              => $type,
					"status"            => 1,
					"openid"            => $openid,
					"mobile"            => $response_data['data']['0']['Mobile'],
					"username"          => $response_data['data']['0']['TrueName'],
            ];
            $res = M('jc_reserve')->add($data);
            if ($res){
                $this->api_success("$order_sn");
            }else{
                $this->api_error();
            }
        }
    }

    public function window(){
        $order_sn = I("get.order_sn");
        $type     = I("get.type");
        $this->assign('res',$order_sn);
        $this->assign('type',$type);
        $this->display();
    }

    public function create_order(){
        $order_sn       = I("get.order_sn");
        $type           = I('post.type') == '1' ? "浦东机场" : "虹桥机场";
        $openid         = session('openid');
        $response_data  = session('response_data');
        $orderInfo = M('jc_order')->where(['order_sn' => $order_sn,'order_status'=>'1'])->find();
        if($orderInfo == null) {
            if ($_POST){
                $data =[
                    'order_sn'      => $order_sn,
                    'pay_sn'        => $order_sn.'_'.'1',
                    'order_status'  => '1',
                    'order_number'  => '1',
                    'member_name'   => $response_data['data']['0']['TrueName'],
                    'openid'        => $openid,
                    'addtime'       => time(),
                    'edittime'      => time(),
                    'member_mobile' => $response_data['data']['0']['Mobile'],
                    'order_type'    => $type,
                    'pay_style'     => '1',
                    'pay_time'      => time(),
                    'member_payment'=> I('price'),
                ];
                $res = M('jc_order')->add($data);
                if ($res){
                    $this->api_success(["order_sn"=>$order_sn]);
                }else{
                    $this->api_error('1');
                }
            }
        $this->display();
        }else{
            $this->api_error('请勿重复提交');
        }

    }
    //微信支付
    public function payInfo()
    {
        $order_sn = I("order_sn");
        $info = M('jc_order')->where(['order_sn' => $order_sn])->find();

        /*//无须支付的 0元订单
        if($info['member_payment'] <= 0)
        {
            $success  = OrderLogic::instance($order_sn)->zero_pay_success();
            if($success) {
                $this->api_success(["need_pay"=>false,"param"=>[]]);
            }else{
                $this->api_error("网络繁忙");
            }
        }*/

        //todo 支付时间控制业务 过期取消订单


        //支付开始
        switch ($info['pay_style']) {
            case "1"://微信JSPAY支付
                $pay = new JsApiPayService($info['openid']);
                break;
            default:
                $this->api_error("异常的支付方式");
        }

        $order_disc = "渠道Plus机场订单 - ".$info['member_name'].$info['order_number']."人";
        try{
            Log::write("微信支付开始：{$info['pay_sn']}.{$info['member_payment']}.{$order_disc}","DEBUG",'File',APP_PATH.'../log/wxJsApi.log');
            $JsApiParameters = $pay->gen_pay($info['pay_sn'],$info['member_payment'],$order_disc);
        } catch (\WxPayException $e){
            $this->api_error($e->getMessage());
        }

        $this->api_success(["need_pay"=>true,"param" => $JsApiParameters]);
    }

    public function order(){
        $order_sn = I('get.order_sn');
        $openid = $_REQUEST['openid'];
        //$openid = 'o1xY9wvrjRPBPUpzCh6y6DSVcnDk';
        $o_state = $_REQUEST['o_state'];

        if ($order_sn){
            M('jc_order')->where(['order_sn'=>$order_sn])->save(['order_status'=>'2']);
            M('jc_reserve')->where(['order_sn'=>$order_sn])->save(['status'=>'2']);
        }


        if ($o_state!= '' && $o_state != '') {
            if ($openid) {
                $orderfood = M('jc_order')
                               ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                               ->where("my_jc_reserve.openid = '$openid' and my_jc_order.order_status='$o_state'")
                               ->field("my_jc_reserve.*,my_jc_order.*")
                               ->order("pay_time desc")
                               ->select();
                $countfood = count($orderfood);
                $this->assign(compact('orderfood','countfood','o_state'));
                $this->display();
            }
        }else {
            if ($openid) {
                $orderfood = M('jc_order')
                    ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                    ->where("my_jc_reserve.openid = '$openid'")
                    ->field("my_jc_reserve.*,my_jc_order.*")
                    ->order("pay_time desc")
                    ->select();
                $countfood = count($orderfood);
                $this->assign(compact('orderfood', 'countfood'));
                $this->display();
            }
        }
    }
    //订单详情
    public function orderDetail(){
        $order_sn = I('get.order_sn');
        //根据订单号查询订单详情
        $orderList = M('jc_order')
                    ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                    ->where("my_jc_order.order_sn = '$order_sn'")
                    ->field("my_jc_reserve.*,my_jc_order.*")
                    ->order("pay_time desc")
                    ->select();
        if ($orderList){
            $this->assign('orderList',$orderList);
            $this->display();
        }else{
            $this->api_error('订单查询失败');
        }
    }
    //	个人中心
    public function center(){
        if ($_REQUEST['openid']) {
            $this->display();
        }else {
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session

            $response_data = $this->cloneRemoteMemberInfo($openid);
            $jifen = $response_data['data']['0']['EnablePoint'];
            $jfrmb = ($jifen/100);
            session("jfrmb", $jfrmb);

            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");
            if ($cardId) {
                $this->assign("conven_1",$response_data);
                $this->display();
            }else{
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }
    // 会员信息
    public function information(){
        if ($_REQUEST['openid']) {
            //微信授权 获取openid
            $openid = session("openid");
            $response_data = $this->cloneRemoteMemberInfo($openid);
            $uriqi=strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            //个人的信息
            $this->assign("age",$age);
            $this->assign("conven_1",$response_data);
            $this->display();
        }else{
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session
            $response_data = $this->cloneRemoteMemberInfo($openid);
            $uriqi=strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            //var_dump($response_data['data']['0']['MemberGroupName']);
            //die();
            //医生的信息
            $this->assign("age",$age);
            $this->assign("conven_1",$response_data);
            $this->display();
        }
    }
    public function feedback(){
        $this->display();
    }
    public function feedback1(){
        $time=Date('Y-m-d H:i:s');
        $data = array(
            'f_name' => $_POST['name'],
            'f_phone' => $_POST['phone'],
            'f_cardid' => $_POST['cardid'],
            'f_text' => $_POST['text'],
            'f_time' => $time,
            'f_source' => '机场',
        );
        $feed = M()->table("my_th_feedback")->add($data);
        if($feed){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }

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

}