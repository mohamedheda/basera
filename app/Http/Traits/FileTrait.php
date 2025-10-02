<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    final public function image($image, $folder, $oldImage = null)
    {
        // delete old image
        if ($oldImage && File::exists(storage_path('app/public/'.$oldImage))) {
            File::delete(storage_path('app/public/'.$oldImage));
        }
        $rand = rand(999999, 1000000);
        $imageName = time().'_'.$rand.'.'.$image->getClientOriginalExtension();
        $image->move(storage_path('app/public/'.$folder), $imageName);

        return $folder.'/'.$imageName;
    }

    final public function uploadMultiImages($images, $folder, $oldImages = null)
    {
        // delete oldImages if exists
        if ($oldImages) {
            foreach ($oldImages as $oldImage) {
                if (File::exists(storage_path('app/public/'.$oldImage))) {
                    File::delete(storage_path('app/public/'.$oldImage));
                }
            }
        }
        $files = [];
        foreach ($images as $image) {
            $rand = rand(999999, 1000000);
            $imageName = time().'_'.$rand.'.'.$image->getClientOriginalExtension();
            $image->move(storage_path('app/public/'.$folder), $imageName);
            $files[] = $folder.'/'.$imageName;
        }

        return $files;
    }

    // convert base64 to image
    final public function base64Image($base64Image, $folder, $oldImage = null)
    {
        $this->deleteFile($oldImage);
        preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches);
        $extension = $matches[1]; // Get the extension (e.g., png, jpg)
        $base64Data = substr($base64Image, strpos($base64Image, ',') + 1);
        $imageData = base64_decode($base64Data);
        $rand = rand(999999, 1000000);
        $filename = 'image_'.$rand.'.'.$extension;
        $filePath = $folder.'/'.$filename;
        Storage::put('public/'.$filePath, $imageData);

        return $filePath;
    }

    final public function deleteFile($oldImage = null)
    {
        if ($oldImage && File::exists(storage_path('app/public/'.$oldImage))) {
            File::delete(storage_path('app/public/'.$oldImage));
        }
    }

    final public function deleteMulti($oldFiles = null)
    {
        // delete oldImages if exists
        if ($oldFiles) {
            foreach ($oldFiles as $oldImage) {
                if (File::exists(storage_path('app/public/'.$oldImage))) {
                    File::delete(storage_path('app/public/'.$oldImage));
                }
            }
        }
    }
}
