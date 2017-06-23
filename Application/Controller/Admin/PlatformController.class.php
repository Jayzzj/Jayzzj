<?php


class PlatformController extends Controller
{
    /**
     * 声明一个构造函数
     */
    public function __construct()
    {
        //调用私有的方法,并用结果来判定
        $result = $this->checkBycookie();
        if ($result === false) {
            //如果结果不成立，跳转到登录页面
            $this->redirect("index.php?p=Admin&c=Login&a=login", "没有登陆", 3);
        }

    }

    /**
     * 验证登录信息
     * 成功返回ture 失败返回false
     */
    private function checkBycookie()
    {

        //利用$_SESSION在主页判定是否登录
        if (!isset($_SESSION['user_info'])) {
            //检测是否有cookie记录
            if (isset($_COOKIE['id']) && isset($_COOKIE['password'])) {
                //如果有取出’id‘和密码进行比对
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                //将id和密码和数据库的进行比对 如果有返回false
                $adminmodel = new AdminModel();
                $result = $adminmodel->checkBycookie($id, $password);

                //判定返回的结果
                if ($result !== false) {//验证成功
                    //把记录到sesion 中
                    $_SESSION['user_info'] = $result;
                    return true;
                }

            }
//如果没有收到登录数据跳转到登录界面
            return false;

        }
    }
}