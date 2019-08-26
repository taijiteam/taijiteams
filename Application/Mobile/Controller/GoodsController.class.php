<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/31
 * Time: 4:54 PM
 */
namespace Mobile\Controller;

use Common\Controller\BaseController;
use Common\Model\GoodsModel;
use Common\Model\CartModel;
use Common\Model\MemberModel;
use Common\Model\OrderModel;
use function Sodium\add;

class GoodsController extends BaseController
{

    private $Goods_model;
    private $Order_model;
    private $Member_model;

    public function __construct()
    {
        parent::__construct();
        $this->Goods_model = new GoodsModel();
        $this->Order_model = new OrderModel();
        $this->Member_model =new MemberModel();
    }

    //商品详情页面  这里没有用到
    public function index()
    {
//        $this->display();
        echo "暂未开放";exit;
    }

    //商品详情页面
    public function detail()
    {
        $gc_id = I('gc_id');
        $mid = session("member_id");
        $goods_common     = $this->Goods_model->getGoodsCommonById($gc_id);
        $goods_list       = $this->Goods_model->getGoodsList(["goods_common_id" => $gc_id]);
        $goods_num        = $this->Order_model->goods_num($gc_id);
        $collect          = $this->Member_model->collectInfo($gc_id,$mid);
        $spec_name = json_decode($goods_common['spec_name'],true);
        $spec_value = json_decode($goods_common['spec_value'],true);
        $spec_goods = [];
        foreach ($goods_list as $goods_item)
        {
            $sps_key = "";
            $sps = json_decode($goods_item['goods_spec'],true);
            foreach ($sps as $k => $sp){
                $sps_key = $sps_key .'_'. key($sp);
            }
            $spec_goods[trim($sps_key,'_')] = [
                'goods_id'=>$goods_item['goods_id'],
                'goods_storage'=>$goods_item['goods_storage'],
                "goods_price"=>$goods_item['goods_price'],
                "goods_pocket"  => $goods_item['goods_pocket'],
                "goods_pocket_type"=> $goods_common["goods_pocket_type"],
                "goods_pocket_a"  => $goods_item['goods_pocket_a'],
                "goods_pocket_d"  => $goods_item['goods_pocket_d'],
            ];
        }

        $goods_evaluate   = $this->Goods_model->getGoodsEvaluate($gc_id);
        $goods_evaluate_count   = $this->Goods_model->getGoodsEvaluateCount($gc_id);
        $this->assign('goods_evaluate',$goods_evaluate);
        $this->assign('goods_evaluate_count',$goods_evaluate_count);
        $this->assign('goods_common',$goods_common);
        $this->assign('goods_num',$goods_num);
        $this->assign('collect',$collect);


        if(count($spec_name) == 1){
            $this->assign("spec_cnt",1);
            $spec_class_id = key($spec_name);
            $this->assign("spec_info",$spec_value[$spec_class_id]);
            $this->assign("spec_goods",json_encode($spec_goods));
        }else{
            $this->assign("spec_cnt",2);
            $this->assign("spec_name",$spec_name);
            $this->assign("spec_info",$spec_value);
            $this->assign("spec_goods",json_encode($spec_goods));
        }

        $mid = session("member_id");
        if($mid)
        {
            $Cart = new CartModel();
            $carts = $Cart->getUserCart($mid);
            if(!empty($carts)) {
                $cart_detail = json_decode($carts['cart'],true);
                $cart_num = count($cart_detail['cart']);
            }
        }
        $this->assign("cart_num",isset($cart_num) ? $cart_num : 0);
        $this->assign("mid", $mid > 0 ? $mid : 0);
        $this->display('index');
    }
}