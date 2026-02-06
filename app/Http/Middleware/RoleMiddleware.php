<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk Role-Based Access Control (RBAC)
 * 
 * Mengecek apakah user yang sedang login memiliki role yang diizinkan
 * untuk mengakses route tertentu.
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (admin, customer)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login. Silakan login terlebih dahulu.',
            ], 401);
        }

        // Cek apakah user memiliki salah satu role yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.',
            ], 403);
        }

        return $next($request);
    }
}
