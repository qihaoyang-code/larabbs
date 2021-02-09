<?php

namespace App\Handlers;
use Image;
use Str;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        //获取文件后缀
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        //文件夹路径
        $folder_name = "uploads/image/$folder/" . date('Ym/d');

        //具体物理路径,public_path() public 文件夹的具体物理路径
        $upload_path = public_path() . '/' . $folder_name;

        //文件名
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        //保存图片
        $file->move($upload_path, $filename);

        //图片过大时裁剪
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];


    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
