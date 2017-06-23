<?php

/**
 * 基础模型
 */
abstract class Model
{
    protected $db;//属性，保存创建好的DB对象

    protected $error;//保存错误信息
    /**
     * 构造方法，创建对象的时候自动执行
     */
    public function __construct()
    {
        //require TOOLS_PATH."DB.class.php";
        $this->db = DB::getInstance($GLOBALS['config']['db']);//创建单例对象的方法
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }
}