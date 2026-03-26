<?php

namespace App\Http\Controllers\Api\PublicApi;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

/**
 * Controller untuk akses kategori publik (Guest)
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="List kategori (Public)",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index(): JsonResponse
    {
        $categories = Cache::remember('categories_index', now()->addDay(), function () {
            return Category::withCount('products')
                ->orderBy('name')
                ->get();
        });

        return ApiResponse::success($categories, 'Data kategori berhasil diambil.');
    }

    /**
     * @OA\Get(
     *     path="/categories/{slug}",
     *     tags={"Categories"},
     *     summary="Detail kategori dengan produk",
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=404, description="Kategori tidak ditemukan")
     * )
     */
    public function show(Category $category): JsonResponse
    {
        $cacheKey = 'category_detail_' . $category->slug;

        $categoryData = Cache::remember($cacheKey, now()->addHour(), function () use ($category) {
            $category->load([
                'products' => function ($query) {
                    $query->latest()->take(12);
                }
            ]);
            return $category;
        });

        return ApiResponse::success($categoryData);
    }
}
