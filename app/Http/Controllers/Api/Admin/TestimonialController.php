<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk manajemen testimoni (Admin only)
 */
class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::latest()->paginate(12);
        return ApiResponse::paginated($testimonials, 'Data testimoni berhasil diambil.');
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        $testimonial = Testimonial::create($request->validated());

        Log::info("Testimonial created: {$testimonial->name}", [
            'user_id' => auth()->id(),
            'testimonial_id' => $testimonial->id,
            'action' => 'create',
        ]);

        return ApiResponse::created($testimonial, 'Testimoni berhasil dibuat.');
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return ApiResponse::success($testimonial);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $testimonial->update($request->validated());

        Log::info("Testimonial updated: {$testimonial->name}", [
            'user_id' => auth()->id(),
            'testimonial_id' => $testimonial->id,
            'action' => 'update',
        ]);

        return ApiResponse::success($testimonial, 'Testimoni berhasil diupdate.');
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        Log::info("Testimonial deleted: {$name}", [
            'user_id' => auth()->id(),
            'testimonial_id' => $testimonial->id,
            'action' => 'delete',
        ]);

        return ApiResponse::success(null, 'Testimoni berhasil dihapus.');
    }
}
