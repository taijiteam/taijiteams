<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/30
 * Time: 7:21 PM
 */

namespace Common\Model;
use Think\Model;

class GoodsSpecModel extends Model
{
    public function spec_class($wh=[],$order="id asc",$limit=false){
        return $this->table('my_sc_goods_spec_class')->where($wh)->order($order)->limit($limit)->select();
    }

    public function spec_values(){
        return $this->table('my_sc_goods_spec as a')
                ->field('a.*,b.spec_class_name')
                ->join('my_sc_goods_spec_class as b on a.spec_class_id = b.id','LEFT')
                ->select();
    }

    public function spec_name($spec_class_ids){
        $spec_name = [];
        $spec = $this->spec_class(['id'=>['in',$spec_class_ids]],"id desc");
        foreach ($spec as $v) {
            $spec_name[$v['id']] = $v['spec_class_name'];
        }
        return json_encode($spec_name);
    }


    public function find_spec($condition)
    {
        return $this->table('my_sc_goods_spec')->where($condition)->find();
    }

    public function find_class($condition)
    {
        return $this->table('my_sc_goods_spec_class')->where($condition)->find();
    }

    public function addSpec_v($v,$class_id)
    {
        $spec = ["spec_value" => $v , "spec_class_id" => $class_id];
        return $this->table('my_sc_goods_spec')->add($spec);
    }

    public function addSpec_c($class_name){
        return $this->table('my_sc_goods_spec_class')->add(["spec_class_name" => $class_name]);
    }


    public function spec_format($spec)
    {
        $goods =[];
        $spec_names = [];
        $spec_values = [];
        foreach ($spec as $k => $v)
        {
            $kr = explode('.',$k);
            $idx = $kr[0];
            $key = $kr[1];
            if(is_numeric($key))
            {
                $spec_class_id = $kr[1];
                $spec_value = $v;

                //spec_name
                if(!isset($spec_names[$spec_class_id]))
                {
                    $c = $this->find_class(["id" => $spec_class_id]);
                    $spec_names[$spec_class_id] = $c['spec_class_name'];
                }


                $find = $this->find_spec(['spec_value' => $spec_value,'spec_class_id'=>$spec_class_id]);
                if(empty($find)) {
                    $spec_value_id = $this->addSpec_v($spec_value,$spec_class_id);
                }else{
                    $spec_value_id = $find['id'];
                }
                $goods[$idx]["spec"][] = [$spec_value_id => $spec_value];


                $spec_values[$spec_class_id][$spec_value_id]=$spec_value;

            }else{
                $goods[$idx][$key] = $v;
            }
        }

        $spec_format = ["spec_name"=>$spec_names,"spec_value"=>$spec_values,"goods_list"=>$goods];

        return $spec_format;
    }

}