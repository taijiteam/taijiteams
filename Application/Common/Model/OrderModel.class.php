<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 7:51 PM
 */

namespace Common\Model;
use Think\Model;
use Think\Page;

class OrderModel extends Model {

    protected $tableName = 'sc_order';

    private $PageClass = null;

    public function page_list($condition=[],$per_page = 5,$order="order_id desc",$field='*')
    {
        $this->PageClass = new Page($this->cnt(),$per_page);
        $list = $this->field($field)->where($condition)->order($order)->limit($this->PageClass->firstRow.','.$this->PageClass->listRows)->select();
        return $list;
    }

    public function operationCnt_list($condition=[])
    {
        $User = M('sc_order'); // 实例化User对象
        $count      = $User->where($condition)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        return $show;
    }
    public function operationPage_list($condition=[],$per_page = 25,$order="pay_time desc",$field='*')
    {
        $this->PageClass = new Page($this->cnt(),$per_page);
        $list = M('sc_order')->field($field)->where($condition)->order($order)->limit($this->PageClass->firstRow.','.$this->PageClass->listRows)->select();
        return $list;
    }


    public function airportCnt_list($condition=[])
    {
        $User = M('jc_order'); // 实例化User对象
        $count      = $User->where($condition)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        return $show;
    }
    public function airportPage_list($condition=[],$per_page = 25,$order="pay_time desc",$field='*')
    {
        $this->PageClass = new Page($this->airportCnt(),$per_page);
        $list = M('jc_order')->field($field)->where($condition)->order($order)->limit($this->PageClass->firstRow.','.$this->PageClass->listRows)->select();
        return $list;
    }

    public function getOrder()
    {
        $status = [4,13];
        return $this->table("my_sc_order")
            ->join("my_sc_pocket_log on my_sc_order.order_sn = my_sc_pocket_log.frm_data")
            ->where(['my_sc_order.order_status' =>['in',$status]])
            ->field("my_sc_order.*,my_sc_pocket_log.*")
            ->select();
    }


    public function orderDetail($order_sn,$source)
    {
        switch ($source){
            case '机场':
                return $this->table('my_jc_order')
                    ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                    ->field("my_jc_reserve.*,my_jc_order.*")
                    ->where(['my_jc_order.order_sn' => $order_sn])
                    ->find();
                break;
            case '商城':
                return $this->table('my_sc_order')
                    ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
                    ->where(["my_sc_order.order_sn" => $order_sn])
                    ->field('my_sc_order.*,my_sc_goods_common.*')
                    ->find();
                break;
                default;
        }

    }
    public function order_obligation($mid)
    {
        return $this->table('my_sc_order')
                    ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
                    ->where("order_status < 3 AND my_sc_order.member_id = {$mid}")
                    ->field('my_sc_order.*,my_sc_goods_common.*')
                    ->select();
    }
    public function order_paid($mid)
    {
        return $this->table('my_sc_order')
                    ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
                    ->where("order_status = 3 AND my_sc_order.member_id = {$mid}")
                    ->field('my_sc_order.*,my_sc_goods_common.*')
                    ->select();
    }
    public function order_received($mid)
    {
        return $this->table('my_sc_order')
                    ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
                    ->where("order_status = 4 AND my_sc_order.member_id = {$mid}")
                    ->field('my_sc_order.*,my_sc_goods_common.*')
                    ->select();
    }
    public function order_closed($mid)
    {
        $status = [6,9];
        return $this->table('my_sc_order')
                    ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
                    //->where("order_status = {'in',$status} AND my_sc_order.member_id = {$mid}")
                    ->where(["order_status" =>['in',$status],"my_sc_order.member_id" => $mid])
                    ->field('my_sc_order.*,my_sc_goods_common.*')
                    ->select();
    }
    public function show_page()
    {
        if($this->PageClass){
            return $this->PageClass->show();
        }else{
            return "";
        }
    }

    public function goods_num($gc_id)
    {
        return $this->where(['goods_common_id' => $gc_id])->sum('goods_num');
    }


    public function cnt($condition=[])
    {
        return $this->where($condition)->count();
    }
    public function airportCnt($condition=[])
    {
        return M('jc_order')->where($condition)->count();
    }

    public function create_order($order){
        return $this->add($order);
    }

    public function getOrderBySn($order_sn)
    {
        return $this->where(["order_sn" => $order_sn])->find();
    }

    public function getOrderById($order_sn)
    {
        return $this->where(["order_id" => $order_sn])->find();
    }

    public function getOrderByPaySn($order_sn)
    {
        return $this->where(["pay_sn" => $order_sn])->find();
    }

    public function setOrderStatus($id)
    {
        return $this->where(['order_id'=> $id])->save(['order_status' => 10]);
    }


    public function getOrderStatus($mid)
    {
        return $this->table('my_sc_order')
            ->join('my_sc_goods_common on my_sc_goods_common.goods_common_id = my_sc_order.goods_common_id')
            ->where("my_sc_order.order_status < 10 AND my_sc_order.member_id = {$mid}")
            ->field('my_sc_order.*,my_sc_goods_common.*')
            ->order('my_sc_order.addtime desc')
            ->select();
    }

    public function order_detail($order_id,$source)
    {       $Model = new Model();
            switch ($source){
                case '商城':
                    return $this->field('*')->where(['order_id' => $order_id])->find();
                    break;
                case '机场':
                    return $Model->table('my_jc_order')->where(['id' => $order_id])->find();
                    break;
                case '美食':
                    return $Model->table('my_fc_order')->where(['o_id' => $order_id])->find();
                    break;
                case '医疗':
                    return $Model->table('my_order')->where(['order_Id' => $order_id])->find();
                    break;
                case '活动':
                    return $Model->table('my_hd_order')->where(['o_id' => $order_id])->find();
                    break;
                    default;
            }


    }

    public function search($source,$data)
    {
        $Model = new Model();
        switch ($source){
            case "商城":
                if ($data['audit'] == "7"){
                    $data['audit'] = "13";
                }
                if ($data['o_phone'] == "" && $data['o_number'] == "" && $data['audit']!= "" ){
                    $res = $Model->table('my_sc_order')
                        ->where(['order_status' => $data['audit']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_phone'] == "" && $data['o_number'] != "" ) {
                    $res = $Model->table('my_sc_order')
                        ->where(['order_sn' => $data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number'] == "" && $data['o_phone'] != "" ){
                    $res = $Model->table('my_sc_order')
                        ->where(['member_mobile' => $data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_phone'] == "" && $data['o_number'] != "" && $data['audit'] != ""  ){
                    $res = $Model->table('my_sc_order')
                        ->where(['order_status' => $data['audit'],'order_sn'=>$data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_sc_order')
                        ->where(['order_sn' => $data['o_number'],'member_mobile'=>$data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_number'] == "" && $data['audit']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_sc_order')
                        ->where(['order_status' => $data['audit'],'member_mobile'=>$data['o_phone']])
                        ->select();
                    return $res;
                }else{
                    $res = $Model->table('my_sc_order')
                        ->where(['order_status' => $data['audit'],'member_mobile'=>$data['o_phone'],'order_sn'=>$data['o_number']])
                        ->select();
                    return $res;
                }

                break;
            case "活动":
                if ($data['o_phone'] == "" && $data['o_number'] == "" && $data['audit']!= "" ){
                    $res = $Model->table('my_hd_order')
                        ->where(['o_state' => $data['audit']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_phone'] == "" && $data['o_number'] != "" ) {
                    $res = $Model->table('my_hd_order')
                        ->where(['o_number' => $data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number'] == "" && $data['o_phone'] != "" ){
                    $res = $Model->table('my_hd_order')
                        ->where(['o_phone' => $data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_phone'] == "" && $data['o_number'] != "" && $data['audit'] != ""  ){
                    $res = $Model->table('my_hd_order')
                        ->where(['o_state' => $data['audit'],'o_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_hd_order')
                        ->where(['o_number' => $data['o_number'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_number'] == "" && $data['audit']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_hd_order')
                        ->where(['o_state' => $data['audit'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }else{
                    $res = $Model->table('my_hd_order')
                        ->where(['o_state' => $data['audit'],'o_phone'=>$data['o_phone'],'o_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }

                break;
            case "医疗":
                if ($data['o_phone'] == "" && $data['o_number'] == "" && $data['audit']!= "" ){
                    $res = $Model->table('my_order')
                        ->where(['order_state' => $data['audit']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_phone'] == "" && $data['o_number'] != "" ) {
                    $res = $Model->table('my_order')
                        ->where(['order_number' => $data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number'] == "" && $data['o_phone'] != "" ){
                    $res = $Model->table('my_order')
                        ->where(['o_phone' => $data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_phone'] == "" && $data['o_number'] != "" && $data['audit'] != ""  ){
                    $res = $Model->table('my_order')
                        ->where(['order_state' => $data['audit'],'order_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_order')
                        ->where(['order_number' => $data['o_number'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_number'] == "" && $data['audit']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_order')
                        ->where(['order_state' => $data['audit'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }else{
                    $res = $Model->table('my_order')
                        ->where(['order_state' => $data['audit'],'o_phone'=>$data['o_phone'],'order_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }
                break;
            case "美食":
                if ($data['audit'] == "4"){
                    $data['audit'] = "3";
                }
                if ($data['o_phone'] == "" && $data['o_number'] == "" && $data['audit']!= "" ){
                    $res = $Model->table('my_th_order')
                        ->where(['o_state' => $data['audit']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_phone'] == "" && $data['o_number'] != "" ) {
                    $res = $Model->table('my_th_order')
                        ->where(['o_number' => $data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number'] == "" && $data['o_phone'] != "" ){
                    $res = $Model->table('my_th_order')
                        ->where(['o_phone' => $data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_phone'] == "" && $data['o_number'] != "" && $data['audit'] != ""  ){
                    $res = $Model->table('my_th_order')
                        ->where(['o_state' => $data['audit'],'o_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }elseif($data['audit'] == "" && $data['o_number']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_th_order')
                        ->where(['o_number' => $data['o_number'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }elseif($data['o_number'] == "" && $data['audit']!= ""  && $data['o_phone']!= "" ){
                    $res = $Model->table('my_th_order')
                        ->where(['o_state' => $data['audit'],'o_phone'=>$data['o_phone']])
                        ->select();
                    return $res;
                }else{
                    $res = $Model->table('my_th_order')
                        ->where(['o_state' => $data['audit'],'o_phone'=>$data['o_phone'],'o_number'=>$data['o_number']])
                        ->select();
                    return $res;
                }
                break;
            default: ;
        }
    }





    /*******************************     活动订单审核  *******************************************/
    public function getActivityOrder(){
        $status = [4,7];
        $Model = new Model();
        $res = $Model->table('my_hd_order')->where(['o_state' => ['in',$status]])->select();
        return $res;
    }
    //更改活动订单状态
    public function setOrderStatusActivityAudit($id,$orderStatus){
        $Model = new Model();
        $orderStatus = $Model->table("my_hd_order")->where(['o_id'=>$id])->save(['o_state'=>$orderStatus]);
        return $orderStatus;
    }
    /*******************************     活动订单审核  *******************************************/
    public function getDoctorOrder(){
        $status = [4,7];
        $Model = new Model();
        $res = $Model->table('my_order')->where(['order_state' => ['in',$status]])->select();
        return $res;
    }
    //更改活动订单状态
    public function setOrderStatusDoctorAudit($id,$orderStatus){
        $Model = new Model();
        $orderStatus = $Model->table("my_order")->where(['order_Id'=>$id])->save(['order_state'=>$orderStatus]);
        return $orderStatus;
    }
    /*******************************     活动订单审核  *******************************************/
    public function getProjectOrder(){
        $status = [3,7];
        $Model = new Model();
        $res = $Model->table('my_th_order')->where(['o_state' => ['in',$status]])->select();
        return $res;
    }
    //更改活动订单状态
    public function setOrderStatusProjectAudit($id,$orderStatus){
        $Model = new Model();
        $orderStatus = $Model->table("my_th_order")->where(['o_id'=>$id])->save(['o_state'=>$orderStatus]);
        return $orderStatus;
    }
    /*******************************     机场订单审核  *******************************************/
    public function getAirportOrder(){
        //$status = [3,7];
        $Model = new Model();
        $res = $Model->table('my_jc_order')
                    ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                    ->field("my_jc_reserve.*,my_jc_order.*")
                    ->order("pay_time desc")
                    ->select();
        return $res;
    }
    public function airportCount(){
        $User = M('jc_order'); // 实例化User对象
        $count = $User->table('my_jc_order')
                    ->join('my_jc_reserve on  my_jc_order.order_sn = my_jc_reserve.order_sn','left')
                    ->field("my_jc_reserve.*,my_jc_order.*")
                    ->order("pay_time desc")
                    ->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        return $show;
    }
    //更改活动订单状态
    public function setOrderStatusAirportAudit($id,$orderStatus){
        $Model = new Model();
        $orderStatus = $Model->table("my_jc_order")->where(['id'=>$id])->save(['order_status'=>$orderStatus]);
        return $orderStatus;
    }

    /******************************      商品添加评论   *************************************/

    public function addComments($data)
    {
        $Model = new Model();
        $res = $Model->table('my_sc_evaluate')->add($data);
        return $res;
    }

    /*******************************     订单审核  *******************************************/
    public function goToAudit($data){
        $Model = new Model();
        $res = $Model->table('my_th_audit')->data($data)->add();
        return $res;
    }
    //更改商城订单状态
    public function setOrderStatusAudit($id,$orderStatus,$source){
        $Model = new Model();
        switch ($source){
            case "商城":
                $orderStatus = $this->where(['order_id'=>$id])->save(['order_status'=>$orderStatus]);
                return $orderStatus;
            break;
            case "活动":
                $orderStatus = $Model->table("my_hd_order")->where(['o_id'=>$id])->save(['o_state'=>$orderStatus]);
                return $orderStatus;
            break;
            case "医疗":
                $orderStatus = $Model->table("my_order")->where(['order_Id'=>$id])->save(['order_state'=>$orderStatus]);
                return $orderStatus;
            break;
            case "美食":
                $orderStatus = $Model->table("my_th_order")->where(['o_id'=>$id])->save(['o_state'=>$orderStatus]);
                return $orderStatus;
            break;
            case "机场":
                $orderStatus = $Model->table("my_jc_order")->where(['id'=>$id])->save(['order_status'=>$orderStatus]);
                return $orderStatus;
            break;
            default: ;
        }

    }
    //获取已审核的订单
    public function getOrderStatusAudit($source){
        switch ($source){
            case "商城":
                $orderListAudit = $this->table('my_sc_order')
                    ->join('my_sc_audit on my_sc_order.order_id = my_sc_audit.order_id')
                    ->where(['my_sc_order.order_status'=>12])
                    ->field("my_sc_order.*,my_sc_audit.*")
                    ->select();
                return $orderListAudit;
            break;
            case "活动":
                $orderListAudit = $this->table('my_hd_order')
                    ->join('my_hd_activityAudit on my_hd_order.o_id = my_hd_activityAudit.order_id','right')
                    ->where(['my_hd_order.o_state'=>6])
                    ->field("my_hd_order.*,my_hd_activityAudit.*")
                    ->select();
                return $orderListAudit;
            break;
            case "医疗":
                $orderListAudit = $this->table('my_order')
                    ->join('my_doctor_audit on my_order.order_Id = my_doctor_audit.order_id','right')
                    ->where(['my_order.order_state'=>6])
                    ->field("my_order.*,my_doctor_audit.*")
                    ->select();
                return $orderListAudit;
            break;
            case "美食":
                $orderListAudit = $this->table('my_th_order')
                    ->join('my_th_audit on my_th_order.o_id = my_th_audit.order_id','right')
                    ->where(['my_th_order.o_state'=>6])
                    ->field("my_th_order.*,my_th_audit.*")
                    ->select();
                return $orderListAudit;
            break;
            case "机场":
                $orderListAudit = $this->table('my_jc_order')
                    ->join('my_th_audit on my_jc_order.id = my_th_audit.order_id','right')
                    ->where(['my_jc_order.order_status'=>6,'source'=>'机场'])
                    ->field("my_jc_order.*,my_th_audit.*")
                    ->select();
                return $orderListAudit;
            break;
            default: ;
        }

    }
    //驳回已审核的订单
    public function delOrderAudit($id,$source){
        $Model = new Model();
        switch ($source) {
            case "商城":
                $rejectOrder = $Model->table('my_sc_audit')->where(['order_id' => $id])->delete();
                return $rejectOrder;
            break;
            case "活动":
                $rejectOrder = $Model->table('my_hd_activityAudit')->where(['order_id' => $id])->delete();
                return $rejectOrder;
            break;
            case "医疗":
                $rejectOrder = $Model->table('my_doctor_audit')->where(['order_id' => $id])->delete();
                return $rejectOrder;
            break;
            case "美食":
                $rejectOrder = $Model->table('my_project_audit')->where(['order_id' => $id])->delete();
                return $rejectOrder;
            break;
            case "机场":
                $rejectOrder = $Model->table('my_th_audit')->where(['order_id' => $id])->delete();
                return $rejectOrder;
            break;
            default: ;
        }
    }
}