<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 10:56 AM
 */
namespace Common\Logic;

use Common\Model\CartModel;
use Common\Model\GoodsModel;

class CartLogic
{

    private $mid = 0;
    private $goods_id = 0;
    private $cart_id = 0;

    private $cart_info = null;
    private $goods_info = null;

    private $Cart_model = null;
    private $Goods_model = null;

    private static $stInstance = null;

    private function __construct($member_id,$goods_id)
    {
        $this->mid      = intval($member_id);
        $this->goods_id = intval($goods_id);
        $this->Cart_model  = new CartModel();
        $this->Goods_model = new GoodsModel();
        $this->cart_info();
    }

    public static function instance($member_id,$goods_id){
        if(self::$stInstance == null) {
            self::$stInstance = new CartLogic($member_id,$goods_id);
        }
        return self::$stInstance;
    }


    public function getGoodsInfo(){
        return $this->goods_info;
    }

    public function getCartInfo(){
        return $this->cart_info;
    }

    //当前用户和旧购物车信息
    private function cart_info()
    {
        if($this->mid <= 0) {
            return false;
        }

        if($this->goods_id <= 0) {
            return false;
        }

        //商品信息
        $this->goods_info = $this->Goods_model->getGoodsById($this->goods_id);


        //购物车信息
        $cart = $this->Cart_model->getUserCart($this->mid);
        if(empty($cart)) {
            $this->cart_info = [];
        } else {
            $this->cart_id = $cart['id'];
            $this->cart_info = json_decode($cart['cart'],true);
        }
    }


    //更新用户购物车信息
    public function updateMemberCart()
    {
        if($this->cart_id)
        {
            $updata = ["id" => $this->cart_id , "cart" => json_encode($this->cart_info)];
            return $this->Cart_model->updateCart($updata);
        } else {
            $addata = ["mid" => $this->mid , "cart" => json_encode($this->cart_info)];
            return $this->Cart_model->addCart($addata);
        }
    }

    public function addGoodsToCart($num)
    {
        if(isset($this->cart_info['cart'][$this->goods_id]))
        {
            //减去原来价格
            $this->cart_info['total_price'] = $this->cart_info['total_price'] - $this->cart_info['cart'][$this->goods_id]['goods_price'] * $this->cart_info['cart'][$this->goods_id]['num'];
            //更新价格和数量
            $this->cart_info['cart'][$this->goods_id]['num'] = $this->cart_info['cart'][$this->goods_id]['num'] + $num;
            $this->cart_info['cart'][$this->goods_id]['goods_price'] = $this->goods_info['goods_price'];
        }else {
            $this->cart_info['cart'][$this->goods_id] = ['goods_price' => $this->goods_info['goods_price'], "num" => $num];
        }

        //计算新总价
        $this->cart_info['total_price'] = $this->cart_info['total_price'] + $this->cart_info['cart'][$this->goods_id]['goods_price'] * $this->cart_info['cart'][$this->goods_id]['num'];

        return $this->cart_info;
    }

    public function cutGoodsFromCart($num)
    {
        if(isset($this->cart_info['cart'][$this->goods_id]))
        {
            //减去原来价格
            $this->cart_info['total_price'] = $this->cart_info['total_price'] - $this->cart_info['cart'][$this->goods_id]['goods_price'] * $this->cart_info['cart'][$this->goods_id]['num'];
            //更新价格和数量
            $this->cart_info['cart'][$this->goods_id]['num'] = $this->cart_info['cart'][$this->goods_id]['num'] - $num;
            $this->cart_info['cart'][$this->goods_id]['goods_price'] = $this->goods_info['goods_price'];

            if($this->cart_info['cart'][$this->goods_id]['num'] <= 0)
            {
                unset($this->cart_info['cart'][$this->goods_id]);
            } else
            {
                $this->cart_info['total_price'] = $this->cart_info['total_price'] + $this->cart_info['cart'][$this->goods_id]['goods_price'] * $this->cart_info['cart'][$this->goods_id]['num'];
            }

            return true;
        }else{
            return false;
        }
    }
}