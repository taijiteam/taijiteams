<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 7:43 PM
 *
 *
 * 商品管理  goods_common  goods
 */

namespace Admin\Controller;
use Common\Controller\BaseController;
use Common\Model\GoodsCommentModel;
use Common\Model\GoodsCommonModel;
use Common\Model\GoodsModel;
use Common\Logic\GoodsLogic;
use Common\Model\GoodsSpecModel;
class GoodsController extends BaseController
{
    private $GoodsSpec_model;
    private $Goods_Common_Model;
    private $Goods_Model;

    public function __construct()
    {
        parent::__construct();
        $this->Goods_Model = new GoodsModel();
        $this->Goods_Common_Model = new GoodsCommonModel();
        $this->GoodsSpec_model = new GoodsSpecModel();
    }

    public function goodsList(){
        $goodsList = $this->Goods_Common_Model->page_list(["goods_status"=>['lt',3]],15);
        $goods_page = $this->Goods_Common_Model->show_page();
        if ($goodsList)
        {
            $this->assign('goods_page',$goods_page);
            $this->assign('goodsList',$goodsList);
            $this->display();
        }
    }

    public function goods_search(){
        $goods_name = $this->goodsName;
        $goodsList = $this->Goods_Common_Model->goodsSearch($goods_name);
        if ($goodsList)
        {
            //$this->assign('$goodsList',$goodsList);
            $this->api_success($goodsList,'加载中...');
            $this->display();
        }else{
            $this->api_error('系统正忙，请稍后重试');
        }
    }

    public function goodsInfo(){
        $gc_id = $_GET['gc_id'];
        $info = $this->Goods_Common_Model->getGoodsById($gc_id);
        if ($info) $this->api_success($info);

    }

    /*************** 商品添加 *******************************************************/
    public function add()
    {
        //exit();
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $specs = $this->GoodsSpec_model->spec_class();
            $this->assign("spec_list",$specs);
            $this->display();
        } else {
            $spec = I('spec_info');
            $goods_spec = $this->GoodsSpec_model->spec_format($spec);
            if( empty($goods_spec['spec_name']) || empty($goods_spec['spec_value']) || empty($goods_spec["goods_list"]) ){
                $this->api_error("请先选择规格并填写规格再提交");
            }
            $goods_list = $goods_spec["goods_list"];

            $goods_common = $this->goods_common_add($goods_spec);
            if(!$goods_common) $this->api_error("添加失败");

            foreach ($goods_list as $goods)
            {
                $res = $this->goods_detail_add($goods,$goods_common);
                if(!$res) $this->api_error("商品详情生成异常");
            }

            $this->api_success();
        }
    }

    private function goods_common_add($goods_spec)
    {
        $goods_name =  trim(I('goods_name'));
        if(!$goods_name) $this->api_error("商品名称不能为空");
        $goods_code =  trim(I('goods_code'));
        if(!$goods_code) $this->api_error("商品编号不能为空");
        $goods_unit =  trim(I('goods_unit'));
        $goods_unit = $goods_unit ? $goods_unit : "件";



        $goodsData = [
            'goods_name'            => $goods_name,
            'goods_code'            => $goods_code,//商品编号
            'goods_unit'            => $goods_unit,//单位名称
            'main_img'              => '',
            'main2_img'             => '',
            'main3_img'             => '',
            'main4_img'             => '',
            'main5_img'             => '',
            'desc_img'              => '',
            'adve_img'              => '',
            'goods_remark'          => trim(I('goods_remark')),   //详情
            'goods_status'          => 1, //1:默认下架 2:上架 3:删除
            'is_hidden'             => I('is_hidden') ?  1 : 0,
            'goods_store'           => "渠道PLUS",
            'goods_category'        => I('goods_category'), //分类
            'goods_addtime'         => TIMESTAMP,
            'goods_edittime'        => TIMESTAMP,
            'goods_pocket_type'    => I('goods_pocket_type') ? intval(I('goods_pocket_type')) : 0,          //积分类型  1:A积分
            'spec_name'             => json_encode($goods_spec['spec_name'],JSON_UNESCAPED_UNICODE),   //规格属性信息
            'spec_value'            => json_encode($goods_spec['spec_value'],JSON_UNESCAPED_UNICODE),  //规格详情信息
        ];
        //var_dump($goodsData);exit();
        $gc_id = $this->Goods_Common_Model->addGoods($goodsData);
        if ($gc_id) {
            $goodsData['goods_common_id'] = $gc_id;
            $this->save_goods_pic($gc_id);
            return $goodsData;
        } else {
           return false;
        }
    }

    private function save_goods_pic($gc_id,$old_goods = [])
    {
        $save = [];
        $img_field = ["main_img","main2_img","main3_img","main4_img","main5_img","desc_img","adve_img"];
        foreach ($img_field as $name)
        {
            $temp = I($name);//   /Public/Uploads/Temp/3374d24032e5a13881adfedbb73f8faf.jpeg
            if(empty($temp) || $temp == $old_goods[$name]) continue;
            $new_dir = "/Public/Uploads/Goods/{$gc_id}/";
            $savepath = APP_PATH."..".$new_dir;
            if(!is_dir($savepath)){
                mkdir($savepath,0777,true);
            }
            $file = explode('.',$temp);
            $ext  = $file[1];
            $new  = $new_dir . "{$name}." . $ext;
            rename(APP_PATH.'..'.$temp,APP_PATH.'..'.$new);
            $save[$name] = $new."?v=".time();
        }

        if(!empty($save)){
            $this->Goods_Common_Model->saveGoods($save,$gc_id);
        }
    }

    private function goods_detail_add($goods,$goods_common)
    {
        $data = [
            'goods_common_id'   =>      $goods_common['goods_common_id'],
            'goods_name'        =>      $goods_common['goods_name'],
            'goods_spec'        =>      json_encode($goods['spec'],JSON_UNESCAPED_UNICODE),
            'goods_price'       =>      intval($goods['goods_price']),
            'goods_pocket'      =>      intval($goods['goods_pocket']),
            'goods_pocket_a'     =>     intval($goods['goods_pocket_a']),
            'goods_storage'     =>      intval($goods['goods_storage']),
            'goods_salenum'     =>      0,
            'goods_lock'        =>      0,
            'goods_status'      =>      1, //1:默认下架 2:上架 3:删除
            'addtime'           =>      TIMESTAMP,
            'edittime'          =>      TIMESTAMP,
        ];

        //忽略没有价格或库存的数据
        if($data['goods_price'] <=0 || $data['goods_storage'] <=0) {
            return true;
        }

        $g_id = $this->Goods_Model->add($data);
        if($g_id) {
            return $g_id;
        }else{
            return false;
        }
    }
   /****************** 图片修改  不改状态 ***********************************/
    public function save_img()
    {
        $gc_id = I('get.gc_id');
        $old_goods = [];
        $save = [];
        $img_field = ["main_img","main2_img","main3_img","main4_img","main5_img","desc_img","adve_img"];
        //var_dump($img_field);exit();
        foreach ($img_field as $name)
        {
            $temp = I($name);//   /Public/Uploads/Temp/3374d24032e5a13881adfedbb73f8faf.jpeg
            if(empty($temp) || $temp == $old_goods[$name]) continue;
            $new_dir = "/Public/Uploads/Goods/{$gc_id}/";
            $savepath = APP_PATH."..".$new_dir;
            if(!is_dir($savepath)){
                mkdir($savepath,0777,true);
            }
            $file = explode('.',$temp);
            $ext  = $file[1];
            $new  = $new_dir . "{$name}." . $ext;
            rename(APP_PATH.'..'.$temp,APP_PATH.'..'.$new);
            $save[$name] = $new."?v=".time();
        }
        if(!empty($save)){
            $res = $this->Goods_Common_Model->saveGoods($save,$gc_id);
            if (!empty($res)) $this->api_success();
        }
    }



    public function saveGoods()
    {
        $gc_id = I('get.gc_id');
        $goodsInfo = $this->Goods_Common_Model->getGoodsInfoById($gc_id);

        $this->save_goods_pic($gc_id,$goodsInfo);

        $data = [
            'goods_category'    =>      trim(I('goods_category')),
            'goods_name'        =>      trim(I('goods_name')),
            'goods_code'        =>      trim(I('goods_code')),
            'goods_unit'        =>      trim(I('goods_unit')),
            'goods_pocket_type' =>      trim(I('goods_pocket_type')),
            'goods_remark'      =>      trim(I('goods_remark')),
            'is_hidden'         =>      trim(I('is_hidden')),
            'goods_status'      =>      1, //1:默认下架 2:上架 3:删除
            'goods_edittime'          =>      TIMESTAMP,
        ];
        $res = $this->Goods_Common_Model->saveGoods($data,$gc_id);
        if ($res) $this->api_success($message='更新成功');
    }
    //添加一个规格对应的商品
    public function addNewGoodsItem()
    {
        $gc_id = intval(I('gc_id'));
        if($gc_id <= 0){
            return $this->api_error("异常的参数");
        }

        $goods_common = $this->Goods_Common_Model->getGoodsInfoById($gc_id);
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $spec_name = json_decode($goods_common['spec_name'],true);
            $this->assign("spec_name",$spec_name);
            $this->assign("goods_common",$goods_common);
            $this->display();
        }else{
            $form_data = I('form_data');
            $goods = [];
            $g_v2 = [];
            foreach ($form_data as $m)
            {
               $k = $m['name'];
               $v = $m['value'];
               if(is_numeric($k))
               {
                   $find = $this->GoodsSpec_model->find_spec(['spec_value' => $v,'spec_class_id'=>$k]);
                   if(empty($find)) {
                       $spec_value_id = $this->GoodsSpec_model->addSpec_v($v,$k);
                   }else{
                       $spec_value_id = $find['id'];
                   }
                   $goods['spec'][][$spec_value_id] = $v;

                   $g_v = json_decode($goods_common['spec_value'],true);
                   foreach($g_v as $o => $p) {
                        if($o == $k){
                            $p[$spec_value_id] = $v;
                            $g_v2[$o] = $p;
                        }
                   }
               }else{
                   $goods[$k] = intval(trim($v));
               }
            }

            if($goods['goods_price'] <=0 || $goods['goods_storage'] <= 0){
                $this->api_error("商品价格或库存不得未空");
            }
            $goods_id = $this->goods_detail_add($goods,$goods_common);
            if($goods_id) {
                $this->Goods_Common_Model->saveGoods(["spec_value"=> json_encode($g_v2,JSON_UNESCAPED_UNICODE)],$gc_id);
                $this->api_success("添加成功");
            }else{
                $this->api_error("添加失败");
            }
        }
    }

    /*************** 商品添加 *******************************************************/

    public function goods_detail()
    {
        $show_page = I('tab');
        $goods_id = I('goods_id');
        $res = $this->Goods_Common_Model->getGoodsById($goods_id);
        $this->assign('res',$res);


        $spec_name = json_decode($res['spec_name'],true);
        $spec_val  = json_decode($res['spec_value'],true);
        $this->assign("spec_name",$spec_name);
        $this->assign("spec_val",$spec_val);

        $goods_list = $this->Goods_Model->getGoodsList(["goods_common_id"=>$goods_id]);
        foreach ($goods_list as $k => $gooos_items) {
            $goods_list[$k]['goods_spec'] = json_decode($gooos_items['goods_spec'],true);
        }
        $this->assign("goods_list",$goods_list);
        $this->assign("show_page",$show_page);
        $this->display('Goods/add');
    }

    //商品上下架
    public function line()
    {
        $gc_id = $_POST['gc_id'];
        $gc_status = $_POST['gc_status'] == 1 ? '2' : '1';
        if($gc_status == 2) {
            $res = $this->Goods_Common_Model->online($gc_id);
        }elseif($gc_status == 1) {
            $res = $this->Goods_Common_Model->offline($gc_id);
        }else{
            $res = false;
        }

        if ($res) $this->api_success();
    }


    public function goods_online()
    {
        $goods_id = intval($_POST['goods_id']);
        if($goods_id <= 0) $this->api_error("错误的参数");
        $this->Goods_Model->online($goods_id);
        $this->api_success();
    }

    public function goods_offline(){
        $goods_id = intval($_POST['goods_id']);
        if($goods_id <= 0) $this->api_error("错误的参数");
        $this->Goods_Model->offline($goods_id);
        $this->api_success();
    }


    public function del()
    {
        $gc_id = $_GET['gc_id'];
    }
}