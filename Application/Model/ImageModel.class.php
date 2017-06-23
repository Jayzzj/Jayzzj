<?php

/**
 * 图片处理工具模型
 */
class ImageModel extends Model
{
    /**
     * 制作缩略图
     * @$src_path 原图路径
     */
    public function thumb($src_path,$thumb_width,$thumb_height){
        //1.创建一个新的指定大小的画布
        $thumb_image = imagecreatetruecolor($thumb_width,$thumb_height);
        //2.基于已经存在的原图创建一张画布
        //获取图片的绝对路径
        $src_path = UPLOADS_PATH.$src_path;
//        var_dump($src_path);exit;
        if(!is_file($src_path)){//判定是否有这个文件
            $this->error = "文件路径错误！";
            return false;
        }

        $src_info = getimagesize($src_path);
        //动态获取图片宽高
        list($src_width,$src_height) = $src_info;

        /**
         * 获取图片类型，根据图片类型来使用不同的方法创建图片
         */
//    var_dump($src_info);exit;
        $mime = $src_info['mime'];
        $func = str_replace('image/','',$mime);
//    var_dump($func);exit;
        //准备创建方法的方法名变量
        $make_func = "imagecreatefrom".$func;
//    var_dump($make_func);exit;
        $src_image = $make_func($src_path);


        //目标图片补白
        //选择白色
        $white = imagecolorallocate($thumb_image,255,255,255);
        //填充颜色
        imagefill($thumb_image,0,0,$white);
        /**
         * 等比例缩放
         * 1.计算最大的缩放比例（按照最大值进行缩放）
         *
         * 2.计算缩放和图片的宽度和高度
         */
        //1.计算最大的缩放比例（按照最大值进行缩放）
        $scale = max($src_width/$thumb_width,$src_height/$thumb_height);
        //2.计算缩放和图片的宽度和高度
        //var_dump($scale);exit;
        $width = $src_width/$scale;
        $height = $src_height/$scale;
//    var_dump($width,$height);exit;

        //3.将原图拷贝到新的画布上
        /***
         * imagecopyresampled (
         * resource $dst_image , 目标图片资源
         * resource $src_image , 原图片资源
         * int $dst_x , int $dst_y , 目标图片的起始坐标
         * int $src_x , int $src_y , 原图片的起始坐标
         * int $dst_w , int $dst_h , 目标图片的宽高
         * int $src_w , int $src_h   原图片的宽高
         * )
         */
        //拷贝后居中 计算起始位置
        imagecopyresampled($thumb_image,$src_image,($thumb_width-$width)/2,($thumb_height-$height)/2,0,0,$width,$height,$src_width,$src_height);

        //4.保存新图片
            /**
             * 确定缩略图片的保存路径
             * 和原图路径一致，只是加上一个后缀
             * D:\web\MVC_day7\shop_v30\Uploads\goods\20170618\IT_59461a7bc4ac5_{$thumb_width}x{$thumb_height}.jpg
             */
            //缩略图路径
            $pathinfo = pathinfo($src_path);
            $thumb_path = $pathinfo['dirname'].'/'.$pathinfo['filename']."_{$thumb_width}x{$thumb_height}.".$pathinfo['extension'];
//            var_dump($thumb_path);exit;
            //准备输出图片的方法名变量
            $out_func = "image".$func;
    //    var_dump($out_func);exit;
            $out_func($thumb_image,$thumb_path);


            //5.关闭图片 新 旧
            imagedestroy($src_image);
            imagedestroy($thumb_image);

            //var_dump(str_replace(UPLOADS_PATH,'',$thumb_path));exit;
            return str_replace(UPLOADS_PATH,'',$thumb_path);

    }
}