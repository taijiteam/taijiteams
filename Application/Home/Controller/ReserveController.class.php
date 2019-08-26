<?php
namespace Home\Controller;
use Think\Controller;
class ReserveController extends AdminController {

    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }

    /**
     * 未使用权益列表
     */
    public function index(){
        $client = new \OpenApiClient ();

        // 获取微信openid
        $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //获取完整url
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
            $cardId = $response_openid['data'][0]['CardId'];
            $username = $response_openid['data'][0]['TrueName'];
            $phone = $response_openid['data'][0]['Mobile'];
            $groupName = $response_openid['data'][0]['MemberGroupName'];
        }else {
            // 成员没有绑定，跳转注册
            redirect( $this->Register );
        }
        $start = $this->merDeff($cardId);//判断会员id显示信息

        $countList = array (
            "userAccount" => '10000',
            "cardId" => $cardId,
            "memberPassword" => '',
            "where" => "",
            "pageIndex" => '0',
            "pageSize" => "200",
            "orderBy" => ''
        );
        $response_countList = $client->CallHttpPost ( "Get_CountListPagedV2",$countList );
        if ( $response_countList['status']=='0') {
            $this->assign('lists',$response_countList['data']);
        }
        $this->assign("start",$start);
        $this->display();
    }
    /*
     * 时间：2019-3-6
     * 根据会员id展示
     * */
    public function merDeff($cardId){
        if ($cardId == '17612109603' || $cardId =='15601609999' || $cardId =='17724800330' || $cardId =='18918195999' || $cardId =='18918192999' || $cardId =='18918199699'|| $cardId =='18918199899' || $cardId =='13585795685'|| $cardId =='18616568505'){
            $start = 1;
        }else{
            $start = 0;
        }
        return $start;
    }
    /**
     * 医疗预约信息提交
     *
     */
    public function appointment(){
        $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $info = $this->wechat($url2);
        if( $info['openid'] ){
            $id = $info['openid'];
        }else{
            $id = 0;//
        }
        $data_openid = array (
            "deviceType" => '1',
            "thirdOpenId" => $id
        );
        $client = new \OpenApiClient ();
        $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
        $cardid = $response_openid['data'][0]['CardId'];
        $username = $response_openid['data'][0]['TrueName'];
        $phone = $response_openid['data'][0]['Mobile'];
        $this->assign('cardid',$cardid);
        $this->assign('username',$username);
        $this->assign('phone',$phone);
        $this->display();
    }


    public function hospital(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');

        $guid = $_REQUEST['guid'];                //计次唯一标识
        $itemguid = $_REQUEST['itemguid'];        //项目唯一标识

        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $cardid   = $_REQUEST['cardid'];                   //成员卡号
            $guid   = $_REQUEST['guid'];                       //计次唯一标识
            $data['cardid'] = $_REQUEST['cardid'];
            $data['oddmember']= 'yl'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //医院名称
            $data['roffice']  = $_REQUEST['roffice'];          //科室
            $data['rdoctor']  = $_REQUEST['rdoctor'];          //医生姓名
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');           //提交时间
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ( $data['payment']>'0' || $data['payment']!='' ) {
                $data['rpay']   = '是';                        //是否支付
            }else {
                $data['rpay']   = '计次消费';
            }
            $data['check']    = '等待审核';                     //审核
            $data['remark']   = $_REQUEST['remark'];

            $reAdd = $reserve->data($data)->add();
            if ($reAdd!=false) {
                $saveCount = array (
                    "userAccount" => '10000',
                    "cardId" => $cardid,
                    "memberPassword" => '',
                    "countList" => array(
                        "0" => array(
                            "Guid" => $guid,
                            "cutCount" => '1',         //扣次次数
                            "meno" =>'预约接口扣次'
                        )
                    )
                );
                $response_saveCount = $client->CallHttpPost ( "SaveCountAddConsume",$saveCount );
                if ($response_saveCount['status']=='0') {
                    $re['code'] = '1';
                    $re['message'] = '预约成功';
                    $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                                'first'=> array( 'value'=>urlencode($data['ritem']),
                                    'color'=>"#173177"
                                ),
                                'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                    'color'=>"#173177"
                                ),
                                'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                    'color'=>"#173177"
                                ),
                                'keyword3'=> array( 'value'=>urlencode($data['ritem']),
                                    'color'=>"#173177"
                                ),
                                'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                    'color'=>"#173177"
                                ),
                                'keyword5'=> array( 'value'=>urlencode(),
                                    'color'=>"#173177"
                                ),
                                'remark'=> array( 'value'=>urlencode('医院：'.$data['itemname'].'\n科室：'.$data['roffice'].'\n医生：'.$data['rdoctor'].'\n备注：'.$data['remark'].''),
                                    'color'=>"#173177"
                                ),
                            )
                        );
                        if (isset($tokenArr['access_token'])){
                            $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
                            $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
                        }
                    }
                }else {
                    $re['code'] = '-1';
                    $re['message'] = '预约失败，请联系客服';
                    $re['url'] = '';
                    echo json_encode($re,JSON_UNESCAPED_UNICODE);
                }
                die;
            }else {
                $re['code'] = '-1';
                $re['message'] = '预约失败，请联系客服';
                $re['url'] = '';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }
        }else {
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //获取完整url
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
                $cardId = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
                $groupName = $response_openid['data'][0]['MemberGroupName'];
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }
            if ( $groupName=='待审核' ) {
                // echo "<script> if(confirm('请升级成员卡')){location.href='".$this->groupUpdate."'}else{javascript :history.back(-1)}</script>";
                echo "<script> alert('请升级成员卡');location.href='".$this->groupUpdate."'</script>";
            }

            $type = $_REQUEST['type'];        // (检查：1；就诊：2；住院：3；)
            if ($type=='1') {
                $typeName = '检查';
            }elseif ($type=='2') {
                $typeName = '就诊';
            }elseif ($type=='3') {
                $typeName = '住院';
            }
            $this->assign('typeName',$typeName);  //当前权益名称

            // 医生姓名
            $name = $_REQUEST['name'];
            $this->assign('name',$name);
            // 医院名称
            $hospital = $_REQUEST['hospit'];
            $this->assign('hospital',$hospital);

            // 通过备注区分
            $countList = array (
                "userAccount" => '10000',
                "cardId" => $cardId,
                "memberPassword" => '',
                "where" => " Count > 0 and Flag=1 and GoodsItemGuid='".$itemguid."'",
                "pageIndex" => '0',
                "pageSize" => "200",
                "orderBy" => ''
            );
            $response_countList = $client->CallHttpPost ( "Get_CountListPagedV2",$countList );
            if ($response_countList['status']=='0') {
                $arrList = $response_countList['data'];
            }
            foreach ($arrList as $k => $List) {
                $cont[] = $List['Count'];
            }

            $itemCont = array_sum($cont);
            $this->assign('cardId',$cardId);      //成员卡号
            $this->assign('username',$username);  //成员姓名
            $this->assign('phone',$phone);        //成员手机号
            $this->assign('groupName',$groupName);//成员级别名称
            $this->assign('itemCont',$itemCont);  //当前权益可用数量
            $this->assign('guid',$guid);  //当前权益可用数量
            $this->display();
        }
    }


    /**
     * 机场预约信息提交
     *
     */
    public function airport(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            // $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            // $data['rname']    = $_REQUEST['rname'];            //姓名
            // $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            // $data['itemname'] = $_REQUEST['itemname'];         //机场名称
            // $data['rdate']    = $_REQUEST['rdate'];            //日期
            // $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            // $data['payment']  = $_REQUEST['payment'];          //支付金额
            // if ($data['payment'] > '0') {
            //   // $data['rpay']     = $_REQUEST['rpay'];
            //   $data['rpay']     = '是';                        //是否支付
            // }else {
            //   $data['rpay']     = '否';
            // }
            // $data['check']    = '等待审核';                     //审核
            // $data['remark']   = $_REQUEST['remark'];
            $data['ritem']    = '机场特约VVIP';         //预约项目名称
            $data['rname']    = '某某';            //姓名
            $data['rmobile']   = '131147258369';   //手机号
            $data['itemname'] = '浦东国际机场';        //医院名称
            $data['rdate']    = date('Y-m-d H:i:s');            //日期
            $data['payment']  = '1599.00';          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
                $data['rpay']     = '是';                        //是否支付
            }else {
                $data['rpay']     = '否';
            }
            $data['check']    = '等待审核';                     //审核
            $data['remark']   = '尽快恢复';


            $reAdd = $reserve->data($data)->add();
            if ($reAdd!=false) {
                $re['code'] = '1';
                $re['message'] = '预约成功';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }else {
                $re['code'] = '0';
                $re['message'] = '预约失败';
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
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
            if ( $wechatOpenid['status']!='0' ) {
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
    }

    /**
     * 金融免抵押预约信息提交
     *
     */
    public function loans(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['oddmember']= 'jr'.$odd;                     //预约单号
            $data['cardid']= $_REQUEST['cardid'];              //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //企业名称
            $data['position'] = $_REQUEST['position'];         //个人职位
            $data['loanment'] = $_REQUEST['loanment'];         //贷款金额
            $data['address'] = $_REQUEST['address'];           //面谈地址
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            $data['rtime']    = $_REQUEST['rtime'];            //时段
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
                $data['rpay']     = '是';                        //是否支付
            }else {
                $data['rpay']     = '否';
            }
            $data['check']    = '等待审核';                     //审核
            $data['remark']   = $_REQUEST['remark'];

            $reAdd = $reserve->data($data)->add();
            if ($reAdd!=false) {
                $re['code'] = '1';
                $re['message'] = '申请提交成功，我们会在24小时内联系您，请您保持电话畅通！';
                $re['url'] = 'http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22';
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
                            'first'=> array( 'value'=>urlencode("金融免抵押预约"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('金融免抵押'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode($data['address']),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('企业名称：'.$data['itemname'].'\n个人职位：'.$data['position'].'\n贷款金额：'.$data['loanment'].'\n备注：'.$data['remark'].''),
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
                $re['url'] = '';
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
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
            if ( $wechatOpenid['status']!='0' ) {
                $cardid = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
            }else {
                // 成员没有绑定，跳转注册
                //redirect( $this->Register );
                $this->display();//更改为没绑定也跳转
            }
            $this->assign('cardid',$cardid);
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
    }

    /**
     * 企业咨询预约信息提交
     *
     */
    public function advis(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //成员卡号
            $data['oddmember']= 'qy'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //资源类型
            $data['address'] = $_REQUEST['address'];           //面谈地址
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            $data['rtime']    = $_REQUEST['rtime'];            //时段
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                            'first'=> array( 'value'=>urlencode("企业咨询"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('企业咨询'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode($data['address']),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('资源类型：'.$data['itemname'].'\n备注：'.$data['remark'].''),
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
                $re['url'] = '';
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
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
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

    /**
     * 商业房源预约信息提交
     *
     */
    public function property(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //成员卡号
            $data['oddmember']= 'sy'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //房源类型
            $data['address'] = $_REQUEST['address'];           //房源地址
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                            'first'=> array( 'value'=>urlencode("商业房源"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('商业房源'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode($data['address']),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('房源类型：'.$data['itemname'].'\n备注：'.$data['remark'].''),
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
                $re['url'] = '';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }
        }else {
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            // echo $url2;
            // die;
            $info = $this->wechat($url2);
            if( $info['openid'] ){
                $id = $info['openid'];
            }
            $data_openid = array (
                "deviceType" => '1',
                "thirdOpenId" => $id
            );
            $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
            if ( $wechatOpenid['status']!='0' ) {
                $cardid = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
                $group = $response_openid['data'][0]['MemberGroupName'];
                if ($group == '待审核') {
                    echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
                    redirect( $this->groupUpdate );
                    die;
                }
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }

            $title = $_REQUEST['title'];
            $address = $_REQUEST['address'];
            $this->assign('title',$title);
            $this->assign('address',$address);


            $this->assign('cardid',$cardid);
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
    }
    /**
     * 商业房源我要找店预约信息提交
     *
     */
    public function seekshop(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //成员卡号
            $data['oddmember']= 'sy'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['unit'] = $_REQUEST['unit'];         //需求预算
            $data['purpose'] = $_REQUEST['purpose'];           //用途
            $data['budget']    = $_REQUEST['budget'];            //预算
            $data['subtime']  = date('Y-m-d H:i:s');         //提交时间
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                            'first'=> array( 'value'=>urlencode("商业房源-我要找店"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('商业房源-我要找店'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode(),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode(),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('需求面积：'.$data['unit'].'\n用途：'.$data['purpose'].'\n预算：'.$data['budget'].'\n备注：'.$data['remark'].''),
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
                $re['url'] = '';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }
        }else {
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            // echo $url2;
            // die;
            $info = $this->wechat($url2);
            if( $info['openid'] ){
                $id = $info['openid'];
            }
            $data_openid = array (
                "deviceType" => '1',
                "thirdOpenId" => $id
            );
            $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
            if ( $wechatOpenid['status']!='0' ) {
                $cardid = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
                $group = $response_openid['data'][0]['MemberGroupName'];
                if ($group == '待审核') {
                    echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
                    redirect( $this->groupUpdate );
                    die;
                }
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }

            $title = $_REQUEST['title'];
            $address = $_REQUEST['address'];
            $this->assign('title',$title);
            $this->assign('address',$address);


            $this->assign('cardid',$cardid);
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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

    /**
     * 成员特惠预约信息提交
     *
     */
    public function discounts(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');

        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //预约项目名称
            $data['oddmember']= 'th'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //项目名称
            $data['address'] = $_REQUEST['address'];         //收件地址
            $data['rdate']    = $_REQUEST['date'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');           //提交时间
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                            'first'=> array( 'value'=>urlencode("成员特惠"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('成员特惠'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode($data['address']),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('活动名称：'.$data['itemname'].'\n备注：'.$data['remark'].''),
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
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $info = $this->wechat($url2);
            $tokeninfo = $this->gettoken();
            $opurl = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$tokeninfo['access_token']."&next_openid=";
            $openidarr = json_decode($this->httpGet($opurl),true);
            $openidarr = $openidarr['data']['openid'];
            if( $info['openid'] ){
                $id = $info['openid'];
            }
            // 通过openid判断微信是否关注公众号
            if(!in_array($id,$openidarr)){
                $attention = '0';
                $this->assign('attention',$attention);
            }else {
                // 通过openid判断微信是否绑定一卡易
                $data_openid = array (
                    "deviceType" => '1',
                    "thirdOpenId" => $id
                );
                $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
                if ( $wechatOpenid['status']!='0' ) {
                    $cardid = $response_openid['data'][0]['CardId'];
                    $username = $response_openid['data'][0]['TrueName'];
                    $phone = $response_openid['data'][0]['Mobile'];
                    $MemberGroupName = $response_openid['data'][0]['MemberGroupName'];
                }else {
                    // 成员没有绑定，跳转注册
                    redirect( $this->Register );
                }
                if ($MemberGroupName=='待审核') {
                    // 成员等级为待审核，跳转到买卡
                    redirect( $this->groupUpdate );
                }

                $title = urldecode($_REQUEST['title']);
                $this->assign('cardid',$cardid);
                $this->assign('username',$username);
                $this->assign('title',$title);
                $this->assign('phone',$phone);
            }
            $this->display();
        }
    }

    /**
     * 私享空间预约信息提交
     *
     */
    public function space(){
        $client = new \OpenApiClient ();
        $reserve = M('reserve');
        if (IS_POST) {
            $odd = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data['ritem']    = $_REQUEST['ritem'];            //预约项目名称
            $data['cardid']    = $_REQUEST['cardid'];          //成员卡号
            $data['oddmember']= 'sx'.$odd;                     //预约单号
            $data['rname']    = $_REQUEST['rname'];            //姓名
            $data['rmobile']  = $_REQUEST['rmobile'];          //手机号
            $data['itemname'] = $_REQUEST['itemname'];         //房源类型
            $data['unit'] = $_REQUEST['unit'];                 //人数
            $data['rdate']    = $_REQUEST['rdate'];            //日期
            $data['subtime']  = date('Y-m-d H:i:s');           //提交时间
            $data['payment']  = $_REQUEST['payment'];          //支付金额
            if ($data['payment'] > '0') {
                // $data['rpay']     = $_REQUEST['rpay'];
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
                $re['url'] = 'http://www.qudaoplus.cn/merber_all_show/index.php/home/personnal/central';
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
                            'first'=> array( 'value'=>urlencode("私享空间"),
                                'color'=>"#173177"
                            ),
                            'keyword1'=> array( 'value'=>urlencode($data['rname']),
                                'color'=>"#173177"
                            ),
                            'keyword2'=> array( 'value'=>urlencode($data['rmobile']),
                                'color'=>"#173177"
                            ),
                            'keyword3'=> array( 'value'=>urlencode('私享空间'),
                                'color'=>"#173177"
                            ),
                            'keyword4'=> array( 'value'=>urlencode($data['rdate']),
                                'color'=>"#173177"
                            ),
                            'keyword5'=> array( 'value'=>urlencode(),
                                'color'=>"#173177"
                            ),
                            'remark'=> array( 'value'=>urlencode('名称：'.$data['itemname'].'\n人数：'.$data['unit'].'\n备注：'.$data['remark'].''),
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
                $re['url'] = '';
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }
        }else {
            // 获取微信openid
            $url2 = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            $info = $this->wechat($url2);
            if( $info['openid'] ){
                $id = $info['openid'];
            }
            $data_openid = array (
                "deviceType" => '1',
                "thirdOpenId" => $id
            );
            $response_openid = $client->CallHttpPost ( "GetMemberGuidByOpenId", $data_openid );
            // $wechatOpenid = $this->acitiveOpenId($id);      //获取成员是否绑定了微信
            if ( $wechatOpenid['status']!='0' ) {
                $cardid = $response_openid['data'][0]['CardId'];
                $username = $response_openid['data'][0]['TrueName'];
                $phone = $response_openid['data'][0]['Mobile'];
                $group = $response_openid['data'][0]['MemberGroupName'];
                if ($group == '待审核') {
                    echo "<script>alert('成员级别不支持此功能，请升级成员卡！')</script>";
                    redirect( $this->groupUpdate );
                    die;
                }
            }else {
                // 成员没有绑定，跳转注册
                redirect( $this->Register );
            }

            $title = $_REQUEST['title'];
            $this->assign('title',$title);

            $this->assign('cardid',$cardid);
            $this->assign('username',$username);
            $this->assign('phone',$phone);
            $this->display();
        }
    }

}
