<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save($file, $folder, $file_prefix)
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

        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];


    }
}
