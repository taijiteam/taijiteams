<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/30
 * Time: 9:32 AM
 */

namespace Common\Logic;


use Common\Model\GoodsModel;
use Think\Upload;
use Think\Image;

class GoodsLogic
{

    private $Goods_model;

    private $mid = 10;

    private $goods_ids = 1;

    private $Goods_comment_model;

    private function __construct($goods_id)
    {
        $this->goods_id = intval($goods_id);
        $this->Goods_model = new GoodsModel();
        $this->getGoods_info();
    }

    public static function instance($goods_id){
        $instance = new GoodsLogic($goods_id);
        return $instance;
    }

    public function Home1(){

        //模块1 Home1
         $this->Goods_Model->Home1($this->goods_ids);


        /*//模块2 Home2
        $Goods_list2 = $this->Goods_Model->Home2($this->goods_ids);
        $this->assign($Goods_list2);

        //模块3 Home3
        $Goods_list3 = $this->Goods_Model->Home3($this->goods_ids);
        $this->assign($Goods_list3);

        //模块4 Home4
        $Goods_list4 = $this->Goods_Model->Home4($this->goods_ids);
        $this->assign($Goods_list4);
        */


    }




    //文件上传的相关信息写作方法，方便调用
    /*public function GoodsUpload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 31457280;
        $upload->exts = array('jpg','gif','png','jpeg');
        $upload->rootPath  =     './Public/Uploads/Goods/';
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $info = $upload->upload();
        return $info;
         $Img = new \Think\Image();
          $ImgName= $Img->open($info);
          $image->thumb(150, 150)->save('$ImgName');
    }*/

    public function getGoods_info(){
//        return $this->goods_info;
    }

    //添加商品主图
    public function GoodsPhoto(){
        if ($_FILES){
            $info         =  $this->GoodsUpload($_FILES);
            //$this->ajaxReturn($info);
            $photo        =  $info['file']['savepath'].$info["file"]['savename'];
            //$this->ajaxReturn($info);
            if($photo){
                $data = array(
                    'msg' => "恭喜您上传成功",
                    'error' => 1,
                    'photo' => $photo,
                );
                $this->ajaxReturn($data);
            }else{
                $data = array(
                    'msg' => "运气不好哦上传失败了",
                    'error' => 0,
                );
                $this->ajaxReturn($data);
            }
        }else{
            $data = array(
                'msg' => "未选择照片",
                'error' => 2,
            );
            $this->ajaxReturn($data);
        }
    }



}