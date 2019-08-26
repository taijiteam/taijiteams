<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/12
 * Time: 4:22 PM
 */

namespace Mobile\Controller;

use Common\Controller\BaseController;

use Common\Logic\PocketLogic;
use Common\Service\Pay\WxPayNotifyService;

class NotifyController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $Notify = new WxPayNotifyService();
        $Notify->Handle();
    }

    public function test(){
        PocketLogic::instance(15)->sendPocket(1,100,'bonus','12312313');
    }
}



