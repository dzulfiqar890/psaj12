<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk menambahkan Security Headers ke semua response
 * 
 * Headers ini membantu melindungi aplikasi dari serangan seperti:
 * - Clickjacking (X-Frame-Options)
 * - XSS (X-XSS-Protection, X-Content-Type-Options)
 * - MIME sniffing (X-Content-Type-Options)
 */
class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mencegah clickjacking - halaman tidak bisa di-embed dalam iframe
        $response->headers->set('X-Frame-Options', 'DENY');

        // Mencegah browser menebak MIME type yang salah
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Mengaktifkan XSS filter browser (untuk browser lama)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy - hanya kirim origin untuk cross-origin requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions policy - batasi fitur browser yang bisa digunakan
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // HSTS - paksa HTTPS (hanya aktifkan di production)
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
