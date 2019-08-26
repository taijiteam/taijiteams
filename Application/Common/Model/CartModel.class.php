<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 2019/5/28
 * Time: 12:45 PM
 */
namespace Common\Model;
use Think\Model;

class CartModel extends Model
{

    protected $tableName = 'sc_cart';  //ModelClass名称如果和表有不同 就需要手动设置

    public function __construct($name = '', $tablePrefix = '', $connection = '')
    {
        parent::__construct($name, $tablePrefix, $connection);
    }

    public function getUserCart($mid)
    {
         return $this->field('*')->where(["mid" => $mid])->find();
    }

    public function addCart($data){
        return $this->add($data);
    }

    public function updateCart($data){
        return $this->save($data);
    }
}