<?php
//配置文件一般直接返回数组
return [
    'db'=>[//数据库连接信息
        'host'=>'127.0.0.1',
        'user'=>'root',
        'password'=>'root',
        'dbName'=>'myshop',
        'port'=>3306,
        'charset'=>'utf8'
    ],
    'app'=>[//默认的访问参数
        'default_platform'=>'Admin',
        'default_controller'=>'Login',
        'default_action'=>'login'
    ]
];