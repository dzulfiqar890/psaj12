<?php

namespace App\Http\Controllers\Api\PublicApi;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Controller untuk akses produk publik (Guest)
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="List produk (Public)",
     *     description="Mendapatkan daftar produk dengan search, filter, dan pagination",
     *     @OA\Parameter(name="search", in="query", description="Cari berdasarkan nama produk", @OA\Schema(type="string")),
     *     @OA\Parameter(name="category_id", in="query", description="Filter berdasarkan ID kategori", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="min_price", in="query", description="Harga minimum", @OA\Schema(type="number")),
     *     @OA\Parameter(name="max_price", in="query", description="Harga maksimum", @OA\Schema(type="number")),
     *     @OA\Parameter(name="page", in="query", description="Nomor halaman", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $version = Cache::get('products_cache_version', 1);
        $cacheKey = 'products_index_v' . $version . '_' . md5(json_encode($request->all()));

        $paginatedResult = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($request) {
            $products = Product::with('category:id,name,slug')
                ->search($request->input('search'))
                ->byCategory($request->input('category_id'))
                ->byPriceRange(
                    $request->input('min_price'),
                    $request->input('max_price')
                )
                ->latest()
                ->paginate(12);

            // Transform data untuk menambahkan info stok
            $products->getCollection()->transform(function ($product) {
                $data = $product->toArray();
                $data['is_in_stock'] = $product->isInStock();
                $data['formatted_price'] = $product->formatted_price;
                return $data;
            });

            return [
                'data' => $products->items(),
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ]
            ];
        });

        return ApiResponse::successPaginated(
            $paginatedResult['data'],
            'Data produk berhasil diambil.',
            $paginatedResult['pagination']
        );
    }

    /**
     * @OA\Get(
     *     path="/products/{slug}",
     *     tags={"Products"},
     *     summary="Detail produk (Public)",
     *     description="Mendapatkan detail produk berdasarkan slug",
     *     @OA\Parameter(name="slug", in="path", required=true, description="Slug produk", @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="price", type="number"),
     *                 @OA\Property(property="formatted_price", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="stock", type="integer"),
     *                 @OA\Property(property="is_in_stock", type="boolean"),
     *                 @OA\Property(property="whatsapp_link", type="string", nullable=true),
     *                 @OA\Property(property="stock_message", type="string", nullable=true),
     *                 @OA\Property(property="category", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Produk tidak ditemukan")
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $cacheKey = 'product_detail_' . $product->slug;

        $productData = Cache::remember($cacheKey, now()->addHour(), function () use ($product) {
            $product->load('category:id,name,slug');

            $data = $product->toArray();
            $data['formatted_price'] = $product->formatted_price;
            $data['is_in_stock'] = $product->isInStock();
            $data['whatsapp_link'] = $product->isInStock() ? $product->getWhatsAppLink() : null;
            $data['stock_message'] = $product->getStockMessage();

            return $data;
        });

        return ApiResponse::success($productData);
    }
}
