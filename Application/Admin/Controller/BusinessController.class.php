<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class BusinessController extends Controller {
    /**
     * 接口
     */
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }
    //密码设置
    public function getMd5Password($password){
        $pwd = md5($password);
        return substr($pwd,14);//substr(被截取字符串,从第几位截取);
    }
    //文件上传的相关信息写作方法，方便调用
    public function BusinessUpload(){
        //$this->ajaxReturn('111');
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 31457280;
        $upload->exts = array('jpg','gif','png','jpeg');
        $upload->rootPath  =     './Public/Uploads/Project/';
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        //dump($upload);die();
        $info   =   $upload->upload();
        return $info;
    }

    /**
     *	会员上传照片
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    public function BusinessPhoto1(){
        $cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
        parse_str($cur_q,$myArray);
        $id = $myArray["id"];
        if ($_FILES){
            $info   =  $this->BusinessUpload($_FILES);
            $photo  =  $info['file']['savepath'].$info['file']['savename'];
            //dump($info['file']);//获取yiwei数组
            //dump($photo);//获取拼接文件名
            $res = M('th_images')->add(array('i_image'=>$photo,'i_pid'=>$id));
            //var_dump($res);
        }
    }
    /**
     *	会员上传照片
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    public function BusinessPhoto2(){
        $cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
        parse_str($cur_q,$myArray);
        $id = $myArray["id"];
        if ($_FILES){
            $info   =  $this->BusinessUpload($_FILES);
            $photo  =  $info['file']['savepath'].$info['file']['savename'];
            //dump($info['file']);//获取yiwei数组
            //dump($photo);//获取拼接文件名
            $res = M('th_images')->add(array('i_image'=>$photo,'i_nid'=>$id));
            //var_dump($res);
        }
    }
    /**
     *	会员上传照片
     *	时间 2018-12-10
     *	author：Ertao
     */
    public function BusinessPhoto3(){
        $cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
        parse_str($cur_q,$myArray);
        $id = $myArray["id"];
        if ($_FILES){
            $info   =  $this->BusinessUpload($_FILES);
            $photo  =  $info['file']['savepath'].$info['file']['savename'];
            //dump($info['file']);//获取yiwei数组
            //dump($photo);//获取拼接文件名
            $res = M('th_images')->add(array('i_image'=>$photo,'i_fid'=>$id));
            //var_dump($res);
        }
    }

    /**
     * 商家管理
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function BusinessList(){
        //获取mid
        $mid = session('mid');
        //dump($mid);die();
        if($mid != null) {
            $Shops = M('th_shops'); // 实例化merber对象
            $count = $Shops->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
            $show = $Page->show();// 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $Shops->limit($Page->firstRow . ',' . $Page->listRows)->select();
            //dump($list);
            $this->assign('count', $count);// 赋值数据集
            $this->assign('list', $list);// 赋值数据集
            $this->assign('page', $show);// 赋值分页输出
            //$this->display(); // 输出模板
        }else{
            echo '<script charset="utf-8">alert("臭不要脸的，不登录就想进来，去登录！！！");</script>';
            $this->display('Index/login');
        }
       // dump($res);
       $this->display();
    }
    /**
     * 会员展示  or  禁用
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function BusinessActive(){
        //接收ajax传值;
        //会员id号
        if($_POST){
            $id = $_POST['id'];
            //禁用会员
            $Merber = M("th_shops"); // 实例化User对象
            $member =$Merber->where(['s_id'=>$id])->find();//根据id  查找数据库s_active的字段
            $data['s_active'] = array('s_active'=>$member['s_active'] == '0'?1:0);//更改s_active的值
            $active = $Merber->where(['s_id'=>$id])->save($data['s_active']);//更改数据库的字段值
            //dump($active);die();
            if($active){

            }
        }else{
            $this->display();
        }
    }


    //商铺添加
    public function BusinessAdd()
    {
        //echo '11111';
        //接收password  和   repwd
        $password = $this->getMd5Password($_POST['pass']);
        $repwd = $this->getMd5Password($_POST['repass']);
        //dump($password.$repwd);
        if ($repwd == $password) {
            if ($_POST) {
                $data = array(
                    's_name' => $_POST['user'],
                    's_user' => $_POST['user'],
                    's_shopid' => $_POST['shopid'],
                    's_phone' => $_POST['phone'],
                    's_pwd' => $password,
                    's_telephone' => $_POST['telephone'],
                    's_category' => $_POST['groupname'],
                    's_linkman' => $_POST['linkman'],
                    's_address' => $_POST['address'],
                    's_active' => $_POST['active'],
                    's_time' => $_POST['time'],

                );
                //dump($data);
                $res = M('th_shops')->add($data);
                //$this->ajaxReturn($res);die();
                if($res){
                    $date = array(
                        'msg' => "恭喜您上传成功",
                        'error' => 1,
                    );
                    $this->ajaxReturn($date);
                }else{
                    $date = array(
                        'msg' => "运气不好，上传失败了呦！",
                        'error' => 0,
                    );
                    $this->ajaxReturn($date);
                }
            }
            $this->display();
        }
    }
    //商铺添加
    public function BusinessSave()
    {
        if ($_POST) {
            $data = array(
                's_name' => $_POST['user'],
                's_user' => $_POST['user'],
                's_shopid' => $_POST['shopid'],
                's_phone' => $_POST['phone'],
                's_telephone' => $_POST['telephone'],
                's_category' => $_POST['groupname'],
                's_linkman' => $_POST['linkman'],
                's_address' => $_POST['address'],
                's_active' => $_POST['active'],
                's_time' => $_POST['time'],
                'introduce' => $_POST['introduce'],
                'introduce1' => $_POST['introduce1'],
                'introduce2' => $_POST['introduce2'],

            );
            dump($data);die();
            $res = M('th_shops')->add($data);
            //$this->ajaxReturn($res);die();
            if($res){
                $date = array(
                    'msg' => "恭喜您上传成功",
                    'error' => 1,
                );
                $this->ajaxReturn($date);
            }else{
                $date = array(
                    'msg' => "运气不好，上传失败了呦！",
                    'error' => 0,
                );
                $this->ajaxReturn($date);
            }
        }
        $this->display();

    }
    //商铺详情
    public function BusinessDefatu(){
        $id = $_GET['id'];
        //查找关于id的所有商户信息
        $res = M('th_shops')->where("s_id = $id")->find();
        //dump($res);die();
        if($res != null){
            $this->assign('res',$res);
            $this->assign('id',$id);
        }
        $this->display();
    }
    //商铺编辑
    public function BusinessEdit()
    {


        $this->display();
    }

}