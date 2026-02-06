<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

/**
 * Helper class untuk format response API yang konsisten.
 */
class ApiResponse
{
    /**
     * Response sukses dengan data.
     *
     * @param mixed $data Data yang akan dikembalikan
     * @param string $message Pesan sukses
     * @param int $code HTTP status code
     * @return JsonResponse
     */
    public static function success($data = null, string $message = 'Berhasil.', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Response error.
     *
     * @param string $message Pesan error
     * @param int $code HTTP status code
     * @param mixed $errors Detail error (opsional)
     * @return JsonResponse
     */
    public static function error(string $message = 'Terjadi kesalahan.', int $code = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Response dengan pagination.
     *
     * @param LengthAwarePaginator $paginator Data dengan pagination
     * @param string $message Pesan sukses
     * @return JsonResponse
     */
    public static function paginated(LengthAwarePaginator $paginator, string $message = 'Data berhasil diambil.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ], 200);
    }

    /**
     * Response untuk data yang baru dibuat (201 Created).
     *
     * @param mixed $data Data yang baru dibuat
     * @param string $message Pesan sukses
     * @return JsonResponse
     */
    public static function created($data = null, string $message = 'Data berhasil dibuat.'): JsonResponse
    {
        return self::success($data, $message, 201);
    }

    /**
     * Response tidak ditemukan (404 Not Found).
     *
     * @param string $message Pesan error
     * @return JsonResponse
     */
    public static function notFound(string $message = 'Data tidak ditemukan.'): JsonResponse
    {
        return self::error($message, 404);
    }

    /**
     * Response tidak authorized (401 Unauthorized).
     *
     * @param string $message Pesan error
     * @return JsonResponse
     */
    public static function unauthorized(string $message = 'Anda belum login.'): JsonResponse
    {
        return self::error($message, 401);
    }

    /**
     * Response akses ditolak (403 Forbidden).
     *
     * @param string $message Pesan error
     * @return JsonResponse
     */
    public static function forbidden(string $message = 'Akses ditolak.'): JsonResponse
    {
        return self::error($message, 403);
    }
}
