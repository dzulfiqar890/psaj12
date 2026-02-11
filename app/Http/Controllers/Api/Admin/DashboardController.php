<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $stats = [
            'products_count' => Product::count(),
            'users_count' => User::count(),
            'reached_accounts' => $this->getReachedAccounts(),
        ];

        // Get latest activities
        $activities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($log) {
                return [
                    'action' => $log->description,
                    'time' => $log->time_ago,
                    'icon' => $log->icon,
                    'user' => $log->user->username ?? 'System',
                ];
            });

        // If no real activities yet, show recent data as fallback
        if ($activities->isEmpty()) {
            $activities = collect([
                ['action' => 'Dashboard diakses', 'time' => 'Baru saja', 'icon' => 'activity', 'user' => auth()->user()->username ?? 'Admin'],
            ]);
        }

        $stats['activities'] = $activities;

        return ApiResponse::success($stats, 'Data statistik berhasil diambil.');
    }

    /**
     * Count unique IPs from sessions table if using 'database' driver,
     * otherwise fall back to Contact count.
     */
    private function getReachedAccounts(): int
    {
        try {
            if (config('session.driver') === 'database' && \Schema::hasTable('sessions')) {
                return DB::table('sessions')
                    ->distinct('ip_address')
                    ->count('ip_address');
            }
        } catch (\Exception $e) {
            // Silence
        }

        // Fallback: count contacts as proxy for reach
        return Contact::count();
    }
}
