<?php
/**
 * Created by PhpStorm.
 * User: jql
 * Date: 2019/5/31
 * Time: 10:00 AM
 *
 *
 * 商品评论管理  GoodsComment  goods
 */

namespace Admin\Controller;

use Common\Controller\BaseController;
use Common\Model\GoodsCommentModel;
use Common\Model\GoodsCommonModel;
use Common\Logic\GoodsLogic;
use Common\Model\MemberModel;

class GoodsCommentController extends BaseController
{
    private $Goods_Common_Model;
    private $Member_Model;
    private $Goods_Comment_Model;
    private $GoodsLogic;
    private $mid = 10;
    private $goods_ids = [1,2,3];
    private $keyword = "2";
    private $text = "商品质量贼好，穿三年都穿不破，新衣服也不用买了。";
    private $stat = "5";
    private $goods_id = 1;

    public function __construct()
    {
        parent::__construct();
        $this->Goods_Common_Model = new GoodsCommonModel();
        $this->Member_Model = new MemberModel();
        $this->Goods_Comment_Model = new GoodsCommentModel();
    }

    public function index()
    {


    }

    //接收商品评论
    public function addGoodsComment(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            //上传接收gid mid
            $goods_id = $this->goods_id;
            $mid = $this->mid;
            $keyword = $this->keyword;
            $stat = $this->stat;
            $text = $this->text;
            $MemberInfo = $this->Member_Model->getMemberInfo($mid);
            //$MemberInfo = M('merber')->where(['m_id'=>$mid])->find();
            $time = time();
            //goods_comment
            $arr = array(
                      "e_star"           => $stat,//    I('e_star'),             //评论的星星
                      "e_goods_id"       => $goods_id,
                      "e_keywords"       => $keyword,        //I('e_keywords'),         //评论关键字
                      "e_text"           => $text,    //I('e_text'),             //评论内容
                      "e_name"           => $MemberInfo['m_cname'],  //用户姓名
                      "e_headimg"        => $MemberInfo['m_img'],    //用户头像
                      "e_mid"            => $mid,                    //用户mid
                      "e_onumber"        => $goods_id,               //评论商品id
                      "e_time"           => $time,                  //评论时间
                      "e_status"         => 1,                       //评论状态   1：显示  2：隐藏
            );
            $res = $this->Goods_Comment_Model->addGoodsComment($arr);
            //$res = M('sc_evaluate')->add($arr);
            if ($res){
                $data = $arr;
                $this->api_success($data,"评论成功");
            }else{
                $this->api_error("评论失败");
            }
        }
    }




}