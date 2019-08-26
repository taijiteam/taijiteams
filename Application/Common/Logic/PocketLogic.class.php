<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 5:32 PM
 */

/**
 * Pocket  积分  分四大类   金额积分都保存在用户表身上
 *
 * PocketA  a
 *          积累-1.购买商品返点  2.购买身份会员充值  3.签到.....
 *          使用-普通商品可以用抵扣 商品需要设置A标签
 *
 *
 * PocketB  b1   b2   b3
 *      积累-被邀请用户直接有
 *      使用-对某种类型进行优惠抵扣的积分   商品需要设置 B1   B2  B3 标签
 *
 * PocketC  c
 *          积累-游客每日签到
 *          使用-游客每日签到的积分  可用于兑换  商品打C标签
 *
 *
 *
 * PocketD  d
 *          累积-？
 *          使用-提现的积分   达到某一个条件 就可以提现   和商品无关
 *
 */

namespace Common\Logic;

use Common\Model\GoodsModel;
use Common\Model\MemberModel;

class PocketLogic
{

    private $mid;

    private $Member_model;

    private $pocketA;

    private $pocketB;

    private $pocketB1;

    private $pocketB2;

    private $pocketB3;

    private $pocketC;

    private $pocketD;

    const POCKET_A      = 1;     //A积分
    const POCKET_B1     = 201;   //酒积分
    const POCKET_B2     = 202;
    const POCKET_B3     = 203;
    const POCKET_C      = 3;
    const POCKET_D      = 4;

    private function __construct($mid)
    {
        $this->mid = $mid;

        $this->Member_model = new MemberModel();
        $info = $this->Member_model->member_sort($this->mid);

        $this->pocketA = intval($info['a_consume_sort']);
        $this->pocketB1 = intval($info['a_jiu_sort']);
        $this->pocketB2 = 0;
        $this->pocketB3 = 0;
        $this->pocketB = $this->pocketB1 + $this->pocketB2 + $this->pocketB3;
        $this->pocketD = intval($info['a_winning_sort']);
    }


    public static function instance($mid){
        $instance = new PocketLogic($mid);
        return $instance;
    }

//    /**
//     * 每日签到
//     */
//    public function daily_sign()
//    {
//
//    }

    public function getTotalPocket(){
        return $this->pocketA + $this->pocketB + $this->pocketC + $this->pocketD;
    }

    public function getPocketA(){
        return $this->pocketA;
    }

    public function getPocketB(){
        return $this->pocketB;
    }

    public function getPocketB1(){
        return $this->pocketB1;
    }

    public function getPocketB2(){
        return $this->pocketB2;
    }

    public function getPocketB3(){
        return $this->pocketB3;
    }

    public function getPocketC(){
        return $this->pocketC;
    }

    public function getPocketD(){
        return $this->pocketD;
    }

    public function sendPocket($type,$points,$frm,$frm_data='',$admin_id=0)
    {
        switch ($type)
        {
            case self::POCKET_A:
                $res = $this->Member_model->add_consume_sort($this->mid,$this->pocketA,$points);
                break;
            case self::POCKET_B1:
                $res = $this->Member_model->add_jiu_sort($this->mid,$this->pocketB1,$points);
                break;
            case self::POCKET_D:
                $res = $this->Member_model->add_winning_sort($this->mid,$this->pocketD,$points);
                break;
            default:
                return false;
        }
        if($res) {
            $this->pocket_log($this->mid,$type,$points,0,$frm,$frm_data,$admin_id);
        }else{
            return false;
        }
        return true;
    }

    public function usePocket($type,$points,$frm,$frm_data='',$admin_id = 0)
    {
        switch ($type)
        {
            case self::POCKET_A:
                $res = $this->Member_model->use_consume_sort($this->mid,$this->pocketA,$points);
                break;
            case self::POCKET_B1:
                $res = $this->Member_model->use_jiu_sort($this->mid,$this->pocketB1,$points);
                break;
            case self::POCKET_D:
                $res = $this->Member_model->use_winning_sort($this->mid,$this->pocketD,$points);
                break;
            default:
                return false;
        }

        if($res) {
            $this->pocket_log($this->mid,$type,$points,1,$frm,$frm_data,$admin_id);
        }else{
            return false;
        }
        return true;
    }

    private function pocket_log($mid,$type,$points,$act,$frm='admin',$frm_data='',$admin_id=0)
    {
        $data = [
            "mid" => $mid,
            "pocket_type" => $type,
            "pocket_value" => $points,
            "pocket_act" => $act,
            "pocket_frm" => $frm,
            "frm_data" => $frm_data,
            "admin_id"  => $admin_id,// 0:系统发送
            "addtime"   => time()
        ];
       $this->Member_model->pocket_log($data);
    }


    public function checkPockets($gid,$goods_num,$want_type, $want_use)
    {
        $Goods  = new GoodsModel();
        $info   = $Goods->getGoodsAll($gid);

        $type   = $info['goods_pocket_type'];
        if($want_type != self::POCKET_A && $want_type != self::POCKET_D && $want_type != $type) {
            //$want_type 不是A  那  如果不是商品指定的可用积分类型  就返回错误
            $this->ErrMsg = "这个商品不支持当前选择的积分";
            return false;
        }

        switch ($want_type){
            case self::POCKET_A:
                $max_use = intval($info['goods_pocket_a'] * $goods_num);
                return $this->checkPocketA($want_use,$max_use);
            case self::POCKET_B1:
                $max_use = intval($info['goods_pocket'] * $goods_num);
                return $this->checkPocketB1($want_use,$max_use);
            case self::POCKET_D:
                $max_use = intval($info['goods_pocket_d'] * $goods_num);
                return $this->checkPocketD($want_use,$max_use);
            default:
                return false;
        }
    }


    private function checkPocketA($want_to_use,$max_use)
    {
        if($this->pocketA < $want_to_use){
            $this->ErrMsg = "您账户中只有{$this->pocketA}点消费积分";
            return false; //A积分不足 $want_to_use
        }

        if($want_to_use > $max_use) {
            $this->ErrMsg = "这个订单最高只能使用{$max_use}点消费积分";
            return false; //不能使用超过 $max_use的
        }

        return true;
    }


    private function checkPocketB1($want_to_use,$max_use)
    {
        if($this->pocketB1 < $want_to_use){
            $this->ErrMsg = "您账户中只有{$this->pocketB1}点尊享积分";
            return false; //酒积分不足 $want_to_use
        }

        if($want_to_use > $max_use) {
            $this->ErrMsg = "这个订单最高只能使用{$max_use}点尊享积分";
            return false; //不能使用超过 $max_use的
        }

        return true;
    }


    private function checkPocketD($want_to_use,$max_use)
    {
        if($this->pocketB1 < $want_to_use){
            $this->ErrMsg = "您账户中只有{$this->pocketB1}点奖励积分";
            return false; //酒积分不足 $want_to_use
        }

        if($want_to_use > $max_use) {
            $this->ErrMsg = "这个订单最高只能使用{$max_use}点奖励积分";
            return false; //不能使用超过 $max_use的
        }

        return true;
    }

    public $ErrMsg = '';
}