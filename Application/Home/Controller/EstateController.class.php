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
class EstateController extends AdminController {
	public function _initialize(){
		Vendor('phpSDK.OpenApiClient');
		//Vendor('PHPSDK.lib.OpenApiClient');
	}
	public function upload(){
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Public/Uploads/Estate/'; // 设置附件上传根目录
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        $this->error("请上传图片");
	    }else{// 上传成功
	        return $info;
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

	/****************************************** 微信授权 开始**********************************************************/
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
        //if($response_data['data']['0']['MemberGroupName'] == "亦享成员" || $response_data['data']['0']['MemberGroupName'] == "待审核"){
        if($response_data['data']['0']['MemberGroupName'] == "待审核"){
            echo '<script charset="utf-8">alert("温馨提示：您的成员卡不支持此功能，请升级成员卡");location.href="http://shop.qudaoplus.cn/Home/Home/index";</script>';
        }
        session("cardId", $response_data['data']['0']['CardId']);
        session("response_data", $response_data);
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

	/****************************************** 微信授权 结束**********************************************************/




	/****************************************** 房   产 开始**********************************************************/
    public function Housekeeper()
    {
        $this->display();
    }

	//主页
	public function index(){
		$this->wxOther();
		$cardId = session("cardId");
		// 判断是否登录
	    if ($cardId) {
	    	$shops 		= M()->query("select es.e_title,es.e_id,p.p_photo from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and es.e_state=1 group by es.e_id limit 3");
	    	$residence  = M()->query("select es.e_title,es.e_id,p.p_photo from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and es.e_state=1 group by es.e_id limit 3");
	    	$office 	= M()->query("select es.e_title,es.e_id,p.p_photo from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and es.e_state=1 group by es.e_id limit 3");
			$this->assign(compact('shops','residence','office'));
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
	}
	//详细页面
	public function content(){
		$e_id 	 = $_REQUEST['e_id'];
		//echo $e_id;
		$openid  = session("cardId");
		$collect = M()->table("my_fc_collection")->where("c_eid='$e_id' and c_cardid='$openid'")->find();
		$content = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->where("e_id='$e_id'")->find();
		$photo   = M()->table("my_fc_photo")->where("p_eid='$e_id'")->select();
		$photo1   = M()->table("my_fc_photo")->where("p_eid='$e_id'")->select();
		$this->assign(compact('content','zt','photo','photo1','collect'));
		$this->display();
	}
	//商铺页面
	public function shops(){
		$e_category = $_REQUEST['e_category'];
		$shops 		= M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where("e_category='$e_category' and es.e_state=1")->group("es.e_id")->select();
		$this->assign(compact('shops'));
		$this->display();
	}
	//写字楼
	public function office(){
		$e_category = $_REQUEST['e_category'];
		$office 	= M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where("e_category='$e_category' and es.e_state=1")->group("es.e_id")->select();
		$this->assign(compact('office'));
		$this->display();
	}
	//住宅
	public function residence(){
		$e_category = $_REQUEST['e_category'];
		$residence 	= M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where("e_category='$e_category' and es.e_state=1")->group("es.e_id")->select();
		$this->assign(compact('residence'));
		$this->display();
	}
	//仓库厂房
	public function factory(){
		$e_category1 = $_REQUEST['e_category1'];
		$e_category2 = $_REQUEST['e_category2'];
		$factory 	 = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where("e_category='$e_category1' or e_category='$e_category2' and es.e_state=1")->group("es.e_id")->select();
		$this->assign(compact('factory'));
		$this->display();
	}
	//区域看房
	public function regional(){
		$e_regional = $_REQUEST['e_regional'];
		$regional   = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where re.r_regional='$e_regional' and es.e_state=1 group by es.e_id");
		$this->assign(compact('regional'));
		$this->display();
	}
	//联系我们页面
	public function tellme(){
		$this->display();
	}
	//	个人中心页面
	public function center(){
	    $this->wxOther();
		$cardId = session("cardId");
		// 判断是否登录
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
		}else{}
	}
	//会员信息
	public function information(){
        $response_data = session('response_data');
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
	//发布房源
	public function rental(){
		$openid = $_REQUEST['openid'];
		if($openid){
			$regional = M()->table("my_fc_regional")->select();
			$this->assign(compact('regional','openid'));
			$this->display();
		}else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
	    }
	}
	public function rentaladd(){
		$order 			=$_POST['e_title'];
		$e_community 	= $_POST['e_community'];
		$e_address 		= $_POST['e_address'];
		$e_area 		= $_POST['e_area'];
		$e_rent 		= $_POST['e_rent'];
		$photo 			=$_FILES['photo'];
		if (!$photo){
			$this->error($photo->getError());
		}else{
			if(!$order||!$e_community||!$e_address||!$e_area||!$e_rent){
				$this->error("信息输入不全");
			}else{
				$info =  $this->upload();
				$e_time=Date('Y-m-d H:i:s');
				$data = array(
					'e_title'		=>$_POST['e_title'],//标题
					'e_regional'	=>$_POST['e_regional'],//所在区域
					'e_community'	=>$_POST['e_community'],//小区名称
					'e_address'		=>$_POST['e_address'],//小区地址
					'e_housetype'	=>$_POST['e_hosetype'],//户型
					'e_rent'		=>$_POST['e_rent'],//租金
					'e_payment'		=>$_POST['e_payment'],//付款方式
					'e_area'		=>$_POST['e_area'],//面积
					'e_category'	=>'住宅',//类型
					'e_conditions'	=>$_POST['e_conditions'],//装修
					'e_floor'		=>$_POST['e_floor'],//楼层
					'e_describe'	=>$_POST['e_describe'],//描述
					'e_toward'		=>$_POST['e_toward'],//朝向
					'e_bed'			=>$_POST['e_bed'],//床
					'e_tv'			=>$_POST['e_tv'],//电视
					'e_kongtiao'	=>$_POST['e_kongtiao'],//空调
					'e_washer'		=>$_POST['e_washer'],//洗衣机
					'e_heating'		=>$_POST['e_heating'],//暖气
					'e_balcony'		=>$_POST['e_balcony'],//阳台
					'e_wardrobe'	=>$_POST['e_wardrobe'],//衣柜
					'e_calorifier'	=>$_POST['e_calorifier'],//热水器
					'e_microwave'	=>$_POST['e_microwave'],//微波炉
					'e_refrigerator'=>$_POST['e_refrigerator'],//冰箱
					'e_kitchen'		=>$_POST['e_kitchen'],//厨房
					'e_gas'			=>$_POST['e_gas'],//煤气
					'e_furniture'	=>$_POST['e_furniture'],//桌椅
					'e_toilet'		=>$_POST['e_toilet'],//卫生间
					'e_parking'		=>$_POST['e_parking'],//车位
					'e_openid'		=>$_POST['e_openid'],//openid
					'e_uphone'		=>$_POST['e_uphone'],//用户联系方式
					'e_release'		=>$_POST['e_release'],//用户姓名
					'e_time'		=>$e_time,//
					'e_state'		=>'',//
				);
				$estateadd = M()->table("my_fc_estate")->add($data);
				
				if ($estateadd) {
					$e_id = $estateadd;
		            foreach($info as $key =>$info) {
		                $phot[] = array(
		                	'p_photo' =>$info['savepath'].$info['savename'],
		                	'p_eid' =>$e_id,
		                ); 
		            }
		            $photoadd = M()->table("my_fc_photo")->addAll($phot);
		            if($photoadd){
			            $this->ajaxReturn(1);
			        }else{
			            $this->ajaxReturn(0);
			        } 
		    //         if($photoadd){
		    //             $title="
						// <h2>提交成功</h2>
						// <div>
						// 	<p>信息提交成功</p>
						// 	<p>我们会在24小时内审核</p>
						// 	<p>您可以在个人中心我的发布</p>
						// 	<p>查看发布状态，谢谢</p>
						// </div>";
						// $this->assign("title",$title);
						// $this->display('Estate/feed');
		    //         }else{
		    //             $this->error("添加失敗");
		    //         }
		        }else{
		        	$this->error("添加失敗");
		        }
			}
		}
	}
	//	修改我的房源信息
	public  function hmod(){
		$e_id = $_REQUEST['e_id'];
		$regional = M()->table("my_fc_regional")->select();
		$photo1   = M()->table("my_fc_photo")->where("p_eid=$e_id")->select();
		$estate   = M()->table("my_fc_estate")->where("e_id=$e_id")->find();
		$this->assign(compact('regional','photo1','estate'));
		$this->display();
	}
	public function hmodajax(){
		$p_id=I("post.p_id");
        $photo=M()->table("my_fc_photo")->where("p_id = $p_id")->select();//查询选择的信息
        unlink("./Public/Uploads/Estate/".$photo[0]["p_photo"]); //删除当前信息的图片
        $result=M()->table("my_fc_photo")->where("p_id = $p_id")->delete();//删除当前信息
        if($result){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        } 
	}

	//	终究修改我的房源信息
	public function upload_1(){
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Public/Uploads/Estate/'; // 设置附件上传根目录
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        return $info;
	    }else{// 上传成功
	        return $info;
	    }
	}
	public function hmodend(){
		$order 			=$_POST['e_title'];
		$e_community 	= $_POST['e_community'];
		$e_address 		= $_POST['e_address'];
		$e_area 		= $_POST['e_area'];
		$e_rent 		= $_POST['e_rent'];
		$photo 			=$_FILES['photo'];
		$e_id 			= $_POST['e_id'];
		if(!$order||!$e_community||!$e_address||!$e_area||!$e_rent){
			$this->error("信息输入不全");
		}else{
			$info =  $this->upload_1();
			if(!$info){
				$e_time=Date('Y-m-d H:i:s');
				$data = array(
					'e_title'		=>$_POST['e_title'],//标题
					'e_regional'	=>$_POST['e_regional'],//所在区域
					'e_community'	=>$_POST['e_community'],//小区名称
					'e_address'		=>$_POST['e_address'],//小区地址
					'e_housetype'	=>$_POST['e_hosetype'],//户型
					'e_rent'		=>$_POST['e_rent'],//租金
					'e_payment'		=>$_POST['e_payment'],//付款方式
					'e_area'		=>$_POST['e_area'],//面积
					'e_category'	=>'住宅',//类型
					'e_conditions'	=>$_POST['e_conditions'],//装修
					'e_floor'		=>$_POST['e_floor'],//楼层
					'e_describe'	=>$_POST['e_describe'],//描述
					'e_toward'		=>$_POST['e_toward'],//朝向
					'e_bed'			=>$_POST['e_bed'],//床
					'e_tv'			=>$_POST['e_tv'],//电视
					'e_kongtiao'	=>$_POST['e_kongtiao'],//空调
					'e_washer'		=>$_POST['e_washer'],//洗衣机
					'e_heating'		=>$_POST['e_heating'],//暖气
					'e_balcony'		=>$_POST['e_balcony'],//阳台
					'e_wardrobe'	=>$_POST['e_wardrobe'],//衣柜
					'e_calorifier'	=>$_POST['e_calorifier'],//热水器
					'e_microwave'	=>$_POST['e_microwave'],//微波炉
					'e_refrigerator'=>$_POST['e_refrigerator'],//冰箱
					'e_kitchen'		=>$_POST['e_kitchen'],//厨房
					'e_gas'			=>$_POST['e_gas'],//煤气
					'e_furniture'	=>$_POST['e_furniture'],//桌椅
					'e_toilet'		=>$_POST['e_toilet'],//卫生间
					'e_parking'		=>$_POST['e_parking'],//车位
					'e_openid'		=>$_POST['e_openid'],//openid
					'e_uphone'		=>$_POST['e_uphone'],//用户联系方式
					'e_release'		=>$_POST['e_release'],//用户姓名
					'e_time'		=>$e_time,//
					'e_state'		=>'',//
				);
				$estateadd = M()->table("my_fc_estate")->where("e_id=$e_id")->save($data);
				if($estateadd){
		            $this->ajaxReturn(1);
		        }else{
		            $this->ajaxReturn(0);
		        } 
				// if($estateadd){
	   //              $title="
				// 	<h2>修改成功</h2>
				// 	<div>
				// 		<p>信息修改成功</p>
				// 		<p>我们会在24小时内审核</p>
				// 		<p>您可以在个人中心我的发布</p>
				// 		<p>查看发布状态，谢谢</p>
				// 	</div>";
				// 	$this->assign("title",$title);
				// 	$this->display('Estate/feed');
	   //          }else{
	   //              $this->error("修改失敗");
	   //          }
			}else{
				$e_time=Date('Y-m-d H:i:s');
				$data = array(
					'e_title'		=>$_POST['e_title'],//标题
					'e_regional'	=>$_POST['e_regional'],//所在区域
					'e_community'	=>$_POST['e_community'],//小区名称
					'e_address'		=>$_POST['e_address'],//小区地址
					'e_housetype'	=>$_POST['e_hosetype'],//户型
					'e_rent'		=>$_POST['e_rent'],//租金
					'e_payment'		=>$_POST['e_payment'],//付款方式
					'e_area'		=>$_POST['e_area'],//面积
					'e_category'	=>'住宅',//类型
					'e_conditions'	=>$_POST['e_conditions'],//装修
					'e_floor'		=>$_POST['e_floor'],//楼层
					'e_describe'	=>$_POST['e_describe'],//描述
					'e_toward'		=>$_POST['e_toward'],//朝向
					'e_bed'			=>$_POST['e_bed'],//床
					'e_tv'			=>$_POST['e_tv'],//电视
					'e_kongtiao'	=>$_POST['e_kongtiao'],//空调
					'e_washer'		=>$_POST['e_washer'],//洗衣机
					'e_heating'		=>$_POST['e_heating'],//暖气
					'e_balcony'		=>$_POST['e_balcony'],//阳台
					'e_wardrobe'	=>$_POST['e_wardrobe'],//衣柜
					'e_calorifier'	=>$_POST['e_calorifier'],//热水器
					'e_microwave'	=>$_POST['e_microwave'],//微波炉
					'e_refrigerator'=>$_POST['e_refrigerator'],//冰箱
					'e_kitchen'		=>$_POST['e_kitchen'],//厨房
					'e_gas'			=>$_POST['e_gas'],//煤气
					'e_furniture'	=>$_POST['e_furniture'],//桌椅
					'e_toilet'		=>$_POST['e_toilet'],//卫生间
					'e_parking'		=>$_POST['e_parking'],//车位
					'e_openid'		=>$_POST['e_openid'],//openid
					'e_uphone'		=>$_POST['e_uphone'],//用户联系方式
					'e_release'		=>$_POST['e_release'],//用户姓名
					'e_time'		=>$e_time,//
				);
				$estateadd = M()->table("my_fc_estate")->where("e_id=$e_id")->save($data);
				if ($estateadd) {
		            foreach($info as $key =>$info) {
		                $phot[] = array(
		                	'p_photo' =>$info['savepath'].$info['savename'],
		                	'p_eid' =>$e_id,
		                ); 
		            }
		            $photoadd = M()->table("my_fc_photo")->addAll($phot);
		            if($photoadd){
		            	$this->ajaxReturn(1);
			        }else{
			            $this->ajaxReturn(0);
			        } 
		    //         if($photoadd){
		    //             $title="
						// <h2>修改成功</h2>
						// <div>
						// 	<p>信息修改成功</p>
						// 	<p>我们会在24小时内审核</p>
						// 	<p>您可以在个人中心我的发布</p>
						// 	<p>查看发布状态，谢谢</p>
						// </div>";
						// $this->assign("title",$title);
						// $this->display('Estate/feed');
		    //         }else{
		    //             $this->error("修改失敗");
		    //         }
		        }else{
		        	$this->error("修改失敗");
		        }
		    }
		}
	}
	//	我发布的房源
	public function house(){
		$phone = $_REQUEST['phone'];
		if($phone){
			//$house = M()->table("my_fc_estate as e")->join("my_fc_photo as p on e.e_id=p.p_eid")->where("e_openid='$openid'")->select();
			$house = M()->query("select * from my_fc_estate as e join my_fc_photo as p on e.e_id=p.p_eid where e_uphone=$phone group by e.e_id order by e.e_time");
			$this->assign("house",$house);
			$this->display();
		}else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
	    }
	}
	//	删除我发布的房源
	public function h_del(){
		$e_id=I("post.e_id");
        $photo=M()->table("my_fc_photo")->where("p_eid = $e_id")->select();//查询选择的信息
        foreach ($photo as $key => $photo) {
			$photo = $photo["p_photo"];
			unlink("./Public/Uploads/Estate/".$photo); //删除当前信息的图片
		}
        //unlink("./Public/Uploads/Estate/".$photo[0]["p_photo"]); //删除当前信息的图片
        $p_del=M()->table("my_fc_photo")->where("p_eid = $e_id")->delete();//删除图片列表信息
		$e_del=M()->table("my_fc_estate")->where("e_id = $e_id")->delete();//删除当前信息
        if($p_del && $e_del){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
// $e_id=I("post.e_id");
// $photo=M("my_fc_photo")->where("p_eid = $e_id")->select();//查询选择的信息
// unlink("./Public/Uploads/Estate/".$photo["p_photo"]); //删除当前信息的图片
// $result=M("my_fc_photo")->where("p_eid = $e_id")->delete();//删除图片列表信息
// $result=M("my_fc_estate")->where("e_id = $e_id")->delete();//删除当前信息
// if($result){
//     $this->ajaxReturn(1);
// }else{
//     $this->ajaxReturn(0);
// }
	}
	//	我的预约
	public function appoint(){
		$e_id = $_REQUEST['e_id'];
		$openid = $_REQUEST['openid'];
		if ($openid) {
			$estate = M()->table("my_fc_estate")->where("e_id='$e_id'")->find();
			$this->assign("estate",$estate);
			$this->display();
		}else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
	    }
		
	}
	//	我的预约
	public function appointadd(){
		$or_utime =$_POST['or_utime'];
		$or_content = $_POST['or_content'];
		if(!$or_utime){
			$this->error("请输入预约时间");
		}else{
			$or_time=Date('Y-m-d H:i:s');
			$data = array(
				'or_eid'	=>$_POST['or_eid'],//商品编号
				'or_user'	=>$_POST['or_user'],//预约用户
				'or_uphone'	=>$_POST['or_uphone'],//预留手机号
				'or_openid'	=>$_POST['or_openid'],//用户openid
				'or_utime'	=>$_POST['or_utime'],//预约看房时间
				'or_content'=>$_POST['or_content'],//预约留言
				'or_time'	=>$or_time,//订单提交时间
				'or_manager'=>$_POST['or_manager'],//经理人
				'or_mphone'	=>$_POST['or_mphone'],//经理人手机号
			);
			$orderadd = M()->table("my_fc_order")->add($data);
			if($orderadd){
				$title="
				<h2>提交成功</h2>
				<div>
					<p>预约提交成功</p>
					<p>稍后房产经理会与您联系，</p>
					<p>请您保持电话畅通，谢谢！</p>
				</div>";
				$this->assign("title",$title);
				$this->display('Estate/feed');
			}else{
				$this->error("添加失敗");
			}
		}
	}
	//	我预约的房源
	public function order(){
		$openid = $_REQUEST['openid'];
		$order 	= M()->table("my_fc_order as o")->join("my_fc_estate as e on o.or_eid=e.e_id")->join("my_fc_photo as p on p.p_eid=e.e_id")->where("or_openid='$openid'")->group("e.e_id")->select();
		$this->assign("order",$order);
		$this->display();
	}
	//意见反馈
	public function feedback(){
		$openid = $_REQUEST['openid'];
		$user = $_REQUEST['user'];
		$uphone = $_REQUEST['uphone'];
		if($openid){
			
			$this->assign(compact('openid','user','uphone'));
			$this->display();
		}else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
	    }
	}
	public function feedbackadd(){
		if (!$_POST) {
			$this->error($order->getError());
		}else{
			$o_time=Date('Y-m-d H:i:s');
			$data = array(
				'o_user' 	=> $_POST['o_user'], 
				'o_uphone' 	=> $_POST['o_uphone'], 
				'o_openid' 	=> $_POST['o_openid'], 
				'o_content' => $_POST['o_content'], 
				'o_time' 	=> $o_time, 
			);
			$opinion = M()->table("my_fc_opinion")->add($data);
			if($opinion){
		                $title="
						<h2>提交成功</h2>
						<div>
							<p>谢谢您的反馈</p>
							<p>我们会认真考虑您的建议或者意见</p>
							<p>让我们一起建立一个更好的平台！</p>
						</div>";
						$this->assign("title",$title);
						$this->display('Estate/feed');
		            }else{
		                $this->error("添加失敗");
		            }
		}
	}
    //	添加收藏
    public function collecadd(){
        $c_id = $_POST['cid'];
        $p_id = $_POST['p_id'];
        $cardid = $_POST['cardid'];
        if ($c_id) {
            $cllection = M()->table("my_fc_collection")->where("c_id = '$c_id'")->delete();
            if ($cllection) {
                $state = array(
                    'p_id' => $p_id,
                    'cardid' => $cardid,
                    'state' => 1,
                );
                $this->ajaxReturn($state);
            }else{
                $this->ajaxReturn(0);
            }
        }else{
            if ($p_id != '' && $cardid != '') {
                $data = array(
                    'c_eid' => $p_id,
                    'c_cardid' => $cardid,
                );
                $cllection = M()->table("my_fc_collection")->add($data);
                if ($cllection) {
                    $state = array(
                        'c_id' => $cllection,
                        'p_id' => $p_id,
                        'cardid' => $cardid,
                        'state' => 1,
                    );
                    $this->ajaxReturn($state);
                }else{
                    $this->ajaxReturn(0);
                }
            }else{
                $this->ajaxReturn(2);
            }
        }
    }

	//	我的收藏
	public function collect(){
        $openid  = session("cardId");
		if ($openid) {
        	$collect = M()->table("my_fc_collection as c")->join("my_fc_estate as e on c.c_eid=e.e_id")->join("my_fc_photo as p on p.p_eid=e.e_id")->where("c.c_cardid='$openid'")->group("e.e_id")->select();
        	$this->assign("collect",$collect);
			$this->display();
        }else {
	        echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
	    }
	}
	//	全站检索
	public function sousuo(){
		$map = array();
		$keywords = $_POST['keywords'];
		if ($keywords) {
			$map['e_title|e_category|e_address|r_regional|e_rent'] = array('like','%'.$keywords.'%' );
			$map['e_state'] = 1;
		}
		$max = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where($map)->group("es.e_id")->select();
		$count = count($max);
		$page = new Page($count,10);
		//分页跳转的时候保证查询条件
		foreach ($sear as $key => $value) {
			if (!is_array($value)) {
				$page->parameter .="$key=".urlencode($value)."&";
			}
		}
		$show = $page->show();
		$data = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->group("es.e_id")->where($map)->limit($page->firstRow,$page->listRows)->select();
		$this->assign(compact('count','show','data'));
		$this->display();
	}
            /**	8月31号最新筛选 **/
    //商铺
	public function screeningSP(){
// $shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id where es.e_category='商铺' and re.r_regional='黄浦区' and es.e_rent>=0 and es.e_rent<=100000 and es.e_area>=0 and es.e_area<=100000");
// 			dump($shops);
// 			die();
		// $data = array(
		// 	'e_regional' => $_POST['e_regional'],//区域
		// 	'e_rentmin' => $_POST['e_rentmin'],//租金最小值
		// 	'e_rentmax' => $_POST['e_rentmax'],//租金最大值
		// 	'e_areamin' => $_POST['e_areamin'],//面积最小值
		// 	'e_areamax' => $_POST['e_areamax'],//面积最大值
		// 	'e_category' => $_POST['e_category'],//房源类型分类
		// 	 );
		$r_regional = $_POST['e_regional'];//区域
		$e_rentmin = $_POST['e_rentmin'];//租金最小值
		$e_rentmax = $_POST['e_rentmax'];//租金最大值
		$e_areamin = $_POST['e_areamin'];//面积最小值
		$e_areamax = $_POST['e_areamax'];//面积最大值
		if ($r_regional&$e_rentmin&$e_rentmax&$e_areamin&$e_areamax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and r_regional='$r_regional' and e_rent>=$e_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");

		}elseif ($r_regional&$e_rentmin&$e_rentmax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and re.r_regional='$r_regional' and es.e_rent>=$e_rentmin and es.e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional&$e_areamin&$e_areamax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and r_regional='$r_regional' and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_rentmin&$e_rentmax&$e_rentmin&$e_rentmax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_areamin&$e_areamax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and e_area>=$r_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
		}elseif ($e_rentmin&$e_rentmax) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional) {
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and r_regional='$r_regional' and es.e_state=1 group by es.e_id");
		}else{
			$shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='商铺' and es.e_state=1 group by es.e_id");
		}
		$this->assign(compact('shops'));
		$this->display('Estate/shops');
	}

	// 	写字楼
	public function screeningXZ(){
// $shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id where es.e_category='商铺' and re.r_regional='黄浦区' and es.e_rent>=0 and es.e_rent<=100000 and es.e_area>=0 and es.e_area<=100000");
// 			dump($shops);
// 			die();
		$data = array(
			'e_regional' 	=> $_POST['e_regional'],//区域
			'e_rentmin' 	=> $_POST['e_rentmin'],//租金最小值
			'e_rentmax' 	=> $_POST['e_rentmax'],//租金最大值
			'e_areamin' 	=> $_POST['e_areamin'],//面积最小值
			'e_areamax' 	=> $_POST['e_areamax'],//面积最大值
			'e_category' 	=> $_POST['e_category'],//房源类型分类
			 );
		// $r_regional = $_POST['e_regional'];//区域
		// $e_rentmin 	= $_POST['e_rentmin'];//租金最小值
		// $e_rentmax 	= $_POST['e_rentmax'];//租金最大值
		// $e_areamin 	= $_POST['e_areamin'];//面积最小值
		// $e_areamax 	= $_POST['e_areamax'];//面积最大值
		$r_regional = $data['e_regional'];//区域
		$e_rentmin 	= $data['e_rentmin'];//租金最小
		$e_rentmax 	= $data['e_rentmax'];//租金最大
		$e_areamin 	= $data['e_areamin'];//面积最小
		$e_areamax 	= $data['e_areamax'];//租金最大

			if ($r_regional&$e_rentmin&$e_rentmax&$e_areamin&$e_areamax) {
				// dump(1);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and r_regional='$r_regional' and e_rent>='$e_rentmin' and e_rent<='$e_rentmax' and e_area>='$e_areamin' and e_area<='$e_areamax' and es.e_state=1 group by es.e_id");

			}elseif ($r_regional&$e_rentmin&$e_rentmax) {
				// dump(2);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and re.r_regional='$r_regional' and es.e_rent>=$e_rentmin and es.e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
			}elseif ($r_regional&$e_areamin&$e_areamax) {
				// dump(3);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and r_regional='$r_regional' and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
				
			}elseif ($e_rentmin&$e_rentmax&$e_rentmin&$e_rentmax) {
				// dump(4);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
				
			}elseif ($e_areamin&$e_areamax) {
				// dump(5);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and e_area>=$r_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			}elseif ($e_rentmin&$e_rentmax) {
				// dump(6);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
			}elseif ($r_regional) {
				// dump(7);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and r_regional='$r_regional' and es.e_state=1 group by es.e_id");
			}else{
				// dump(8);
				// dump($r_regional);
				// dump($e_rentmin);
				// dump($e_rentmax);
				// dump($e_areamin);
				// dump($e_areamax);
				// dump($data);
				$office = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='写字楼' and es.e_state=1 group by es.e_id");
			}
			$this->assign(compact('office'));
			$this->display('Estate/office');
		//}
	}
	// 	住宅
	public function screeningZZ(){
// $shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id where es.e_category='商铺' and re.r_regional='黄浦区' and es.e_rent>=0 and es.e_rent<=100000 and es.e_area>=0 and es.e_area<=100000");
// 			dump($shops);
// 			die();
		// $data = array(
		// 	'e_regional' => $_POST['e_regional'],//区域
		// 	'e_rentmin' => $_POST['e_rentmin'],//租金最小值
		// 	'e_rentmax' => $_POST['e_rentmax'],//租金最大值
		// 	'e_areamin' => $_POST['e_areamin'],//面积最小值
		// 	'e_areamax' => $_POST['e_areamax'],//面积最大值
		// 	'e_category' => $_POST['e_category'],//房源类型分类
		// 	 );
		$r_regional = $_POST['e_regional'];//区域
		$e_rentmin 	= $_POST['e_rentmin'];//租金最小值
		$e_rentmax 	= $_POST['e_rentmax'];//租金最大值
		$e_areamin 	= $_POST['e_areamin'];//面积最小值
		$e_areamax 	= $_POST['e_areamax'];//面积最大值
		if ($r_regional&$e_rentmin&$e_rentmax&$e_areamin&$e_areamax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and r_regional='$r_regional' and e_rent>=$e_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");

		}elseif ($r_regional&$e_rentmin&$e_rentmax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and re.r_regional='$r_regional' and es.e_rent>=$e_rentmin and es.e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional&$e_areamin&$e_areamax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and r_regional='$r_regional' and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_rentmin&$e_rentmax&$e_rentmin&$e_rentmax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_areamin&$e_areamax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and e_area>=$r_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
		}elseif ($e_rentmin&$e_rentmax) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional) {
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and r_regional='$r_regional' and es.e_state=1 group by es.e_id");
		}else{
			$residence = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='住宅' and es.e_state=1 group by es.e_id");
		}
		$this->assign(compact('residence'));
		$this->display('Estate/residence');
	}
		// 	厂房仓库
	public function screeningCC(){
// $shops = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id where es.e_category='商铺' and re.r_regional='黄浦区' and es.e_rent>=0 and es.e_rent<=100000 and es.e_area>=0 and es.e_area<=100000");
// 			dump($shops);
// 			die();
		// $data = array(
		// 	'e_regional' => $_POST['e_regional'],//区域
		// 	'e_rentmin' => $_POST['e_rentmin'],//租金最小值
		// 	'e_rentmax' => $_POST['e_rentmax'],//租金最大值
		// 	'e_areamin' => $_POST['e_areamin'],//面积最小值
		// 	'e_areamax' => $_POST['e_areamax'],//面积最大值
		// 	'e_category' => $_POST['e_category'],//房源类型分类
		// 	 );
		$r_regional = $_POST['e_regional'];//区域
		$e_rentmin 	= $_POST['e_rentmin'];//租金最小值
		$e_rentmax 	= $_POST['e_rentmax'];//租金最大值
		$e_areamin 	= $_POST['e_areamin'];//面积最小值
		$e_areamax 	= $_POST['e_areamax'];//面积最大值
		if ($r_regional&$e_rentmin&$e_rentmax&$e_areamin&$e_areamax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and r_regional='$r_regional' and e_rent>=$e_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");

		}elseif ($r_regional&$e_rentmin&$e_rentmax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and re.r_regional='$r_regional' and es.e_rent>=$e_rentmin and es.e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional&$e_areamin&$e_areamax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and r_regional='$r_regional' and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_rentmin&$e_rentmax&$e_rentmin&$e_rentmax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and e_area>=$e_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
			
		}elseif ($e_areamin&$e_areamax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and e_area>=$r_areamin and e_area<=$e_areamax and es.e_state=1 group by es.e_id");
		}elseif ($e_rentmin&$e_rentmax) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and e_rent>=$r_rentmin and e_rent<=$e_rentmax and es.e_state=1 group by es.e_id");
		}elseif ($r_regional) {
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and r_regional='$r_regional' and es.e_state=1 group by es.e_id");
		}else{
			$factory = M()->query("select * from my_fc_estate as es join my_fc_regional as re on es.e_regional=re.r_id join my_fc_photo as p on p.p_eid=es.e_id where es.e_category='厂房' or  es.e_category='仓库' and es.e_state=1 group by es.e_id");
		}
		$this->assign(compact('factory'));
		$this->display('Estate/factory');
	}

	//	模糊查询——商铺筛选
	public function residencesx(){
		$map = array();
		$keywords = $_REQUEST['e_regional'];
		if ($keywords) {
			$map['e_title|e_category|e_address|r_regional'] = array('like','%'.$keywords.'%' );
			$map['e_category'] = "住宅";
		}
		$count = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where($map)->group("es.e_id")->count();
		$page = new Page($count,10);
		//分页跳转的时候保证查询条件
		foreach ($sear as $key => $value) {
			if (!is_array($value)) {
				$page->parameter .="$key=".urlencode($value)."&";
			}
		}
		$show = $page->show();
		$residence = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->join("my_fc_photo as p on p.p_eid=es.e_id")->where($map)->limit($page->firstRow,$page->listRows)->group("es.e_id")->select();
		$this->assign(compact('count','show','residence'));
		$this->display('Estate/residence');
	}
	//	模糊查询——商铺筛选
	public function factorysx(){
		$map = array();
		$keywords = $_REQUEST['e_regional'];
		if ($keywords) {
			$map['e_title|e_category|e_address|r_regional'] = array('like','%'.$keywords.'%' );
			$map['e_collection'] = 1;
			// $map['e_category'] = "仓库";
		}
		$count = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->where($map)->count();
		$page = new Page($count,10);
		//分页跳转的时候保证查询条件
		foreach ($sear as $key => $value) {
			if (!is_array($value)) {
				$page->parameter .="$key=".urlencode($value)."&";
			}
		}
		$show = $page->show();
		$factory = M()->table("my_fc_estate as es")->join("my_fc_regional as re on es.e_regional=re.r_id")->where($map)->limit($page->firstRow,$page->listRows)->select();
		$this->assign(compact('count','show','factory'));
		$this->display('Estate/factory');
	}
}
/****************************************** 房   产 结束**********************************************************/