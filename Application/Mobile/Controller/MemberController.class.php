<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/31
 * Time: 5:29 PM
 */
namespace Mobile\Controller;
use Common\Controller\MobileController;

use Common\Model\MemberModel;
class MemberController extends MobileController
{

    private $Member_model;

    public function __construct()
    {
        parent::__construct();
        $this->Member_model = new MemberModel();
    }

    //个人中心
    public function index()
    {
        $memberInfo = $this->Member_model->getMemberInfo($this->member_id);
        $this->assign("member",$memberInfo);
        $this->display();
    }


    /******************************************     积分   ************************************************************/

    public function integral()
    {
        $pocket_type = intval(I('integral_type'));
        $pocket_type = $pocket_type <= 0 ? 0 : $pocket_type;

        $mid = $this->member_id;
        if ($mid) {
            $memberInfo =   $this->Member_model->getMemberInfo($mid);
            $info = $this->Member_model->member_sort($mid);
            $consumption = $this->Member_model->consumptionInfo($mid,$pocket_type);
            $this->assign('info', $info);
            $this->assign('memberInfo', $memberInfo);
            $this->assign('integral_type',$pocket_type);
            $this->assign('consumption', $consumption);
        }

        $this->display();
    }

    public function service_rules(){
        $mid = $this->member_id;
        $memberInfo =   $this->Member_model->getMemberInfo($mid);
        $this->assign('memberInfo', $memberInfo);
        $this->display();
    }

/*************************************** 商品收藏 *******************************************************************************/
    //商品收藏
    public function setCollect()
    {
        $gc_id = I('gc_id');
        $mid   = $this->member_id;
        if ($mid){
            $collectInfo = $this->Member_model->collectInfo($gc_id,$mid);
            if (!empty($collectInfo))
            {
                if ($collectInfo['0']['is_collect'] == '1')
                {
                    $res = $this->Member_model->cou_collect($gc_id,$mid);
                    $this->api_success($res);
                }else if ($collectInfo['0']['is_collect'] == '0')
                {
                    $res = $this->Member_model->set_collect($gc_id,$mid);
                    $this->api_success($res,'is_collect');
                }
            }else{
                $data=['mid'=>$mid,'goods_id'=>$gc_id,'is_collect'=>1,'addtime'=>time(),'eddtime'=>time()];
                $this->Member_model->add_collect($data);
                $this->api_success();
            }
        }
    }


    //收藏页面
    public function collect()
    {
        $mid   = $this->member_id;
        $collectInfo = $this->Member_model->collectList($mid);
        $gc_id = [];
        foreach ($collectInfo as $item)
        {
            $gc_id[] = $item['goods_id'];
        }
        if (!empty($gc_id)){
            $collect = $this->Member_model->collect($gc_id,$mid);
            $this->assign('collect',$collect);
            $this->display();
        }else{
            $this->display();
        }


    }




}