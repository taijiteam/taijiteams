<?php
namespace Admin\Controller;
use Common\Model\MemberModel;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class SortController extends Controller {

    private $Member_model;
    /**
     * 接口
     */
    public function _initialize(){
        Vendor('phpSDK.OpenApiClient');
    }

    public function __construct()
    {
        parent::__construct();
        $this->Member_model = new MemberModel();
    }
    /*********************************************   导出   **********************************************************/
    public function export()
    {
        $order_type = I('get.order_type');
        switch ($order_type){
            case '3':
                $expTableData = $this->Member_model->sortAllType($order_type);
                break;
            case '1':
                $expTableData = $this->Member_model->sortAllType($order_type);
            break;
            case '2':
                $expTableData = $this->Member_model->sortAllType($order_type);
            break;
            case '4':
                $expTableData = $this->Member_model->sortAllType($order_type);
            break;
            default;
        }
        //phpExcel导出
        set_time_limit(0);
        $expTitle = '成员积分记录';
        vendor('PHPExcel.Classes.PHPExcel');
        $title = ['订单编号','付款人','手机号','商品名称','积分使用','积分使用类型','支付方式','消费时间'];
        // 设置
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE',
            'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT',
            'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        $row = 1; //设置纵向单元标识
        if ($title){
            $cnt = count($title);
            $objPHPExcel->getActiveSheet(0)->mergeCells('A'.$row.':'.$cellName[$cnt-1].$row); //合并单元格
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,$expTitle.date("Y-m-d H:i:s"));
            $row++;
            $i =0;
            foreach ($title as $v){ //设置列标题
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].$row,$v);
                $i++;
            }
            $row++;
        }
        /**
         * 单元格宽度
         */
        //$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        //开始赋值
        if (!empty($expTableData)) {
            $i = 0;
            foreach ($expTableData as $key => $value) {
                $j = 0;
                if ($value['pocket_act'] == '0')
                {
                    $value['pocket_value'] = '积分增加+'.$value['pocket_value'];
                    $value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
                }else{
                    $value['pocket_value'] = '积分使用-'.$value['pocket_value'];
                    $value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
                };
                if ($value['pay_style']){
                    $value['pay_style'] = '微信支付';
                }
                foreach ($value as $item){
                    //var_dump($item);
                    $objPHPExcel->getActiveSheet()->setCellValue($cellName[$j] . ($i+$row), $item);
                    $j++;
                }
                $i++;
            }
        } else {
            die(" 暂无数据" . EOL);
        }
        //die();


        $objPHPExcel->getActiveSheet()->setTitle('成员积分记录');

        // 设置行高
        $name = '成员积分记录.xlsx';//任意名字
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $name);
        header('Cache-Control: max-age=0');
        $ExcelWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $ExcelWriter->save('php://output');
        exit;
    }
    //导出积分列表
    public function exportList()
    {
        set_time_limit(0);

        $order_type = I('get.order_type');
        $expTitle = '成员积分记录';
        $expTableData = $this->Member_model->sortAllType($order_type);
        vendor('PHPExcel.Classes.PHPExcel');
        $title = ['姓名','性别','电话','酒积分','机场积分','医疗积分','兑换积分','金币积分','总积分'];
        // 设置
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE',
            'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT',
            'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        $row = 1; //设置纵向单元标识
        if ($title){
            $cnt = count($title);
            $objPHPExcel->getActiveSheet(0)->mergeCells('A'.$row.':'.$cellName[$cnt-1].$row); //合并单元格
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,$expTitle.date("Y-m-d H:i:s"));
            $row++;
            $i =0;
            foreach ($title as $v){ //设置列标题
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].$row,$v);
                $i++;
            }
            $row++;
        }
        /**
         * 单元格宽度
         */
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        //开始赋值
        if (!empty($expTableData)) {
            $i = 0;
            foreach ($expTableData as $key => $value) {
                //$Cellkey = $key + 3;
                $j = 0;
                foreach ($value as $item){
                    $objPHPExcel->getActiveSheet()->setCellValue($cellName[$j] . ($i+$row), $item);
                    $j++;
                }
                $i++;
            }
        } else {
            die(" 暂无数据" . EOL);
        }


        $objPHPExcel->getActiveSheet()->setTitle('成员积分记录');

        // 设置行高
        $name = '成员积分记录.xlsx';//任意名字
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $name);
        header('Cache-Control: max-age=0');
        $ExcelWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $ExcelWriter->save('php://output');
        exit;
    }

    /**
     * 会员积分
     * 时间：2019年3月18日13:31:19
     * author：ErTao
     */
    public function sortList(){
        //获取用户的积分情况
        $count = M()->table('my_merber')
            ->join('my_sort on my_merber.m_id = my_sort.a_aid')
            ->field('my_merber.m_id,m_sex,m_phone,m_cname,my_sort.*')
            ->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $res = M()->table('my_merber')
                    ->join('my_sort on my_merber.m_id = my_sort.a_aid')
                    ->field('my_merber.m_id,m_sex,m_phone,m_cname,m_integrals,my_sort.*')
                    ->order('my_merber.m_time desc')
                    ->limit($Page->firstRow . ',' . $Page->listRows)
                    ->select();
        //dump($res);
        $this->assign('count',$count);
        $this->assign('res',$res);
        $this->assign('page', $show);// 赋值分页输出
        $this->display();
    }
    //积分管理详情
    public function sortDefatu(){
        if($_GET){
            $id = $_GET['id'];
            //dump($id);
           //根据id查找
            $res = M()->table('my_merber')
                ->join('my_sort on my_merber.m_id = my_sort.a_aid')
                ->where("my_merber.m_id = $id")
                ->field('my_merber.m_cname,my_sort.*')
                ->find();// 查询满足要求的总记录数
            //dump($res);

            $this->assign('res',$res);
            $this->display();
        }

    }
    //积分更改
    public function sortEditSave(){
        //接收上传的id
        $id = $_POST['id'];
        //dump($id);
        //接收上传的积分
        $data = array(
            'a_jiu_sort' => $_POST['a_jiu_sort'],  //酒积分
            'a_jichang_sort' => $_POST['a_jichang_sort'],  //机场积分
            'a_doctor_sort' => $_POST['a_doctor_sort'],  //医疗积分
            'a_consume_sort' => $_POST['a_consume_sort'],  //兑换积分
            'a_jinbi_sort' => $_POST['a_jinbi_sort'],  //金币积分
        );
        //总积分
        $scort = array('m_integrals'=>array_sum($data));
        //更新总积分  以及 积分详情
        if($data != null && $scort != null){
            $res1 =  M('sort')->where("a_aid = $id")->save($data);
            $res2 =  M('merber')->where("m_id = $id")->save($scort);
            if($res1 && $res2){
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
        }
        //dump($scort);
    }
    //根据人名搜索
    public function sortSearch(){
        //接受传值id
            $keywords = $_POST['username'];
            //$this->ajaxReturn($id);
            //dump($id);die();
            //搜索数据库中的所有数据进行模糊搜索
            $data['m_cname'] = array('like', "%$keywords%");
            $res =M()->table('my_merber')
                ->join('my_sort on my_merber.m_id = my_sort.a_aid')
                ->field('my_merber.m_id,m_sex,m_phone,m_cname,my_sort.*')
                ->where($data)
                ->select();
            //dump($res);die();
           if($res != null){
               $this->assign('search',$res);
               $this->display();
           }else{
               $this->display();
           }
    }
    //积分使用记录
    public function sort_log()
    {
        $pocket_type = intval(I('integral_type'));
        $pocket_type = $pocket_type <= 0 ? 0 : $pocket_type;

        $mid = I('get.mid');
        if ($mid) {
            $memberInfo =   $this->Member_model->getMemberInfo($mid);
            $info = $this->Member_model->member_sort($mid);
            $consumption = $this->Member_model->consumptionInfo($mid,$pocket_type);
            $count = count($consumption);
            $this->assign('info', $info);
            $this->assign('memberInfo', $memberInfo);
            $this->assign('integral_type',$pocket_type);
            $this->assign('consumption', $consumption);
            $this->assign('count', $count);
        }
        $this->display();
    }
    //积分使用记录
    public function sortAll()
    {
        $consumption = $this->Member_model->sortAll();
        $count = count($consumption);
        $this->assign('consumption', $consumption);
        $this->assign('count', $count);
        $this->display();
    }

}