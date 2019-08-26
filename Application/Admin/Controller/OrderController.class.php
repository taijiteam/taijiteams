<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 9:10 AM
 */

namespace Admin\Controller;

use Common\Controller\BaseController;
use Common\Logic\OrderLogic;
use Common\Model\OrderModel;
use Common\Logic\OrderLogicClass;
class OrderController extends BaseController
{
    private $Order_Model;

    public function __construct()
    {
        parent::__construct();
        $this->Order_Model = new OrderModel();
    }

    /**********************************************     导出       *****************************************************/
    public function export()
    {
        $expTitle = '机场订单';
        $expCellName = M('jc_order')->field(['order_sn','member_name','member_mobile','order_type','order_status','order_status','pay_style','addtime'])->where(['id' => '29'])->find();
        $expTableData = M('jc_order')->field('*')->select();
        vendor('PHPExcel.Classes.PHPExcel');
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        // 设置
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        //设置单元格内容加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //设置单元格内容水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //根据excel坐标，添加数据
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $expTitle . date('Y-m-d H:i:s'));

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "订单编号");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "付款人");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "电话");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "预约机场");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "支付金额");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "支付状态");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "审核状态");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "支付方式");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "下单时间");

        /**
         * 单元格宽度
         */
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        // Miscellaneous glyphs, UTF-8
        //开始赋值
        if (!empty($expTableData)) {
            foreach ($expTableData as $key => $value) {
                $Cellkey = $key + 3;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $Cellkey, $value['order_sn']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $Cellkey,  $value['member_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $Cellkey,  $value['member_mobile']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $Cellkey,  $value['order_type']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $Cellkey,  $value['member_payment']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $Cellkey,  $value['order_status']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $Cellkey,  $value['order_status']);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $Cellkey,  $value['pay_style']);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $Cellkey,  date('Y-m-d H:i:s',$value['pay_time']));
            }
        } else {
            die(" 暂无数据" . EOL);
        }


            $objPHPExcel->getActiveSheet()->setTitle('订单');

            // 设置行高
            $name = '机场订单.xlsx';//任意名字
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . $name);
            header('Cache-Control: max-age=0');
            $ExcelWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $ExcelWriter->save('php://output');
            exit;
        }






    public function index()
    {
       /* $list = $this->Order_Model->page_list();
        $this->assign('list',$list);

        $cnt = $this->Order_Model->cnt();
        $this->assign('count',$cnt);

        $page = $this->Order_Model->show_page();
        $this->assign('page',$page);*/
        $orderList = $this->Order_Model->getOrder();
        //dump($orderList);exit();
        $this->assign('orderList',$orderList);
        $this->display();
    }

    public function search()
    {
        $source = I("get.source");
        if ($_GET){
            $data = [
                'o_number'  => trim(I('order_sn')),
                'o_phone'   => trim(I('o_phone')),
                //'pay'       => trim(I('pay')),
                'audit'     => trim(I('audit')) == "交易完成" ? "4" : "7",
            ];
            $orderInfo = $this->Order_Model->search($source,$data);
            if ($orderInfo == null){
                $this->display();
                //$this->api_error('没有此订单');
            }else{
                $this->assign('orderList',$orderInfo);
                $this->display();
                //$this->api_success($orderInfo);
            }
        }
    }
    public function activitySearch()
    {
        $source = I("get.source");
        if ($_GET){
            $data = [
                'o_number'  => trim(I('order_sn')),
                'o_phone'   => trim(I('o_phone')),
                //'pay'       => trim(I('pay')),
                'audit'     => trim(I('audit')) == "交易完成" ? "4" : "7",
            ];
            $orderInfo = $this->Order_Model->search($source,$data);
            if ($orderInfo == null){
                $this->display();
                //$this->api_error('没有此订单');
            }else{
                $this->assign('orderList',$orderInfo);
                $this->display();
                //$this->api_success($orderInfo);
            }
        }
    }
    public function doctorSearch()
    {
        $source = I("get.source");
        if ($_GET){
            $data = [
                'o_number'  => trim(I('order_sn')),
                'o_phone'   => trim(I('o_phone')),
                //'pay'       => trim(I('pay')),
                'audit'     => trim(I('audit')) == "交易完成" ? "4" : "7",
            ];
            $orderInfo = $this->Order_Model->search($source,$data);
            if ($orderInfo == null){
                $this->display();
                //$this->api_error('没有此订单');
            }else{
                $this->assign('orderList',$orderInfo);
                $this->display();
                //$this->api_success($orderInfo);
            }
        }
    }
    public function projectSearch()
    {
        $source = I("get.source");
        if ($_POST){
            $data = [
                'o_number'  => trim(I('order_sn')),
                'o_phone'   => trim(I('o_phone')),
                //'pay'       => trim(I('pay')),
                'audit'     => trim(I('audit')) == "交易完成" ? "4" : "7",
            ];
            $orderInfo = $this->Order_Model->search($source,$data);
            if ($orderInfo == null){
                $this->display();
                //$this->api_error('没有此订单');
            }else{
                $this->assign('orderList',$orderInfo);
                $this->display();
                //$this->api_success($orderInfo);
            }
        }
    }

    public function detail()
    {
        $order_id = I('order_id');
        $res = $this->Order_Model->order_detail($order_id);
        $this->assign('res',$res);
        $this->display();
    }

    public function order_del()
    {
        $order_id = I('id');
        $order_status = $this->Order_Model->setOrderStatus($order_id);
        if ($order_status) $this->api_success();
    }

    public function create()
    {
        //后台协助下单

        //下单有从购物车  有直接下单 2种

        //生成订单


        $buyer_id = 1;
        $order_sn = $this->makeOrderSn();

        $order['order_status'] = 1;
        $order['order_sn'] = $this->makeOrderSn();

        $order['member_id'] = $buyer_id;
        $order['member_mobile'] = 1;
        $order['deliver_address'] = 1;
        $order['deliver_price'] = 1;

        $order['goods_id'] = 1;
        $order['goods_name'] = 1;
        $order['goods_num'] = 1;
        $order['goods_price'] = 1;


        $order['total_price'] = 1;//total_price
        $order['member_payment'] = 1;//会员支付的金额
        $order['pay_style']      = 1;//支付类型
        $order['member_package'] = 1;
        $order['member_pocket'] = 1;

        $order['addtime'] = time();
        $order['editTime'] = time();

        //商品锁定








        //支付完成


        //商品库存扣除


        //订单状态更改
    }

    public function edit()
    {
        //订单流程
    }

    private function makeOrderSn()
    {
        return date('YmdHis');
    }


    public function order_delivered(){
        $order_sn = I('order_sn');
        $res =OrderLogic::instance($order_sn)->order_delivered();
        if($res){
            $this->api_success();
        }else{
            $this->api_error("操作失败");
        }
    }


    /**************************      商城订单审核     开始     *********************************************/
    //订单审核
    public function audit(){
        $source = I("source");
        $order_id = I('order_id');
        $res = $this->Order_Model->order_detail($order_id,$source);
        $this->assign('source',$source);
        $this->assign('order_id',$order_id);
        $this->assign('res',$res);
        $this->display();
    }
    //订单审核
    public function addAudit(){
        $member_id = session('mid');
        $time = date("Y-m-d H:i:s",time());
        //接受上传的审核的数据
        if($_POST){
          $data=[
              "mid"          =>   $member_id['a_name'],
              "order_id"     =>   $_POST["order_id"],
              "source"       =>   $_POST["source"],
              "gc_id"        =>   $_POST["gc_id"],
              "pay"          =>   $_POST["pay"],
              "audit"        =>   $_POST["money"],
              "add_time"     =>   $time,
          ];
            $res = $this->Order_Model->goToAudit($data);
            if ($res){
                switch ($data["source"]){
                    case "商城":
                        $id = $data['order_id'];    //order_id
                        $orderStatus = "12";        //已审核订单状态
                        $source = "商城";
                        $orderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
                        if ($orderStatus) $this->api_success();
                    break;
                    case "活动":
                        $id = $data['order_id'];    //order_id
                        $orderStatus = "6";        //已审核订单状态
                        $orderStatus = $this->Order_Model->setOrderStatusActivityAudit($id,$orderStatus);
                        if ($orderStatus) $this->api_success();
                    break;
                    case "医疗":
                        $id = $data['order_id'];    //order_id
                        $orderStatus = "6";        //已审核订单状态
                        $orderStatus = $this->Order_Model->setOrderStatusDoctorAudit($id,$orderStatus);
                        if ($orderStatus) $this->api_success();
                    break;
                    case "美食":
                        $id = $data['order_id'];    //order_id
                        $orderStatus = "6";        //已审核订单状态
                        $orderStatus = $this->Order_Model->setOrderStatusProjectAudit($id,$orderStatus);
                        if ($orderStatus) $this->api_success();
                    break;
                    case "机场":
                        $id = $data['order_id'];    //order_id
                        $orderStatus = "6";        //已审核订单状态
                        $orderStatus = $this->Order_Model->setOrderStatusAirportAudit($id,$orderStatus);
                        if ($orderStatus) $this->api_success();
                    break;
                    default: ;
                }
            }
        }else{
            $this->api_error('请刷新页面后重试');
        }
    }
    //已审核订单列表
    public function completed(){
        $source = I('source');
        $this->assign('source',$source);
        $this->display();
    }
    //商城已审核订单接口
    public function check_list(){
        $source = I('source');
        $checkList = $this->Order_Model->getOrderStatusAudit($source);
        $data['code'] = 0;
        $data['data'] = $checkList;
        $this->ajaxReturn($data);
    }
    //活动已审核订单接口
    public function check_ActivityList(){
        $source = "活动";
        $checkList = $this->Order_Model->getOrderStatusAudit($source);
        $data['code'] = 0;
        $data['data'] = $checkList;
        $this->ajaxReturn($data);
        $this->display();
    }

    //驳回审核
    public function reject(){
        $id = I("id");           //order_id
        $orderStatus = "13";     // 已驳回的审核状态
        $source = "商城";
        $OrderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
        if ($OrderStatus){
            //删除已审核表的数据
            $res = $this->Order_Model->delOrderAudit($id,$source);
            if ($res) $this->api_success();
        }
    }
    /**************************    商城订单审核     结束     *********************************************/
    /**************************    活动订单审核     开始     *********************************************/
    public function activity(){
        $orderList = $this->Order_Model->getActivityOrder();
        $this->assign('orderList',$orderList);
        $this->display();
    }
    //驳回审核
        public function activityReject(){
            $id = I("id");           //order_id
            $orderStatus = "7";     // 已驳回的审核状态
            $source  = "活动";       // 已驳回的审核类型
            $OrderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
            if ($OrderStatus){
                //删除已审核表的数据
                $res = $this->Order_Model->delOrderAudit($id,$source);
                if ($res) $this->api_success();
            }
        }
    /**************************    活动订单审核     结束     *********************************************/
    /**************************    医疗订订单审核     开始     *********************************************/
    public function doctor(){
        $orderList = $this->Order_Model->getDoctorOrder();
        $this->assign('orderList',$orderList);
        $this->display();
    }
    //医疗已审核订单接口
    public function check_DoctorList(){
        $source = "医疗";
        $checkList = $this->Order_Model->getOrderStatusAudit($source);
        $data['code'] = 0;
        $data['data'] = $checkList;
        $this->ajaxReturn($data);
        $this->display();
    }
    //驳回审核
    public function doctorReject(){
        $id = I("id");           //order_id
        $orderStatus = "7";     // 已驳回的审核状态
        $source  = "医疗";       // 已驳回的审核类型
        $OrderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
        if ($OrderStatus){
            //删除已审核表的数据
            $res = $this->Order_Model->delOrderAudit($id,$source);
            if ($res) $this->api_success();
        }
    }
    /**************************    医疗订单审核     结束     *********************************************/
    /**************************    餐厅订单审核     开始     *********************************************/
    public function project(){
        $orderList = $this->Order_Model->getProjectOrder();
        $this->assign('orderList',$orderList);
        $this->display();
    }
    //医疗已审核订单接口
    public function check_ProjectList(){
        $source = "美食";
        $checkList = $this->Order_Model->getOrderStatusAudit($source);
        $data['code'] = 0;
        $data['data'] = $checkList;
        $this->ajaxReturn($data);
        $this->display();
    }
    //驳回审核
    public function projectReject(){
        $id = I("id");           //order_id
        $orderStatus = "7";     // 已驳回的审核状态
        $source  = "美食";       // 已驳回的审核类型
        $OrderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
        if ($OrderStatus){
            //删除已审核表的数据
            $res = $this->Order_Model->delOrderAudit($id,$source);
            if ($res) $this->api_success();
        }
    }
    /**************************    餐厅订单审核     结束     *********************************************/
    /**************************    机场订单审核     开始     *********************************************/
    public function airport(){
        $orderList = $this->Order_Model->getAirportOrder();
        $page = $this->Order_Model->airportCnt_list($condition=['order_status' =>['in',[2,7]]]);
        $list = $this->Order_Model->airportPage_list($condition=['order_status' =>['in',[2,7]]]);
        //dump($page);exit();
        $this->assign('orderList',$orderList);
        $this->assign('page',$page);
        $this->assign('list',$list);
        $this->display();
    }
    //机场已审核订单接口
    public function check_airportList(){
        $source = "机场";
        $checkList = $this->Order_Model->getOrderStatusAudit($source);
        $data['code'] = 0;
        $data['data'] = $checkList;
        $this->ajaxReturn($data);
        $this->display();
    }
    //驳回审核
    public function airportReject(){
        $id = I("id");           //order_id
        $orderStatus = "7";     // 已驳回的审核状态
        $source  = "机场";       // 已驳回的审核类型
        $OrderStatus = $this->Order_Model->setOrderStatusAudit($id,$orderStatus,$source);
        if ($OrderStatus){
            //删除已审核表的数据
            $res = $this->Order_Model->delOrderAudit($id,$source);
            if ($res) $this->api_success();
        }
    }
    /**************************    机场订单审核     结束     *********************************************/
}