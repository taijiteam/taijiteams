<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 8:41 AM
 *
 *  商品规格管理
 */

namespace Admin\Controller;

use Common\Controller\BaseController;
use Think\Model;
use Common\Model\GoodsSpecModel;

class GoodsSpecController extends BaseController
{
    private $Spec_model = null;

    public function __construct()
    {
        parent::__construct();
        $this->Spec_model = new GoodsSpecModel();
    }

    public function class_list(){
        $this->assign("list",$this->Spec_model->spec_class())->display();
    }

    public function spec_list(){
        $this->assign("list",$this->Spec_model->spec_values())->display();
    }

    public function spec_table()
    {
        $spec = I('spec_class_ids');
        $cnt = count($spec);
        if($cnt > 2 || $cnt <= 0) {
            $this->api_error("请至少选一个或最多三个规格");
        }

        $spec_class_name = [];
        $spec_class_id   = [];
        foreach ($spec as $k => $v){
            $spec_class_name[] = $v;
            $spec_class_id[] = $k;
        }

        $spec_class_name[] = "售价";
        $spec_class_name[] = "库存";
        $spec_class_name[] = "B积分(B1-酒/B2..)";
        $spec_class_name[] = "A积分";

        $spec_class_id[] = "goods_price";
        $spec_class_id[] = "goods_storage";
        $spec_class_id[] = "goods_pocket";
        $spec_class_id[] = "goods_pocket_a";

        $data = ["spec_class_name"=>$spec_class_name,"spec_class_id"=>$spec_class_id];
        $this->api_success($data);
    }
}