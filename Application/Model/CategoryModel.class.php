<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 15:24
 */
class CategoryModel extends Model
{
    /**
     * 获取所有的数据
     */
    public function getAll(){
        //1.准备sql语句获取所有分类的
            $sql = "select * from category";
        //2.执行sql语句
            $rows = $this->db->fetchAll($sql);
            return $rows;
    }
}