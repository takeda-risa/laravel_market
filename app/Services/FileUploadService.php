<?php
 
namespace App\Services;
 
class FileUploadService {
 
    public function saveImage($image){
        $path = '';
        if( isset($image) === true ){
            $path = $image->store('photos', 'public');
        }
        return $path;; // 画像が存在しない場合は空文字
    }
}