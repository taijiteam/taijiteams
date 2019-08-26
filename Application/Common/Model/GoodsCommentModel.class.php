<?php
/**
 * Created by PhpStorm.
 * User: jql
 * Date: 2019/5/31
 * Time: 10:05 AM
 */

namespace Common\Model;
use Think\Model;

class GoodsCommentModel extends Model
{



    protected $tableName = 'sc_evaluate';  //ModelClass名称如果和表有不同 就需要手动设置

    public function __construct($name = '', $tablePrefix = '', $connection = '')
    {
        parent::__construct($name, $tablePrefix, $connection);
    }

    public function field($goods_id)
    {
        return $this->field('*')->where(["goods_id" => $goods_id])->find();
    }


    //添加评论
    public function addGoodsComment($data)
    {
        return $this->add($data);
    }


    //查询数据库中是否已存在地址
    public function locatRess($mid){
        return $this->table('my_sc_address')->where(['mid'=>$mid])->find();
    }


}

