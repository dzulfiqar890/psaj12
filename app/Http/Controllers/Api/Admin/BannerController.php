<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\ActivityLog;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Controller untuk manajemen banner (Admin only)
 */
class BannerController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
    }

    public function index(): JsonResponse
    {
        $banners = Banner::latest()->paginate(12);
        return ApiResponse::paginated($banners, 'Data banner berhasil diambil.');
    }

    public function store(BannerRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->upload($request->file('image'), 'banners');
                }

                $banner = Banner::create($data);

                ActivityLog::log('create', $banner, "Banner '{$banner->title}' ditambahkan");

                return ApiResponse::created($banner, 'Banner berhasil dibuat.');
            });
        } catch (\Exception $e) {
            Log::error('Banner creation failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal membuat banner. Silakan coba lagi.', 500);
        }
    }

    public function show(Banner $banner): JsonResponse
    {
        return ApiResponse::success($banner);
    }

    public function update(BannerRequest $request, Banner $banner): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $banner) {
                $data = $request->validated();

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->update(
                        $request->file('image'),
                        $banner->image,
                        'banners'
                    );
                }

                $banner->update($data);

                ActivityLog::log('update', $banner, "Banner '{$banner->title}' diperbarui");

                return ApiResponse::success($banner, 'Banner berhasil diupdate.');
            });
        } catch (\Exception $e) {
            Log::error('Banner update failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal mengupdate banner. Silakan coba lagi.', 500);
        }
    }

    public function destroy(Banner $banner): JsonResponse
    {
        try {
            return DB::transaction(function () use ($banner) {
                $this->imageService->delete($banner->image);

                $bannerTitle = $banner->title;
                $banner->delete();

                ActivityLog::log('delete', (object)['id' => null], "Banner '{$bannerTitle}' dihapus");

                return ApiResponse::success(null, 'Banner berhasil dihapus.');
            });
        } catch (\Exception $e) {
            Log::error('Banner deletion failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal menghapus banner. Silakan coba lagi.', 500);
        }
    }
}
