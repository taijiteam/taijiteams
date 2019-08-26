<?php
namespace Home\Controller;
use Common\Model\MemberModel;
use Common\Service\HttpService;
use Common\Service\WxOauthService;
use Think\Controller;
use Think\Log;
use Think\Model;

header("Content-type: text/html; charset=utf-8");
class DoctorController extends AdminController {
	public function _initialize(){
		Vendor('phpSDK.OpenApiClient');
	}

    /*******************************  微信授权  开始****************************************************/
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

    /*******************************  微信授权 结束****************************************************/

    /*******************************  名医风采 开始****************************************************/
	//主页
    public function Housekeeper()
    {
        $this->display();
    }
	public function index(){
	    /*$this->wxOther();*/
	    $cardId = session('cartId');
	    if ($cardId) {
		    //调用主页信息
			$h_list=M()->query("select * from my_hospital");
			$do_list_1=M()->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid limit 2");
			$do_list_2=M()->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid GROUP BY do.do_doctor");
			/*
			*系统消息状态
			*/
			$merber=$_SESSION['infor']['data']['0']['TrueName'];
			$m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
			//$m_state  = M()->query("select * from my_message where m_state=1 and m_merber=".$merber);
			// dump($m_state);
			// die();
			//$m_state  = M()->table("my_message")->where("m_state=1 and m_merber=''")->select();
			if ($m_state){
				$m_statenow =1;
			}else{
				$m_statenow =2;
			}
			session("message_state", $m_statenow);
			//系统消息状态结束
			$this->assign(compact('response_data','h_list','do_list_1','do_list_2'));
			$this->display();
	        
	    }elseif ($aOpenid['data']['0']['MemberGroupName']=='待审核') {
	        $re['code']='-1';
	        $re['message']='成员级别不支持此功能，请升级成员卡';
	        $re['url']= $this->groupUpdate;
	        echo json_encode($re,JSON_UNESCAPED_UNICODE);
	        die;
	    }else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberRegister"</script>';
	    }
	}
	public function ranking(){
		$this->display();
	}
	//预约页
	public function appoint(){
		$this->wxOther();
		$cardId = session("cardId");
		$age = $this->getAge($uriqi);

		// 判断是否登录
	    if ($cardId) {
			$doctor = M("doctor");
			$do = M()->table("my_doctor as do")->join("my_department as de on de.de_doid=do.do_deid")->join("my_hospital as h on h.h_id=do.do_deid")->where('do_id='.$_REQUEST['do_id'])->find();
			$this->assign(compact('do','age'));
			$this->display();
	    }else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberRegister"</script>';
	    }
	}
	//根据生日计算年龄函数
	public function getAge($birthday){
	    //格式化出生时间年月日
	    $byear=date('Y',$birthday);
	    $bmonth=date('m',$birthday);
	    $bday=date('d',$birthday);

	    //格式化当前时间年月日
	    $tyear=date('Y');
	    $tmonth=date('m');
	    $tday=date('d');

	    //开始计算年龄
	    $age=$tyear-$byear;
	    if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){
	         $age--;
	    }
	    return $age;
	}
	//成功预约提醒页
	public function feed(){
		$order = M("order");
		$openid = $_POST['openid'];
		$order=$_POST;
		if (!$order) {
			$this->error($order->getError());
		}else{
			$order_time=Date('Y-m-d H:i:s');
			$order_number=date(ymd).substr(time(),-5).substr(microtime(),2,5);//用户订单号自动生成
			$date = array(
				'order_user'        =>$_POST['order_user'],
				'order_usex'        =>$_POST['order_usex'],
				'order_uage'        =>$_POST['order_uage'],
				'order_uphone'      =>$_POST['order_uphone'],
				'order_dohospital'  =>$_POST['order_dohospital'],
				'order_dodepar'     =>$_POST['order_dodepar'],
				'order_doctor'      =>$_POST['order_doctor'],
				'order_choose'      =>$_POST['order_choose'],
				'order_describe'    =>$_POST['order_describe'],
				'order_ustart'      =>$_POST['order_ustart'],
				'order_uend'        =>$_POST['order_uend'],
				'order_time'        =>$order_time,
				'order_number'      =>$order_number,
			);
			$orderadd = M()->table("my_order")->add($date);
			if ($orderadd) {

		//系统消息推送
        $message = array(
				'm_merber'=>$_POST['order_user'],
				'm_content'=>"恭喜您！于".$order_time."成功预约".$_POST['order_dohospital']."就医服务，请您保持电话畅通，稍后会有服务顾问联系您！",
				'm_time'=>$order_time,
				'm_message'=>"订单号:".$order_number,
			);
        $messageadd = M()->table("my_message")->add($message);
        //系统消息结束

		// 公众号的id和secret
        $appid = 'wxc0a07eb0a480bd56';
        $appsecret = '5b7af4e7e07f1fcf1b4ca8b720cd11d3';
        $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $tokenArr = json_decode($this->httpGet($token_url),true);

        $openids[] = $openid;   //yonghu
        //$openids[] = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';   //yangkanglong openid
        $openids[] = 'o1xY9wvrjRPBPUpzCh6y6DSVcnDk';   //
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
                 'first'=> array( 'value'=>urlencode("医疗预约"),
                                  'color'=>"#173177"
                                ),
                 'keyword1'=> array( 'value'=>urlencode($date['order_user']),
                                     'color'=>"#173177"
                                   ),
                 'keyword2'=> array( 'value'=>urlencode($date['order_uphone']),
                                     'color'=>"#173177"
                                   ),
                 'keyword3'=> array( 'value'=>urlencode('医疗预约'),
                                     'color'=>"#173177"
                                   ),
                 'keyword4'=> array( 'value'=>urlencode($date['order_time']),
                                     'color'=>"#173177"
                                   ),
                 'remark'=> array( 'value'=>urlencode('订单编号：'.$date['order_number'].''),
                                   'color'=>"#173177"
                                 ),
               )
           );
           if (isset($tokenArr['access_token'])){
             $url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokenArr['access_token'];
             $send = json_decode($this->httpGet($url2,urldecode(json_encode($template))),true);
           }
        }
        //公众号消息推送结束

        /*
			*系统消息状态
			*/
			$merber=$_SESSION['infor']['data']['0']['TrueName'];
			$m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
			if ($m_state){
				$m_statenow =1;
			}else{
				$m_statenow =2;
			}
			session("message_state", $m_statenow);
			//系统消息状态结束

				$title="
					<h2>恭喜您预约成功！</h2>
					<div>
						<p>感谢您的预约，</p>
						<p>稍后客服会与您联系，</p>
						<p>请保持电话畅通，谢谢！</p>
					</div>";
				$this->assign("title",$title);
				$this->display();
			}else {
				$this->error("预约失敗");
			}
		}
	}
	//医院列表页
	public function hospital(){
		//$hospital = M("hospital");
		$h_list=M()->query("select * from my_hospital");
		$this->assign("h_list",$h_list);
		$this->display();
	}
	//医院详情页
	public function hospital_content(){
        $h_id =$_REQUEST['h_id'];
        $hospital=M("hospital");
        $h=$hospital->table("my_hospital as h")->join("my_department as d on h.h_id=d.de_hid")->where(['h_id' => $h_id])->find();//查医院
        $h_list=$hospital->table("my_hospital as h")->join("my_department as d on h.h_id=d.de_hid")->where(['h_id' => $h_id])->select();//查医院科室


        $Model = new Model();
        $doctor_list = $Model->table('my_doctor')->field("*")->where(['do_hid'=>$h_id])->select();
        $label = M()->query("select la.la_label from my_label as la join my_doctor as do on la.la_doid=do.do_Id where la.la_doid=".$h_id);

        $this->assign(compact('h','h_list'));
        $this->assign('doctor_list',$doctor_list);
        $this->assign('label',$label);
        $this->display();

	}
	//医生列表
	public function doctor(){
		//$doctor = M("doctor");
		$do_list=M()->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid GROUP BY do.do_doctor");
		foreach ($do_list as $key => $value) {
    		$do_id=$do_list[$key]['do_Id'];
    		
    		$elist = M()->query("select la.la_label from my_doctor as do join my_hospital as ho on do.do_hid=ho.h_id join my_department as de on do.do_deid = de.de_doid join my_label as la on do.do_id=la.la_doid where la_doid='$do_id' GROUP by la.la_label");
    		$do_list[$key]['erji']=$elist;
    	}

		$this->assign("do_list",$do_list);
		$this->display();
	}
	//医生详情页
	public function doctor_content(){
		$do_id=I("get.do_id");
		$do = M()->table("my_doctor as do")->join("my_department as de on de.de_doid=do.do_deid")->join("my_hospital as h on h.h_id=do.do_deid")->where('do_id='.$_REQUEST['do_id'])->find();
		//$label = M()->table("my_label as la")->join("my_doctor as do on do.do_id=la.la_doid")->where('la_doid='.$_REQUEST['do_id'])-select();
		$label = M()->query("select la.la_label from my_label as la join my_doctor as do on la.la_doid=do.do_Id where la.la_doid=".$_REQUEST['do_id']);
		$doctor  = $do['do_doctor'];
		$ev_list = M()->table("my_evaluation")->where("ev_doctor='$doctor'")->select();//查询所有评价
		$ev_dlevel_3 = M()->table("my_evaluation")->where("ev_dlevel=3 and ev_doctor='$doctor'")->count();//非常好
		$ev_dlevel_2 = M()->table("my_evaluation")->where("ev_dlevel=2 and ev_doctor='$doctor'")->count();//很好
		$ev_dlevel_1 = M()->table("my_evaluation")->where("ev_dlevel=1 and ev_doctor='$doctor'")->count();//一般
		$this->assign(compact('ev_list','do','ev_dlevel_3','ev_dlevel_2','ev_dlevel_1','label'));
		$this->display();
	}
	//住院
	public function ihospital(){
		//$ihospital = M("hospital");
		$ih_list=M()->query("select * from my_hospital");
		// dump($ih_list);
		// die();
		$this->assign("ih_list",$ih_list);
		$this->display();
	}
	//住院科室医生
	public function ihospital_list(){
		//$doctor = M("doctor");
		$doctor = M("doctor");
		$h_id=$_REQUEST['h_id'];
		$hospital = M()->query("select h_hospital from my_hospital where h_id='$h_id'");
	
		$do_list=$doctor->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid  where h.h_id='$h_id' GROUP BY do.do_doctor");
		foreach ($do_list as $key => $value) {
    		$do_id=$do_list[$key]['do_Id'];
    		
    		$elist = M()->query("select la.la_label from my_doctor as do join my_hospital as ho on do.do_hid=ho.h_id join my_department as de on do.do_deid = de.de_doid join my_label as la on do.do_id=la.la_doid where la_doid='$do_id' GROUP by la.la_label");
    		$do_list[$key]['erji']=$elist;
    	}
		$department=M("department");
		$de_list=$department->query("select *from my_department group by de_department");
		$this->assign(compact('do_list','de_list','h_id','hospital'));
		$this->display();
		// $do_list=M()->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid");
		// //$department=M("department");
		// $de_list=M()->query("select *from my_department group by de_department");
		// $this->assign(compact('do_list','de_list'));
		// $this->display();
	}
	//科目分类查找医生
	public function ihospital_list_1(){
		//$doctor = M("doctor");
		$department = M("department");
		$de_department=I("get.de_department");
		$h_id=$_REQUEST['h_id'];
		$hospital = M()->query("select h_hospital from my_hospital where h_id='$h_id'");
		
		$do_list=$department->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid where de_department='$de_department' and h.h_id='$h_id' GROUP BY do.do_doctor");
		foreach ($do_list as $key => $value) {
    		$do_id=$do_list[$key]['do_Id'];
    		
    		$elist = M()->query("select la.la_label from my_doctor as do join my_hospital as ho on do.do_hid=ho.h_id join my_department as de on do.do_deid = de.de_doid join my_label as la on do.do_id=la.la_doid where la_doid='$do_id' GROUP by la.la_label");
    		$do_list[$key]['erji']=$elist;
    	}
		$department=M("department");
		$de_list=$department->query("select *from my_department group by de_department");
		$this->assign(compact('do_list','de_list','h_id','hospital'));
		$this->display('Doctor/ihospital_list');
	}
	//科目分类
	public function department(){
		$doctor = M("doctor");
		$do_list=$doctor->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid GROUP BY do.do_doctor");
		foreach ($do_list as $key => $value) {
    		$do_id=$do_list[$key]['do_Id'];
    		
    		$elist = M()->query("select la.la_label from my_doctor as do join my_hospital as ho on do.do_hid=ho.h_id join my_department as de on do.do_deid = de.de_doid join my_label as la on do.do_id=la.la_doid where la_doid='$do_id' GROUP by la.la_label");
    		$do_list[$key]['erji']=$elist;
    	}
		$department=M("department");
		$de_list=$department->query("select *from my_department group by de_department");
		$this->assign(compact('do_list','de_list'));
		$this->display();
	}
	//科目分类选择
	public function department_list(){
        $department = M("department");
        $de_department=I("get.de_department");


        $do_list=$department->query("select * from my_doctor as do join my_department as de on de.de_doid=do.do_deid join my_hospital as h on h.h_id=do.do_deid where de_department='$de_department'");
        foreach ($do_list as $key => $value) {
            $do_id=$do_list[$key]['do_Id'];

            $elist = M()->query("select la.la_label from my_doctor as do join my_hospital as ho on do.do_hid=ho.h_id join my_department as de on do.do_deid = de.de_doid join my_label as la on do.do_id=la.la_doid where la_doid='$do_id' GROUP by la.la_label");
            $do_list[$key]['erji']=$elist;
        }

        $de_list=$department->query("select *from my_department group by de_department");
        $this->assign(compact('do_list','de_list'));
        $this->display('Doctor/department');
	}
	//联系我们
	public function tellme(){
		$this->display();
	}
	//系统消息
	public function message(){
		$m_merber = $_REQUEST['m_merber'];
		$mlist	  = M()->query("select * from my_message where m_merber='$m_merber' order by m_time desc");
		//系统消息状态
		$merber=$_SESSION['infor']['data']['0']['TrueName'];
		$m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
		if ($m_state){
			$m_statenow =1;
		}else{
			$m_statenow =2;
		}
		session("message_state", $m_statenow);
		//系统消息状态结束
		$this->assign("message",$message);
		$this->assign("mlist",$mlist);
		$this->display();
	}
	//系统消息详细
	public function message_content(){
		$m_id = $_REQUEST['m_id'];
		if($m_id){
			$message = M()->table("my_message")->where("m_id=".$m_id)->find();
			if ($message['m_state']==1) {
				$messageupdate = M()->query("update my_message set m_state=2 where m_id='$m_id'");
				//重新获取消息状态
				$merber=$_SESSION['infor']['data']['0']['TrueName'];
				$m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
				if ($m_state){
					$m_statenow =1;
				}else{
					$m_statenow =2;
				}
				session("message_state", $m_statenow);
				//系统消息状态结束
				$this->assign("message",$message);
				$this->display();
			}
			else{
				//$message = M()->table("my_message")->where("m_id=".$m_id)->find();
				// dump($message);
				// die();
				$this->assign("message",$message);
				$this->display();
			}
		}
		
	}
	//个人中心
	public function center(){
	    $this->wxOther();
        $cardId = session("cardId");
		// 判断是否登录
		if ($cardId) {
			//系统消息状态
			$merber=$_SESSION['infor']['data']['0']['TrueName'];
			$m_state  = M()->table("my_message")->where("m_state=1 and m_merber='$merber'")->select();
			if ($m_state){
				$m_statenow =1;
			}else{
				$m_statenow =2;
			}
			session("message_state", $m_statenow);
			//系统消息状态结束
	    	$this->display();
		}else{}
	}
	//会员信息
	public function information(){
		// dump($_SESSION);
  //   	die();
		$client = new \OpenApiClient();
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
    	session("infor", $response_data);//存储在session
    	$cardId = session("cardId");
    	$uriqi=strtotime($response_data['data']['0']['Birthday']);
		$age = $this->getAge($uriqi);
		// dump($response_data);
		// die();
		//医生的信息
		$this->assign("age",$age);
		$this->assign("conven_1",$response_data);
		$this->display();
	}
	//所有订单
	public function order_all(){
		//$order = M("order");
		$phone=$_REQUEST['order_uphone'];

		//$order_list = $order->where('order_uphone='.$_REQUEST['order_uphone'])->select();
		$order_list = M()->query("select * from my_order where order_uphone='$phone' order by order_time desc");
		// dump($order_list);
		// die();
		if($state==1){
			$title = "订单待确认";
		}elseif ($state==2) {
			$title = "订单待支付";
		}elseif ($state==3) {
			$title = "订单待评价";
		}else{
			$title = "全部订单";
		}
		// dump($order_list);
		// die();
		$this->assign(compact('order_list','title'));
		$this->display('Doctor/order');
	}
	//个人订单
	public function order(){
		//$order = M("order");
		$phone=$_REQUEST['order_uphone'];
		$state=$_REQUEST['order_state'];

		//$order_list = $order->where('order_uphone='.$_REQUEST['order_uphone'])->select();
		$order_list = M()->query("select * from my_order where order_uphone='$phone' and order_state='$state' order by order_time desc");
		if($state==1){
			$title = "订单待确认";
		}elseif ($state==2) {
			$title = "订单待支付";
		}elseif ($state==3) {
			$title = "订单待评价";
		}else{
			$title = "全部订单";
		}
		// dump($order_list);
		// die();
		$this->assign(compact('order_list','title'));
		$this->display();
	}
	//订单详细
	public function order_content(){
// 		Vendor('payAPI.JSAPI');
// 		//①、获取用户openid
// 		$tools = new \JsApiPay();
// 		$openId = $tools->GetOpenid();
// 		dump($tools);
// 		 die();
// 		//②、统一下单
// $input = new \WxPayUnifiedOrder();
// $input->SetBody($Body);
// $input->SetAttach($Body);
// $input->SetOut_trade_no($Out_trade_no);
// $input->SetTotal_fee($Total_fee*100);
// $input->SetTime_start(date("YmdHis"));
// $input->SetTime_expire(date("YmdHis", time() + 600));
// $input->SetGoods_tag($Body);
// $input->SetNotify_url("http://www.qudaoplus.cn/");
// $input->SetTrade_type("JSAPI");
// $input->SetOpenid($openid);
// $order = \WxPayApi::unifiedOrder($input);
// $this->jsApiParameters = $tools->GetJsApiParameters($order);

// 		//获取共享收货地址js函数参数
// 		$editAddress = $tools->GetEditAddressParameters();
		//支付代码结束
		$order = M("order");
		$order_content=$order->table("my_order as o")->join("my_service as ser on ser.ser_id=o.order_choose")->where('order_id='.$_REQUEST['order_id'])->find(); //获取订单详情
		$this->assign('openid',$openid);
		$this->assign("content",$order_content);
		$this->display();
	}
	public function pay(){
		if ($_REQUEST['order_id']) {
			$order=M()->query("update my_order set order_state=3 where order_id=".$_REQUEST['order_id']);
			// dump($order);
			// die();
			if (!$order){
				$this->display();
			}else{
				$this->error("添加失败");
			}
			
		}else{
			$this->error($order->getError());
		}
	}
	//微信公众号支付
	public function wechatAPI(){
		
	}
	//就医评价
	public function evaluation_list(){

		// dump($order);
		// die();
		$phone=$_REQUEST['order_uphone'];
		$state=$_REQUEST['order_state'];

		//$order_list = $order->where('order_uphone='.$_REQUEST['order_uphone'])->select();
		$order_list = M()->query("select * from my_order where order_uphone='$phone' and order_state='$state' order by order_time desc");
		// dump($order_list);
		// die();
		if($state==1){
			$title = "订单待确认";
		}elseif ($state==2) {
			$title = "订单待支付";
		}elseif ($state==3) {
			$title = "订单待评价";
		}else{
			$title = "全部订单";
		}
		// dump($order_list);
		// die();
		$this->assign(compact('order_list','title'));
		$this->display();
	}
	//就医评价
	public function evaluation(){

		$order_number = $_REQUEST['order_number'];
		//dump($order_number);
		$order = M()->table("my_order")->where("order_number=".$_REQUEST['order_number'])->find();
		//$order = M()->query("select * from my_order where order_number=".$_REQUEST['order_number']);
		//dump($order);
		$evstate = M()->table("my_evaluation")->where("ev_number=".$_REQUEST['order_number'])->find();
		// dump($evstate);
		// die();
		$this->assign("evstate",$evstate);
		$this->assign("order",$order);
		$this->display();
	}
	public function evalu_deal(){
		$evaluation = $_POST;
		if (!$evaluation) {
			$this->error($order->getError());
		}else{
			$ev_time=Date('Y-m-d H:i:s');
			$date = array(
				'ev_number'=>$_POST['ev_number'],
				'ev_doctor'=>$_POST['ev_doctor'],
				'ev_mylevel'=>$_POST['ev_mylevel'],
				'ev_all'=>$_POST['ev_all'],
				'ev_dlevel'=>$_POST['ev_dlevel'],
				'ev_user'=>$_POST['ev_user'],
				'ev_content'=>$_POST['ev_content'],
				'ev_time'=>$ev_time,
			);
			// dump($date);
			// die();
			$date1 = array(
				'order_state'=>"4",
			);
			// dump($order);
			// dump($_POST['ev_number']);
			//   die();
			$orderadd = M()->table("my_order")->where("order_number=".$_POST['ev_number'])->save($date1);
			 // dump($orderadd);
			 //  die();
			//$orderadd=Db::table('my_order')->insert($date);
			//$orderadd=M()->table("my_order")->insert($order);//页面
			//$orderadd=M()->query("insert into my_order(order_id) values ($_POST['id'])");
			if ($orderadd) {
				$evaluationadd = M()->table("my_evaluation")->add($date);

				if ($evaluationadd) {
					
					$title="
					<h2>恭喜您评价成功！</h2>
					<div>
						<p>感谢您的评价，</p>
						<p>提升服务质量，优化平台</p>
						<p>界面，做出适于大众的好平台</p>
					</div>";
					$this->assign("title",$title);
					$this->display('Doctor/feed');
				}
				else{
					$this->error("订单评价失败");
				}
			}else{
				$this->error("订单评价失败");
			}
		}
	}
	//意见反馈
	public function feedback(){
		$phone = $_REQUEST['f_phone'];
		//dump($phone);
		$this->assign("phone",$phone);
		$this->display();
	}
	public function feed_deal(){
		$feedback = $_POST;
		if(!$feedback){
			$this->error($order->getError());
		}else{
			$f_time=Date('Y-m-d H:i:s');
			$date = array(
				'f_phone'=>$_POST['f_phone'],
				'f_content'=>$_POST['f_content'],
				'f_time'=>$f_time,
			);
			$feedbackadd = M()->table("my_feedback")->add($date);
			if ($feedbackadd) {
				$title="
				<h2>恭喜您反馈成功！</h2>
				<div>
					<p>感谢您的反馈，</p>
					<p>提升服务质量，优化平台</p>
					<p>界面，做出适于大众的好平台</p>
				</div>";
				$this->assign("title",$title);
				$this->display('Doctor/feed');
			}else{
				$this->error("反馈失败");
			}
		}
	}
    /*******************************  名医风采 结束****************************************************/
}
