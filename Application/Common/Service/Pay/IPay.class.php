<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/12
 * Time: 9:49 AM
 */
namespace Common\Service\Pay;

interface IPay
{
    public function gen_pay($pay_sn,$fee,$body);
//    public function on_notify($post);
}