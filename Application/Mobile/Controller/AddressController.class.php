<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/31
 * Time: 5:34 PM
 */

namespace Mobile\Controller;
use Common\Controller\MobileController;
use Common\Model\GoodsCommentModel;
use Common\Model\GoodsCommonModel;
use Common\Model\MemberAddressModel;
use Common\Model\MemberModel;
use Common\Controller\BaseController;
use Think\Model;

class AddressController extends BaseController
{

    private $Goods_Common_Model;
    private $Member_Model;
    private $Goods_Comment_Model;
    private $Member_Address;

    public function __construct()
    {
        parent::__construct();
        $this->Goods_Common_Model = new GoodsCommonModel();
        $this->Member_Model = new MemberModel();
        $this->Goods_Comment_Model = new GoodsCommentModel();

        $this->Member_Address = new MemberAddressModel();
    }


    public function index()
    {
        $mid = session('member_id');
        $address = $this->Member_Address->member_address($mid);
        $this->assign('address',$address);
        $this->display();
    }

    public function choose()
    {
        $mid = session('member_id');
        $frm = $_GET['redirect_url'] ? urlencode($_GET['redirect_url']) :  urlencode($_SERVER['HTTP_REFERER']);
        $address = $this->Member_Address->member_address($mid);
        $this->assign('address',$address);
        $this->assign("frm",$frm);
        $this->display();
    }

    //添加地址
    public function add()
    {
        $mid = session('member_id');
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->assign("frm",urlencode($_GET["redirect_url"]));
            $this->display();
        }
        else
        {
            $name = I('name');
            $address = I('address');
            $mobile = I('mobile');
            $is_default = I('is_default');
            //查询数据库是否已存在地址
//            $member = $this->Member_Model->getMemberInfo($this->member_id);  //获取用户手机号码
            $m_address = $this->Goods_Comment_Model->locatRess($mid);  //查询是否已存在地址
            if (empty($m_address))
            {
                //第一次  即使不是默认地址也设置为默认
                $arr = [
                    'mid'           =>    $mid,
                    'consignee'     =>    $name,
                    'address'       =>    $address,
                    'mobile'        =>    $mobile,
                    'is_default'    =>    1,
                ];
                $res = $this->Member_Address->addAdress($arr);
            }
            else
            {
                $arr = [
                    'mid'       =>   $mid,
                    'consignee' =>   $name,
                    'address'   =>   $address,
                    'mobile'    =>   $mobile,
                    'is_default'=>   0,
                ];
                $res = $this->Member_Address->addAdress($arr);

                if($is_default && $res) {
                    $this->Member_Address->setDefault($res,$mid);
                }
            }

            if($res){
                $this->api_success();
            }else{
                $this->api_error("添加失败");
            }
        }
    }

    public function edit()
    {
        $id = I('get.id');
        $address = $this->Goods_Common_Model->findAddress($id);
        $this->assign('address',$address);
        $this->assign('id',$id);
        $this->display();
    }
    public function set_edit()
    {
        $mid =session('member_id');
        $id = I('post.id');
        $name = I('name');
        $address = I('address');
        $mobile = I('mobile');
        $is_default = I('is_default') == 1 ? I('is_default') : '0';
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'consignee'        =>    $name,
                'address'          =>    $address,
                'mobile'           =>    $mobile,
                'is_default'       =>    $is_default,
                'addr_status'        =>    '1',
            ];
            //$res = $this->Goods_Common_Model->saveAddress($id,$data);
            $Model = new Model();
            $res = $Model->table('my_sc_address')->where(['id' => $id])->save($data);
            if (!empty($res)){
                $this->api_success();
            }else{
                $this->api_error();
            }
        }
        $this->display();
    }

    public function set_default()
    {
        $mid = session('member_id');
        $address_id = I('address_id');
        $ok  = $this->Member_Address->setDefault($address_id,$mid);
        if($ok){
            $this->api_success();
        }else {
            $this->api_error("选择失败");
        }
    }

    public function del()
    {

    }
}