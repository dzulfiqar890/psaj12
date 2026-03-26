<?php

namespace App\Http\Controllers\Api\PublicApi;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

/**
 * Controller untuk akses banner publik (Guest)
 */
class BannerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/banners",
     *     tags={"Banners"},
     *     summary="List banner aktif (Public)",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index(): JsonResponse
    {
        $banners = Cache::remember('active_banners', now()->addDay(), function () {
            return Banner::active()
                ->latest()
                ->get();
        });

        return ApiResponse::success($banners, 'Data banner berhasil diambil.');
    }
}
