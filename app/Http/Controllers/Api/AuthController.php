<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="username", type="string", example="johndoe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="no_telephone", type="string", example="081234567890"),
 *     @OA\Property(property="image", type="string", nullable=true),
 *     @OA\Property(property="role", type="string", enum={"admin", "customer"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class AuthController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Authentication"},
     *     summary="Registrasi user baru",
     *     description="Mendaftarkan user baru sebagai customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"username", "email", "password", "password_confirmation"},
     *                 @OA\Property(property="username", type="string", example="johndoe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="password123"),
     *                 @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *                 @OA\Property(property="no_telephone", type="string", example="081234567890"),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registrasi berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Registrasi berhasil."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="1|abc123...")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();

                // Upload image jika ada
                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->upload($request->file('image'), 'users');
                }

                // Set default role sebagai customer
                $data['role'] = 'customer';

                // Buat user baru
                $user = User::create($data);

                // Generate token
                $token = $user->createToken('auth_token')->plainTextToken;

                // Log activity
                Log::info("User registered: {$user->email}", ['user_id' => $user->id]);

                return ApiResponse::created([
                    'user' => $user,
                    'token' => $token,
                ], 'Registrasi berhasil. Selamat datang di Katalog Gitar!');
            });
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return ApiResponse::error('Registrasi gagal. Silakan coba lagi.', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     description="Login dengan email dan password untuk mendapatkan token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@gitarkatalog.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login berhasil."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="1|abc123...")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Email atau password salah")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return ApiResponse::error('Email atau password salah.', 401);
        }

        $user = Auth::user();

        // Revoke all previous tokens untuk keamanan
        $user->tokens()->delete();

        // Generate new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Log activity
        Log::info("User logged in: {$user->email}", ['user_id' => $user->id]);

        return ApiResponse::success([
            'user' => $user,
            'token' => $token,
        ], 'Login berhasil. Selamat datang kembali!');
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     description="Logout dan hapus token saat ini",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout berhasil.")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Belum login")
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        // Untuk API token authentication
        if ($request->user()->tokens()->count() > 0) {
            $request->user()->tokens()->delete();
        }

        // Untuk session-based authentication (Scramble)
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log activity
        Log::info("User logged out: {$user->email}", ['user_id' => $user->id]);

        return ApiResponse::success(null, 'Logout berhasil. Sampai jumpa!');
    }

    /**
     * @OA\Get(
     *     path="/me",
     *     tags={"Authentication"},
     *     summary="Get current user profile",
     *     description="Mendapatkan data profil user yang sedang login",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil."),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Belum login")
     * )
     */
    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success($request->user());
    }
}
