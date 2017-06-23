<?php
 @session_start();
    //将项目中的所有目录 先给他定义一个常量来表示
    defined("DS") or define("DS",DIRECTORY_SEPARATOR);
    defined("ROOT_PATH") or define("ROOT_PATH",__DIR__.DS);//项目根目录
    defined("APP_PATH") or define("APP_PATH",ROOT_PATH."Application".DS);//应用目录
    defined("FRAME_PATH") or define("FRAME_PATH",ROOT_PATH."Framework".DS);//框架目录
    defined("PUBLIC_PATH") or define("PUBLIC_PATH",ROOT_PATH."Public".DS);//公共目录
    defined("UPLOADS_PATH") or define("UPLOADS_PATH",ROOT_PATH."Uploads".DS);//上次目录
    defined("CONFIG_PATH") or define("CONFIG_PATH",APP_PATH."Config".DS);//配置文件目录
    defined("CONTROLLER_PATH") or define("CONTROLLER_PATH",APP_PATH."Controller".DS);//控制器目录
    defined("MODEL_PATH") or define("MODEL_PATH",APP_PATH."Model".DS);//模型目录
    defined("VIEW_PATH") or define("VIEW_PATH",APP_PATH."View".DS);//视图目录
    defined("TOOLS_PATH") or define("TOOLS_PATH",FRAME_PATH."Tools".DS);//工具目录


    //使用配置文件
    $GLOBALS['config'] = require CONFIG_PATH."application.config.php";
//    var_dump($GLOBALS['config']);exit;
    //接收请求参数
    $p = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['app']['default_platform'];//平台
    $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['app']['default_controller'];//控制器类的类名
    $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['app']['default_action'];//类中的方法名

    //定义当前访问的控制器和视图文件所在路径
    defined("CURRENT_CONTROLLER_PATH") or define("CURRENT_CONTROLLER_PATH",CONTROLLER_PATH.$p.DS);
    defined("CURRENT_VIEW_PATH") or define("CURRENT_VIEW_PATH",VIEW_PATH.$p.DS.$c.DS);

    //创建控制器类对象
    //require CURRENT_CONTROLLER_PATH."{$c}Controller.class.php";
    $class_name = $c."Controller";
    $controller = new $class_name();//可变类名 类名可以使用一个变量来代替

    //调用控制器对象上的方法
    $controller->$a();

    /**
     * 类的自动加载
     */
    function __autoload($class_name){//传入的是类名
        //保存框架核心类中类名和类所在路径的映射
        $classMapping = [
            "Model"=>FRAME_PATH."Model.class.php",
            "DB"=>TOOLS_PATH."DB.class.php",
            'Controller'=>FRAME_PATH."Controller.class.php",
            'Page'=>TOOLS_PATH."Page.class.php"
        ];
        //根据类名加载对应的类文件
        if (isset($classMapping[$class_name])){//判定是否加载框架核心类 优先判定
            require $classMapping[$class_name];
        }elseif(substr($class_name,-10) == "Controller"){//判定是否以Controller结尾
            require CURRENT_CONTROLLER_PATH.$class_name.".class.php";
        }elseif (substr($class_name,-5) == "Model"){//判定是否以Model结尾
            require MODEL_PATH.$class_name.".class.php";
        }
    }