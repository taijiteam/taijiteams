<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/6/14
 * Time: 9:58 AM
 */


namespace Admin\Controller;
use Common\Controller\BaseController;
use Think\Upload;

class UploadController extends BaseController
{

    public function image()
    {
        if ($_FILES){

            $upload            =     new Upload();// 实例化上传类
            $upload->maxSize   =     31457280;
            $upload->exts      =     array('jpg','gif','png','jpeg');
            $upload->rootPath  =     './Public/Uploads/Temp/';
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $upload->autoSub   =     false;
            $upload->saveName  =     md5(microtime().'_'.rand(0,999));
            $info              =     $upload->upload();

            if(!$info) {// 上传错误提示错误信息
                $this->api_error($upload->getError());
            }

            $photo     =  "/Public/Uploads/Temp/".$info["file"]['savename'];
            if($photo){
                $this->api_success(["photo"=>$photo]);
            }else{
                $this->api_error("上传失败");
            }
        }else{
            $this->api_error("没有找到上传的文件");
        }
    }


}