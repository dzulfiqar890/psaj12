@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Products -->
        <div class="card-hover bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cream flex items-center justify-center text-gold">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <div>
                    <div id="stat-products" class="text-3xl font-bold text-slate-800">
                        <div class="skeleton h-8 w-16 rounded-lg"></div>
                    </div>
                    <p class="text-sm text-slate-500 mt-0.5">Products</p>
                </div>
            </div>
        </div>

        <!-- Akun Terjangkau -->
        <div class="card-hover bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-gold">
                    <i data-lucide="globe" class="w-6 h-6"></i>
                </div>
                <div>
                    <div id="stat-reach" class="text-3xl font-bold text-slate-800">
                        <div class="skeleton h-8 w-16 rounded-lg"></div>
                    </div>
                    <p class="text-sm text-slate-500 mt-0.5">Akun Terjangkau</p>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="card-hover bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-gold">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <div id="stat-users" class="text-3xl font-bold text-slate-800">
                        <div class="skeleton h-8 w-16 rounded-lg"></div>
                    </div>
                    <p class="text-sm text-slate-500 mt-0.5">Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Admin -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
            <i data-lucide="activity" class="w-5 h-5 text-gold"></i> Aktivitas Admin
        </h2>
        <div id="activity-list" class="space-y-1">
            <!-- Skeleton -->
            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-4 p-3 animate-pulse">
                    <div class="w-10 h-10 rounded-xl skeleton flex-shrink-0"></div>
                    <div class="flex-1 space-y-2">
                        <div class="skeleton h-4 rounded w-3/4"></div>
                        <div class="skeleton h-3 rounded w-1/4"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const result = await Api.get('/stats');
                if (result && result.success) {
                    const d = result.data;
                    animateCounter('stat-products', d.products_count);
                    animateCounter('stat-reach', d.reached_accounts);
                    animateCounter('stat-users', d.users_count);
                    renderActivities(d.activities);
                }
            } catch (e) {
                console.error(e);
                ['stat-products', 'stat-reach', 'stat-users'].forEach(id => {
                    document.getElementById(id).innerHTML = '<span class="text-slate-400">—</span>';
                });
            }

            function animateCounter(id, target) {
                const el = document.getElementById(id);
                el.innerHTML = '0';
                let current = 0;
                const step = Math.max(1, Math.ceil(target / 40));
                const interval = setInterval(() => {
                    current += step;
                    if (current >= target) { current = target; clearInterval(interval); }
                    el.textContent = current;
                }, 30);
            }

            function renderActivities(items) {
                const container = document.getElementById('activity-list');
                container.innerHTML = '';
                if (!items || items.length === 0) {
                    container.innerHTML = '<p class="text-slate-400 text-sm py-4 text-center">Belum ada aktivitas.</p>';
                    return;
                }
                items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition group';
                    div.innerHTML = `
                        <div class="w-10 h-10 rounded-xl bg-cream flex items-center justify-center text-gold flex-shrink-0 group-hover:scale-105 transition-transform">
                            <i data-lucide="${item.icon || 'activity'}" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-slate-700 truncate">${item.action}</p>
                            <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> ${item.time}</p>
                        </div>
                    `;
                    container.appendChild(div);
                });
                lucide.createIcons();
            }
        });
    </script>
@endpush