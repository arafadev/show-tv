<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploadService
{
    public function uploadImage(UploadedFile $file, string $directory, int $maxWidth = 800, int $maxHeight = 600): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        $manager = new ImageManager(new Driver());

        $image = $manager->read($file);

        if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
            $image = $image->scaleDown($maxWidth, $maxHeight);
        }

        Storage::disk('public')->put($path, (string) $image->toJpeg());

        return $path;
    }

    public function uploadVideo(UploadedFile $file, string $directory): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        Storage::disk('public')->putFileAs($directory, $file, $filename);

        return $path;
    }

    public function deleteFile(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
