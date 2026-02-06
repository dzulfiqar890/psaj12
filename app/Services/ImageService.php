<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Service untuk mengelola upload dan delete file gambar.
 * 
 * Fitur:
 * - Upload file ke storage dengan nama unik
 * - Auto-delete file lama saat update
 * - Validasi sudah dilakukan di Form Request
 */
class ImageService
{
    /**
     * Upload file ke storage.
     *
     * @param UploadedFile $file File yang diupload
     * @param string $folder Folder tujuan (e.g., 'products', 'categories')
     * @return string Path file yang tersimpan
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        // Generate nama file unik
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Simpan ke storage/app/public/{folder}
        $path = $file->storeAs($folder, $filename, 'public');

        Log::info("File uploaded: {$path}");

        return $path;
    }

    /**
     * Delete file dari storage.
     *
     * @param string|null $path Path file yang akan dihapus
     * @return bool True jika berhasil atau file tidak ada
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return true;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            Log::info("File deleted: {$path}");
            return true;
        }

        return true;
    }

    /**
     * Get full URL untuk akses file.
     *
     * @param string|null $path Path file
     * @return string|null URL lengkap atau null jika path kosong
     */
    public function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::url($path);
    }

    /**
     * Update file - delete yang lama, upload yang baru.
     *
     * @param UploadedFile $newFile File baru
     * @param string|null $oldPath Path file lama
     * @param string $folder Folder tujuan
     * @return string Path file baru
     */
    public function update(UploadedFile $newFile, ?string $oldPath, string $folder): string
    {
        // Hapus file lama
        $this->delete($oldPath);

        // Upload file baru
        return $this->upload($newFile, $folder);
    }
}
