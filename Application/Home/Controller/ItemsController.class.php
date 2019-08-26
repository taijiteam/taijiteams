<?php


namespace Home\Controller;
use Think\Controller;
use Think\Log;

class ItemsController extends AdminController
{

    /******************************  项目对接 开始****************************************************************/

    //项目对接  首页
    public function index(){
        $this->display();
    }
    /**
     * 项目对接预约信息提交
     *
     */
    public function project(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');

        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //成员卡号
            $data['oddmember']= 'xm'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //项目名称
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']  = $_REQUEST['rpay'];
                $data['rpay']     = '是';                        //是否支付
            }else {
                $data['rpay']     = '否';
            }
            $data['check']    = '等待审核';                     //审核
            $data['remark']   = $_REQUEST['remark'];

            $reAdd = $reserve->data($data)->add();
            if ($reAdd!=false) {
                $re['code'] = '1';
                $re['message'] = '预约成功';
                $re['url'] = '/Home/Items/central';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                // 公众号的id和secret
                $appid = 'wxc0a07eb0a480bd56';
                $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
                $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                $tokenArr = json_decode($this->httpGet($token_url),true);

                $openids[] = 'o1xY9wm9JSfoPtX1QyFpK1TNSC4s';   //liuhui openid
                $openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
                foreach ($openids as $key => $value) {
                    $template = array(
                        'touser'=> $value,
                        'template_id'=>"xy7-rGvo49g2LlRg4wq8aTZZP3u01K-Z90YuTswTz70",
                        'url'=>"",
                        'miniprogram'=>array(
                            'appid'=>"",
                            'pagepath'=>""
                        ),
                        'data'=>array(
                            'first'=> array( 'value'=>urlencode("项目对接"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('项目对接'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode('无'),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('项目名称：'.$data['itemname'].'\n备注：'.$data['remark'].''),
                                'color'=>"#173177"
                            ),
                        )
                    );
                    if (isset($tokenArr['access_token'])){
                        $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
                        $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
                    }
                }
                die;
            }else {
                $re['code'] = '0';
                $re['message'] = '预约失败';
                $re[''] = '';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }
        }else {
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
            $info = $this->wechat($url2);
            if( $info['openid'] ){
                $id = $info['openid'];
            }
            $data_openid = array (
                "deviceType" => '1',
                "thirdOpenId" => $id
            );
            $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
            if ( $wechatOpenid['status']!='0' ) {
                $cardid = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }
            $this->assign('cardid',$cardid);
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
    }



    //成员中心
    public function central(){
        $client = new \OpenApiClient ();

        $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];//获取当前的url地址
        $info = $this->wechat($url2);//
        if( $info['openid'] ){
            $id = $info['openid'];//获取用户id
        }

        $data = array (
            "deviceType" => "1",
            "thirdOpenId" => $id
        );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
        // 2.发起请求
        $response_data = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data );
        session("cardId", $response_data['data']['0']['CardId']);//存储在session
        $cardId = session("cardId");
        // print_r($response_data);
        // die();
        if( $response_data['status'] == 0 ){
            $card_data = array(
                "cardId"=>$cardId,
                "password"=>"",
                "isGetExtValue"=>"true"
            );//isGetExtValue更多扩展信息；一卡易扩展会员
            $response_card = $client->CallHttpPost ( "Get_MemberInfo", $card_data );
            $card_arr = $response_card['data']['0'];
            // 判断性别
            if ($response_card['data']['0']['Sex'] =='1' ) {
                $sex = "先生";
            }elseif ($response_card['data']['0']['Sex'] =='2' ) {
                $sex = "女士";
            }else {
                $sex = "未知";
            }
            // 判断成员卡图片
            if ( $response_card['data']['0']['MemberGroupName'] == '亦享成员' ) {
                $card_img = "https://files.1card1.cn/g1/M02/84/B8/CgoMA1pDAQOAGXryAACCa0SXK9w157.png";
                $cardname = '亦享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '致享成员' ) {
                $card_img = "https://files.1card1.cn/g1/M02/76/09/CgoMA1pDALWASKFSAADaYOHInSw624.png";
                $cardname = '致享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '悦享成员' ) {
                $card_img = "https://files.1card1.cn/g1/M02/E7/4B/CgoMA1mT2r6ALqUjAACMWuISPsQ315.png";
                $cardname = '悦享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '真享成员' ) {
                $card_img = "https://files.1card1.cn/g1/M02/87/F5/CgoMA1mT22uAfPkgAACbrQdNdeg308.png";
                $cardname = '真享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '君享成员' ) {
                $card_img = "https://files.1card1.cn/g1/M02/63/93/CgoMA1obtbOAawEuAADsCAi6_QU845.png";
                $cardname = '君享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '尊享大咖' ) {
                $card_img = "https://files.1card1.cn/g1/M02/1E/55/CgoMA1mT2R2AUwcsAADif52jgfc168.png";
                $cardname = '尊享';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '高级顾问' ) {
                $card_img = "https://files.1card1.cn/g1/M01/9B/65/CgoMA1mCmTGAWsbzAABqZvhl-oE620.png";
                $cardname = '顾问';
            } elseif ( $response_card['data']['0']['MemberGroupName'] == '待审核' ) {
                $card_img = "https://files.1card1.cn/g1/M02/CE/C8/CgoMA1mepR-ASxdNAACNQNpOT-c516.png";
            }else {
                $card_img = "https://files.1card1.cn/g1/M00/AD/C9/CgoMA1Xcb5KAHS66AAAyo46nUDk347.png";
            }
            // 页面映射
            $this->assign('card_arr',$card_arr);
            $this->assign('card_img',$card_img);
            $this->assign('cardname',$cardname);
            $this->assign('sex',$sex);
            $this->display();
        }else{
            redirect( $this->Register );
        }
    }
}
    /******************************  项目对接 结束****************************************************************/