<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/29
 * Time: 10:44 AM
 */

namespace Common\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        define("TIMESTAMP",time());
        $this->assign("versions",$this->versions);
    }

    public function api_success($data=[],$message='success'){

        $ret = [
            'code' => (string)200,
            'data' => $data,
            'message' => $message
        ];

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($ret);exit;
    }

    public function api_error($message='error',$code='000',$data=[]){
        $ret = [
            'code' => (string)$code,
            'message' => $message,
            'data'  => $data
        ];

        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($ret);exit;
    }

    private $versions = '2019061803';

    #000  弹框现实 返回的Message

    #200  成功


    #需要执行 特殊业务
    #1000001   商品


    #200001    订单


    #300001    购物车
    #300010    商品数量已经达到库存最大值
    #300011    商品数量已经到最小值
}