<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Controller untuk manajemen produk (Admin only)
 */
class ProductController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/admin/products",
     *     tags={"Products"},
     *     summary="List semua produk (Admin)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="search", in="query", description="Cari berdasarkan nama", @OA\Schema(type="string")),
     *     @OA\Parameter(name="category_id", in="query", description="Filter berdasarkan kategori", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="min_price", in="query", description="Harga minimum", @OA\Schema(type="number")),
     *     @OA\Parameter(name="max_price", in="query", description="Harga maksimum", @OA\Schema(type="number")),
     *     @OA\Parameter(name="page", in="query", description="Nomor halaman", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('category')
            ->search($request->input('search'))
            ->byCategory($request->input('category_id'))
            ->byPriceRange(
                $request->input('min_price'),
                $request->input('max_price')
            )
            ->latest()
            ->paginate(12);

        return ApiResponse::paginated($products, 'Data produk berhasil diambil.');
    }

    /**
     * @OA\Post(
     *     path="/admin/products",
     *     tags={"Products"},
     *     summary="Buat produk baru",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "category_id", "price"},
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="category_id", type="integer"),
     *                 @OA\Property(property="price", type="number"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="stock", type="integer"),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Produk berhasil dibuat"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(ProductRequest $request): JsonResponse
    {
        // Cek apakah sudah ada kategori
        if (Category::count() === 0) {
            return ApiResponse::error(
                'Gagal! Silakan buat kategori produk terlebih dahulu sebelum menambah produk.',
                422
            );
        }

        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $data['created_by'] = $request->user()->id;

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->upload($request->file('image'), 'products');
                }

                $product = Product::create($data);
                $product->load('category');

                ActivityLog::log('create', $product, "Produk '{$product->name}' ditambahkan");

                return ApiResponse::created($product, 'Produk berhasil dibuat.');
            });
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal membuat produk. Silakan coba lagi.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/products/{slug}",
     *     tags={"Products"},
     *     summary="Detail produk",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=404, description="Produk tidak ditemukan")
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $product->load('category');

        // Tambahkan info WhatsApp dan stok
        $productData = $product->toArray();
        $productData['whatsapp_link'] = $product->isInStock() ? $product->getWhatsAppLink() : null;
        $productData['stock_message'] = $product->getStockMessage();
        $productData['is_in_stock'] = $product->isInStock();

        return ApiResponse::success($productData);
    }

    /**
     * @OA\Put(
     *     path="/admin/products/{slug}",
     *     tags={"Products"},
     *     summary="Update produk",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(required=true, @OA\MediaType(mediaType="multipart/form-data", @OA\Schema(
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="category_id", type="integer"),
     *         @OA\Property(property="price", type="number"),
     *         @OA\Property(property="description", type="string"),
     *         @OA\Property(property="stock", type="integer"),
     *         @OA\Property(property="image", type="string", format="binary")
     *     ))),
     *     @OA\Response(response=200, description="Produk berhasil diupdate")
     * )
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $product) {
                $data = $request->validated();

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->update(
                        $request->file('image'),
                        $product->image,
                        'products'
                    );
                }

                $product->update($data);
                $product->load('category');

                ActivityLog::log('update', $product, "Produk '{$product->name}' diperbarui");

                return ApiResponse::success($product, 'Produk berhasil diupdate.');
            });
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal mengupdate produk. Silakan coba lagi.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/admin/products/{slug}",
     *     tags={"Products"},
     *     summary="Hapus produk (soft delete)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="slug", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Produk berhasil dihapus")
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            return DB::transaction(function () use ($product) {
                // Hapus gambar
                $this->imageService->delete($product->image);

                $productName = $product->name;
                $product->delete();

                ActivityLog::log('delete', (object)['id' => null], "Produk '{$productName}' dihapus");

                return ApiResponse::success(null, 'Produk berhasil dihapus.');
            });
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal menghapus produk. Silakan coba lagi.', 500);
        }
    }
}
