<?php


namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\OrderModel;
use Common\Logic\OrderLogic;

class OperationController extends BaseController
{
    private $Order_Model;

    public function __construct()
    {
        parent::__construct();
        $this->Order_Model = new OrderModel();
    }

    /********************************************* 商城运营订单列表 *********************************************************/
    public function shopList()
    {
        $orderList = $this->Order_Model->operationPage_list($condition=['order_status != 10']);
        $page = $this->Order_Model->operationCnt_list($condition=['order_status != 10']);
        if ($orderList)
        {
            $this->assign('orderList',$orderList);
            $this->assign('page',$page);
            $this->display();
        }
    }


    /********************************************* 机场运营订单列表 *********************************************************/
    public function airportList()
    {
        $orderList = $this->Order_Model->airportPage_list();
        $page = $this->Order_Model->airportCnt_list();
        if ($orderList)
        {
            $this->assign('orderList',$orderList);
            $this->assign('page',$page);
            $this->display();
        }
    }

    public function airportDetail()
    {
        $order_sn = I('get.order_sn');
        $source = '机场';
        $orderInfo = $this->Order_Model->orderDetail($order_sn,$source);
        if ($orderInfo)
        {
            $this->assign('orderInfo',$orderInfo);
            $this->display();
        }
    }
    public function shopDetail()
    {
        $order_sn = I('get.order_sn');
        $source = '商城';
        $orderInfo = $this->Order_Model->orderDetail($order_sn,$source);
        if ($orderInfo)
        {
            $this->assign('orderInfo',$orderInfo);
            $this->display();
        }
    }

}