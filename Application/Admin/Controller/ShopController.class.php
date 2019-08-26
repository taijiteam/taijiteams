<?php
namespace Admin\Controller;
use Home\Controller\IndexController;
use Think\Controller;
use Think\Upload;
header('Content-Type:text/html; charset=utf-8');
class ShopController extends Controller {

    /**
     *	首页商品查找
     *	时间 2019-05-20I
     *	author：Ertao
     */
    public function shopIndex(){
        //按照首页需要展示的推荐查找
        $shop = M('sc_goods')->where('id > 0')->order('g_sort')->select();
        dump($shop);
        $this->assign('shop',$shop);
        $this->display();
    }
    /**
     * 列表页面展现
     * 时间 2019-05-23
     *	author：Ertao
     */
    public function goodList(){
        $shop = M('sc_goods')->where('id > 0')->order('g_sort')->select();
        dump($shop);
        $this->assign('shop',$shop);
        $this->display();
    }

}