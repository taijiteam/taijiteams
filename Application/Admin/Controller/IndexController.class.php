<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class IndexController extends Controller {
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
        $upload->rootPath  =     './Public/Uploads/Member/';
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $info = $upload->upload();
        return $info;
    }
    //密码设置
    public function getMd5Password($password){
        $pwd = md5($password);
        return substr($pwd,14);//substr(被截取字符串,从第几位截取);
    }
    /**
	*	登录界面
	*	时间 2018-12-24
	*	author：Ertao
	*
	*/
    public function login(){
        if ($_POST) {
            //开启session
            session_start();
            $data['a_admin'] = trim(I('post.username'));
            $data['a_pwd'] = $this->getMd5Password(I('post.password'));
            //print_r($data);exit();
            $check = M("a_admin")->where($data)->find();
            if ($check['a_statat'] == 0) {

                //如果登录成功 则把用户信息存入session
                session('mid', $check);
                if (session('mid') != null) {
                    //遍历信息
                    $date = array(
                        'a_admin' => $check['a_admin'],  //管路员账号
                        'a_name' => $check['a_name'],  //管路员名字
                        'a_sex' => $check['a_sex'],  //性别
                        'a_phone' => $check['a_phone'],  //手机号码
                        'a_note' => $check['a_note'],  //备注
                        'a_email' => $check['a_email'],  //邮箱
                        'a_duty' => $check['a_duty'],  //职位
                        'a_permissions' => $check['a_permissions'],  //权限分类
                        'a_time' => time(),  //时间
                    );
//                    $this->ajaxReturn($date);
                    //var_dump($date);die();
                    //把信息存入记录表中
                    $admin = M('a_admins'); //实例化admins
                    $admin->add($date);
                    //判断数据库中是否有数据
                    if ($check != null) {
                        $status['status'] = 'ok';
                        $status['content'] = '登陆成功';
                        $this->ajaxReturn($status);
                    } else {
                        $status['status'] = 'error';
                        $status['content'] = '账号或密码不正确';
                        $this->ajaxReturn($status);
                    }
                } else {
                    $status['status'] = 'error';
                    $status['content'] = '账号或密码不正确';
                    $this->ajaxReturn($status);
                }
            }else{
                $status['status'] = 'error';
                $status['content'] = '账号已禁用,请联系管理员解禁';
                $this->ajaxReturn($status);
            }

            } else {
                $this->display();
            }

    }
    /**
    *	管理后台主页界面
    *	时间 2018-12-24
    *	author：Ertao
    *
    */
	public function index(){
        ///获取session值
        $mid = session('mid');
        //dump($mid);
        if($mid == null){
                echo '<script charset="utf-8">alert("请您先去登录！！！");</script>';
                $this->display('Index/login');
            }else{
                $admin = $mid['a_admin'];
                $this->assign('res',$admin);
                $this->display();
        }
	}
	/**
    *	管理后台主页界面
    *	时间 2018-12-24
    *	author：Ertao
    *
    */
	public function welcome(){
        ///获取session值
        $mid = session('mid');
        //dump($mid);
        if($mid == null){
                echo '<script charset="utf-8">alert("请您先去登录！！！");</script>';
                $this->display('Index/login');
            }else{
                $admin = $mid['a_admin'];
                $res = M('merber')->count();
                $this->assign('res',$admin);
                $this->assign('list',$res);
                $this->display();
            }
	}
	/**
	*	会员列表
	*	时间 2018-12-10
	*	author：Ertao
	*
	*/
	public function memberList(){
        //获取session值
        $a = '超级管理员';
        $b = '成员管理员';
        $mid = session('mid');
        if($mid['a_permissions'] == $a || $mid['a_permissions']==$b){
               
                if($mid != null) {
                    $Merber = M('merber'); // 实例化merber对象
                    $count = $Merber->count();// 查询满足要求的总记录数
                    $Page = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
                    $show = $Page->show();// 分页显示输出
                    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                    $list = $Merber->order('m_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
                    foreach ($list as $key => $value) {
                        $m_workunits = $list[$key]['m_workunits'];//查询单条数据
                        $p_serves = explode(",", $m_workunits);//分割
                        $m_work = explode(" ", $p_serves[0]);
                        $list[$key]['erji'] = $m_work;//赋值
                    }
                    $this->assign('count', $count);// 赋值数据集
                    $this->assign('list', $list);// 赋值数据集
                    $this->assign('page', $show);// 赋值分页输出
                    $this->display(); // 输出模板
                }else{
                    echo '<script charset="utf-8">alert("请您先去登录！！！");</script>';
                    $this->display('Index/login');
                    }
        }else{
            echo '<script charset="utf-8">alert("抱歉你没有权限访问！！！");</script>';
        }
	}
    /**
     * 会员展示  or  禁用
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function memberActive(){
        //接收ajax传值;
            //会员id号
        if($_POST){
            $id = $_POST['id'];
            //禁用会员
            $Merber = M("merber"); // 实例化User对象
            $member =$Merber->where(['m_id'=>$id])->find();//根据id  查找数据库m_starte的字段
            $data['m_starte'] = array('m_starte'=>$member['m_starte'] == '0'?1:0);//更改m_starte的值
            $active = $Merber->where(['m_id'=>$id])->save($data['m_starte']);//更改数据库的字段值
            //dump($active);die();
            if($active){

            }
        }else{
            $this->display();
        }
    }
    /**
     * 会员删除
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
   public function memberDel(){
       if($_POST){
           $id = $_POST['id'];//接收mid
           //dump($id);
           //根据mid删除该用户
           $res = M('merber')->where(['m_id'=>$id])->delete();
           if($res){
               //dump($res);
           }else{
               echo '<script charset="utf-8">alert("删除失败！！！");</script>';
               $this->display();
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
    public function memberEdit(){
        if($_GET){
            //接收id
            $id = $_GET['id'];
            //根据id查找被编辑人的信息
            $res = M('merber')->where(['m_id'=>$id])->find();
            //dump($res);
            $this->assign('res',$res);
            //$this->ajaxReturn($res);
            $this->display();
        }else{
            $this->display();
        }
    }
    /**
     * 会员编辑
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function memberDetailed(){
        if($_GET){
            //接收id
            $id = $_GET['mid'];
            //根据id查找被编辑人的信息
            $res = M('merber')->where(['m_id'=>$id])->find();
            //dump($res);
            $this->assign('res',$res);
            //$this->ajaxReturn($res);
            $this->display();
        }else{
            $this->display();
        }
    }
    /**
     * 会员更新
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function memberEditSave(){

        if($_POST){
            //接收id
            $id = $_POST['id'];//姓名
            $data=array(
                'm_cname'   =>  $_POST['cname'],//姓名
                'm_phone'   =>  $_POST['phone'],//手机
                'm_workunits'   =>  $_POST['workunits'],//单位 职务
                'm_socialposition'   =>  $_POST['socialposition'],//社会职务
                'm_sort'   =>  $_POST['sort'],              //选中排序
                'm_address'   =>  $_POST['address'],//联系地址
            );
            //数据更改
            $res = M('merber')->where(['m_id'=>$id])->save($data);
            //dump($data);
            //$this->ajaxReturn($res);die();
            if($res != null){
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
     *	会员添加
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    public function memberAdd(){

        if ($_POST){
            //$this->ajaxReturn($_POST);exit();
            $data = array(
                'm_num'   =>  $_POST['num'],        //会员卡号
                'm_groupname'   =>  $_POST['groupname'],//会员级别
                'm_category'   =>  $_POST['category'],//会员类别
                'm_img'   =>  $_POST['photo'],//照片
                'm_cname'   =>  $_POST['cname'],//姓名
                'm_sex'   =>  $_POST['sex'],//性别
                'm_phone'   =>  $_POST['phone'],//手机
                'm_birthday'   =>  $_POST['birthday'],//生日
                'm_constellation'   =>  $_POST['constellation'],//星座
                'm_zodiac'   =>  $_POST['zodiac'],//属相
                'm_email'   =>  $_POST['email'],//邮箱
                'm_workunits'   =>  $_POST['workunits'],//单位 职务
                'm_school'   =>  $_POST['school'],//毕业院校
                'm_socialposition'   =>  $_POST['socialposition'],//社会职务
                'm_industry'   =>  $_POST['industry'],//从事行业
                'm_pamanager'   =>  $_POST['pamanager'],//服务经理
                'm_address'   =>  $_POST['address'],//联系地址
                'm_works'   =>  $_POST['works'],//工作类
                'm_integrals'   =>  $_POST['integrals'],//工作类
                'm_socials'   =>  $_POST['socials'],//社交类
                'm_lifes'   =>  $_POST['lifes'],//生活类
                'm_arts'   =>  $_POST['arts'],//艺术类
                'm_starte'   =>  $_POST['starte'],//展示状态
                'm_indate'   =>  $_POST['indate']==""?'永久有效':$_POST['indate'],//有效期
                'm_time'   =>  $_POST['time'],//登记时间
                'm_referrername'   =>  $_POST['referrername'],//推荐人姓名
                'm_doctors'   =>  $_POST['doctors'],//名医预约
                'm_finance'   =>  $_POST['finance'],//金融支持
                'm_magazine'   =>  $_POST['magazine'],//杂志专访
                'm_wechattext'   =>  $_POST['wechattext'],//推广服务
                'm_business'   =>  $_POST['business'],//经营范围
                'm_brands'   =>  $_POST['brands'],//品牌
                'm_wechatid'   =>  $_POST['wechatid'],//微信号
                'm_storefront'   =>  $_POST['storefront'],//登记店面
                'm_opened_people'   =>  $_POST['opened_people'],//开卡人
                'm_cameras'   =>  $_POST['cameras'],//摄像
                'm_wechatshow'   =>  $_POST['wechatshow'],//微信朋友圈展示
                'm_actname'   =>  $_POST['actname'],//精彩活动展示
                'm_tcspwdl'   =>  $_POST['tcspwdl'],//天朝上品代理
                'm_goodat'   =>  $_POST['goodat'],//个人擅长
                'm_brandstrat'   =>  $_POST['brandstrat'],//铭牌状态
                'm_memberships'   =>  $_POST['memberships'],//会籍服务人
                'm_recby'   =>  $_POST['recby'],//推荐机构
                'm_degree'   =>  $_POST['degree'],//最高学历
                'm_major'   =>  $_POST['major'],//专业
                'm_bcardid'   =>  $_POST['bcardid'],//名片
                'm_gifthand'   =>  $_POST['gifthand'],//伴手礼
                'm_infop'   =>  $_POST['infop'],//个人资料提供者
                'm_intactbest'   =>  $_POST['intactbest'],//喜爱活动偏好
                'm_zipaddress'   =>  $_POST['zipaddress'],//杂志寄送地址
                'm_tablemer'   =>  $_POST['tablemer'],//会员信息表
                'm_services'   =>  $_POST['services'],//会员信息表
                'm_introduce'   =>  implode('', $_POST['introduce']),//个人介绍
            );
            //$this->ajaxReturn($data);exit();
            $member = M("merber")->add($data);
            //var_dump($a);die();
            if($member){
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
     *	会员更改
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    public function memberChange(){
        //接收会员id
        $id = $_POST['num'];
        //根据会员id   查找数据库中的照片地址
        $img = M('merber')->where(['m_num'=>$id])->select();
        //dump($img[0]['m_img']);die();
        if ($_POST){
            //$this->ajaxReturn($_POST);
            $data = array(
                'm_num'   =>  $_POST['num'],        //会员卡号
                'm_groupname'   =>  $_POST['groupname'],//会员级别
                'm_category'   =>  $_POST['category'],//会员类别
                'm_img'   =>  $_POST['photo']==''?$img[0]['m_img']:$_POST['photo'],//照片
                'm_cname'   =>  $_POST['cname'],//姓名
                'm_sex'   =>  $_POST['sex'],//性别
                'm_phone'   =>  $_POST['phone'],//手机
                'm_birthday'   =>  $_POST['birthday'],//生日
                'm_constellation'   =>  $_POST['constellation'],//星座
                'm_zodiac'   =>  $_POST['zodiac'],//属相
                'm_email'   =>  $_POST['email'],//邮箱
                'm_workunits'   =>  $_POST['workunits'],//单位 职务
                'm_school'   =>  $_POST['school'],//毕业院校
                'm_socialposition'   =>  $_POST['socialposition'],//社会职务
                'm_industry'   =>  $_POST['industry'],//从事行业
                'm_pamanager'   =>  $_POST['pamanager'],//服务经理
                'm_address'   =>  $_POST['address'],//联系地址
                'm_works'   =>  $_POST['works'],//工作类
                'm_integrals'   =>  $_POST['integrals'],//可用积分
                'm_socials'   =>  $_POST['socials'],//社交类
                'm_lifes'   =>  $_POST['lifes'],//生活类
                'm_arts'   =>  $_POST['arts'],//艺术类
                'm_starte'   =>  $_POST['starte'],//展示状态
                'm_indate'   =>  $_POST['indate']==""?'永久有效':$_POST['indate'],//有效期
                'm_time'   =>  $_POST['time'],//登记时间
                'm_referrername'   =>  $_POST['referrername'],//推荐人姓名
                'm_doctors'   =>  $_POST['doctors'],//名医预约
                'm_finance'   =>  $_POST['finance'],//金融支持
                'm_magazine'   =>  $_POST['magazine'],//杂志专访
                'm_wechattext'   =>  $_POST['wechattext'],//推广服务
                'm_business'   =>  $_POST['business'],//经营范围
                'm_brands'   =>  $_POST['brands'],//品牌
                'm_wechatid'   =>  $_POST['wechatid'],//微信号
                'm_storefront'   =>  $_POST['storefront'],//登记店面
                'm_opened_people'   =>  $_POST['opened_people'],//开卡人
                'm_cameras'   =>  $_POST['cameras'],//摄像
                'm_wechatshow'   =>  $_POST['wechatshow'],//微信朋友圈展示
                'm_actname'   =>  $_POST['actname'],//精彩活动展示
                'm_tcspwdl'   =>  $_POST['tcspwdl'],//天朝上品代理
                'm_goodat'   =>  $_POST['goodat'],//个人擅长
                'm_brandstrat'   =>  $_POST['brandstrat'],//铭牌状态
                'm_memberships'   =>  $_POST['memberships'],//会籍服务人
                'm_recby'   =>  $_POST['recby'],//推荐机构
                'm_degree'   =>  $_POST['degree'],//最高学历
                'm_major'   =>  $_POST['major'],//专业
                'm_bcardid'   =>  $_POST['bcardid'],//名片
                'm_gifthand'   =>  $_POST['gifthand'],//伴手礼
                'm_infop'   =>  $_POST['infop'],//个人资料提供者
                'm_intactbest'   =>  $_POST['intactbest'],//喜爱活动偏好
                'm_zipaddress'   =>  $_POST['zipaddress'],//杂志寄送地址
                'm_services'   =>  $_POST['services'],//会员信息表
                'm_tablemer'   =>  $_POST['tablemer'],//会员信息表
                'm_introduce'   =>  implode('', $_POST['introduce']),//个人介绍
            );

            //die();
            //$this->ajaxReturn($data);die();
            $member = M("merber")->where(['m_num' => $data['m_num']])->save($data);
            //$this->ajaxReturn($member);die();
            if($member){
                $date = array(
                    'msg' => "恭喜您更新成功",
                    'error' => 1,
                );
                $this->ajaxReturn($date);
            }else{
                $date = array(
                    'msg' => "运气不好哦更新失败了",
                    'error' => 0,
                );
                $this->ajaxReturn($date);
            }
        }else{
            $this->display();
        }

    }
    /**
     *	会员上传照片
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    public function memberPhoto(){
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
    /**
     * 验证登陆
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function LoginState($user,$pwd){
        if($user==""||$pwd==null){
            return false;
        }else{
            return true;
        }
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