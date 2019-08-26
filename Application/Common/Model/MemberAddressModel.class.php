<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/1
 * Time: 9:22 AM
 */
namespace Common\Model;
use Think\Model;

class MemberAddressModel extends Model
{
    protected $tableName = 'sc_address';

    public function member_address($mid)
    {
        $data = [1,2];
        $ret = $this->table('my_sc_address')->where(['mid'=>$mid,'addr_status'=>1])->order('is_default desc')->select();
        if(empty($ret)){
            return [];
        }else{
            return $ret;
        }
    }

    public function getMemberAddr($address_id,$mid)
    {
        $ret = $this->field('*')->where(["id"=>$address_id,"mid"=>$mid])->find();
        if(empty($ret)){
            return [];
        }else{
            return $ret;
        }
    }

    public function getDefault($mid)
    {
        $ret = $this->table('my_sc_address')->where([ 'mid'=>$mid, "is_default" => 1])->find();
        if(empty($ret)){
            return [];
        }else{
            return $ret;
        }
    }

    public function setDefault($address_id,$mid)
    {
        $this->where(["mid"=>$mid])->save(["is_default" => 0]);
        $set   = $this->where(["id" => $address_id])->save(["is_default" => 1]);
        //$set   = $this->where(["id" => $address_id])->find();
        if($set){
            return true;
        }else{
            return false;
        }
    }

    public function addAdress($data)
    {
        return $this->add($data);
    }




}