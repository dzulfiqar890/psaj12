<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Controller untuk manajemen kategori (Admin only)
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/categories",
     *     tags={"Categories"},
     *     summary="List semua kategori (Admin)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="page", in="query", description="Nomor halaman", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=401, description="Belum login"),
     *     @OA\Response(response=403, description="Akses ditolak")
     * )
     */
    public function index(): JsonResponse
    {
        $categories = Category::withCount('products')
            ->latest()
            ->paginate(12);

        return ApiResponse::paginated($categories, 'Data kategori berhasil diambil.');
    }

    /**
     * @OA\Post(
     *     path="/admin/categories",
     *     tags={"Categories"},
     *     summary="Buat kategori baru",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Kategori berhasil dibuat"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();

                $category = Category::create($data);

                ActivityLog::log('create', $category, "Kategori '{$category->name}' ditambahkan");

                return ApiResponse::created($category, 'Kategori berhasil dibuat.');
            });
        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal membuat kategori. Silakan coba lagi.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/categories/{slug}",
     *     tags={"Categories"},
     *     summary="Detail kategori",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=404, description="Kategori tidak ditemukan")
     * )
     */
    public function show(Category $category): JsonResponse
    {
        $category->load('products');
        return ApiResponse::success($category);
    }

    /**
     * @OA\Put(
     *     path="/admin/categories/{slug}",
     *     tags={"Categories"},
     *     summary="Update kategori",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Kategori berhasil diupdate"),
     *     @OA\Response(response=404, description="Kategori tidak ditemukan")
     * )
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $category) {
                $data = $request->validated();

                $category->update($data);

                ActivityLog::log('update', $category, "Kategori '{$category->name}' diperbarui");

                return ApiResponse::success($category, 'Kategori berhasil diupdate.');
            });
        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal mengupdate kategori. Silakan coba lagi.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/admin/categories/{slug}",
     *     tags={"Categories"},
     *     summary="Hapus kategori (soft delete)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Kategori berhasil dihapus"),
     *     @OA\Response(response=404, description="Kategori tidak ditemukan"),
     *     @OA\Response(response=409, description="Kategori masih memiliki produk")
     * )
     */
    public function destroy(Category $category): JsonResponse
    {
        // Cek apakah kategori masih memiliki produk
        if ($category->products()->exists()) {
            return ApiResponse::error(
                'Kategori tidak dapat dihapus karena masih memiliki produk. Silakan hapus atau pindahkan produk terlebih dahulu.',
                409
            );
        }

        try {
            return DB::transaction(function () use ($category) {
                $categoryName = $category->name;
                $category->delete();

                ActivityLog::log('delete', (object)['id' => null], "Kategori '{$categoryName}' dihapus");

                return ApiResponse::success(null, 'Kategori berhasil dihapus.');
            });
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal menghapus kategori. Silakan coba lagi.', 500);
        }
    }
}

