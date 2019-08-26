<?php
namespace Shops\Controller;
use Think\Controller;
use Think\Upload;
use Think\LoginState;
use Think\weChatMsg;
header("Content-type: text/html; charset=utf-8");
class IndexController extends Controller {
    /**
     * 接口
     */
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }
	//文件上传的相关信息写作方法，方便调用
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 31457280;
        $upload->exts = array('jpg','gif','png','jpeg');
        $upload->rootPath  =     './Public/Admin/Uploads/';
        $upload->autoSub = false;
        $upload->saveName = time().'_'.mt_rand(); 
        $info = $upload->upload();     
        return $info;
    }
    public function getMd5Password($password){
        $pwd = md5($password);
        return substr($pwd,14);//substr(被截取字符串,从第几位截取);
    }
    /**
	*
	*	登录界面
	*	时间 2019年3月18日
	*	author：ErTao
	*
	*/
	public function login(){
	    if ($_POST){
            $data['s_shopid'] = $_POST['username'];
            $data['s_pwd'] = $_POST['password'];
            $data['s_pwd'] = $this->getMd5Password($_POST['password']);
            $check = M("th_shops")->where($data)->find();
            if($check){
                session('s_pwd',$check['s_pwd']);
                session('s_name',$check['s_name']);
                session('s_shopid',$check['s_shopid']);
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }else{
            $this->display();
        }
	}
    /**
    *
    *	管理后台主页界面
    *	时间 2019年3月18日
    *	author：ErTao
    *
    */
	public function index(){
	    if ($this->LoginState($_SESSION["s_shopid"],$_SESSION["s_pwd"]) == true){
            $shopid = $_SESSION['s_shopid'];
            $orderlist = M("th_order")->where(["o_shopid" => $shopid,'o_state' => 1])->select();
            $count = count($orderlist);
            $page1 = new \Think\Page($count, 10);
            $page = $page1->show();
            $mlist = M("th_order")->where(["o_shopid" => $shopid,'o_state' => 1])->limit($page1->firstRow . ',' . $page1->listRows)->order("o_time desc")->select();
            $this->assign(compact('mlist', 'page'));
            $this->display();
        }else{
            echo '<script charset="utf-8">alert("您登陆超时或者未登录，请重新登陆，点击确认跳转疼陆界面！");</script>';
            $this->display('Index/login');
        }
	}
	//已结算订单
    public function order(){
        if ($this->LoginState($_SESSION["s_shopid"],$_SESSION["s_pwd"]) == true){
            $shopid = $_SESSION['s_shopid'];
            $orderlist = M("th_order")->where(["o_shopid" => $shopid,'o_state' => 3])->select();
            $count = count($orderlist);
            $page1 = new \Think\Page($count, 10);
            $page = $page1->show();
            $mlist = M("th_order")->where(["o_shopid" => $shopid,'o_state' => 3])->limit($page1->firstRow . ',' . $page1->listRows)->order("o_time desc")->select();
            $this->assign(compact('mlist', 'page'));
            $this->display();
        }else{
            echo '<script charset="utf-8">alert("您登陆超时或者未登录，请重新登陆，点击确认跳转疼陆界面！");</script>';
            $this->display('Index/login');
        }
    }
	//密码更改
    public function memberSave(){
	    $id = session('s_shopid');
	    //dump($id);
	    //查找用户
        $this->assign('res',$id);
        $this->display();

    }
    //密码
    public function memberGengGai(){
        $id = session('s_shopid');
        $password = $this->getMd5Password($_POST['password']);
        $repwd = $this->getMd5Password($_POST['repwd']);
        $data = array('s_pwd'=>$repwd);
        //dump($repwd);exit();
        $pass = M('th_shops')->where(['s_shopid' => $id])->find();
        //dump($pass['s_pwd']);exit();
        //密码和数据库中一样
        if($pass['s_pwd'] != $repwd){
            //两次密码验证
            if ($password == $repwd){
                //存入数据库
                $res = M('th_shops')->where(['s_shopid' => $id])->save($data);
                if($res){
                    $status['status'] = 'ok';
                    $status['content'] = '更改成功';
                    exit($this->ajaxReturn($status));
                }else{
                    $status['status'] = 'error';
                    $status['content'] = '两次密码不一致';
                    exit($this->ajaxReturn($status));
                    }
                }
            }else{
                $status['status'] = 'error';
                $status['content'] = '密码未进行修改';
                $this->ajaxReturn($status);
            }
    }
    //订单修改
	public function orderSave(){
        $money = $_POST['money'];
        $number = $_POST['number'];
        $openid = $_POST['openid'];
        $shops = $_POST['shopname'];
        $time = date('Y-m-d H:i:s');
        $data = array(
            'o_aprace' => $money,
            'o_state'  => '3'
        );
        $orderc = M("th_order")->where("o_number = '$number'")->find();
        $name = $orderc['o_user'];
        $phone = $orderc['o_phone'];
        $title = $orderc['o_pcate'].'消费';
        $order = M("th_order")->where("o_number = '$number'")->save($data);
        if ($order){
            $msg = $this->weChatMsg($openid,$name,$phone,$title,$time,$number,$money,$shops);
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }
    //退出
    public function logout(){
        //清除session
        session('s_pwd',null);
        session('s_name',null);
        session('s_shopid',null);
        $this->display('Index/login');
    }
    /**
    *
    *	商户查询会员
    *	时间 2019年3月18日13:08:15
    *	author：ErTao
    *
    */
    public function member(){
        if ($this->LoginState($_SESSION["s_shopid"],$_SESSION["s_pwd"]) == true){
            $this->display();
        }else{
            echo '<script charset="utf-8">alert("您登陆超时或者未登录，请重新登陆，点击确认跳转登陆界面！");</script>';
            $this->display('Index/login');
        }
    }
    public function memberSel(){
        $client = new \OpenApiClient();//调用一卡易系统接口
        $cardid = $_POST['cardid'];
        $data = array (
            "cardId" => $cardid,
        );
        $response_data = $client->CallHttpPost("Get_MemberInfo",$data);
        $this->ajaxReturn($response_data);
    }
    public function moneyCardid(){
        $cardid = $_POST['cardid'];
        $money = $_POST['money'];
        $shopid = $_POST['shopid'];
        $time = date('Y-m-d H:i:s');
        $data = array (
            "shop_cardid" => $cardid,
            "shop_money" => $money,
            "shop_shopid" => $shopid,
            "shop_time" => $time,
        );
        $order = M("th_shoporder")->add($data);
        if ($order){
            //$msg = $this->weChatMsg($openid,$name,$phone,$title,$time,$number,$money,$shops);
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }
    /**
     * 验证登陆
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function LoginState($user,$pwd){
        if($user==""||$pwd==null){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 微信消息推送
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function weChatMsg($openid,$name,$phone,$title,$time,$number,$money,$shops){
        // 公众号的id和secret
        $appid = 'wxc0a07eb0a480bd56';
        $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
        $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $tokenArr = json_decode($this->httpGet($token_url),true);
        $openids[] = $openid;   //yonghu
        //$openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
        $openids[] = 'o1xY9wvrjRPBPUpzCh6y6DSVcnDk';   //jingqilong openid
        foreach ($openids as $key => $value) {
            $template = array(
                'touser'=> $value,
                'template_id'=>"vuOXP0o7JN8roFHwFP9IPfhLlyBOaRIhRbsM25KGIyQ",
                'url'=>"",
                'miniprogram'=>array(
                    'appid'=>"",
                    'pagepath'=>""
                ),
                'data'=>array(
                    'first'=> array( 'value'=>urlencode($title),
                        'color'=>"#173177"
                    ),
                    'keyword1'=> array( 'value'=>urlencode($shops.''.$title),
                        'color'=>"#173177"
                    ),
                    'keyword2'=> array( 'value'=>urlencode('￥'.$money),
                        'color'=>"#173177"
                    ),
                    'keyword3'=> array( 'value'=>urlencode($time),
                        'color'=>"#173177"
                    ),
                    'keyword4'=> array( 'value'=>urlencode($number),
                        'color'=>"#173177"
                    ),
                    'remark'=> array( 'value'=>urlencode('温馨提示：'.$name.'您好，您在'.$shops.'共消费￥'.$money.'，欢迎再次光临'),
                        'color'=>"#173177"
                    ),
                )
            );
            if (isset($tokenArr['access_token'])){
                $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
                $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
            }
        }
        return $send;
        //公众号消息推送结束
    }
    /**
     * 获取微信执行后的参数
     */
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

}