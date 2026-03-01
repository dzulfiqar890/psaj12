<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\ActivityLog;
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

        ActivityLog::log('create', $testimonial, "Testimoni '{$testimonial->name}' ditambahkan");

        return ApiResponse::created($testimonial, 'Testimoni berhasil dibuat.');
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return ApiResponse::success($testimonial);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $testimonial->update($request->validated());

        ActivityLog::log('update', $testimonial, "Testimoni '{$testimonial->name}' diperbarui");

        return ApiResponse::success($testimonial, 'Testimoni berhasil diupdate.');
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        ActivityLog::log('delete', (object)['id' => null], "Testimoni '{$name}' dihapus");

        return ApiResponse::success(null, 'Testimoni berhasil dihapus.');
    }
}
