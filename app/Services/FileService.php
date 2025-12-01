<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function upload(UploadedFile $file, string $folder = 'upload')
    {
        $fileName = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $fileName);
        return $path;
    }

    public function delete(string $path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
