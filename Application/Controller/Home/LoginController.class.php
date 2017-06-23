<?php


class LoginController extends Controller
{
    public function login(){

        $this->display('login');
    }

    public function sign(){

        $this->display('sign');

    }
}