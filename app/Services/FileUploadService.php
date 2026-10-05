<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function store(?UploadedFile $file, string $directory): ?string
    {
        return $file?->store($directory, 'public');
    }

    public function replace(?UploadedFile $file, ?string $oldPath, string $directory): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        $path = $this->store($file, $directory);

        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
