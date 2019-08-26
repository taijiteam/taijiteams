<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
use Think\Page;
header("Content-type: text/html; charset=utf-8");
class TestController extends AdminController {
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
	// 美食详细页
	public function foodcontent(){
		$p_id = 17;
        //dump($openid);die();
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
	// 美食预定
	public function foodappoint(){
		$p_id = 17;
		// dump($p_id);
		 //dump($openid);
		 //die();
			$images = M()->table("my_th_images")->where("i_pid = '$p_id'")->select();//查询图片
			$project = M()->table("my_th_project")->where("p_id = '$p_id'")->find();//查询项目
			// dump($insurance);
			$this->assign(compact('project','images'));
			$this->display();
	}

    // 美食订单最终预订
    public function foodorder(){
        $o_time=Date('Y-m-d H:i:s');
        //die(dump($openid));
        $o_number=date(ymd).substr(time(),-5).substr(microtime(),2,5);//用户订单号自动生成
        $data = array(
            'o_start'	=> $_POST['o_start'],					//入住时间
            'o_atime'		=> $_POST['o_atime'],					//离店时间
            'o_nop'	=> $_POST['o_nop'],				//联系人
            'o_user'	=> $_POST['o_user'],				//联系电话
            'o_phone'	=> $_POST['o_phone'],
            'o_around'	=> $_POST['o_hopinion'],				//特殊需求
            'o_content'	=> $_POST['o_content'],				//o_content
            'o_openid'		=> $_POST['o_openid'],				//o_openid
            'o_pid'		=> $_POST['o_pid'],					//o_pid
            'o_shopid'		=> $_POST['o_shopid'],					//o_shopid
            'o_time'	=> $o_time,							//订单提交时间
            'o_number'	=> $o_number,					//订单号
            'o_state'	=> 1,						//订单状态
            'o_pcate'	=> '美食',				//旅游
            'o_source'	=> '二维码链接',				//来源
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


}