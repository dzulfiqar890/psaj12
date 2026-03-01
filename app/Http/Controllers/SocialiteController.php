<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect ke Google OAuth.
     */
    public function redirectToGoogle()
    {
        // Bypass SSL on local dev (cURL error 60 fix)
        if (config('app.env') === 'local') {
            $guzzle = new \GuzzleHttp\Client(['verify' => false]);
            return Socialite::driver('google')->setHttpClient($guzzle)->redirect();
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            // Bypass SSL on local dev (cURL error 60 fix)
            if (config('app.env') === 'local') {
                $guzzle = new \GuzzleHttp\Client(['verify' => false]);
                $googleUser = Socialite::driver('google')->setHttpClient($guzzle)->user();
            } else {
                $googleUser = Socialite::driver('google')->user();
            }

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                // Cek apakah user adalah admin
                if (!$user->is_admin) {
                    return redirect('/login')->withErrors([
                        'email' => 'Akun ini tidak memiliki akses admin.',
                    ]);
                }

                Auth::login($user);

                Log::info("User logged in via Google: {$user->email}", ['user_id' => $user->id]);

                return redirect()->route('admin.dashboard');
            }

            // Jika user tidak ditemukan, tolak akses
            return redirect('/login')->withErrors([
                'email' => 'Akun Google Anda tidak terdaftar sebagai admin. Hubungi administrator.',
            ]);

        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect('/login')->withErrors([
                'email' => 'Gagal login dengan Google. Silakan coba lagi.',
            ]);
        }
    }
}
