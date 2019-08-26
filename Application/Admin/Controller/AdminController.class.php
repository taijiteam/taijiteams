<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class AdminController extends Controller {
    /**
     * 接口
     */
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }
    //密码验证
    public function getMd5Password($password){
        $pwd = md5($password);
        return substr($pwd,14);//substr(被截取字符串,从第几位截取);
    }
    /**
	*	主界面
	*	时间 2018-12-24
	*	author：Ertao
	*
	*/
    public function AdminManage(){
        $Admin = M('a_admin'); // 实例化merber对象
        $count = $Admin->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $Admin->order('a_time asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('count', $count);// 赋值数据集
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板

    }


    /**
     * 会员编辑
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function adminAdd(){
        if ($_POST){
            //$this->ajaxReturn($_POST);
            $data = array(
                'a_permissions'   =>  $_POST['groupname'],//管理员类别
                'a_name'   =>  $_POST['cname'],//姓名
                'a_admin'   =>  $_POST['admin'],//管理员账号
                'a_sex'   =>  $_POST['sex'],//性别
                'a_email'   =>  $_POST['email'],//邮箱
                'a_phone'   =>  $_POST['phone'],//手机号码
                'a_duty'   =>  $_POST['duty'],//职务
                'a_note'   =>  $_POST['note'],//工作类
                'a_pwd'   =>  $this->getMd5Password($_POST['pass']),//密码
                'a_statat'   =>  $_POST['starte'],//展示状态
                'a_time'   =>  $_POST['time'],//登记时间
            );
            //$this->ajaxReturn($data);
            $admin = M("a_admin")->add($data);
            if($admin){
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



    /**
     * 会员编辑
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function adminEdit(){
        $this->display();
    }
    /**
     * 会员修改密码
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function adminPassword(){
        //接收用户id
        $id = $_GET['id'];
        //查询用户的名字
        $res = M('a_admin')->where("a_id = $id")->find();
        //dump($res);die();
        //$this->ajaxReturn($res);
        $this->assign('res',$res);
        $this->display();
    }




    /**
     * 会员修改密码
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function adminSave(){
        //接收用户id
        $id = $_POST['id'];
        $oldpass = $this->getMd5Password($_POST['oldpass']);
        $repwd  = $this->getMd5Password($_POST['pass']);
         //查询用户的名字
        $pwd = M('a_admin')->where("a_id = $id")->getField('a_pwd');
        //dump($oldpass);dump($pwd);die();
        if($pwd == $oldpass){
            //接收新密码
            $password =array('a_pwd'=>$repwd);
            $res = M('a_admin')->where("a_id = $id")->save($password);
            /*$this->ajaxReturn($res);*/
            if($res != null){
                $status['status']=';';
                $status['content']='更改成功';
                $this->ajaxReturn($status);
            }else{
                $status['status']='?';
                $status['content']='更改失败';
                $this->ajaxReturn($status);
            }

        }else{
            $status['status']='?';
            $status['content']='旧密码不正确';
            $this->ajaxReturn($status);
        }
        //dump($res);die();
        //$this->ajaxReturn($res);
        $this->display();
    }

    /**
     * 会员登录记录
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function adminList(){
        $Admin = M('a_admins'); // 实例化merber对象
        $count = $Admin->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $Admin->order('a_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('count', $count);// 赋值数据集
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }


    /**
     * 会员退出
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function logout(){
       //清除session
        session('mid',null);
        $this->display('Index/login');
    }

}