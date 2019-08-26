<?php
namespace Home\Controller;

    use Common\Model\MemberModel;
    use Common\Service\HttpService;
    use Common\Service\WxOauthService;
    use Think\Controller;
    use Think\Log;
    use Think\Upload;
    use Think\Page;

header("Content-type: text/html; charset=utf-8");
class ActivityController extends AdminController
{
    public function _initialize()
    {
        Vendor('phpSDK.OpenApiClient');
        //Vendor('PHPSDK.lib.OpenApiClient');
    }

    public function upload()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Public/Uploads/Estate/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error("请上传图片");
        } else {// 上传成功
            return $info;
        }
    }

    //根据生日计算年龄函数
    public function getAge($birthday)
    {
        //格式化出生时间年月日
        $byear = date('Y', $birthday);
        $bmonth = date('m', $birthday);
        $bday = date('d', $birthday);

        //格式化当前时间年月日
        $tyear = date('Y');
        $tmonth = date('m');
        $tday = date('d');

        //开始计算年龄
        $age = $tyear - $byear;
        if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
            $age--;
        }
        return $age;
    }
    /********************  微信授权  开始 ******************************************************************************/
    //微信授权
    public function wxOther()
    {
        //微信授权 获取openid
        $WxOauthService = new WxOauthService();
        $WxUserInfo = $WxOauthService->WxUserInfo();
        $openid = $WxUserInfo['openid'];
        session("openid", $openid);//存储在session
        session("information", $WxUserInfo);//存储在session
        $response_data = $this->cloneRemoteMemberInfo($openid);
        if($response_data['data']['0']['MemberGroupName'] == "亦享成员" || $response_data['data']['0']['MemberGroupName'] == "待审核"){
            echo '<script charset="utf-8">alert("温馨提示：您的成员卡不支持此功能，请升级成员卡");location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22";</script>';
        }
        session("cardId", $response_data['data']['0']['CardId']);
        $cardId = session("cardId");
    }
    // 获取微信执行后的参数
    public function httpGet( $url,$data=null ) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if ( !empty($data) ) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    //  获取用户的openid  和 一卡易信息
    private function cloneRemoteMemberInfo($openid)
    {
        $response_data = $this->getMemberInfoFrom1card1($openid);
        Log::write(json_encode($response_data),"DEBUG",'File',APP_PATH.'../log/member_login.log');

        //将open_id 和 mobile信息保存
        $Member_model = new MemberModel();
        if( $response_data['status'] == 0 )
        {
            $has_member = $Member_model->getMemberInfo(["m_phone" => $response_data['data'][0]['Mobile']]);
            if(!empty($has_member)){
                $updata = [
                    "m_cname"       =>  $response_data['data'][0]['TrueName'],
                    "m_groupname"   =>  $response_data['data'][0]['MemberGroupName'],
                    "m_openids"     =>  $response_data['data'][0]['ThirdOpenId'],
                    "m_num"         =>  $response_data['data'][0]['CardId']
                ];
                $update = $Member_model->update_member(["m_id"=>$has_member['m_id']],$updata);
                session("member_id");
            }else{
                $member_id = $Member_model->add_member($response_data['data'][0]);
                session("member_id");
            }
            return $response_data;
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




    /********************  微信授权  结束 ******************************************************************************/
    /********************  精彩活动  开始******************************************************************************/
    public function Housekeeper()
    {
        $this->display();
    }
    //往期活动
    public function list_act()
    {
        $this->wxOther();
        //if ($_REQUEST['phone']) {
        $cate = $_REQUEST['cate'];
        //$a_category = $_REQUEST['category'];//原版
        $a_category = "活动";
        //$catetime = $_REQUEST['catetime'];//原版
        $catetime = "往期活动";
        $time = date('Y-m-d H:i:s');
        if ($cate) {
            //$list = M()->table("my_hd_activity")->where("a_category = '$a_category' and a_cate = '$cate' and a_end < '$time'")->order("a_end desc")->select();
            $list = M()->table("my_hd_activity")->where("a_category = '$a_category' and a_cate = '$cate'")->order("a_end desc")->select();

            $this->assign(compact('list', 'cate'));
            $this->display();
        } else {
            //$list = M()->table("my_hd_activity")->where("a_category = '$a_category' and a_end < '$time'")->order("a_end desc")->select();
            $list = M()->table("my_hd_activity")->where("a_category = '$a_category'")->order("a_end desc")->select();
            //dump($list);
            //die();
            $this->assign(compact('list', 'catetime'));
            $this->display();
        }
        /* }else {
             $client = new \OpenApiClient ();
             $url2 	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];//获取当前的url地址
             $info 	= $this->wechat($url2);//
             if( $info['openid'] ){
                 $id = $info['openid'];//获取用户id
                 session("openid", $id);//存储在session
             }
             // 获取用户信息
             // 公众号的id和secret

             $openid = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';//yangkanglong openid
             $appid = 'wxc0a07eb0a480bd56';
             $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
             $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
             $tokenArr = json_decode($this->httpGet($access_token),true);


             $information_1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$tokenArr['access_token']."&openid=".$id."&lang=zh_CN";
             $information_2 = json_decode($this->httpGet($information_1),true);
             //dump($information_2);
             session("information", $information_2);//存储在session
             // the end
             $data = array (
                 "deviceType" => "1",
                 "thirdOpenId" => $id
             );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
             // 2.发起请求
             $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
             if($response_data['data']['0']['MemberGroupName'] != "内部测试"){
                 echo '<script charset="utf-8">alert("温馨提示：此板块正在维护中……");location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22";</script>';
             }
             session("infor", $response_data);//存储在session
             session("cardId", $response_data['data']['0']['CardId']);
             $cardId = session("cardId");

             // 判断是否登录
             if ($cardId) {
                 // $time_1 = date('Y-n-d',strtotime("-1 days"));
                 $time = date('Y-m-d H:i:s');
                 //活动推荐
                 $taglist_1 = M()->query("select * from my_hd_activity where a_category = '活动' and a_tag = '1' limit 0,4");
                 $taglist_2 = M()->query("select * from my_hd_activity where a_category = '活动' and a_tag = '1' limit 4,4");
                 $taglist_3 = M()->query("select * from my_hd_activity where a_category = '活动' and a_tag = '1' limit 8,4");
                 //最新活动
                 $newlist_1 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end > '$time' limit 0,3");
                 $newlist_2 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end > '$time' limit 3,3");
                 $newlist_3 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end > '$time' limit 6,3");
                 //往期活动
                 $oldlist_1 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end < '$time' limit 0,3");
                 $oldlist_2 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end < '$time' limit 3,3");
                 $oldlist_3 = M()->query("select * from my_hd_activity where a_category = '活动' and a_end < '$time' limit 6,3");
                 //活动场地
                 $sitelist = M()->query("select * from my_hd_activity where a_category = '场地' limit 0,4");
                 //活动用品
                 $supplist = M()->query("select * from my_hd_activity where a_category = '用品' limit 0,6 ");
                 //dump($newlist_2);
                 // die();
                 $this->assign(compact(
                     'taglist_1','taglist_2','taglist_3',
                     'newlist_1','newlist_2','newlist_3',
                     'oldlist_1','oldlist_2','oldlist_3',
                     'sitelist','supplist'
                 ));
                 $this->display();
             }elseif ($aOpenid['data']['0']['MemberGroupName']=='待审核') {
                 $re['code']   ='-1';
                 $re['message']='成员级别不支持此功能，请升级成员卡';
                 $re['url']    = $this->groupUpdate;
                 echo json_encode($re,JSON_UNESCAPED_UNICODE);
                 die;
             }else {
                 echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
             }
         }*/
    }
    //  内容页
    public function content()
    {
        $a_id = $_REQUEST['id'];
        //echo $a_id;
        $a_category = $_REQUEST['category'];
        $cardid = $_REQUEST['cardid'];
        $collect = M()->table("my_hd_collect")->where("c_aid = '$a_id' and c_cardid = '$cardid'")->find();
        if ($a_category == '活动') {
            $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
            $images = M()->table("my_hd_images")->where("i_aid = '$a_id'")->select();
            $guest = M()->table("my_hd_guest")->where("g_aid = '$a_id'")->select();
            $evalist = M()->table("my_hd_evaluate")->where("e_aid = '$a_id'")->select();
//            1111
            $map['e_keywords'] = array('like', '%非常满意%');
            $map['e_aid'] = $a_id;
            $ev = M()->table("my_hd_evaluate")->where($map)->count();
            $map1['e_keywords'] = array('like', '%服务很好%');
            $map1['e_aid'] = $a_id;
            $ev1 = M()->table("my_hd_evaluate")->where($map1)->count();
            $map2['e_keywords'] = array('like', '%印象不错%');
            $map2['e_aid'] = $a_id;
            $ev2 = M()->table("my_hd_evaluate")->where($map2)->count();
            $map3['e_keywords'] = array('like', '%描述相符%');
            $map3['e_aid'] = $a_id;
            $ev3 = M()->table("my_hd_evaluate")->where($map3)->count();
            $map4['e_keywords'] = array('like', '%性价比高%');
            $map4['e_aid'] = $a_id;
            $ev4 = M()->table("my_hd_evaluate")->where($map4)->count();
            $map5['e_keywords'] = array('like', '%行程合理%');
            $map5['e_aid'] = $a_id;
            $ev5 = M()->table("my_hd_evaluate")->where($map5)->count();
//            11111
            foreach ($evalist as $key => $value) {
                $keywords = explode(" ", $evalist[$key]['e_keywords']);
                $evalist[$key]['second'] = $keywords;
            }
//            dump($ev1);
//            die();
            $this->assign(compact('content', 'collect', 'guest', 'images', 'evalist', 'ev', 'ev1', 'ev2', 'ev3', 'ev4', 'ev5'));
            $this->display('Activity/actcontent');
        } elseif ($a_category == '场地') {
            $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
//            dump($content['a_address']);
//		die();
            $address = substr(strrchr($content['a_address'], "上海市"), 1);
            $siteimg = M()->table("my_hd_siteimg")->where("si_aid = '$a_id' and si_cate = '场地'")->select();
            $siteimg1 = M()->table("my_hd_siteimg")->where("si_aid = '$a_id' and si_cate = '大厅'")->select();
            $map = array();
            $map['a_site'] = array('like', '%' . $a_id . '%');
            $alist = M()->table("my_hd_activity")->where($map)->select();
            $evalist = M()->table("my_hd_evaluate")->where("e_aid = '$a_id'")->select();
            $map1['e_keywords'] = array('like', '%非常满意%');
            $map1['e_aid'] = $a_id;
            $ev1 = M()->table("my_hd_evaluate")->where($map1)->count();
            $map2['e_keywords'] = array('like', '%服务很好%');
            $map2['e_aid'] = $a_id;
            $ev2 = M()->table("my_hd_evaluate")->where($map2)->count();
            $map3['e_keywords'] = array('like', '%印象不错%');
            $map3['e_aid'] = $a_id;
            $ev3 = M()->table("my_hd_evaluate")->where($map3)->count();
            $map4['e_keywords'] = array('like', '%描述相符%');
            $map4['e_aid'] = $a_id;
            $ev4 = M()->table("my_hd_evaluate")->where($map4)->count();
            $map5['e_keywords'] = array('like', '%性价比高%');
            $map5['e_aid'] = $a_id;
            $ev5 = M()->table("my_hd_evaluate")->where($map5)->count();
            $map6['e_keywords'] = array('like', '%行程合理%');
            $map6['e_aid'] = $a_id;
            $ev6 = M()->table("my_hd_evaluate")->where($map6)->count();
//            11111
//            foreach ($evalist as $key=>$value){
//                $keywords = explode(" ", $evalist[$key]['e_keywords']);
//                $evalist[$key]['second'] = $keywords;
//            }
            $this->assign(compact('content', 'collect', 'siteimg', 'alist', 'siteimg1', 'address', 'evalist', 'ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'));
            $this->display('Activity/sitecontent');
        } elseif ($a_category == '用品') {
            $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
            $this->assign(compact('content', 'collect'));
            $this->display('Activity/supcontent');
        }
    }
    // 活动内容页跳转
    public function pinglun()
    {
        $map = array();
        $e_keywords = $_POST['pinglun'];
        if ($e_keywords) {
            $map['e_keywords'] = array('like', '%' . $e_keywords . '%');
            $map['e_aid'] = $_POST['id'];
        }
        $pinglun = M()->table("my_hd_evaluate")->where($map)->select();
//        foreach ($pinglun as $key=>$value){
//            $keywords = explode(" ", $pinglun[$key]['e_keywords']);
//            $pinglun[$key]['second'] = $keywords;
//        }
        if ($pinglun) {
            $this->ajaxReturn($pinglun);
        } else {
            $this->ajaxReturn(0);
        }
    }
    // 活动内容页跳转 场地
    public function actshow()
    {
        $a_id = $_REQUEST['id'];
        //echo $a_id;
        $name = $_REQUEST['name'];
        $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
        //var_dump($content);
        if ($name == '部分参会单位') {
            $show = $content['a_firm'];
        } elseif ($name == '参会须知') {
            $show = $content['a_notice'];
        } elseif ($name == '会议场地') {
            /*$data = $content['a_site'];
			$show = M()->table("my_hd_activity")->where("a_id = '$data'")->find();
			//dump($data);
			$said = $show['a_id'];
            $alist = M()->table("my_hd_activity")->where("a_site = '$said'")->select();*/
            $show = $content['a_notice'];
        }
        $this->assign(compact('name', 'show', 'data', 'alist'));
        $this->display();
    }
    // 活动报名
    public function actappoint()
    {
        $a_id = $_REQUEST['id'];
        $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
        $this->assign(compact('content'));
        $this->display();
    }
    // 活动报名  信息确认
    public function actsub()
    {
        $time = Date('Y-m-d H:i:s');
        $o_number = date(ymd) . substr(time(), -5) . substr(microtime(), 2, 5);//用户订单号自动生成
        $o_cate = '报名';
        $data = array(
            'o_name' => $_POST['name'],
            'o_phone' => $_POST['phone'],
            'o_mail' => $_POST['email'],
            'o_wechat' => $_POST['wechat'],
            'o_work' => $_POST['work'],
            'o_position' => $_POST['position'],
            'o_text' => $_POST['text'],
            'o_cardid' => $_POST['cardid'],
            'o_openid' => $_POST['openid'],
            'o_aid' => $_POST['id'],
            'o_price' => $_POST['price'],
            'o_time' => $time,
            'o_number' => $o_number,
            'o_cate' => $o_cate,
        );
        $order = M()->table("my_hd_order")->add($data);
        //$this->ajaxReturn($data);
        if ($order) {
            // 公众号的id和secret
            $appid = 'wxc0a07eb0a480bd56';
            $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
            $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $tokenArr = json_decode($this->httpGet($token_url), true);
            $openids[] = $openid;   //yonghu
            $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
            foreach ($openids as $key => $value) {
                $template = array(
                    'touser' => $value,
                    'template_id' => "xy7-rGvo49g2LlRg4wq8aTZZP3u01K-Z90YuTswTz70",
                    'url' => "",
                    'miniprogram' => array(
                        'appid' => "",
                        'pagepath' => ""
                    ),
                    'data' => array(
                        'first' => array(
                            'value' => urlencode("活动报名"),
                            'color' => "#173177"
                        ),
                        'keyword1' => array(
                            'value' => urlencode($data['o_name']),
                            'color' => "#173177"
                        ),
                        'keyword2' => array(
                            'value' => urlencode($data['o_phone']),
                            'color' => "#173177"
                        ),
                        'keyword3' => array(
                            'value' => urlencode('活动报名'),
                            'color' => "#173177"
                        ),
                        'keyword4' => array(
                            'value' => urlencode($data['o_time']),
                            'color' => "#173177"
                        ),
                        'remark' => array(
                            'value' => urlencode('订单编号：' . $data['o_number'] . '\n提示信息：恭喜您报名成功，请您注意活动信息，及时参加活动。更多详情请关注《渠道PLUS微管家精彩活动平台》！'),
                            'color' => "#173177"
                        ),
                    )
                );
                if (isset($tokenArr['access_token'])) {
                    $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tokenArr['access_token'];
                    $send = json_decode($this->httpGet($url2, urldecode(json_encode($template))), true);
                }
            }
            //公众号消息推送结束
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }
    //  活动-用品列表
    public function supplies()
    {
        $data['a_id'] = array('in', explode(" ", $_REQUEST['supplies']));
        $suplist = M()->table("my_hd_activity")->where($data)->select();
        // dump($suplist);
        // die();
        $this->assign(compact('suplist'));
        $this->display();
    }
    // 场地需求
    public function siteappoint()
    {
        $a_id = $_REQUEST['id'];
        $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
        $this->assign(compact('content'));
        $this->display();
    }
    public function sitesub()
    {
        $time = Date('Y-m-d H:i:s');
        $o_number = date(ymd) . substr(time(), -5) . substr(microtime(), 2, 5);//用户订单号自动生成
        $o_cate = '场地';
        $data = array(
            'o_name' => $_POST['name'],
            'o_phone' => $_POST['phone'],
            'o_work' => $_POST['work'],
            'o_position' => $_POST['position'],
            'o_text' => $_POST['text'],
            'o_cardid' => $_POST['cardid'],
            'o_openid' => $_POST['openid'],
            'o_aid' => $_POST['id'],
            'o_price' => $_POST['price'],
            'o_time' => $time,
            'o_number' => $o_number,
            'o_cate' => $o_cate,
        );
        $order = M()->table("my_hd_order")->add($data);
        //$this->ajaxReturn($data);
        if ($order) {
            // 公众号的id和secret
            $appid = 'wxc0a07eb0a480bd56';
            $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
            $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $tokenArr = json_decode($this->httpGet($token_url), true);
            $openids[] = $openid;   //yonghu
            $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
            foreach ($openids as $key => $value) {
                $template = array(
                    'touser' => $value,
                    'template_id' => "xy7-rGvo49g2LlRg4wq8aTZZP3u01K-Z90YuTswTz70",
                    'url' => "",
                    'miniprogram' => array(
                        'appid' => "",
                        'pagepath' => ""
                    ),
                    'data' => array(
                        'first' => array(
                            'value' => urlencode("场地需求"),
                            'color' => "#173177"
                        ),
                        'keyword1' => array(
                            'value' => urlencode($data['o_name']),
                            'color' => "#173177"
                        ),
                        'keyword2' => array(
                            'value' => urlencode($data['o_phone']),
                            'color' => "#173177"
                        ),
                        'keyword3' => array(
                            'value' => urlencode('场地需求'),
                            'color' => "#173177"
                        ),
                        'keyword4' => array(
                            'value' => urlencode($data['o_time']),
                            'color' => "#173177"
                        ),
                        'remark' => array(
                            'value' => urlencode('订单编号：' . $data['o_number'] . '\n提示信息：恭喜您场地需求提交成功。更多详情请关注《渠道PLUS微管家精彩活动平台》！'),
                            'color' => "#173177"
                        ),
                    )
                );
                if (isset($tokenArr['access_token'])) {
                    $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tokenArr['access_token'];
                    $send = json_decode($this->httpGet($url2, urldecode(json_encode($template))), true);
                }
            }
            //公众号消息推送结束
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }
    // 用品需求
    public function supappoint()
    {
        $a_id = $_REQUEST['id'];
        $content = M()->table("my_hd_activity")->where("a_id = '$a_id'")->find();
        $this->assign(compact('content'));
        $this->display();
    }

    public function supsub()
    {
        $time = Date('Y-m-d H:i:s');
        $o_number = date(ymd) . substr(time(), -5) . substr(microtime(), 2, 5);//用户订单号自动生成
        $o_cate = '用品';
        $data = array(
            'o_name' => $_POST['name'],
            'o_phone' => $_POST['phone'],
            'o_num' => $_POST['num'],
            'o_address' => $_POST['address'],
            'o_text' => $_POST['text'],
            'o_cardid' => $_POST['cardid'],
            'o_openid' => $_POST['openid'],
            'o_aid' => $_POST['id'],
            'o_price' => $_POST['price'],
            'o_time' => $time,
            'o_number' => $o_number,
            'o_cate' => $o_cate,
        );
        $order = M()->table("my_hd_order")->add($data);
        //$this->ajaxReturn($data);
        if ($order) {
            // 公众号的id和secret
            $appid = 'wxc0a07eb0a480bd56';
            $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
            $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $tokenArr = json_decode($this->httpGet($token_url), true);
            $openids[] = $openid;   //yonghu
            $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
            foreach ($openids as $key => $value) {
                $template = array(
                    'touser' => $value,
                    'template_id' => "xy7-rGvo49g2LlRg4wq8aTZZP3u01K-Z90YuTswTz70",
                    'url' => "",
                    'miniprogram' => array(
                        'appid' => "",
                        'pagepath' => ""
                    ),
                    'data' => array(
                        'first' => array(
                            'value' => urlencode("用品需求"),
                            'color' => "#173177"
                        ),
                        'keyword1' => array(
                            'value' => urlencode($data['o_name']),
                            'color' => "#173177"
                        ),
                        'keyword2' => array(
                            'value' => urlencode($data['o_phone']),
                            'color' => "#173177"
                        ),
                        'keyword3' => array(
                            'value' => urlencode('用品需求'),
                            'color' => "#173177"
                        ),
                        'keyword4' => array(
                            'value' => urlencode($data['o_time']),
                            'color' => "#173177"
                        ),
                        'remark' => array(
                            'value' => urlencode('订单编号：' . $data['o_number'] . '\n提示信息：恭喜您场地需求提交成功。更多详情请关注《渠道PLUS微管家精彩活动平台》！'),
                            'color' => "#173177"
                        ),
                    )
                );
                if (isset($tokenArr['access_token'])) {
                    $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tokenArr['access_token'];
                    $send = json_decode($this->httpGet($url2, urldecode(json_encode($template))), true);
                }
            }
            //公众号消息推送结束
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }


    // 个人中心
    public function center()
    {
        $this->wxOther();
        $cardId = session("cardId");
        //dump($cardId);exit();
        if ($cardId) {
            $this->display();
        } else {
            $client = new \OpenApiClient ();
            $url2 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];//获取当前的url地址
            $info = $this->wechat($url2);//
            if ($info['openid']) {
                $id = $info['openid'];//获取用户id
                session("openid", $id);
            }


            $appid = 'wxc0a07eb0a480bd56';
            $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
            $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $tokenArr = json_decode($this->httpGet($access_token), true);


            $information_1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $tokenArr['access_token'] . "&openid=" . $id . "&lang=zh_CN";
            $information_2 = json_decode($this->httpGet($information_1), true);
            //dump($information_2);
            session("information", $information_2);//存储在session


            $data = array(
                "deviceType" => "1",
                "thirdOpenId" => $id
            );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
            // 2.发起请求
            $response_data = $client->CallHttpPost("GetMemberGuidByOpenId", $data);
            session("infor", $response_data);//存储在session
            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");
            //   dump($cardId);
            // die();
            // 判断是否登录
            //if (!empty($cardId)) {
            if ($cardId) {
                /*
                *系统消息状态
                */
                // $merber=$_SESSION['infor']['data']['0']['TrueName'];
                // $m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
                // if ($m_state){
                // 	$m_statenow =1;
                // }else{
                // 	$m_statenow =2;
                // }
                // session("message_state", $m_statenow);
                //系统消息状态结束
                $this->display();
            } else {
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }

    // 会员信息
    public function information()
    {
        if ($_REQUEST['openid']) {
            $client = new \OpenApiClient();
            $data = array(
                "deviceType" => "1",
                "thirdOpenId" => $_REQUEST['openid'],
            );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
            // 2.发起请求
            $response_data = $client->CallHttpPost("GetMemberGuidByOpenId", $data);
            session("infor", $response_data);//存储在session
            $cardId = session("cardId");
            $uriqi = strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            // dump($response_data);
            // die();
            //医生的信息
            $this->assign("age", $age);
            $this->assign("conven_1", $response_data);
            $this->display();
        } else {
            $client = new \OpenApiClient();
            $url2 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];//获取当前的url地址
            $info = $this->wechat($url2);//
            if ($info['openid']) {
                $id = $info['openid'];//获取用户id
            }
            $data = array(
                "deviceType" => "1",
                "thirdOpenId" => $id
            );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
            // 2.发起请求
            $response_data = $client->CallHttpPost("GetMemberGuidByOpenId", $data);
            session("infor", $response_data);//存储在session
            $cardId = session("cardId");
            $uriqi = strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            // dump($response_data);
            // die();
            //医生的信息
            $this->assign("age", $age);
            $this->assign("conven_1", $response_data);
            $this->display();
        }
    }

    // 活动报名订单
    public function actorder()
    {
        $o_state = $_REQUEST['o_state'];
        $cardid = $_REQUEST['cardid'];
        if ($o_state) {
            $order = M()->table("my_hd_order as o")->join("my_hd_activity as a on a.a_id = o.o_aid")->where("o_cardid = '$cardid' and o_state = '$o_state' and o_cate = '报名'")->order("o_time desc")->select();
            $count = count($order);
        } else {
            $order = M()->table("my_hd_order as o")->join("my_hd_activity as a on a.a_id = o.o_aid")->where("o_cardid = '$cardid' and o_cate = '报名'")->order("o_time desc")->select();
            $count = count($order);
        }
        $this->assign(compact('order', 'count', 'o_state'));
        $this->display();
    }

    // 报名订单详情页 时间 2019-1-4
    public function actordercon()
    {
        $o_number = $_REQUEST['o_number'];
        $ordercon = M()->table("my_hd_order as o")->join("my_hd_activity as a on a.a_id = o.o_aid")->where("o_number = '$o_number'")->find();
        $this->assign(compact('ordercon', 'count', 'o_state'));
        $this->display();
    }


    /*
    *
    *	报名评价
    *   时间：2019-01-07
    *   author：Ertao
    */
    public function evaluate()
    {
        $number = $_REQUEST['o_number'];
        $ordercon = M()->table("my_hd_order as o")->join("my_hd_activity as a on a.a_id = o.o_aid")->where("o_number = '$number'")->find();
        $orderevalu = array(
            '非常满意',
            '服务很好',
            '印象不错',
            '描述相符',
            '性价比高',
            '行程合理',
        );
        $this->assign(compact('ordercon', 'orderevalu', 'o_state'));
        $this->display();
    }

    // 报名评价最终提交
    public function evalusub()
    {
        $time = Date('Y-m-d H:i:s');
        $onumber = $_POST['o_number'];
        $data = array(
            'e_star' => $_POST['level'],  //
            'e_keywords' => implode(" ", $_POST['label']),   //
            'e_text' => $_POST['content'],  //
            'e_name' => $_POST['name'],  //
            'e_headimg' => $_POST['userimg'],  //
            'e_cardid' => $_POST['cardid'],  //
            'e_openid' => $_POST['openid'],  //
            'e_aid' => $_POST['aid'],  //
            'e_onumber' => $_POST['o_number'],  //
            'e_time' => $time,  //
        );
        $evaluate = M()->table("my_hd_evaluate")->add($data);
        //$this->ajaxReturn($evaluate);
        if ($evaluate) {
            $date = array(
                'o_state' => 4,
            );
            $evaluate = M()->table("my_hd_order")->where("o_number = '$onumber'")->save($date);
            if ($evaluate) {
                $this->ajaxReturn(1);
            } else {
                $evaluate = M()->table("my_hd_evaluate")->where("e_id = '$evaluate'")->delete();
                $this->ajaxReturn(2);
            }
        } else {
            $this->ajaxReturn(0);
        }

    }

    // 收藏列表
    public function collec()
    {
        $cardid = $_REQUEST['cardid'];
        //$time = date('Y-m-d H:i:s');
        $time = time();
        $actlist = M()->table("my_hd_collect as c")->join("my_hd_activity as a on a.a_id = c.c_aid")->where("c.c_cardid = '$cardid' and a.a_category = '活动'")->select();
        $endTime = strtotime($actlist['0']['a_end']);
        //dump($endTime);
        $suplist = M()->table("my_hd_collect as c")->join("my_hd_activity as a on a.a_id = c.c_aid")->where("c.c_cardid = '$cardid' and a.a_category = '用品'")->select();
        $sitelist = M()->table("my_hd_collect as c")->join("my_hd_activity as a on a.a_id = c.c_aid")->where("c.c_cardid = '$cardid' and a.a_category = '场地'")->select();
        $this->assign(compact('actlist', 'suplist', 'sitelist', 'time', 'endTime'));
        $this->display();
    }

    //删除收藏
    public function collecdel()
    {
        $c_id = $_POST['cid'];
        $cllection = M()->table("my_hd_collect")->where("c_id = '$c_id'")->delete();
        if ($cllection) {
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }

    //收藏
    public function collecadd()
    {
        $c_id = $_POST['cid'];
        $a_id = $_POST['a_id'];
        $cardid = $_POST['cardid'];
        if ($c_id) {
            //判断收藏存在
            $cllection = M()->table("my_hd_collect")->where("c_id = '$c_id'")->delete();
            if ($cllection) {
                $state = array(
                    'a_id' => $a_id,
                    'cardid' => $cardid,
                    'state' => 1,
                );
                $this->ajaxReturn($state);
            } else {
                $this->ajaxReturn(0);
            }
        } else {
            if ($a_id != '' && $cardid != '') {
                $time = Date('Y-m-d H:i:s');
                $data = array(
                    'c_aid' => $a_id,
                    'c_cardid' => $cardid,
                    'c_time' => $time,
                );
                $cllection = M()->table("my_hd_collect")->add($data);
                if ($cllection) {
                    $state = array(
                        'c_id' => $cllection,
                        'a_id' => $a_id,
                        'cardid' => $cardid,
                        'state' => 1,
                    );
                    $this->ajaxReturn($state);
                } else {
                    $this->ajaxReturn(0);
                }
            } else {
                $this->ajaxReturn(2);
            }
        }
    }

    // 模糊查询
    public function search()
    {
        $map = array();
        $keywords = $_REQUEST['keywords'];
        if ($keywords) {
            $map['a_title|a_address|a_category|a_site|a_cate|a_type|a_scale'] = array('like', '%' . $keywords . '%');
            //$map['p_category'] = "旅游";
            // $map['e_category'] = "仓库";
        }
        // $count = M()->table("my_th_project as p")->join("my_th_images as i on i.i_pid=p.p_id")->where($map)->count();
        // $page = new Page($count,10);
        // //分页跳转的时候保证查询条件
        // foreach ($sear as $key => $value) {
        // 	if (!is_array($value)) {
        // 		$page->parameter .="$key=".urlencode($value)."&";
        // 	}
        // }
        // $show = $page->show();
        // $factory = M()->table("my_th_project as p")->join("my_th_images as i on i.i_pid=p.p_id")->where($map)->group("p.p_id")->limit($page->firstRow,$page->listRows)->select();
        // foreach ($factory as $key => $value) {
        // 	$p_serve  = $factory[$key]['p_serve'];//查询单条数据
        // 	$p_serves = explode(" ", $p_serve);//分割
        // 	$factory[$key]['erji'] = $p_serves;//赋值
        // }
        // $name = $keywords;
        // dump($name);
        $alist = M()->table("my_hd_activity")->where($map)->select();
        // foreach ($mlist as $key => $value) {
        // 	$m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
        // 	$p_serves = explode(",", $m_workunits);//分割
        // 	$m_work = explode(" ", $p_serves[0]);
        // 	$mlist[$key]['erji'] = $m_work;//赋值
        // }
        $time = date('Y-m-d H:i:s');
        //dump($alist);
        $this->assign(compact('alist', 'time', 'keywords'));
        $this->display();
    }





    /********************  精彩活动  结束******************************************************************************/


}