<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class ShoppingController extends Controller {
    /**
     * 接口
     */
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }
    //文件上传的相关信息写作方法，方便调用
    public function memberUpload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 31457280;
        $upload->exts = array('jpg','gif','png','jpeg');
        $upload->rootPath  =     './Public/Uploads/Goods/';
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $info = $upload->upload();
        return $info;
    }
    /**
     * 会员积分
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function orderList()
    {
        //查找商品表内的所有商品便利展示
        //获取session值
        $a = '超级管理员';
        $b = '产品管理员';
        $mid = session('mid');
        if($mid['a_permissions'] == $a || $mid['a_permissions']==$b){

            if($mid != null) {
                $Merber = M('sc_goods'); // 实例化goods对象
                $count = $Merber->count();// 查询满足要求的总记录数
                $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
                $show = $Page->show();// 分页显示输出
                // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                $list = $Merber->order('addtime desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
                /* foreach ($list as $key => $value) {
                     $m_workunits = $list[$key]['m_workunits'];//查询单条数据
                     $p_serves = explode(",", $m_workunits);//分割
                     $m_work = explode(" ", $p_serves[0]);
                     $list[$key]['erji'] = $m_work;//赋值
                 }*/
                $this->assign('count', $count);// 赋值数据集
                $this->assign('list', $list);// 赋值数据集
                $this->assign('page', $show);// 赋值分页输出
                $this->display(); // 输出模板
            }else{
                echo '<script charset="utf-8">alert("臭不要脸的，不登录就想进来，去登录！！！");</script>';
                $this->display('Index/login');
            }
        }else{
            echo '<script charset="utf-8">alert("抱歉你没有权限访问！！！");</script>';
        }
    }
    //添加商品
    public function shopAdd(){
        if ($_POST){
            //$this->ajaxReturn($_POST);
            $time = time();
            $data = array(
                'g_encoding'   =>  $_POST['encoding'],          //商品编码
                'g_category'   =>  $_POST['category'],          //商品类别
                'g_name'   =>  $_POST['name'],                  //商品名称
                'g_unit'   =>  $_POST['unit'],                  //商品单位
                'g_store'   =>  $_POST['store'],                //商品店铺
                'g_count'   =>  $_POST['count'],                //库存数量
                'g_price'   =>  $_POST['price'],                //商品价格
                'g_state'   =>  $_POST['state'],                //商品状态
                'g_jifen'   =>  $_POST['jifen'],                //商品积分
                'g_pleased'   =>  $_POST['pleased'],            //商品进货价
                'g_remark'   => implode('', $_POST['remark']),              //商品备注
                'g_addtime'   =>  date("Y-m-d h:i:s", $time),              //商品时间
                'addtime'   =>   $time,                      //商品时间戳
            );
            //dump($data);die();
            //$this->ajaxReturn($data);die();
            $goods = M("sc_goods")->add($data);
            //$num =M()->getLastInsID();
            $num = array('g_img' => $goods,'g_parameter' => $goods);
            $img = M("sc_goods")->where(['id'=>$goods])->save($num);
            //接收照片的名字  存入数据库
            $data1 = array(
                'g_imgName' => $_POST['img'],
                'g_gid'     => $goods,
                'g_sort'    => '1',
            );
            $dir = M('sc_img')->add($data1);
            //接收商品详情图  存入数据库
            //接收照片的名字  存入数据库
            $data2 = array(
                'g_imgName' => $_POST['img2'],
                'g_gid'     => $goods,
                'g_sort'    => '3',
            );
            $dir2 = M('sc_img')->add($data2);
            //dump($dir);die();
            //判断数据库中是否有数据
            if($goods && $img && $dir && $dir2){
                $date = array(
                    'msg' => "恭喜您上传成功",
                    'error' => 1,
                );
                $this->ajaxReturn($date);
            }else{
                $date = array(
                    'msg' => "运气不好哦上传失败了",
                    'error' => 0,
                );
                $this->ajaxReturn($date);
            }
        }else{
            $this->display();
        }

    }
    //商品方法
    public function shopDetails($id){
        //echo $id;
        $this->display();
    }
    //商品规则页面
    public function shop_spec()
    {
        //固定商品
        $th = "<th>名称</th><th>元见</th>";
        $tr = "<td>自定义</td><td>自定义</td>";

        $ids = ["库存","尺码","颜色","价格"];
        foreach ($ids as $k => $v)
        {
            $th =  $th . "<th>{$v}</th>";
            $tr =  $tr . "<td><input type='text' name='{$v}' value='{$v}' class='layui-input'></td>";
        }

        $table = "<tr>{$th}</tr><tr>{$tr}</tr>";

        $this->assign('table',$table);
        $this->display();
    }



    //添加商品图片
    public function goodsPhoto(){
        if ($_FILES){
            $info         =  $this->memberUpload($_FILES);
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
    //添加商品详情图
    public function goodsPhoto2(){
        if ($_FILES){
            $info         =  $this->memberUpload($_FILES);
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