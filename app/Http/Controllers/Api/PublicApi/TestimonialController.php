<?php

namespace App\Http\Controllers\Api\PublicApi;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

/**
 * Controller untuk akses testimoni publik (Guest)
 */
class TestimonialController extends Controller
{
    /**
     * @OA\Get(
     *     path="/testimonials",
     *     tags={"Testimonials"},
     *     summary="List testimoni aktif (Public)",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::active()
            ->latest()
            ->get();

        return ApiResponse::success($testimonials, 'Data testimoni berhasil diambil.');
    }
}
