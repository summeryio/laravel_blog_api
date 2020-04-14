<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use Image;

class ImageUploadHandler {
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $prefix, $max_width = false) {
        $folder_name = "uploads/images/$folder" . date('Ym/d', time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->redusize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function redusize($file_path, $max_width) {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save();
    }
}
