<?php
namespace Admin\Controller;
use Home\Controller\IndexController;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class MemberController extends Controller {

    /**
     *	模糊搜索会员
     *	时间 2018-12-10
     *	author：Ertao
     *
     */
    /*public function memberSearch(){
        //接受传值id
        if($_POST){
            $keywords = $_POST['m_cname'];
            //$this->ajaxReturn($id);
            //dump($id);die();
            //搜索数据库中的所有数据进行模糊搜索
            $User = M("merber"); // 实例化User对象
            $data['m_cname'] = array('like', "%$keywords%");
            $res = $User->where($data)->select();
            print_r($res);
            if($res != null){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }else{
            $this->display('Index/memberSearch');
        }
       }*/
       public function memberSearch(){
        //接受传值id
            $keywords = $_POST['username'];
            //$this->ajaxReturn($id);
            //dump($id);die();
            //搜索数据库中的所有数据进行模糊搜索
            $User = M("merber"); // 实例化User对象
            $data['m_cname'] = array('like', "%$keywords%");
            $res = $User->where($data)->select();
           foreach ($res as $key => $value) {
               $m_workunits = $res[$key]['m_workunits'];//查询单条数据
               $p_serves = explode(",", $m_workunits);//分割
               $m_work = explode(" ", $p_serves[0]);
               $res[$key]['erji'] = $m_work;//赋值
           }
            //dump($res);die();
           if($res != null){
               $this->assign('search',$res);
               $this->display();
           }else{
               $this->display();
           }

       }
       //清空选中搜索的值
        public function memberEmpty(){
           //清空m_sort 的一列值
            //$data = array('m_sort'=>'');
            $res = M('merber')->where('m_id','>',0)->setField('m_sort',null,true);
            //dump($res);die();
            if($res != false){
                $status['status']=';';
                $status['content']='已清空所有排序值';
                $this->ajaxReturn($status);
            }else{
                $status['status']='?';
                $status['content']='不要重复清空';
                $this->ajaxReturn($status);
            }
        }


}