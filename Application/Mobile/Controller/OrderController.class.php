<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/30
 * Time: 2:34 PM
 */

namespace Mobile\Controller;

use Common\Controller\MobileController;
use Common\Logic\PocketLogic;
use Common\Model\GoodsCommonModel;
use Common\Model\GoodsModel;
use Common\Model\MemberAddressModel;
use Common\Model\MemberModel;
use Common\Logic\OrderLogic;
use Common\Model\OrderModel;
use Common\Service\Pay\JsApiPayService;
use Common\Logic\CartLogic;
use Think\Log;

class OrderController extends MobileController
{
    private $OrderModel;

    public function __construct()
    {
        parent::__construct();
        $this->OrderModel = new OrderModel();
    }

    public function order_list()
    {
        $mid = $this->member_id;
        $res = $this->OrderModel->getOrderStatus($mid);
        $this->assign('list',$res);
        $this->display();

    }

    public function order_obligation()
    {
        $mid = $this->member_id;
        $res = $this->OrderModel->order_obligation($mid);
        $this->assign('res',$res);
        $this->display();
    }

    public function order_received()
    {
        $mid = $this->member_id;
        $res = $this->OrderModel->order_received($mid);
        $this->assign('res',$res);
        $this->display();
    }

    public function order_paid()
    {
        $mid = $this->member_id;
        $res = $this->OrderModel->order_paid($mid);
        $this->assign('res',$res);
        $this->display();
    }
    public function order_closed()
    {
        $mid = $this->member_id;
        $res = $this->OrderModel->order_closed($mid);
        $this->assign('res',$res);
        $this->display();
    }
    public function order_detail()
    {
        $order_sn = I("order_sn");
        $info = $this->OrderModel->getOrderBySn($order_sn);

        $this->assign("order_info",$info);
        $this->assign("deliver_address",json_decode($info['deliver_address'],true));
        $this->assign("deliver_info",[]);
        $this->assign("send_pocket",intval($info['member_payment']/10));

        $GoodsModel = new GoodsModel();
        $goods = $GoodsModel->getGoodsAll($info['goods_id']);
        $this->assign("goods_info",$goods);
        $this->display();
    }

    /********************** 下单流程 *********************************************************/
    //1.进入订单确认页面 选择积分 地址 等确认信息
    public function order_confirm()
    {
        //无论直接提交 还是 购物车选中 都发送 goods / num
        $gid = I('goods_id',0,'int');
        $num = I('num',0,'int');
        if($gid <=0 || $num <=0)
        {
            $this->api_error("非法的参数提交");
        }
        $this->assign("num",$num);


        //获取用户的默认地址
        $Address_model = new MemberAddressModel();
        $addr = $Address_model->getDefault($this->member_id);
        $this->assign("address",$addr);

        //获取运费信息(包邮？运费另外计算？)
        //$shippingFee = 0;

        //获取商品简单信息
        $Goods_model = new GoodsModel();
        $goods = $Goods_model->getGoodsAll($gid);
        $this->assign("goods",$goods);

        $Member_model = new MemberModel();
        $member = $Member_model->member_sort($this->member_id);
        $this->assign("member",$member);

        $member_info = $Member_model->getMemberInfo($this->member_id);
        $this->assign("member_info",$member_info);


        if($goods['goods_pocket_type'] == 201){
            $jiu_sort = $member['a_jiu_sort'] >= $goods['goods_pocket'] ? $goods['goods_pocket'] : $member['a_jiu_sort'];
        }else{
            $jiu_sort = 0;
        }
        $this->assign("default_jiu_sort",$jiu_sort);


        if($member['a_consume_sort'] < 100 && $goods['goods_pocket_d']>0 && $member['a_winning_sort'] > 0){
            $winning_sort = 1;
        }else{
            $winning_sort = 0;
        }
        $this->assign("can_use_winning_sort",$winning_sort);

        $this->display();
    }

    //2.提交生成订单信息 锁住商品 积分扣除 计算支付金额等  最终生成订单号
    public function create_order()
    {
        $gid = intval(I('goods_id'));
        $num = intval(I('num'));
        $address_id = intval(I('address_id'));
        $member_remark = trim(I('member_remark'));

        $pock_type = intval(I('poctet_type'));//类型 A积分
        $pock_val  = intval(I('pocket_val')); //值

        $Member = new MemberModel();
        $memberInfo = $Member->getMemberInfo($this->member_id);
        if(empty($memberInfo)) $this->api_error("用户信息异常");

        if($memberInfo['m_groupname'] == "待审核") {
            $introduce_member = trim(I('introduce_member'));
            if(empty($introduce_member)){
                $this->api_error("推荐人不得为空");
            }
            $introduce = $Member->getMemberInfo(["m_cname" => $introduce_member]);
            //高级顾问 尊享大咖 悦享成员
            if(empty($introduce)) {
                $this->api_error("请填写一个正确的推荐人，需要全名不能有错别字哦");
            }
        }

        $Goods = new GoodsModel();
        $goodsInfo = $Goods->getGoodsAll($gid);
        if(empty($goodsInfo)) $this->api_error("商品信息异常");
        if($goodsInfo['goods_status'] == 1) $this->api_error("商品已下架");


        if($pock_type > 0 && $pock_val >0)
        {
            $PocketLogic = PocketLogic::instance($this->member_id);
            $pock_ok = $PocketLogic->checkPockets($gid,$num,$pock_type,$pock_val);
            if(!$pock_ok) {
                Log::write("$this->member_id $gid $num $pock_type $pock_val","DEBUG",'File',APP_PATH.'../log/member_login.log');
                $err = empty($PocketLogic->ErrMsg) ? "积分不能这么用哦" :$PocketLogic->ErrMsg;
                $this->api_error($err);
            }
        }else{
            $PocketLogic = null;
            $pock_ok = false;
            $pock_type = $pock_val = 0;
        }

        $Address = new MemberAddressModel();
        $addressInfo = $Address->getMemberAddr($address_id,$this->member_id);
        if(empty($addressInfo)) return $this->api_error("地址信息异常");
        $address_json = json_encode(["name"=>$addressInfo['consignee'],"mobile"=>$addressInfo['mobile'],"address"=>$addressInfo["address"]],JSON_UNESCAPED_UNICODE);

        $ret = OrderLogic::instance()->create_order($memberInfo,$goodsInfo,$num,$address_json,$member_remark,$pock_type,$pock_val);
        if($ret){
            if($pock_ok) $PocketLogic->usePocket($pock_type,$pock_val,"order",$ret);
            $this->refresh_cart($gid,$num);
            $this->api_success(["order_sn"=>$ret]);
        }else{
            $this->api_error("订单生成失败");
        }
    }


    private function refresh_cart($goods_id,$num)
    {
        $CartLogic = CartLogic::instance($this->member_id,$goods_id);
        $CartLogic->cutGoodsFromCart($num);
        $CartLogic->updateMemberCart();
    }

    //3.用户选择微信点击支付提交  倒计时30分钟  点击支付 请求JSAPI 获取验签后  再由js唤起支付 提交 等待完成回调 前往订单完成页面
    public function payInfo()
    {
        $order_sn = I("order_sn");
        $info = $this->OrderModel->getOrderBySn($order_sn);

        //无须支付的 0元订单
        if($info['member_payment'] <= 0)
        {
            $success  = OrderLogic::instance($order_sn)->zero_pay_success();
            if($success) {
                $this->api_success(["need_pay"=>false,"param"=>[]]);
            }else{
                $this->api_error("网络繁忙");
            }
        }

        //todo 支付时间控制业务 过期取消订单


        //支付开始
        switch ($info['pay_style']) {
            case "1"://微信JSPAY支付
                $pay = new JsApiPayService($this->member_info['m_openids']);
                break;
            default:
                $this->api_error("异常的支付方式");
        }

        $order_disc = "渠道Plus商城订单 - ".$info['goods_name'].$info['goods_num']."件";
        try{
            Log::write("微信支付开始：{$info['pay_sn']}.{$info['member_payment']}.{$order_disc}","DEBUG",'File',APP_PATH.'../log/wxJsApi.log');
            $JsApiParameters = $pay->gen_pay($info['pay_sn'],$info['member_payment'],$order_disc);
        } catch (\WxPayException $e){
            $this->api_error($e->getMessage());
        }

        $this->api_success(["need_pay"=>true,"param" => $JsApiParameters]);
    }

    //4.用户支付前主动取消订单 或 时间到达后自动变成订单过期取消  返回积分等信息 order_status 0 => 9
    public function cancel_order()
    {
        $order_sn = I('id');
        $ret = OrderLogic::instance($order_sn)->order_canceled();
        if ($ret) {
            $this->api_success();
        } else {
            $this->api_error("操作失败");
        }
    }

    //商家设置发货  order_status 2 => 3  /Admin/Order中

    //6.用户确认收货  order_status 3 => 4
    public function goods_received()
    {
        $order_sn = I('order_sn');
        $ret = OrderLogic::instance($order_sn)->order_received();
        if ($ret) {
            $mid = $this->member_id;
            $res = $this->OrderModel->order_received($mid);
            $this->assign('res',$res);
            $this->display('order/order_received');
        } else {
            $this->api_error("操作失败");
        }
    }


    /***************************************************** 商品订单评论 *******************************************************************/

    //评论页面
    public function comments()
    {
        $gc_id = $_GET['gc_id'];
        $order_sn= $_GET['order_sn'];
        $GoodsCommon_Mobile = new GoodsCommonModel();
        $info = $GoodsCommon_Mobile->getGoodsInfoById($gc_id);
        $this->assign('info',$info);
        $this->assign('order_sn',$order_sn);
        $this->display();
    }

    //添加评论
    public function add_comments()
    {
        $mid = $this->member_id;
        $gc_id = intval(I('gc_id'));
        if ($gc_id <= 0){
            $this->api_error('参数错误');
        }
        $e_text = trim(I('e_text'));
        $main_img = trim(I('main_img'));
        if($main_img){
            $new_dir = "/Public/Uploads/Goods/{$gc_id}/";
            $savepath = APP_PATH."..".$new_dir;
            if(!is_dir($savepath)){
                mkdir($savepath,0777,true);
            }
            $file = explode('.',$main_img);
            $ext  = $file[1];
            $pic_name = md5(time().rand(0,999));
            $new  = $new_dir . $pic_name."." . $ext;
            rename(APP_PATH.'..'.$main_img,APP_PATH.'..'.$new);
            $main_img = $new;
        }
        $star = intval(I('star'));
        if ($star <= 0){
            $this->api_error('请先打分');
        }
        $order_sn = trim(I('order_sn'));
        if (empty($order_sn)){
            $this->api_error('参数错误');
        }
        $MemberModel = new MemberModel();
        $memberInfo = $MemberModel->getMemberInfo($mid);
        if (!empty($memberInfo))
        {
           $data = [
                'e_star' =>$star,
                'e_goods_id' => $gc_id,
                'e_keywords' => '',
                'e_text' => $e_text,
                'e_name' => $memberInfo['m_cname'],
                'e_headimg' => $memberInfo['m_img'],
                'e_main_img' => $main_img,
                'e_mid' => $mid,
                'e_time' =>time(),
                'e_status' => 1,
                'e_onumber' => $order_sn,
           ];

           $res = $this->OrderModel->addComments($data);
           if ($res)
           {
               OrderLogic::instance($order_sn)->order_completed();
               $this->api_success();
           }else
           {
               $this->api_error('评论失败');
           }
        }
    }


}