<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/1
 * Time: 11:06 AM
 */

namespace Common\Controller;

use Common\Model\MemberModel;

class MobileController extends BaseController
{
    protected $member_id;

    protected $member_info;

    public function __construct()
    {
        parent::__construct();
        //判断用户是否登录
        if( session('member_id') ) {
           $this->member_id = session('member_id');

           $Member = new MemberModel();
           $this->member_info = $Member->getMemberInfo($this->member_id);
        }
        else
        {
            //debug 本地测试
            if(strpos($_SERVER['SERVER_NAME'],'taiji') !== FALSE || strpos($_SERVER['SERVER_NAME'],'192.168.2.') !== FALSE){
                $this->member_id = 143;//本地测试账号
                session("member_id",143);
                $Member = new MemberModel();
                $this->member_info = $Member->getMemberInfo($this->member_id);
                return;
            }

            if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest")
            {
                $this->api_error("授权过期,请重新登录","100");
            }else{
                redirect(MOBILE_SITE_URL."/Mobile/Index/index");
            }
        }
    }

    public function index(){

    }


    private  function syscCookie()
    {
        //没有  判断用户是否在公众号主页登录  验证信息  执行同步登录
        if($mid = $this->CookieVerify()){
            session("member_id","");
            $this->member_id = 12;
        }else{
            //返回未登录 跳转 公众号主页 走登录流程 原版的登录
            $this->redirect('http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22');
        }
    }

    private function CookieVerify()
    {
        $secret_name = md5("member_secret");
        $secret_value = cookie($secret_name);


        $secret_param = md5("secret_param");
        $params = cookie($secret_param);
        $params = explode('_',$params);
        if(count($params) !== 3){
            return false;
        }
        $mid = $params[1];
        $sign = implode('_',array_reverse($params))."QUDAO";

        if($secret_value == md5($sign)){
            return $mid;
        }else{
            return false;
        }
    }

    private function CookieSignature($mid)
    {
        $head = rand(11111,99999);
        $tail = rand(111,999);

        //加密时 333_mid_55555QUDAO
        $signature = md5($tail.'_'.$mid.'_'.$head."QUDAO");
        $params = $head.'_'.$mid.'_'.$tail;

        cookie('member_secret',$signature);
        cookie('secret_param',$params);
     }
}