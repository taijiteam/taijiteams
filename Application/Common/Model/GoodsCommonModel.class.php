<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 1:05 PM
 */

namespace Common\Model;
use Think\Model;
use Think\Page;

class GoodsCommonModel extends Model
{

    protected $tableName = 'sc_goods_common';  //ModelClass名称如果和表有不同 就需要手动设置
    private $PageClass = null;

    public function page_list($condition=[],$per_page = 5,$order="goods_common_id desc",$field='*')
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


    public function getGoodsById($goods_id)
    {
        return $this->table('my_sc_goods_common')
            ->join('my_sc_goods on my_sc_goods.goods_common_id = my_sc_goods_common.goods_common_id ')
            ->where(["my_sc_goods_common.goods_common_id" => $goods_id])
            ->find();
    }


    public function goodsList($condition= [],$order="my_sc_goods.goods_id desc"){
        return $this->table('my_sc_goods_common')
            ->join('my_sc_goods on my_sc_goods.goods_common_id = my_sc_goods_common.goods_common_id')
            ->field('my_sc_goods_common.*,my_sc_goods.goods_price')
            ->where([$condition,'my_sc_goods_common.goods_status' => 2])
            ->group('my_sc_goods_common.goods_common_id')
            ->order($order)
            ->select();
    }

    public function goodsSearch($goods_name){
        $data['goods_name'] = array('like', "%$goods_name%");
        return $this->table('my_sc_goods_common')
            ->join('JOIN my_sc_goods on my_sc_goods.goods_common_id = my_sc_goods_common.goods_common_id','RIGHT')
            ->field('my_sc_goods_common.*,my_sc_goods.goods_price')
            ->where(['my_sc_goods_common.goods_name' => $data['goods_name'],'is_hidden'=>0,'my_sc_goods_common.goods_status' => 2])
            ->select();
    }

    public function goodsCate($cate){
        $ret = $this->field("*")->where(['goods_category'=> $cate,'is_hidden'=>0,'goods_status' => 2])->select();
        if(empty($ret)){
            return [];
        }else{
            return $ret;
        }
    }


    public function getGoodsInfoById($goods_id)
    {
        return $this->field('*')->where(["goods_common_id" => $goods_id])->find();
    }

    public function addGoods($data)
    {
        return $this->add($data);
    }

    public function saveGoods($data,$gc_id)
    {
        return $this->where(['goods_common_id' => $gc_id])->save($data);
    }


    public function savePhoto($gc_id,$PHOTO){
        return $this->where(['goods_common_id' => $gc_id])->save($PHOTO);
    }

    public function findAddress($a_id){
        return $this->table('my_sc_address')->where(['id' => $a_id])->find();
    }

    public function saveAddress($id,$data){
        return $this->table('my_sc_address')->where(['id' => $id])->save($data);
    }



    public function addImg($data,$gid)
    {
        return $this->add($data);
    }


    public function online($gc_id)
    {
        return $this->where(['goods_common_id' => $gc_id])->save(['goods_status' => 2]);
    }

    public function offline($gc_id)
    {
        $res = $this->where(['goods_common_id' => $gc_id])->save(['goods_status' => 1]);
        if($res) {
            $Model = new Model();
            $Model->table('my_sc_goods')->where(['goods_common_id' => $gc_id])->save(['goods_status' => 1]);
        }
        return $res;
    }
}