<?php

/**
 * 文件上传类
 */
class UploadModel extends Model
{
    /**
     * 上传商品图片
     */
    public function uploadOne($file,$dir=''){
        //判断文件上传是否错误，error
        if($file['error'] != 0){
            $this->error = "文件上传失败~！";
            return false;
        }

        //判断上传的类型
        $allow_types = ['image/gif','image/jpeg','image/pjpeg','image/png','image/x-png'];//允许上传的类型
        if(!in_array($file['type'],$allow_types)){
            $this->error = "上传文件类型错误~！";
            return false;
        }

        //判断上传文件的大小
        $max_size = 2*1024*1024;//允许上传的最大文件大小
        if($file['size'] > $max_size){
            $this->error = "文件太大~！";
            return false;
        }

        //判断是否是上传的文件 http post 上传
        if(!is_uploaded_file($file['tmp_name'])){
            $this->error = "不是上传的文件~！";
            return false;
        }

        //准备文件名
        $filename = uniqid("IT_").strrchr($file['name'],".");
        $dir .= date("Ymd")."/";

        //自动创建文件夹
        if(!is_dir(UPLOADS_PATH.$dir)){//判定文件夹是否存在
            mkdir(UPLOADS_PATH.$dir,0777,true);
        }
        //完整的路径名 绝对路径
        $full_name = UPLOADS_PATH.$dir.$filename;
//        var_dump($full_name);exit;
//        var_dump($full_name);exit;
        if(!move_uploaded_file($file['tmp_name'],$full_name)){
            $this->error = "移动文件失败！";
            return false;
        }
        //返回上传后的图片地址
//        var_dump($dir.$filename);exit;
//        var_dump(str_replace(UPLOADS_PATH,'',$full_name));exit;
        return $dir.$filename;
    }
}