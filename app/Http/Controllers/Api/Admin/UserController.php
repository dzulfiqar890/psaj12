<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Controller untuk manajemen user (Admin only)
 */
class UserController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::when($request->has('is_admin'), function ($query) use ($request) {
            return $query->where('is_admin', filter_var($request->is_admin, FILTER_VALIDATE_BOOLEAN));
        })
            ->when($request->search, function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('username', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(12);

        return ApiResponse::paginated($users, 'Data user berhasil diambil.');
    }

    public function store(UserRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->upload($request->file('image'), 'users');
                }

                $user = User::create($data);

                ActivityLog::log('create', $user, "User '{$user->email}' ditambahkan");

                return ApiResponse::created($user, 'User berhasil dibuat.');
            });
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal membuat user. Silakan coba lagi.', 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        return ApiResponse::success($user);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $user) {
                $data = $request->validated();

                // Jangan update password jika kosong
                if (empty($data['password'])) {
                    unset($data['password']);
                }

                if ($request->hasFile('image')) {
                    $data['image'] = $this->imageService->update(
                        $request->file('image'),
                        $user->image,
                        'users'
                    );
                }

                $user->update($data);

                ActivityLog::log('update', $user, "User '{$user->email}' diperbarui");

                return ApiResponse::success($user, 'User berhasil diupdate.');
            });
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal mengupdate user. Silakan coba lagi.', 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        // Tidak bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return ApiResponse::error('Tidak dapat menghapus akun sendiri.', 403);
        }

        try {
            return DB::transaction(function () use ($user) {
                $this->imageService->delete($user->image);

                $userEmail = $user->email;
                $user->delete();

                ActivityLog::log('delete', (object)['id' => null], "User '{$userEmail}' dihapus");

                return ApiResponse::success(null, 'User berhasil dihapus.');
            });
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            return ApiResponse::error('Gagal menghapus user. Silakan coba lagi.', 500);
        }
    }
}
