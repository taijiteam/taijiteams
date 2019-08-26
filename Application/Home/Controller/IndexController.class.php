<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
      if(cookie('status')!=0){
        redirect(U('club/loginWeChat'));
      }
    }
/*************************************** 成员风采 ****************************************************************/


    //全部会员信息
    public function index(){
        Vendor('phpSDK.OpenApiClient');
        $client = new \OpenApiClient ();

        $group = urldecode($_REQUEST['group']);

        $this->assign('group',$group);

        //每页显示条数
        if ( !empty($_REQUEST ['numPerPage']) ) {      //当前查到的条数
            $numPerPage = $_REQUEST ['numPerPage'];
        }

        if (!empty($_REQUEST['page']) ){
            $page = $_REQUEST['page'];
        }

        //加载更多会员查询信息
        if( !empty($page) ){
            if ( $group=='亦享成员' || $group=='致享成员') {
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and ExtValue25 = '商政名流' ",
                    "pageIndex" => $page,                //页码
                    "pageSize" => 5,           //每页显示条数
                    "orderBy" => "RegisterTime desc"     //排序规则
                );
            }else {
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 in ('0','2')",
                    "pageIndex" => $page,           //页码
                    "pageSize" => 5,                //每页显示条数
                    "orderBy" => "RegisterTime desc"     //排序规则
                );
            }
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
            $re['data'] = $response_data['data'];
            $re['num'] = count( $re['data'] );        //总条数
            if( $re['num'] < 5 ){
                $re['state'] = '0';
            }else{
                $re['state'] = '1';
            }
            $con = json_encode($re,JSON_UNESCAPED_UNICODE);
            echo $con;
            exit;
        }else{
            if ( $group=='亦享成员' || $group=='致享成员') {
                //查询商政名流信息
                $szml_data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and ExtValue25 = '商政名流' ",
                    "pageIndex" => 0,
                    "pageSize" => 10,
                    "orderBy" => "RegisterTime desc"
                );
            }else {
                //查询商政名流信息
                $szml_data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 in ('0','2') and ExtValue25 = '商政名流' ",
                    "pageIndex" => 0,
                    "pageSize" => 10,
                    "orderBy" => "RegisterTime desc"
                );
            }
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $szml_data );
            $szml = $response_data["data"];
            $num = count( $szml );        //总条数
            if( $num < 10 ){
                $szml_state = '0';
            }else{
                $szml_state = '1';
            }
            $this->assign( 'szml_state' , $szml_state );
            $this->assign( 'szml_info' , $szml );


            //查询企业精英信息
            $qyjy_data = array (
                "userAccount" => "10000",
                "where" => " ExtValue26 = '0' and ExtValue25 = '企业精英'  ",
                "pageIndex" => 0,
                "pageSize" => 10,
                "orderBy" => "RegisterTime desc"
            );
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $qyjy_data );
            $qyjy = $response_data["data"];
            $num = count( $qyjy );        //总条数
            if( $num < 10 ){
                $qyjy_state = '0';
            }else{
                $qyjy_state = '1';
            }
            $this->assign( 'qyjy_state' , $qyjy_state );
            $this->assign( 'qyjy_info' , $qyjy );


            //查询文艺雅仕信息
            $wyys_data = array (
                "userAccount" => "10000",
                "where" => " ExtValue26 = '0' and ExtValue25 = '文艺雅仕'  ",
                "pageIndex" => 0,
                "pageSize" => 10,
                "orderBy" => "RegisterTime desc"
            );
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $wyys_data );
            $wyys = $response_data["data"];
            $num = count( $wyys );        //总条数
            if( $num < 10 ){
                $wyys_state = '0';
            }else{
                $wyys_state = '1';
            }
            $this->assign( 'wyys_state' , $wyys_state );
            $this->assign( 'wyys_info' , $wyys );


            //查询名医专家信息
            $myzj_data = array (
                "userAccount" => "10000",
                "where" => " ExtValue26 = '0' and ExtValue25 = '名医专家'  ",
                "pageIndex" => 0,
                "pageSize" => 10,
                "orderBy" => "RegisterTime desc"
            );
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $myzj_data );
            $myzj = $response_data["data"];

            $num = count( $myzj );        //总条数
            if( $num < 10 ){
                $myzj_state = '0';
            }else{
                $myzj_state = '1';
            }
            $this->assign( 'myzj_state' , $myzj_state );
            $this->assign( 'myzj_info' , $myzj );

            //所有会员信息
            if ( $group=='亦享成员' || $group=='致享成员') {
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' ",
                    "pageIndex" => 0,
                    "pageSize" => 10,
                    "orderBy" => "RegisterTime desc"
                );
            }else {
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 in ('0','2') ",
                    "pageIndex" => 0,
                    "pageSize" => 10,
                    "orderBy" => "RegisterTime desc"
                );
            }
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
            $data = $response_data["data"];
            // print_r($response_data);
            $re['num'] = count( $data );        //总条数
            if( $re['num'] < 10 ){
                $state = '0';
            }else{
                $state = '1';
            }
            $this->assign( 'state' , $state );
            $this->assign( 'info' , $data );

        }
        $this->display();
    }

    //单个导航查询信息
    public function cation(){
        Vendor('phpSDK.OpenApiClient');
        $client = new \OpenApiClient ();

        $group = urldecode($_REQUEST['group']);


        $type = $_REQUEST ['type'];   //检索信息

        if ( !empty($_REQUEST ['numPerPage']) ) {      //当前查到的条数
            $numPerPage = $_REQUEST ['numPerPage'];
        }
        if (!empty($_REQUEST['page']) ){
            $page = $_REQUEST['page'];
        }

        //加载更多会员查询信息
        if( !empty($page) ){
            if ( $group=='亦享成员' || $group=='致享成员' ){
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and ExtValue25 = '".$type."'",
                    "pageIndex" => $page,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
            }else {
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 in ('0','2') and ExtValue25 = '".$type."'",
                    "pageIndex" => $page,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
            }
            $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
            $re['data'] = $response_data['data'];
            $re['num'] = count( $response_data['data'] );        //总条数
            $re['page'] = intval( $re['num']/5 );                //当前页数
            if( $re['num'] < 5 ){
                $re['state'] = '0';
            }else{
                $re['state'] = '1';
            }
            $con = json_encode( $re,JSON_UNESCAPED_UNICODE);
            echo $con;
            exit;
        }
    }

    //检索
    public function search(){
        Vendor('phpSDK.OpenApiClient');
        $client = new \OpenApiClient ();

        $group = urldecode($_REQUEST['group']);

        if ( $group=='亦享成员' || $group=='致享成员') {
            $content = $_REQUEST ['type'];   //检索信息

            if (!empty($_REQUEST['page']) ){
                $page = $_REQUEST['page'];
            }

            //加载更多检索信息
            if ( empty($content) ) {
                $re['state'] = '-1';
                $re['message'] = '未搜索到成员信息';
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }else if( !empty($content) && !empty($page) ){
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and TrueName like '%".$content."%' or ExtValue3 like '%".$content."%' or ExtValue8 like '%".$content."%'",
                    "pageIndex" => $page,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
                $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
                foreach ($response_data['data'] as $key => $value) {
                    if ( $value['ExtValue25']!='商政名流' ) {
                        $info[] =$value;
                    }
                }
                $re['data'] = $info;
                $re['num'] = count( $re['data'] );        //总条数
                if( $re['num'] < 10 ){
                    $re['state'] = '0';
                }else{
                    $re['state'] = '1';
                }
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }else{
                //检索会员信息
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and TrueName like '%".$content."%' or ExtValue3 like '%".$content."%' or ExtValue8 like '%".$content."%'",
                    "pageIndex" => 0,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
                $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
                foreach ($response_data['data'] as $key => $value) {
                    if ( $value['ExtValue25']!='商政名流' ) {
                        $info[] =$value;
                    }
                }
                $re['data'] = $info;
                $re['num'] = count( $re['data'] );        //总条数
                if( $re['num'] < 10 ){
                    $re['state'] = '0';
                }else{
                    $re['state'] = '1';
                }
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }
        }else {
            $content = $_REQUEST ['type'];   //检索信息

            if (!empty($_REQUEST['page']) ){
                $page = $_REQUEST['page'];
            }

            //加载更多检索信息
            if ( empty($content) ) {
                $re['state'] = '-1';
                $re['message'] = '未搜索到成员信息';
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }else if( !empty($content) && !empty($page) ){
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and TrueName like '%".$content."%' or ExtValue3 like '%".$content."%' or ExtValue8 like '%".$content."%'  ",
                    "pageIndex" => $page,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
                $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
                $re['data'] = $response_data['data'];
                $re['num'] = count( $re['data'] );        //总条数
                if( $re['num'] < 10 ){
                    $re['state'] = '0';
                }else{
                    $re['state'] = '1';
                }
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }else{
                //检索会员信息
                $data = array (
                    "userAccount" => "10000",
                    "where" => " ExtValue26 = '0' and TrueName like '%".$content."%' or ExtValue3 like '%".$content."%' or ExtValue8 like '%".$content."%'  ",
                    "pageIndex" => 0,
                    "pageSize" => 5,
                    "orderBy" => "TrueName ASC"
                );
                $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
                $re['data'] = $response_data['data'];
                $re['num'] = count( $re['data'] );        //总条数
                if( $re['num'] < 10 ){
                    $re['state'] = '0';
                }else{
                    $re['state'] = '1';
                }
                $con = json_encode( $re , JSON_UNESCAPED_UNICODE );
                echo $con;
                exit;
            }
        }
    }

    // 会员详情
    public function details() {
        Vendor('phpSDK.OpenApiClient');
        $client = new \OpenApiClient ();

        $cardid = $_REQUEST['cardid'];
        //所有会员信息
        $data = array (
            "userAccount" => "10000",
            "where" => " Cardid = '".$cardid."' " ,
            "pageIndex" => 0,
            "pageSize" => 1,
            "orderBy" => "TrueName ASC"
        );
        $response_data = $client->CallHttpPost ( "Get_MembersPagedV2", $data );
        $data = $response_data["data"];

        $this->assign('data' , $data);
        $this->display();
    }




/*************************************** 成员风采 ****************************************************************/

}
