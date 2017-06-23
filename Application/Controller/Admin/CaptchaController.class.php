<?php

/**
 * 23 shop_v25 验证码
验证码原理：
1.	生成验证码是一个单独的功能。
2.	验证过程是将用户输入的验证码和session中保存的验证码进行对比。

a.完成验证码（模拟）
1.设计一个url，期望该url完成生产验证码
index.php?p=Admin&c=Captcha&a=index
2.控制器
//1.接收数据
//2.处理数据
//3.显示页面
3.模型

4.视图

使用iframe活动框架，内嵌一个生成验证码的页面
index.php?p=Admin&c=Captcha&a=index

 */

/**
 * 生成随机验证码
 */
class CaptchaController extends Controller
{
    //声明一个生成验证码的方法
//   public function index1(){
//
//       //声明俩个随机数组,并将其合并
//      $arr = array_merge(range(0,9),range("A","Z"));
//
//      //拼接数组得到字符串
//       $str = implode("",$arr);
//
//       //打乱字符串
//       $str = str_shuffle($str);
//
//       //截取4个打乱的随机字符串
//       $rand_code = substr($str,0,4);
//
//       //将截取的4个随机字符装到全局变量session中
//       @session_start();
//       $_SESSION['rand_code'] = $rand_code;
//
//       //把随机字符显示到页面
//       echo $rand_code;
//
//   }
   /**
    * 生成验证码
    */

     public function  index(){
         //1.生成随机字符
            //准备一个所有可能使用的字符串
         $string = "23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
            //打乱字符串
         $string = str_shuffle($string);
            //截取指定长度来生成随机验证码
         $rand_code = substr($string,0,4);
            //将生成的随机保存到session中，方便全局使用使用
         @session_start();
         $_SESSION['rand_code'] = $rand_code;

         //2.准备随机变化的图片
            //mt_rand比rang速度快4倍
            //动态获取图片的大小
              //图片目录
          $captcha_path = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";
            //获取图片大小
         $image_info = getimagesize($captcha_path);
             //把获取的数组返回的值需要的赋予变量方便使用
         list($width,$height) = $image_info;
         $image = imagecreatefromjpeg($captcha_path);

         //3.字体随机改变的颜色
            //准备要使用的颜色
           $black = imagecolorallocate($image,0,0,0);
           $white = imagecolorallocate($image,255,255,255);
           //把截取的随机字符串写入图片
//         imagestring($image,5,$width/3,$height/6,$rand_code,mt_rand(0.1)?$black:$white);
         imagestring($image,5,$width/3,$height/6,$rand_code,mt_rand(0,1) ? $black : $white);
         //4.验证码的白色边框
          imagerectangle($image,0,0,$width-1,$height-1,$white);


          //混淆验证码
            //中验证码中添加多个点
//         for ($i=0;$i<=100;$i++){
//             //imagesetpixel ( resource $image , int $x , int $y , int $color )
//             $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//             imagesetpixel($image,mt_rand(1,$width-2),mt_rand(1,$height-2),$color);
//         }
//             //验证码中加画线
//         for ($i=0;$i<=3;$i++){
//             $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//             imageline($image,mt_rand(1,$width-2),mt_rand(1,$height-2),mt_rand(1,$width-2),mt_rand(1,$height-2),$color);
//
//         }

         //输出图片到浏览器
         header("Content-Type: image/jpeg");
         imagejpeg($image);
         //关闭图片资源
         imagedestroy($image);
     }
}