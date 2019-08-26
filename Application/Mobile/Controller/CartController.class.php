<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 10:52 AM
 */

namespace Mobile\Controller;

use Common\Controller\MobileController;
use Common\Logic\CartLogic;
use Common\Model\CartModel;
use Common\Model\GoodsModel;

class CartController extends MobileController
{
    private $gid;

    private $num;

    private $CartLogic;

    public function __construct()
    {
        parent::__construct();

        $goods_id = intval(I('goods_id'));
        $this->gid = $goods_id > 0 ? $goods_id:1;

        $num = intval(I('num'));
        $this->num = $num > 0 ?  $num : 1;

        if(strtolower(ACTION_NAME) !== 'index') {
            $this->CartLogic = CartLogic::instance($this->member_id,$this->gid);
        }
    }

    public function index()
    {
        $this->display();
    }

    public function getUserCart()
    {
        $Cart_model = new CartModel();
        $cart_info = $Cart_model->getUserCart($this->member_id);
        if(empty($cart_info)) {
            $this->api_success();
        }

        $cart = json_decode($cart_info['cart'],true);
        if(empty($cart['cart'])) {
            $this->api_success();
        }

        $gids = [];
        foreach ($cart['cart'] as $k => $v)
        {
            $gids[] = $k;
        }

        $Goods = new GoodsModel();
        $goodsList = $Goods->getGoodsAll2(["b.goods_id" => ['in',$gids]]);

        $goods = [];
        foreach ($goodsList as $goods_items)
        {
            $goods[$goods_items['goods_id']] = $goods_items;
        }

        $ret = [];
        foreach ($cart['cart'] as $k => $v)
        {
            $goods[$k]["num"] = $v['num'];
            $ret[] = $goods[$k];
        }

        $this->api_success($ret);
    }

    public function add()
    {
        $goods = $this->CartLogic->getGoodsInfo();
        if (empty($goods)) {
            $this->api_error("异常的商品参数:商品不存在");
        } elseif ($goods['goods_storage'] < $this->num) {
            $this->api_error("数量库存不足");
        }elseif($goods['goods_status'] != 2){
            $this->api_error("商品已下架");
        }

        $this->CartLogic->addGoodsToCart($this->num);
        $res = $this->CartLogic->updateMemberCart();

        if($res){
            $this->api_success($res);
        }else{
            $this->api_error("网络错误"); //购物车修改异常
        }
    }

    public function addOne()
    {
        $goods = $this->CartLogic->getGoodsInfo();
        if (empty($goods) || $goods['goods_status'] != 2) {
            $this->api_error("商品不存在或已下架");
        }

        $old_cart = $this->CartLogic->getCartInfo();
        $old_num = $old_cart['cart'][$this->gid]['num'];
        if($goods['goods_storage'] <= $old_num) {
            $this->api_error("已达到库存最大值");
        }
        $this->CartLogic->addGoodsToCart(1);
        $res = $this->CartLogic->updateMemberCart();

        if($res){
            $this->api_success($res);
        }else{
            $this->api_error("网络错误"); //购物车修改异常
        }
    }

    public function cutOne()
    {
        $goods = $this->CartLogic->getGoodsInfo();
        if (empty($goods)) {
            $this->api_error("商品不存在或已下架");
        }

        $old_cart = $this->CartLogic->getCartInfo();
        $old_num = $old_cart['cart'][$this->gid]['num'];
        if($old_num <= 1) {
            $this->api_error("商品已经到达最小值");
        }
        $cut = $this->CartLogic->cutGoodsFromCart(1);
        if(!$cut){
            $this->api_error("我们正在删除购物车，请勿重复点击");
        }
        $res = $this->CartLogic->updateMemberCart();

        if($res){
            $this->api_success($res);
        }else{
            $this->api_error("网络错误"); //购物车修改异常
        }
    }

    public function clean()
    {
        $goods = $this->CartLogic->getGoodsInfo();
        if (empty($goods)) {
            $this->api_error("异常的数据:商品不存在");
        }

        $old_cart = $this->CartLogic->getCartInfo();
        $old_num = $old_cart['cart'][$this->gid]['num'];

        $this->CartLogic->cutGoodsFromCart($old_num);
        $res = $this->CartLogic->updateMemberCart();
        if($res){
            $this->api_success($res);
        }else{
            $this->api_error("网络错误"); //购物车修改异常
        }
    }
}