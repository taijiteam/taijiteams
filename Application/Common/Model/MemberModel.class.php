<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/30
 * Time: 3:16 PM
 */
namespace Common\Model;
use Think\Model;

class MemberModel extends Model
{
    protected $tableName = 'merber';  //ModelClass名称如果和表有不同 就需要手动设置

    public function  getMemberInfo($params)
    {
        if(is_numeric($params)){
            $mid = $params;
            return $this->field('*')->where(['m_id' => $mid])->find();
        }else{
            $condition = $params;
            return $this->field('*')->where($condition)->find();
        }
    }
    public function  getMemberInfoOpenid($params)
        {
          return $this->field('*')->where(['m_openids' => $params])->find();

        }


    public function update_member($wh,$updata)
    {
        return $this->where($wh)->save($updata);
    }


    public function add_member($data)
    {
        $add = [
            "m_cname"       =>  $data['TrueName'],
            "m_phone"       =>  $data['Mobile'],
            "m_groupname"   =>  $data['MemberGroupName'],
            "m_openids"     =>  $data['ThirdOpenId'],
            "m_num"         =>  $data['CardId']
        ];
        return $this->add($add);
    }

    /***** 积分 *****************************************************************************************/
    public function all_sort($mid)
    {
         return $info = $this->table('my_merber')
                    ->join('my_sort on my_sort.a_aid = my_merber.m_id')
                    ->field('my_sort.*,my_merber.m_cname')
                    ->where(['my_merber.m_id' => $mid])
                    ->find();
    }


    public function member_sort($mid)
    {
        $info = $this->table('my_merber')
                ->join('my_sort on my_sort.a_aid = my_merber.m_id')
                ->field('my_sort.*,my_merber.m_cname')
                ->where(['my_merber.m_id' => $mid])
                ->find();
        if(!empty($info))
        {
            return $info;
        }

        $sort = $this->table("my_sort")->where(['a_aid' => $mid])->find();
        if(empty($sort)){
            $data["a_aid"] = $mid;
            $Model = new Model();
            $Model->table("my_sort")->add($data);

            $info = $this->table('my_merber')
            ->join('my_sort on my_sort.a_aid = my_merber.m_id')
            ->field('my_sort.*,my_merber.m_cname')
            ->where(['my_merber.m_id' => $mid])
            ->find();
            return $info;
        }else{
            return [];//用户信息异常
        }
    }

    /************ 积分变更  以及 记录  **************************************************/
    //使用A积分 消费积分
    public function use_consume_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid ,"a_consume_sort" => $old])->save(["a_consume_sort"=> intval($old - $use)]);
    }

    public function add_consume_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid, "a_consume_sort" => $old])->save(["a_consume_sort"=> intval($old + $use)]);
    }


    //酒积分 B1  尊享积分
    public function use_jiu_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid ,"a_jiu_sort" => $old])->save(["a_jiu_sort"=> intval($old - $use)]);
    }

    public function add_jiu_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid ,"a_jiu_sort" => $old])->save(["a_jiu_sort"=> intval($old + $use)]);
    }


    //奖励积分 D
    public function use_winning_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid ,"a_winning_sort" => $old])->save(["a_winning_sort"=> intval($old - $use)]);
    }

    public function add_winning_sort($mid,$old,$use)
    {
        $Model = new Model();
        return $Model->table('my_sort')->where(["a_aid" => $mid ,"a_winning_sort" => $old])->save(["a_winning_sort"=> intval($old + $use)]);
    }


    public function pocket_log($data)
    {
        $Model = new Model();
        $Model->table('my_sc_pocket_log')->add($data);
    }

    //积分消费记录
    public function consumptionInfo($mid,$pocket_type = 0){
        if($pocket_type > 0) {
            return $this->consumptionInfoSave($mid,$pocket_type);
        }else{
            return $this->table('my_sc_pocket_log')->field('*')->where(['mid' => $mid])->order('addtime desc')->select();
        }
    }

    public function consumptionInfoSave($mid,$pocket_type){
        if(is_numeric($pocket_type)) {
            $pocket_type = [$pocket_type];
        }
        return $this->table('my_sc_pocket_log')->field('*')->where(['mid' => $mid,'pocket_type' => ['in',$pocket_type]])->order('addtime desc')->select();
    }

    //积分消费总记录
    public function sortAll()
    {
        return  $this->table('my_sc_pocket_log')
            ->join('my_merber on my_sc_pocket_log.mid = my_merber.m_id')
            ->join('my_sc_order on my_sc_pocket_log.frm_data = my_sc_order.order_sn')
            ->field('my_sc_pocket_log.*,my_merber.*,my_sc_order.*')
            //->field('my_sc_order.order_sn,member_name,member_mobile,goods_name,my_sc_pocket_log.pocket_act,my_sc_pocket_log.pocket_value,my_sc_order.pay_style,my_sc_order.addtime')
            ->order('my_sc_pocket_log.addtime desc')
            ->select();
    }
    public function sortAllType($order_type)
    {
        switch ($order_type){
                case '1':
                return  $this->table('my_sc_pocket_log')
                    ->join('my_merber on my_sc_pocket_log.mid = my_merber.m_id')
                    ->join('my_sc_order on my_sc_pocket_log.frm_data = my_sc_order.order_sn')
                    ->field('my_sc_order.order_sn,member_name,member_mobile,goods_name,my_sc_pocket_log.pocket_act,my_sc_pocket_log.pocket_value,my_sc_order.pay_style,my_sc_order.addtime')
                    ->where(['my_sc_pocket_log.pocket_act' => 0])
                    ->order('my_sc_pocket_log.addtime desc')
                    ->select();
                break;
                case '2':
                return  $this->table('my_sc_pocket_log')
                    ->join('my_merber on my_sc_pocket_log.mid = my_merber.m_id')
                    ->join('my_sc_order on my_sc_pocket_log.frm_data = my_sc_order.order_sn')
                    ->field('my_sc_order.order_sn,member_name,member_mobile,goods_name,my_sc_pocket_log.pocket_act,my_sc_pocket_log.pocket_value,my_sc_order.pay_style,my_sc_order.addtime')
                    ->where(['my_sc_pocket_log.pocket_act' => 1])
                    ->order('my_sc_pocket_log.addtime desc')
                    ->select();
                break;
                case '3':
                    return  $this->table('my_sc_pocket_log')
                        ->join('my_merber on my_sc_pocket_log.mid = my_merber.m_id')
                        ->join('my_sc_order on my_sc_pocket_log.frm_data = my_sc_order.order_sn')
                        ->field('my_sc_order.order_sn,member_name,member_mobile,goods_name,my_sc_pocket_log.pocket_act,my_sc_pocket_log.pocket_value,my_sc_order.pay_style,my_sc_order.addtime')
                        ->order('my_sc_pocket_log.addtime desc')
                        ->select();
                break;
                case '4':
                return  $this->table('my_merber')
                    ->join('my_sort on my_merber.m_id = my_sort.a_aid')
                    ->field('my_merber.m_id,m_sex,m_integrals,m_phone,m_cname,my_sort.*')
                    ->order('my_merber.m_time desc')
                    ->field('my_merber.m_cname,m_sex,m_phone,my_sort.a_jiu_sort,a_jichang_sort,a_doctor_sort,a_consume_sort,a_jinbi_sort,my_merber.m_integrals')
                    ->select();
                break;
                default;
        }

    }


    /******************************************** 商品收藏   sc_collect表 **********************************************************************/

    public function collectInfo($gc_id,$mid)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')->where(['goods_id' => $gc_id,'mid'=>$mid])->select();
    }

    public function cou_collect($gc_id,$mid)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')->where(['goods_id' => $gc_id,'mid'=>$mid])->save(['is_collect'=>0]);
    }

    public function set_collect($gc_id,$mid)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')->where(['goods_id' => $gc_id,'mid'=>$mid])->save(['is_collect'=>1]);
    }

    public function add_collect($data)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')->add($data);
    }

    //收藏商品列表
    public function collectList($mid)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')->where(['mid'=>$mid,'is_collect'=>1])->select();
    }

    public function collect($gc_id,$mid)
    {
        $Model = new Model();
        return $Model->table('my_sc_collect')
                     ->join('my_sc_goods on my_sc_goods.goods_common_id = my_sc_collect.goods_id')
                     ->join('my_sc_goods_common on my_sc_goods.goods_common_id = my_sc_goods_common.goods_common_id')
                     ->field('my_sc_collect.*,my_sc_goods.*,my_sc_goods_common.*')
                     ->where(['my_sc_goods_common.goods_common_id'=>['in',$gc_id],'mid'=>$mid])
                     ->select();
    }
}