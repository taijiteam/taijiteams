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
class MemberController extends AdminController {
	public function _initialize(){
		Vendor('phpSDK.OpenApiClient');
		//Vendor('PHPSDK.lib.OpenApiClient');
	}
	public function upload(){
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Public/Uploads/Member/'; // 设置附件上传根目录
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

	/*******************************  微信授权 ****************************************************/
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
        session("MemberGroupName",$response_data['data']['0']['MemberGroupName']);
        if($response_data['data']['0']['MemberGroupName'] == "待审核"){
            echo '<script charset="utf-8">alert("温馨提示：此板块正在维护中……");location.href="http://shop.qudaoplus.cn/Home/Home/home";</script>';
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

    /*******************************  微信授权 ****************************************************/


    /*******************************  成员风采 ****************************************************/
    //主页面
    public function index(){
        if ($_REQUEST['cardid']) {
            $status = ['0','2'];  //搜索显示状态  以及官员展示
            $MemberGroupName = session('MemberGroupName');
            $jurisdiction = ['尊享大咖','君享成员','真享成员','悦享成员','致享成员','亦享成员'];
            if (in_array($MemberGroupName, $jurisdiction)){
                $mlist = M()->table("my_merber")->where(['m_starte' =>['in',$status]])->order("m_time desc")->select();
            }else{
                $mlist = M()->table("my_merber")->where(['m_starte' => 0])->order("m_time desc")->select();
            }
            foreach ($mlist as $key => $value) {
                $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
                $p_serves = explode(",", $m_workunits);//分割
                $m_work = explode(" ", $p_serves[0]);
                $mlist[$key]['erji'] = $m_work;//赋值
            }
            $this->assign(compact('mlist'));
            $this->display();
        }else{
            $this->wxOther();
            $cardId = session("cardId");
            $status = ['0','2'];  //搜索显示状态  以及官员展示
            $MemberGroupName = session('MemberGroupName');
            $jurisdiction = ['尊享大咖','君享成员','真享成员','悦享成员','致享成员','亦享成员'];
            // 判断是否登录
            if ($cardId) {
                //$mlist = M()->table("my_merber")->order("m_time desc")->limit(0,10)->select();
                //$mlist = M()->table("my_merber")->order("m_time desc")/->select();
                if (in_array($MemberGroupName, $jurisdiction)){
                    $mlist = M()->table("my_merber")->where(['m_starte' =>['in',$status]])->order("m_time desc")->select();
                }else{
                    $mlist = M()->table("my_merber")->where(['m_starte' => 0])->order("m_time desc")->select();
                }
                foreach ($mlist as $key => $value) {
                    $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
                    $p_serves = explode(",", $m_workunits);//分割
                    $m_work = explode(" ", $p_serves[0]);
                    $mlist[$key]['erji'] = $m_work;//赋值
                }
                $this->assign(compact('mlist'));
                $this->display();
            }elseif ($MemberGroupName == '待审核') {
                $re['code']   ='-1';
                $re['message']='成员级别不支持此功能，请升级成员卡';
                $re['url']    = $this->groupUpdate;
                echo json_encode($re,JSON_UNESCAPED_UNICODE);
                die;
            }else {
                echo '<script language="javascript">location.href="http://www.qudaoplus.cn/merber_all_show/index.php/home/admin/merberLogin"</script>';
            }
        }
    }
    //列表页
    public function index_2(){
        $category = $_REQUEST['category'];
        $status = ['0','2'];  //搜索显示状态  以及官员展示
        $MemberGroupName = session('MemberGroupName');
        //dump($MemberGroupName);exit();
        $jurisdiction = ['尊享大咖','君享成员','真享成员','悦享成员','致享成员','亦享成员'];
        if (in_array($MemberGroupName, $jurisdiction)){
            $mlist = M()->table("my_merber")->where(['m_category' => $category,'m_starte' =>['in',$status]])->order("m_time desc")->select();
        }else{
            $mlist = M()->table("my_merber")->where(['m_category' => $category,'m_starte' => 0])->order("m_time desc")->select();
        }
        foreach ($mlist as $key => $value) {
            $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
            $p_serves = explode(",", $m_workunits);//分割
            $m_work = explode(" ", $p_serves[0]);
            $mlist[$key]['erji'] = $m_work;//赋值
        }
        $this->assign(compact('mlist'));
        $this->display('Member/index');
    }
    //详情页
    public function content(){
        $id = $_REQUEST['id'];
        $merber = M()->table("my_merber")->where("m_id = '$id'")->find();
        //$aaa=str_replace(" ","",$merber['m_workunits']);//单位职务无空格
        //$aaa=$merber['m_workunits'];//单位职务有空格
        $aaa=str_replace(" ","&nbsp;&nbsp;&nbsp;",$merber['m_workunits']);//单位职务空格加大
        // dump($aaa);
        $work = explode(",", $aaa);//分割
        $bbb=str_replace(" ","&nbsp;&nbsp;&nbsp;",$merber['m_socialposition']);//社会职务空格加大
        $socia = explode(",", $bbb);//分割
        $this->assign(compact('merber','work','socia'));
        $this->display();
    }
    //	个人中心
    public function my(){
        $num = $_REQUEST['num'];
        $merber = M()->table("my_merber")->where("m_num = '$num'")->find();
        $work = explode(",", $merber['m_workunits']);//分割
        $this->assign(compact('merber','work'));
        $this->display();
    }
    //信息修改
    public function site(){
        $m_num = $_REQUEST['num'];
        $merber = M()->table("my_merber")->where("m_num = '$m_num'")->find();
        $work = explode(",", $merber['m_workunits']);//分割
        $this->assign(compact('merber','work'));
        $this->display();
    }
    //信息确认
    public function infor(){
        $m_num = $_REQUEST['num'];
        $merber = M()->table("my_mb_mesite")->where("me_num = '$m_num' and me_state = 2")->find();
        $work = explode(",", $merber['me_work']);//分割
        $this->assign(compact('merber','work'));
        $this->display();
    }
    // 照片
    public function siteimg(){
        $photo =$_FILES['m_img'];
        //$this->ajaxReturn($photo['size']);
        if ($photo['size'] == '0') {
            $me_time=Date('Y-m-d H:i:s');
            $phot[] = array(
                'me_cname' =>$_POST['cname'],
                'me_ename' =>$_POST['ename'],
                'me_sex' =>$_POST['sex'],
                'me_category' =>$_POST['category'],
                'me_work' =>$_POST['work'],
                'me_socialposition' =>$_POST['socialposition'],
                'me_industry' =>$_POST['industry'],
                'me_introduce' =>$_POST['introduce'],
                'me_num' =>$_POST['num'],
                'me_openid' =>$_POST['openid'],
                'me_time' =>$me_time,
            );
            $photoadd = M()->table("my_mb_mesite")->addAll($phot);
            if($photoadd){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(3);
            }
        }else{
            $info  =  $this->upload();
            $me_time=Date('Y-m-d H:i:s');
            foreach($info as $key =>$info) {
                $phot[] = array(
                    'me_img' =>$info['savepath'].$info['savename'],
                    'me_cname' =>$_POST['cname'],
                    'me_ename' =>$_POST['ename'],
                    'me_sex' =>$_POST['sex'],
                    'me_category' =>$_POST['category'],
                    'me_work' =>str_replace("，",",",$_POST['work']),
                    'me_socialposition' =>$_POST['socialposition'],
                    'me_industry' =>$_POST['industry'],
                    'me_introduce' =>$_POST['introduce'],
                    'me_num' =>$_POST['num'],
                    'me_openid' =>$_POST['openid'],
                    'me_time' =>$me_time,
                );
            }
            $photoadd = M()->table("my_mb_mesite")->addAll($phot);
            if($photoadd){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }
    }
    //设置筛选
    public function setup(){
        //$mlist = M()->table("my_merber")->order("m_time desc")->limit(0,10)->select();
        //$mlist = M()->table("my_merber")->order("m_time desc")/->select();
        $mlist = M()->table("my_merber")->where("m_starte = 0")->order("m_time desc")->select();
        foreach ($mlist as $key => $value) {
            $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
            $p_serves = explode(",", $m_workunits);//分割
            $m_work = explode(" ", $p_serves[0]);
            $mlist[$key]['erji'] = $m_work;//赋值
        }
        $this->assign(compact('mlist'));
        $this->display();
    }
    //分类搜索
    public function setupfirst(){
        $catelist = $_POST['category'];
        $sex = $_POST['sex'];
        if ($sex == '不限') {
            $sex == '';

            $m_category = implode($catelist);
            $date['m_category']=array('in',$catelist);
            //$date['m_category']=array('like','%'.$m_category.'%');
            $date['m_starte'] = 0;
            $mlist = M()->table("my_merber")->where($date)->order("m_time desc")->select();
            //$this->ajaxReturn($mlist);
            foreach ($mlist as $key => $value) {
                $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
                $p_serves = explode(",", $m_workunits);//分割
                $m_work = explode(" ", $p_serves[0]);
                $mlist[$key]['erji'] = $m_work;//赋值
            }
            $this->ajaxReturn($mlist);
        }else{
            $m_category = implode($catelist);
            $date['m_category']=array('in',$catelist);
            //$date['m_category']=array('like','%'.$m_category.'%');
            $date['m_sex'] = $sex;
            $date['m_starte'] = 0;
            $mlist = M()->table("my_merber")->where($date)->order("m_time desc")->select();
            //$this->ajaxReturn($mlist);
            foreach ($mlist as $key => $value) {
                $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
                $p_serves = explode(",", $m_workunits);//分割
                $m_work = explode(" ", $p_serves[0]);
                $mlist[$key]['erji'] = $m_work;//赋值
            }
            $this->ajaxReturn($mlist);
        }
    }
    //确认选中后的排序
    public function setupsecond(){
        $m_id = $_POST['m_id'];
        $date['m_id']=array('in',$m_id);
        $date['m_starte'] = 0;
        $mlist = M()->table("my_merber")->where($date)->order("m_sort asc")->select();
        foreach ($mlist as $key => $value) {
            $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
            $p_serves = explode(",", $m_workunits);//分割
            $m_work = explode(" ", $p_serves[0]);
            $mlist[$key]['erji'] = $m_work;//赋值
        }
        $this->ajaxReturn($mlist);
    }
    //模糊查询
    public function search(){
        $map = array();
        $keywords = $_POST['keywords'];
        if ($keywords) {
            $map['m_cname|m_ename|m_sex|m_category|m_workunits|m_position|m_socialposition|m_industry|m_socialposition'] = array('like','%'.$keywords.'%' );
            //$map['p_category'] = "旅游";
            // $map['e_category'] = "仓库";
            $map['m_starte'] = 0;
        }
        // $count = M()->table("my_merber")->where($map)->count();
        // $page = new Page($count,10);
        // //分页跳转的时候保证查询条件
        // foreach ($sear as $key => $value) {
        // 	if (!is_array($value)) {
        // 		$page->parameter .="$key=".urlencode($value)."&";
        // 	}
        // }
        // $show = $page->show();
        $mlist = M()->table("my_merber")->where($map)->order("m_time desc")->select();
        foreach ($mlist as $key => $value) {
            $m_workunits  = $mlist[$key]['m_workunits'];//查询单条数据
            $p_serves = explode(",", $m_workunits);//分割
            $m_work = explode(" ", $p_serves[0]);
            $mlist[$key]['erji'] = $m_work;//赋值
        }
        $this->assign(compact('mlist'));
        $this->display('Member/index');
    }


    /*************************************** 成员风采*****************************************************************/

}
