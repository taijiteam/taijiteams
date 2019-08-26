<?php
namespace Home\Controller;
use Common\Model\MemberModel;
use Think\Controller;
use Think\Log;
use Think\Upload;
use Common\Service\HttpService;
use Common\Service\WxOauthService;


use Think\Page;
header("Content-type: text/html; charset=utf-8");
class ProjectController extends AdminController {
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
	/*
	*	主页
	*
	*/


	/************************************************* 精选生活  **********************************************************/
    //  精彩活动主页面
    public function Housekeeper()
    {
        $this->display();
    }
    public function index(){
        if ($_REQUEST['phone']) {
            /*//旅游
            $tourlist = M()->query("select p.p_id,p.p_little,i.i_image from my_th_project as p join my_th_images as i on i.i_pid=p.p_id where p.p_category='旅游' and p_country like '%国际%' group by p.p_id order by p.p_id desc limit 6");
            //宾馆
            $hotestar = M()->query("select * from my_th_project where p_category='宾馆' and p_star=1 group by p_id order by p_id desc limit 1");
            $hotellist = M()->query("select p.p_id,p.p_little,i.i_image from my_th_project as p join my_th_images as i on i.i_pid=p.p_id where p.p_category='宾馆' group by p.p_id order by p.p_id desc");*/
            //美食
            $foodstar = M()->query("select * from my_th_project where p_category='美食' and p_star=1 order by p_id desc limit 1");
            $foodlist = M()->query("select * from my_th_project where p_category='美食' order by p_id desc");
            // dump();
            // die();
            $this->assign(compact('tourlist','hotestar','hotellist','foodstar','foodlist'));
            $this->display();
        }else {
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session

            $response_data = $this->cloneRemoteMemberInfo($openid);
            if($response_data['data']['0']['MemberGroupName'] == "待审核"){
                echo '<script charset="utf-8">alert("温馨提示：此板块正在维护中……");location.href="http://shop.qudaoplus.cn/Home/Home/index";</script>';
            }
            //dump($response_data);
            session("infor", $response_data);//存储在session
            $jifen = $response_data['data']['0']['EnablePoint'];
            $jfrmb = ($jifen/100);
            session("jfrmb", $jfrmb);
            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");

            // 判断是否登录
            if ($cardId) {
                /*//旅游
                $tourlist = M()->query("select p.p_id,p.p_little,i.i_image from my_th_project as p join my_th_images as i on i.i_pid=p.p_id where p.p_category='旅游' and p_country like '%国际%' group by p.p_id order by p.p_id desc limit 6");
                //宾馆
                $hotestar = M()->query("select * from my_th_project where p_category='宾馆' and p_star=1 group by p_id order by p_id desc limit 1");
                $hotellist = M()->query("select p.p_id,p.p_little,i.i_image from my_th_project as p join my_th_images as i on i.i_pid=p.p_id where p.p_category='宾馆' group by p.p_id order by p.p_id desc");*/
                //美食
                $foodstar = M()->query("select * from my_th_project where p_category='美食' and p_star=1 order by p_id desc limit 1");
                $foodlist = M()->query("select * from my_th_project where p_category='美食' order by p_id desc");
                // dump();
                // die();
                $this->assign(compact('tourlist','hotestar','hotellist','foodstar','foodlist'));
                $this->display();

            }
            else
            {
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }

	//	美食列表
    public function foodlist()
    {
       //  暂时不知道干嘛用
        if ($_REQUEST['phone']) {
            $foodlist = M()->table("my_th_project as p")->where("p.p_category = '美食'")->order("p.p_id desc")->group("p.p_id")->select();
            foreach ($foodlist as $key => $value) {
                $p_merit = $project[$key]['p_features'];//查询单条数据
                $p_features = explode(" ", $p_merit);//分割
                $foodlist[$key]['erji'] = $p_features;//赋值
            }
            $this->assign(compact('foodlist'));
            $this->display();
        }
        else
        {
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session

            $response_data = $this->cloneRemoteMemberInfo($openid);
            if($response_data['data']['0']['MemberGroupName'] != "内部测试"){
                echo '<script charset="utf-8">alert("温馨提示：此板块正在维护中……");location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22";</script>';
            }
            //dump($response_data);
            session("infor", $response_data);//存储在session
            $jifen = $response_data['data']['0']['EnablePoint'];
            $jfrmb = ($jifen/100);
            session("jfrmb", $jfrmb);
            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");
            // 判断是否登录
            if ($cardId) {
                //美食
                $foodstar = M()->query("select * from my_th_project where p_category='美食' and p_star=1 order by p_id desc limit 1");
                $foodlist = M()->query("select * from my_th_project where p_category='美食' order by p_id desc");
                $this->assign(compact('foodstar','foodlist'));
                $this->display();
            }
            else
            {
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }

    //  美食详细页
    public function foodcontent(){
        $p_id = $_REQUEST['p_id'];
        //dump($p_id);
        $images = M()->table("my_th_images")->where("i_pid = '$p_id'")->select();//餐厅轮播图片
        $project = M()->table("my_th_project")->where("p_id = '$p_id'")->find();//查询项目
        $foodimg = M()->table("my_th_images")->where("i_fid = '$p_id'")->select();//查询推介菜图
        $restimg = M()->table("my_th_images")->where("i_nid = '$p_id'")->select();//查询餐厅内部图
        // 查询收藏状态
        $cardid = $_REQUEST['cardid'];
        $collection = M()->table("my_th_collection")->where("c_pid = '$p_id' and c_cardid = '$cardid'")->find();
        //查询评价
        $map1['e_label'] = array('like','%环境好%' );
        $map1['e_pid'] = $p_id;
        $ev1 = M()->table("my_th_evaulation")->where($map1)->count();
        $map2['e_label'] = array('like','%性价比高%' );
        $map2['e_pid'] = $p_id;
        $ev2 = M()->table("my_th_evaulation")->where($map2)->count();
        $map3['e_label'] = array('like','%干净卫生%' );
        $map3['e_pid'] = $p_id;
        $ev3 = M()->table("my_th_evaulation")->where($map3)->count();
        $map4['e_label'] = array('like','%服务好%' );
        $map4['e_pid'] = $p_id;
        $ev4 = M()->table("my_th_evaulation")->where($map4)->count();
        $map5['e_label'] = array('like','%周边便利%' );
        $map5['e_pid'] = $p_id;
        $ev5 = M()->table("my_th_evaulation")->where($map5)->count();
        $map6['e_label'] = array('like','%房间安静%' );
        $map6['e_pid'] = $p_id;
        $ev6 = M()->table("my_th_evaulation")->where($map6)->count();
        $pinglun = M()->table("my_th_evaulation")->where("e_pid = '$p_id'")->order("e_time desc")->select();
        $this->assign(compact('images','project','foodimg','restimg','collection','pinglun','ev1','ev2','ev3','ev4','ev5','ev6'));
        $this->display();
    }

    //  美食预定
    public function foodappoint(){
        $p_id = $_REQUEST['p_id'];
        $openid = $_REQUEST['openid'];
        //$openid = $this->wechat();
        // dump($p_id);
         /*dump($openid);
         die();*/
        if ($openid) {
            $images = M()->table("my_th_images")->where("i_pid = '$p_id'")->select();//查询图片
            $project = M()->table("my_th_project")->where("p_id = '$p_id'")->find();//查询项目
            // dump($insurance);
            $this->assign(compact('project','images'));
            $this->display();
        }else {
            echo '<script language="javascript">location.href="http://shop.qudaoplus.cn/Mobile/Index/index"</script>';
        }
    }

    // 美食订单最终预订
    public function foodorder(){
        $o_time=Date('Y-m-d H:i:s');
        $o_number=date(ymd).substr(time(),-5).substr(microtime(),2,5);//用户订单号自动生成
        $data = array(
            'o_start'	=> $_POST['o_start'],			//入住时间
            'o_atime'	=> $_POST['o_atime'],			//离店时间
            'o_nop'	    => $_POST['o_nop'],				//联系人
            'o_user'	=> $_POST['o_user'],			//联系电话
            'o_phone'	=> $_POST['o_phone'],
            'o_around'	=> $_POST['o_hopinion'],		//特殊需求
            'o_content'	=> $_POST['o_content'],			//o_content
            'o_openid'	=> $_POST['o_openid'],			//o_openid
            'o_pid'		=> $_POST['o_pid'],				//o_pid
            'o_shopid'	=> $_POST['o_shopid'],			//o_shopid
            'o_source'	=> '渠道PLUS',					//来源
            'o_time'	=> $o_time,						//订单提交时间
            'o_number'	=> $o_number,					//订单号
            'o_state'	=> 1,						    //订单状态
            'o_pcate'	=> '美食',				        //美食
        );
        //$this->ajaxReturn($data);
        $order = M()->table("my_th_order")->add($data);
        //$this->ajaxReturn($data);
        if ($order) {
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }

    //  美食订单
    public function order(){
        $phone = $_REQUEST['phone'];
        $o_state = $_REQUEST['o_state'];
        $openid = session('openid');
        if ($o_state) {
            if ($phone) {
                $orderfood = M()->table("my_th_order as o")->join("my_th_project as p on p.p_id=o.o_pid")->where("o_openid = '$openid' and o_pcate='美食' and o_state='$o_state'")->order("o_time desc")->select();
                $countfood = count($orderfood);
                $this->assign(compact('orderfood','countfood','o_state'));
                $this->display();
            }
        }else{
            if ($phone) {
                $orderfood = M()->table("my_th_order as o")->join("my_th_project as p on p.p_id=o.o_pid")->where("o_openid = '$openid' and o_pcate='美食'")->order("o_time desc")->select();
                $countfood = count($orderfood);
                $this->assign(compact('orderfood','countfood'));
                $this->display();
            }
        }
    }

    //  美食订单详情
    public function ordercont()
    {
        $id = $_REQUEST['o_id'];
        //$cate = $_REQUEST['cate'];
        $order = M()->table("my_th_order as o")->join("my_th_project as p on p.p_id = o.o_pid")->where("o_id = '$id'")->find();
        if (!empty($order))
        {
            $this->assign(compact('order'));
            $this->display();
        }
    }

    //	个人中心
    public function center(){
        if ($_REQUEST['phone']) {
            $this->display();
        }else {
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session

            $response_data = $this->cloneRemoteMemberInfo($openid);
            $jifen = $response_data['data']['0']['EnablePoint'];
            $jfrmb = ($jifen/100);
            session("jfrmb", $jfrmb);


            session("cardId", $response_data['data']['0']['CardId']);
            $cardId = session("cardId");
            if ($cardId) {
                $this->display();
            }else{
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }


    //	收藏列表
    public function collec(){
        $cardid = $_REQUEST['cardid'];
        $factory = M()->table("my_th_project as p")->join("my_th_images as i on i.i_pid=p.p_id")->join("my_th_collection as c on c.c_pid = p.p_id")->where("c.c_cardid = '$cardid'")->group("p.p_id")->select();
        foreach ($factory as $key => $value) {
            $p_serve  = $factory[$key]['p_serve'];//查询单条数据
            $p_serves = explode(" ", $p_serve);//分割
            $factory[$key]['erji'] = $p_serves;//赋值
        }
//        dump($factory);
        $this->assign("factory",$factory);
        $this->display();
    }

    //删除
    public function collecdel(){
        $id = $_POST['c_id'];
        $cllection = M()->table("my_th_collection")->where("c_id = '$id'")->delete();
        if($cllection){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }
    public function collecadd(){
        $c_id = $_POST['cid'];
        $p_id = $_POST['p_id'];
        $cardid = $_POST['cardid'];
        if ($c_id) {
            $cllection = M()->table("my_th_collection")->where("c_id = '$c_id'")->delete();
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
                    'c_pid' => $p_id,
                    'c_cardid' => $cardid,
                );
                $cllection = M()->table("my_th_collection")->add($data);
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
    public function evaluation(){
        $o_id = $_REQUEST['o_id'];
        $cardid = $_REQUEST['cardid'];
        $order = M()->table("my_th_order")->where("o_id = '$o_id'")->find();
        //dump($order['o_pcate']);
        if ($order['o_pcate'] == '旅游') {
            $orderevalu = array(
                '环境好',
                '性价比高',
                '干净卫生',
                '服务好',
                '周边便利',
                '房间安静',
            );
        }elseif ($order['o_pcate'] == '宾馆') {
            $orderevalu = array(
                '环境好',
                '性价比高',
                '干净卫生',
                '服务好',
                '周边便利',
                '房间安静',
            );
        }elseif ($order['o_pcate'] == '美食') {
            $orderevalu = array(
                '环境好',
                '性价比高',
                '干净卫生',
                '服务好',
                '周边便利',
                '房间安静',
            );
        }
        $this->assign(compact('orderevalu','order'));
        $this->display();
    }

    //  订单评价
    public function evalusub(){
        $o_time=Date('Y-m-d H:i:s');
        $data = array(
            'e_level' => $_POST['level'],
            'e_label' => implode(" ", $_POST['label']),
            'e_content' => $_POST['content'],
            'e_name' => $_POST['name'],
            'e_cardid' => $_POST['cardid'],
            'e_userimg' => $_POST['userimg'],
            'e_pid' => $_POST['pid'],
            'e_oid' => $_POST['oid'],
            'e_time' => $o_time,
        );
        //$this->ajaxReturn($data);
        $evaluadd = M()->table("my_th_evaulation")->add($data);
        if ($evaluadd) {
            $data_1 = array('o_state' => 4,);
            $orderadd = M()->table("my_th_order")->where("o_id=".$_POST['oid'])->save($data_1);
            if ($orderadd) {
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }

    }

    //  意见反馈
    public function feedback1(){
        $time=Date('Y-m-d H:i:s');
        $data = array(
            'f_name' => $_POST['name'],
            'f_phone' => $_POST['phone'],
            'f_cardid' => $_POST['cardid'],
            'f_text' => $_POST['text'],
            'f_time' => $time,
            'f_source' => '美食',
        );
        $feed = M()->table("my_th_feedback")->add($data);
        if($feed){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }

    }

    //	模糊查询
    public function search(){
        $map = array();
        $keywords = $_REQUEST['keywords'];
        if ($keywords) {
            $map['p_little|p_title|p_category|p_introduce|p_features|p_activity|p_serve|p_schedule|p_country'] = array('like','%'.$keywords.'%' );
//			$map['p_category'] = "旅游";
            // $map['e_category'] = "仓库";
        }
//		$count = M()->table("my_th_project as p")->join("my_th_images as i on i.i_pid=p.p_id")->where($map)->count();
//		$page = new Page($count,10);
//		//分页跳转的时候保证查询条件
//		foreach ($sear as $key => $value) {
//			if (!is_array($value)) {
//				$page->parameter .="$key=".urlencode($value)."&";
//			}
//		}
//		$show = $page->show();
        $factory = M()->table("my_th_project as p")->join("my_th_images as i on i.i_pid=p.p_id")->where($map)->group("p.p_id")->select();
        foreach ($factory as $key => $value) {
            $p_serve  = $factory[$key]['p_serve'];//查询单条数据
            $p_serves = explode(" ", $p_serve);//分割
            $factory[$key]['erji'] = $p_serves;//赋值
        }
        //$name = $keywords;
//        dump($factory);
        $this->assign(compact('count','show','factory','name'));
        $this->display();
    }

    //  积分抵消订单问题
    public function jifen(){
        $allrmb = $_POST['allrmb'];
        $aprace = $_POST['aprace'];
        $o_integral = ($aprace - $allrmb)*100;

        $o_id = $_POST['id'];
        $data = array(
            'o_allrmb' =>   $allrmb,
            'o_integral' =>   $o_integral,
        );
        $order = M()->table("my_th_order")->where("o_id = '$o_id'")->save($data);
        if ($order){
            $this->ajaxReturn($data);
        }else{
            $this->ajaxReturn(0);
        }
    }

    //  餐厅买单金额确认
    public function orderfood(){
        $fo_id = $_POST['o_id'];
        $order_price=$_POST['keywords'];
        if($order_price == '' || $order_price == 0){
            echo '<script charset="utf-8">alert("您未输入金额或输入为0！");window.history.back();</script>';
        }else{
            $data = array(
                'o_aprace'=>$order_price,
            );
            $order = M()->table("my_th_order")->where("o_id = '$fo_id'")->save($data);
            $ordercon = M()->table("my_th_order as o")->join("my_th_images as i on i.i_pid = o.o_pid")->join("my_th_project as p on p.p_id = o.o_pid")->where("o_id = '$fo_id'")->find();
            $this->assign(compact('fo_id','order_price'));
            $this->display();
        }
    }
    //美食立即享用
    public function forderback(){
        $number = $_REQUEST['o_number'];
        $data = array(
            'o_state'=>3,
        );
        $order = M()->table("my_th_order")->where("o_number = '$number'")->save($data);
        if ($order){
            echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/Home/Project"</script>';
        }else{
            $this->error("确认失败,请联系客服人员！！！");
        }
    }

    //成员特惠支付返回
    public function projectorder(){
        $client = new \OpenApiClient ();
        $number = $_REQUEST['o_number'];
        $order = M()->table("my_th_order")->where("o_number = '$number'")->find();
        $cardid = $_SESSION['cardId'];
        $openid = 'o1xY9wnWt-y3tnGWFy8O8EueypP0';//yangkanglong openid

        $data1 = array (
            "userAccount" => "10000",
            "cardId" => $cardid,
            "point" => -$order['o_integral'],
            "meno" => "测试记录",
        );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
        // 2.发起请求
        $jifen11111 = ($order['o_aprace']/100);
        $response_data = $client->CallHttpPost( "Update_MemberPoint",$data1);
        $data1 = array (
            "userAccount" => "10000",
            "cardId" => $cardid,
            "point" => $jifen11111,
            "meno" => "测试记录",
        );//devicetype=1则为微信；第二个将$id赋值给thirdopenid
        // 2.发起请求
        $response_data = $client->CallHttpPost( "Update_MemberPoint",$data1);
//        dump($data1);
//        dump($response_data);
//        die();
        $wechat = $_REQUEST['wechat'];
        $data = array(
            'o_state'    =>3,
            'o_wechatnum'=>3, //微信订单号
            'o_wechatmc' =>3, //商户单号
            'o_wechattime'=>3, //微信订单时间
        );
//        dump($number);
//        dump($wechat);
//       die();
        $order = M()->table("my_th_order")->where("o_number = '$number'")->save($data);
        if ($order){
            echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/Home/Project"</script>';
        }else{
            $this->error("订单支付失败,请联系客服人员！！！");
        }
    }

    // 会员信息
    public function information(){
        if ($_REQUEST['openid']) {
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session
            $response_data = $this->cloneRemoteMemberInfo($openid);
            $uriqi=strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            // dump($response_data);
            // die();
            //医生的信息
            $this->assign("age",$age);
            $this->assign("conven_1",$response_data);
            $this->display();
        }else{
            //微信授权 获取openid
            $WxOauthService = new WxOauthService();
            $WxUserInfo = $WxOauthService->WxUserInfo();
            $openid = $WxUserInfo['openid'];
            session("openid", $openid);//存储在session
            session("information", $WxUserInfo);//存储在session
            $response_data = $this->cloneRemoteMemberInfo($openid);
            $uriqi=strtotime($response_data['data']['0']['Birthday']);
            $age = $this->getAge($uriqi);
            // dump($response_data);
            // die();
            //医生的信息
            $this->assign("age",$age);
            $this->assign("conven_1",$response_data);
            $this->display();
        }
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
    /************************************************  精彩生活  ******************************************************/

}