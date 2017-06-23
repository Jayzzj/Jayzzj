<?php

/**
 * 基础控制器类
 */
abstract class Controller
{
    private $data = [];//保存所有的需要分配的数据

    /**
     * 将需要分配到视图的数据 保存到 $data 这个属性中
     * @param $name $data 属性的键名 如果$name是一个关联数组，可以直接分配
     * @param $value 对应的值
     */
    protected function assign($name,$value=''){
        if(is_array($name)){//判定变量是否是一个数组
            $this->data = array_merge($this->data,$name);//数组合并
        }else{
            $this->data[$name] = $value;
        }
    }
    /**
     * 加载视图页面
     * @param $template
     */
    protected function display($template){
//        var_dump($this->data);exit;
        //extract — 从数组中将变量导入到当前的符号表 将关联数组的键作为变量名，值作为变量的值
        extract($this->data);
//        $rows = $this->data['rows'];
//        $name = '张三';
//        $age = 18;
        require CURRENT_VIEW_PATH.$template.".html";
        exit;
    }

    /**
     * @param 跳转的url $url 跳转的连接
     * @param string $msg 提示信息
     * @param int $time 等待时间
     */
    protected function redirect($url,$msg='',$time = 0){
        /*        if($time){//时间大于0表示等待后跳转
                    //提示信息
                    echo "<h1>{$msg}</h1>";
                    //等待时间后跳转
                    header("Refresh: {$time};{$url}");
                }else{//立即跳转
                    header("Location: {$url}");
                }*/
        if($time){//时间大于0表示等待后跳转
            //提示信息
            echo "<h1>{$msg}</h1>";
        }
        //等待时间后跳转
        header("Refresh: {$time};{$url}");
        exit;
    }
}