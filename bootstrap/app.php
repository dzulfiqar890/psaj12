<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware untuk role-based access control
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'security.headers' => \App\Http\Middleware\SecurityHeadersMiddleware::class,
        ]);

        // Sanctum stateful domains untuk SPA
        $middleware->statefulApi();

        // Append security headers ke semua response
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        // Rate limiting untuk API
        $middleware->throttleApi('api');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handler untuk API requests
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                // Validation Error - 422
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal. Silakan periksa kembali data yang dikirim.',
                        'errors' => $e->errors(),
                    ], 422);
                }

                // Authentication Error - 401
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda belum login. Silakan login terlebih dahulu.',
                    ], 401);
                }

                // Authorization Error - 403
                if ($e instanceof AccessDeniedHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.',
                    ], 403);
                }

                // Model Not Found - 404
                if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan.',
                    ], 404);
                }

                // Query Exception (Foreign Key Constraint, etc)
                if ($e instanceof QueryException) {
                    $errorCode = $e->errorInfo[1] ?? null;

                    // Foreign key constraint violation
                    if ($errorCode == 1451) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Data tidak dapat dihapus karena masih digunakan oleh data lain.',
                        ], 409);
                    }

                    // Duplicate entry
                    if ($errorCode == 1062) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Data sudah ada. Silakan gunakan data yang berbeda.',
                        ], 409);
                    }

                    // Log query error
                    \Illuminate\Support\Facades\Log::error('Database Error: ' . $e->getMessage());

                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan pada database. Silakan coba lagi.',
                    ], 500);
                }

                // General Server Error - 500
                \Illuminate\Support\Facades\Log::error('Server Error: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => config('app.debug')
                        ? $e->getMessage()
                        : 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                ], 500);
            }
        });
    })->create();
