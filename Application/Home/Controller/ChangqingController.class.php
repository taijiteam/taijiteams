<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
use Think\Page;
header("Content-type: text/html; charset=utf-8");
class ChangqingController extends AdminController {
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
	public function index(){
        $this->display();
	}
	public function sub(){
        //$this->ajaxReturn(1);
        $time=Date('Y-m-d H:i:s');
        $data = array(
            's_grade' => $_POST['grade'],
            's_sudentname' => $_POST['sudentname'],
            's_sudentbrith' => $_POST['sudentbrith'],
            's_patriarch' => $_POST['patriarch'],
            's_phone' => $_POST['phone'],
            's_city' => $_POST['city'],
            's_address1' => $_POST['address1'],
            's_address2' => $_POST['address2'],
//            's_number' => $_POST['number'],
            's_text' => $_POST['text'],
            's_exam' => $_POST['exam'],
            's_time' => $time,
        );
        $schang = M()->table("my_sc_schang")->add($data);
        if($schang){
            $this->ajaxReturn(1);
        }else{
            $this->ajaxReturn(0);
        }
    }
}
?>