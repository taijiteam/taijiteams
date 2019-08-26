<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 6:05 PM
 */

namespace Mobile\Controller;

use Common\Model\GoodsCommonModel;
use Common\Model\GoodsModel;
use Common\Service\HttpService;
use Think\Log;
use Common\Controller\BaseController;
use Common\Model\MemberModel;
use Common\Service\WxOauthService;

class IndexController extends BaseController
{
    private $Goods_model;
    private $GoodsCommon_model;
    private $Member_model;

    public function __construct()
    {
        parent::__construct();
        $this->Goods_model = new GoodsModel();
        $this->GoodsCommon_model = new GoodsCommonModel();
        $this->Member_model = new MemberModel();
    }

    /********************* 授权登录 ************************************/
    private $home_url = MOBILE_SITE_URL."/Mobile/Index/home";
//    private $groupUpdate = "http://www.qudaoplus.cn/merber_all_show/index.php/home/MerberRank/";
    private $Register    = "http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberRegister";

    public function index()
    {
        //设置登录后 前往商城首页 还是 自定义的重定向页面 $redirect_url
        $this->setHomeUrl();

        //微信授权 获取openid
        $WxOauthService = new WxOauthService();
        $WxUserInfo = $WxOauthService->WxUserInfo();
        $openid = $WxUserInfo['openid'];

        //检查本地用户数据完整性 进行跳转 => 商城首页 or 会员升级
        $this->checkLocalMemberInfo($openid);

        //调用一卡易 第三方数据  完善本地用户数据
        $this->cloneRemoteMemberInfo($openid);
    }

    private function setHomeUrl()
    {
        $redirect_url = trim(I('redirect_url'));
        if($redirect_url) $this->home_url = $redirect_url;
    }

    private function checkLocalMemberInfo($openid)
    {
        $Member = new MemberModel();
        $has_member = $Member->getMemberInfo(["m_openids" => $openid]);
        if(!empty($has_member))
        {
//            if($has_member["m_groupname"] == '待审核')
//            {
//
//            }else{
                session("member_id",$has_member['m_id']);
                redirect($this->home_url);
//            }
        }
    }

    private function cloneRemoteMemberInfo($openid)
    {
        $response_data = $this->getMemberInfoFrom1card1($openid);
        Log::write(json_encode($response_data),"DEBUG",'File',APP_PATH.'../log/member_login.log');

        //将open_id 和 mobile信息保存
        if( $response_data['status'] == 0 )
        {
            $has_member = $this->Member_model->getMemberInfo(["m_phone" => $response_data['data'][0]['Mobile']]);
            if(!empty($has_member)){
                $updata = [
                    "m_cname"       =>  $response_data['data'][0]['TrueName'],
                    "m_groupname"   =>  $response_data['data'][0]['MemberGroupName'],
                    "m_openids"     =>  $response_data['data'][0]['ThirdOpenId'],
                    "m_num"         =>  $response_data['data'][0]['CardId']
                ];
                $update = $this->Member_model->update_member(["m_id"=>$has_member['m_id']],$updata);
                session("member_id");
            }else{
                $member_id = $this->Member_model->add_member($response_data['data'][0]);
                session("member_id");
            }

//            $group = $response_data['data'][0]['MemberGroupName'];
//            if ($group == '待审核') {
//                echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
//                redirect( $this->groupUpdate );
//            }else{
                redirect($this->home_url);
//            }
        }else{
            redirect( $this->Register );
        }
    }

    private function getMemberInfoFrom1card1($open_id)
    {
        $_1card1OpenId = '80D02F3AFAD2425DA70A28550275E04F';
        $_1card1Secret = "6BWPQ9";

        $data = ["deviceType" => "1", "thirdOpenId" => $open_id];
        $json_data = json_encode ( $data );

        $TimeStamp = time ();
        $Signature = strtoupper ( md5 ( $_1card1OpenId . $_1card1Secret . $TimeStamp . $json_data ) );

        $url = "http://openapi.1card1.cn/VipCloud/GetMemberGuidByOpenId?openId=" . $_1card1OpenId . "&signature=" . $Signature . "&timestamp=" . $TimeStamp;
        $postData = "data=" . $json_data;
        $result_data = HttpService::httpGet($url,$postData);
        $array = json_decode ( $result_data, true );
        return $array;
    }

    /********************* 授权登录 ************************************/

    //商城首页
    public function home()
    {
        $detail = "/Mobile/Goods/detail?gc_id=";
        $show = [];

        if(strpos($_SERVER['SERVER_NAME'],'taiji') !== FALSE){
            $gc_ids = [21,7,19,20,25];//本地测试数据
        }else{
            $gc_ids = [
                        21,23,24,25,26,27,28,29,
                        30,31,34,35,37,38,
                        42,43
                    ];
        }


        $GoodsModel = new GoodsCommonModel();
        $list = $GoodsModel->goodsList(["my_sc_goods_common.goods_common_id"=>["in",$gc_ids]]);
        $goods_list = [];
        foreach ($list as $item){
            if (!empty($item['adve_img']))
            {
                $item['main_img'] = $item['adve_img'];
            }
            $goods_list[$item['goods_common_id']] = $item;
    }

        //首页banner图  无连接形式
        $show['index_banner'][]  = ["image" => "/Public/Mobile/images/home/index_banner1.png"];
        $show['index_banner'][]  = ["image" => "/Public/Mobile/images/home/index_banner2.png"];


        //轮播图
//        $show['banner'][]       = ["data_type" => "goods", "data" => "19", "goods_info" => $goods_list[19]];
//        $show['banner'][]       = ["data_type" => "url",   "data" => $detail."7" , "image" => $goods_list[7]['main_img']];
//        $show['banner'][]       = ["data_type" => "url",   "data" => $detail."21" , "image" => $goods_list[21]['main_img']];
//        $show['banner'][]       = ["data_type" => "goods", "data" => "20", "goods_info" => $goods_list[20]];

        //热门推荐
        $show['selected'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=25", "goods_info" => $goods_list[25]];
        $show['selected'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=23", "goods_info" => $goods_list[23]];
        $show['selected'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=30", "goods_info" => $goods_list[30]];
        $show['selected'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=21", "goods_info" => $goods_list[21]];



        //艺术文化
        $show['artwork'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=26", "goods_info" => $goods_list[26]];
 //       $show['artwork'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=21", "goods_info" => $goods_list[21]];
 //       $show['artwork'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=21", "goods_info" => $goods_list[21]];

        //甄选名酒
        $show['liquor'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=25", "goods_info" => $goods_list[25]];
        $show['liquor'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=31", "goods_info" => $goods_list[31]];
 //       $show['liquor'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=21", "goods_info" => $goods_list[21]];


        //营养保健
        $show['nutrition'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=24", "goods_info" => $goods_list[24]];
        $show['nutrition'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=34", "goods_info" => $goods_list[34]];
        $show['nutrition'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=35", "goods_info" => $goods_list[35]];


        //珠宝首饰
        $show['jewelry'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=27", "goods_info" => $goods_list[27]];
        $show['jewelry'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=28", "goods_info" => $goods_list[28]];
        $show['jewelry'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=29", "goods_info" => $goods_list[29]];

        //工艺礼品
        $show['gift'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=37", "goods_info" => $goods_list[37]];
        $show['gift'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=38", "goods_info" => $goods_list[38]];
        $show['gift'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=42", "goods_info" => $goods_list[42]];
        $show['gift'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=43", "goods_info" => $goods_list[43]];
        $show['gift'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=30", "goods_info" => $goods_list[30]];

        //私人定制
        $show['customize'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=23", "goods_info" => $goods_list[23]];
 //       $show['customize'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=21", "goods_info" => $goods_list[21]];
 //       $show['customize'][]     = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=20", "goods_info" => $goods_list[20]];

        /*//品味生活
        $show['taste'][]        = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=7", "goods_info" => $goods_list[7]];

        //猜你喜欢
        $show['likes'][]        = ["data_type" => "url", "data" => "/Mobile/Goods/detail?gc_id=7", "goods_info" => $goods_list[7]];*/

        $this->assign("show",$show);
        $this->display();
    }

    /***************** 分类页面 ************************************************************/
    public function cateList()
    {
        $cate_name = I('get.cate');
        $cate_arr = ["艺术文化","甄选名酒", "营养保健", "珠宝首饰", "工艺礼品", "私人定制","积分兑换"];
        if(!in_array($cate_name,$cate_arr)) $this->api_error("错误的参数");

        $goodsList = $this->GoodsCommon_model->goodsList(['my_sc_goods_common.goods_category' => $cate_name]);
        foreach ($goodsList as $k => $goodsItem){
            $goodsItem['goods_remark'] = subtext($goodsItem['goods_remark'],12);
            $goodsList[$k] = $goodsItem;
        }
        $this->assign('cate_name',$cate_name);
        $this->assign('goodsList',$goodsList);
        $this->display();
    }

    public function category()
    {
        $cate = I('get.cate') == '' ? '艺术文化' : I('get.cate');
        $this->assign('cate',$cate);
        $this->display();
    }

    public function cate_goods()
    {
        $cate = I('cate');
        $cate_arr = ["艺术文化","甄选名酒", "营养保健", "珠宝首饰", "工艺礼品", "私人定制"];
        if(!in_array($cate,$cate_arr)) $this->api_error("错误的参数");
        $goodsList = $this->GoodsCommon_model->goodsCate($cate);
        foreach ($goodsList as $k => $goodsItem){
            $goodsItem['goods_name'] = subtext($goodsItem['goods_name'],5);
            $goodsList[$k] = $goodsItem;
        }
        $this->api_success($goodsList);
    }

    /**************** 查询商品 ***************************************************************/
    public function search_goods()
    {
        $this->display();
    }

    public function search_goodsList()
    {
        $goods_name = I('goods_name');
        $goodsList = $this->GoodsCommon_model->goodsSearch($goods_name);
        foreach ($goodsList as $k => $goodsItem){
            $goodsItem['goods_remark'] = subtext($goodsItem['goods_remark'],12);
            $goodsList[$k] = $goodsItem;
        }
        if ($goodsList) $this->api_success($goodsList);
        $this->display('Index/search_goods');
    }

    /************** 无数据逻辑 ***************************************************************/
    public function contact_us(){
        $this->display();
    }
}