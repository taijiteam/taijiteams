<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 1:05 PM
 */

namespace Common\Model;
use mysql_xdevapi\Collection;
use Think\Model;
use Think\Page;

class GoodsModel extends Model
{
    protected $tableName = 'sc_goods';

    private $commonA = ' my_sc_goods_common as a ';
    private $goodsB = ' my_sc_goods as b ';
    private $onGoods = ' on a.goods_common_id = b.goods_common_id ';
    private $join_feild = 'a.*,b.goods_id,b.goods_price,b.goods_storage,b.goods_lock,b.goods_pocket,b.goods_pocket_a,b.goods_pocket_d';
    private $PageClass = null;

    public function __construct()
    {
        parent::__construct();
    }

    /*********  分页套餐 **********************************/
    public function page_list($condition=[],$per_page = 5,$order="goods_id desc",$field='*')
    {
        $this->PageClass = new Page($this->cnt(),$per_page);
        $list = $this->field($field)->where($condition)->order($order)->limit($this->PageClass->firstRow.','.$this->PageClass->listRows)->select();
        return $list;
    }

    public function show_page()
    {
        if($this->PageClass){
            return $this->PageClass->show();
        }else{
            return "";
        }
    }

    public function cnt($condition=[])
    {
        return $this->where($condition)->count();
    }

    /*********  sc_goods表 **********************************/


    public function getGoodsById($goods_id)
    {
        return $this->field('*')->where(["goods_id" => $goods_id])->find();
    }

    public function addGoods($data)
    {
        return $this->add($data);
    }

    public function getGoodsList($condition,$order="goods_id desc",$limit=30)
    {
        return $this->field('*')->where($condition)->order($order)->limit($limit)->select();
    }

    public function online($goods_id){
        return $this->where(["goods_id" => $goods_id])->save(["goods_status" => 2]);
    }

    public function offline($goods_id){
        return $this->where(["goods_id" => $goods_id])->save(["goods_status" => 1]);
    }

    public function lockGoods($goodsInfo,$num)
    {
        $old_storage = $goodsInfo['goods_storage'];
        $old_lock = $goodsInfo['goods_lock'];

        $wh = [
            "goods_id"      =>  $goodsInfo['goods_id'],
            "goods_storage" =>  $old_storage,
            "goods_lock"    =>  $old_lock
        ];

        $updata = [
            "goods_lock"    => $old_lock + $num
        ];
        return $this->where($wh)->save($updata);
    }

    public function unlockGoods($goodsInfo,$num)
    {
        $old_storage = $goodsInfo['goods_storage'];
        $old_lock = $goodsInfo['goods_lock'];

        $wh = [
            "goods_id"      =>  $goodsInfo['goods_id'],
            "goods_storage" =>  $old_storage,
            "goods_lock"    =>  $old_lock
        ];

        $updata = [
            "goods_lock"    => $old_lock - $num
        ];
        return $this->where($wh)->save($updata);
    }

    public function saleGoods($goodsInfo,$num)
    {
        $old_storage = $goodsInfo['goods_storage'];
        $old_lock = $goodsInfo['goods_lock'];
        $old_sale  = $goodsInfo['goods_salenum'];

        $wh = [
            "goods_id"      =>  $goodsInfo['goods_id'],
            "goods_storage" =>  $old_storage,
            "goods_lock"    =>  $old_lock
        ];

        $updata = [
            "goods_storage" => $old_storage - $num,
            "goods_lock"    => $old_lock - $num,
            "goods_salenum" => $old_sale + $num
        ];
        return $this->where($wh)->save($updata);
    }

    /******* 其他 *********************************************************/
    public function addImg($data,$gid)
    {
        return $this->where(['goods_common_id' => $gid])->save($data);
    }


    public function getGoodsEvaluate($gc_id){
        return $this->field('*')->table('my_sc_evaluate')->where(['e_goods_id' => $gc_id])->order('e_star desc')->limit('5')->select();
    }


    public function getGoodsEvaluateCount($gc_id){
        return $this->field('*')->table('my_sc_evaluate')->where(['e_goods_id' => $gc_id])->count();
    }

    ////////   goods_common /////////////////////////////////////////////////////////////////////////////////////
    public function getGoodsCommonById($gc_id)
    {
        return $this->table('my_sc_goods_common')
                    ->join('my_sc_goods on my_sc_goods.goods_common_id = my_sc_goods_common.goods_common_id ')
                    ->field('my_sc_goods_common.*,my_sc_goods.goods_price,my_sc_goods.goods_storage')
                    ->where(['my_sc_goods_common.goods_common_id' => $gc_id])
                    ->find();
    }

    public function getGoodsCommons($condition)
    {
        return $this->table('sc_goods_common')->field('*')->where(["goods_common_id" => $condition])->select();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
    public function getGoodsAll($goods_id)
    {

        return $this->table($this->goodsB)
            ->join($this->commonA .$this->onGoods,'left')
            ->field($this->join_feild)
            ->where(["b.goods_id" => $goods_id])
            ->find();
    }


    public function getGoodsAll2($condition)
    {
        return $this->table($this->goodsB)
            ->join($this->commonA .$this->onGoods,'left')
            ->field($this->join_feild)
            ->where($condition)
            ->select();
    }


}