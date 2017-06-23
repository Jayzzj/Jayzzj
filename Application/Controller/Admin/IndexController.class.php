<?php


class IndexController extends Controller
{
    public function index(){
        //显示页面
        $this->display('index');
    }

    public function head(){
        //显示页面
        $this->display('head');
    }

    public function left(){
        //显示页面
        $this->display('left');
    }

    //显示主页方法
    public function main(){
        //1.接收数据
        //2.处理数据
        //3.显示页面
        $this->display("main");
    }

}