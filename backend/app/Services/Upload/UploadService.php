<?php

namespace App\Services\Upload;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function upload($folder, $file)
    {
        $file_name = $folder. '-' . Carbon::now()->timestamp.'_' . rand(10, 100000000) . '.' . $file->getClientOriginalExtension();
        if (Storage::disk('public-upload')->putFileAs($folder, $file, $file_name)) {
            return $file_name;
        }
        return '';
    }

    public static function deleteFile($folder, $file_name)
    {
        // return Storage::disk('public-upload')->delete($file_name);
        return Storage::disk('public-upload')->delete($folder.'/'.$file_name);
    }
}
