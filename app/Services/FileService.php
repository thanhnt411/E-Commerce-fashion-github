<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Create a new class instance.
     */

    public function upload(UploadedFile $file, string $folder = 'upload')
    {
        $fileName = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $fileName);
        return $path;
    }

    public function uploadMore($files, string $folder = 'upload')
    {
        $gallery = [];
        $count = 1;
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $fileNameG = now()->timestamp . '-' . uniqid() . '-' . $count . '.' . $file->extension();
                $galleryPath = $file->storeAs($folder, $fileNameG);
                $gallery[] = $galleryPath;
                $count = $count + 1;
            }
        }
        $finalString =  implode(',', $gallery);
        return $finalString;
    }

    public function delete(string $path)
    {
        if (Storage::exists(trim($path))) {
            Storage::delete($path);
        }
    }
}
