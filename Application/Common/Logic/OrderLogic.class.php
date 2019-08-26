<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 3:21 PM
 */

namespace Common\Logic;

use Common\Model\GoodsModel;
use Common\Model\OrderModel;

class OrderLogic
{
    private $order_info = [];
    private $order_id   = [];

    const orderCreated   = 1;
    const orderPaid      = 2;
    const orderDelivered = 3;
    const orderReceived  = 4;
    const orderCompleted = 6;
    const orderCanceled  = 9;

    const POCKET_A = 1;
    const POCKET_B1 = 201;
    const POCKET_D  = 4;


    private $Order_model = null;

    private static $stInstance = null;

    private function __construct($data = '',$data_type='order_sn')
    {
        $this->Order_model = new OrderModel();
        if($data !== '')
        {
            if($data_type == 'order_sn'){
                $this->order_info  = $this->Order_model->getOrderBySn($data);
                $this->order_id    = $this->order_info['order_id'];
            }
            elseif($data_type == 'order_id')
            {
                $this->order_info  = $this->Order_model->getOrderById($data);
                $this->order_id    = $this->order_info['order_id'];
            }
            elseif($data_type == 'pay_sn')
            {
                $this->order_info  = $this->Order_model->getOrderByPaySn($data);
                $this->order_id    = $this->order_info['order_id'];
            }
        }
    }

    public static function instance($data = '',$data_type='order_sn')
    {
        if(self::$stInstance == null) {
            self::$stInstance = new OrderLogic($data,$data_type);
        }
        return self::$stInstance;
    }


    public function create_order($buyer_info,$goodsInfo,$goods_num,$addressInfo,$member_remark,$pocket_type,$pocket_val)
    {
        if(empty($buyer_info)) return false;

        if($goods_num > $goodsInfo['goods_storage'] - $goodsInfo['goods_lock']) return false;

        $order = $this->order_data($buyer_info,$goodsInfo,$goods_num,$addressInfo,$member_remark,$pocket_type,$pocket_val);

        //事务
        $order_create_ok = $this->Order_model->create_order($order);
        $Goods   = new GoodsModel();
        $lock_goods_ok    = $Goods->lockGoods($goodsInfo,$goods_num);
        //事务
        if($order_create_ok && $lock_goods_ok){
            return $order['order_sn'];
        }else{
            return false;
        }
    }

    private function order_data($memberInfo,$goodsInfo,$goods_num,$address,$member_remark,$pocket_type,$pocket_val)
    {
        $now = time();
        $order = [];
        $order["order_sn"]      = $this->createOrderSn();
        $order["order_status"]  = 1;   //'订单状态 1:待支付  2:已支付  3:订单完成  9:用户取消'

        $order["member_id"]     = $memberInfo['m_id'];
        $order["member_name"]   = $memberInfo['m_cname'];
        $order["member_mobile"] = $memberInfo['m_phone'];
        $order["member_remark"] = $member_remark;
        $order["goods_id"]      = $goodsInfo['goods_id'];
        $order["goods_common_id"]=$goodsInfo["goods_common_id"];
        $order["goods_name"]    = $goodsInfo["goods_name"];
        $order["goods_num"]     = $goods_num;
        $order["goods_price"]   = $goodsInfo["goods_price"];

        $order["deliver_address"] = $address;
        $order["deliver_price"] = 0;

        $order["total_price"]   = $this->calculate_order_price($goodsInfo,$goods_num,$order["deliver_price"]);
        $order["pay_style"]     = 1;       //支付方式 1：微信
        $order["pay_sn"]      = $this->createPaySn($order["order_sn"],$order["pay_style"]);

        $order["member_payment"]= $this->calculate_payment($order["total_price"],$pocket_type,$pocket_val);//用户需要支付的金额
        $order["pocket_type"]   = $pocket_type;//用户使用的优惠类型  1: A积分
        $order["pocket_value"]  = $pocket_val;//使用的积分

        $order["addtime"]       = $now;
        $order["edittime"]      = $now;

        $order["introduce_member"]   = trim(I('introduce_member'));
        $order["introduce_remark"]   = trim(I('introduce_remark'));
        return $order;
    }

    public function order_canceled()
    {
       if($this->order_info['order_status'] == self::orderCanceled)
       {
           return true;
       }elseif($this->order_info['order_status'] == self::orderCreated)
       {
           $cancel = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderCanceled]);

           $Goods   = new GoodsModel();
           $goodsInfo = $Goods->getGoodsAll($this->order_info['goods_id']);
           $unlock_goods_ok = $Goods->unlockGoods($goodsInfo,$this->order_info['goods_num']);

           if($this->order_info['pocket_type'] > 0 && $this->order_info['pocket_value'] > 0){
                $pocket_back_ok = PocketLogic::instance($this->order_info['member_id'])->sendPocket($this->order_info['pocket_type'], $this->order_info['pocket_value'],'order_cancel',$this->order_info['order_sn']);
           }else{
                $pocket_back_ok  = true;
           }


           if($cancel && $unlock_goods_ok && $pocket_back_ok) return true;
       }else{
           return false;
       }
    }

    public function pay_success()
    {
        if ($this->order_info['order_status'] == self::orderCreated)
        {
            $paid = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderPaid ,"pay_time" => time()]);

            $point = intval($this->order_info['member_payment'] / 10);
            $pocket_send_ok = PocketLogic::instance($this->order_info['member_id'])->sendPocket(1,$point,'bonus',$this->order_info['order_sn']);

            $Goods  = new GoodsModel();
            $goodsInfo = $Goods->getGoodsAll($this->order_info['goods_id']);
            $sale_goods_ok  = $Goods->saleGoods($goodsInfo,$this->order_info['goods_num']);

            if($paid && $pocket_send_ok && $sale_goods_ok){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function zero_pay_success()
    {
        if ($this->order_info['order_status'] == self::orderCreated)
        {
            $paid = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderPaid ,"pay_time" => time()]);

            $Goods  = new GoodsModel();
            $goodsInfo = $Goods->getGoodsAll($this->order_info['goods_id']);
            $sale_goods_ok  = $Goods->saleGoods($goodsInfo,$this->order_info['goods_num']);

            if($paid && $sale_goods_ok){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function order_delivered()
    {
        if($this->order_info['order_status']== self::orderPaid)
        {
            $completed = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderDelivered ,"edittime" => time()]);
            if($completed) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function order_received()
    {
        if($this->order_info['order_status'] >= self::orderDelivered)
        {
            $completed = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderReceived ,"edittime" => time()]);
            if($completed) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }


    public function order_completed()
    {
        if($this->order_info['order_status'] >= self::orderReceived)
        {
            $completed = $this->Order_model->where(['order_id'=> $this->order_id])->save(['order_status' => self::orderCompleted ,"edittime" => time()]);
            if($completed) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    //逾期未支付
    private function isExpireToPay()
    {
        return $this->order_info['order_status']==self::orderCreated && $this->order_info['addtime'] + 60 * 30 > time();
    }

    //已支付
    private function isPayed()
    {
        return $this->order_info['order_status'] >= self::orderPaid && $this->order_info['order_status'] <= self::orderReceived;
    }

    //生成订单号
    private function createOrderSn()
    {
        $d = date('Ymd');
        $cnt = $this->Order_model->cnt(['addtime'=>['gt',strtotime($d)]]);
        $order_sns=sprintf("%04d", $cnt);
        return date('YmdHis') . $order_sns . rand(111,999);
    }

    public function createPaySn($order_sn,$pay_style)
    {
        return $order_sn.'_'.$pay_style;
    }

    //订单价格计算器
    private function calculate_order_price($goods,$num,$deilver){
        return $goods['goods_price'] * $num + $deilver;
    }

    //实际支付计算器
    private function calculate_payment($order_price,$pocket_type,$pocket_value)
    {
        switch ($pocket_type){
            case self::POCKET_A:
                return intval($order_price - $pocket_value);
            case self::POCKET_B1:
                return intval($order_price - $pocket_value);
            case self::POCKET_D:
                return intval($order_price - $pocket_value);
            default:
                return $order_price;
        }
    }
}