<?php

namespace App\Http\Controllers\Api\PublicApi;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

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
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

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
        $category->load([
            'products' => function ($query) {
                $query->latest()->take(12);
            }
        ]);

        return ApiResponse::success($category);
    }
}
