@extends('admin.layout')
@section('title', 'Users')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Users</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola akun pengguna</p>
            </div>
            <button onclick="openModal()"
                class="bg-gold hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium transition flex items-center gap-2 shadow-lg shadow-gold/20">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah User
            </button>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari user..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
            </div>
            <select id="roleFilter"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Role</option>
                <option value="1">Admin</option>
                <option value="0">Non-Admin</option>
            </select>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px] whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Avatar</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Username
                            </th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Role</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Telepon</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-slate-100">
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="animate-pulse">
                                <td class="px-6 py-4" colspan="6">
                                    <div class="skeleton h-5 rounded w-full"></div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 overflow-y-auto py-8">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah User</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                        class="w-5 h-5"></i></button>
            </div>
            <form id="form" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" id="editId">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username *</label>
                    <input type="text" id="f-username" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                    <input type="email" id="f-email" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" id="lbl-password">Password *</label>
                    <input type="password" id="f-password"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm">
                    <p id="hint-password" class="text-xs text-slate-400 mt-1 hidden">Kosongkan jika tidak ingin mengubah
                        password.</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Admin *</label>
                        <select id="f-is_admin" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none">
                            <option value="0">Tidak</option>
                            <option value="1">Ya (Admin)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
                        <input type="text" id="f-phone"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Avatar</label>
                    <input type="file" id="f-image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-cream file:text-gold hover:file:bg-gold/20">
                    <p class="text-xs text-slate-400 mt-1">Maksimal 5MB (JPG, PNG, WEBP)</p>
                </div>
                <button type="submit"
                    class="w-full bg-gold hover:bg-yellow-600 text-white font-medium py-2.5 rounded-xl transition">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allData = [];
        document.addEventListener('DOMContentLoaded', () => loadData());

        document.getElementById('searchInput').addEventListener('input', debounce(() => loadData(), 300));
        document.getElementById('roleFilter').addEventListener('change', () => loadData());

        document.getElementById('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const fd = new FormData();
            fd.append('username', document.getElementById('f-username').value);
            fd.append('email', document.getElementById('f-email').value);
            fd.append('is_admin', document.getElementById('f-is_admin').value);
            fd.append('no_telephone', document.getElementById('f-phone').value);
            const pw = document.getElementById('f-password').value;
            if (pw) fd.append('password', pw);
            if (!id) fd.append('password_confirmation', pw);
            const img = document.getElementById('f-image').files[0];
            if (img) fd.append('image', img);
            if (id) fd.append('_method', 'PUT');

            try {
                const url = id ? `/users/${id}` : '/users';
                await Api.post(url, fd);
                closeModal(); showToast(id ? 'User berhasil diupdate!' : 'User berhasil ditambahkan!'); loadData();
            } catch (err) {
                const errors = err.response?.errors;
                if (errors) { Object.entries(errors).forEach(([k, v]) => showToast(v[0], 'error')); }
                else showToast(err.response?.message || 'Gagal menyimpan', 'error');
            }
        });

        async function loadData() {
            const search = document.getElementById('searchInput').value;
            const role = document.getElementById('roleFilter').value;
            let url = '/users?';
            if (search) url += `search=${encodeURIComponent(search)}&`;
            if (role !== '') url += `is_admin=${role}&`;
            try {
                const res = await Api.get(url);
                allData = res.data || [];
                renderTable(allData);
            } catch (e) { document.getElementById('tableBody').innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-400">Gagal memuat data.</td></tr>'; }
        }

        function renderTable(items) {
            const tbody = document.getElementById('tableBody');
            if (!items.length) { tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Tidak ada user.</td></tr>'; return; }
            tbody.innerHTML = items.map(u => {
                const avatar = u.image_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(u.username)}&background=FFF4E6&color=D4AF37&size=40`;
                const isAdmin = u.is_admin === true || u.is_admin === 1 || u.is_admin === '1';
                const roleBadge = isAdmin ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600';
                const roleLabel = isAdmin ? 'Admin' : 'User';
                return `
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3"><img src="${avatar}" class="w-10 h-10 rounded-full object-cover border border-slate-100"></td>
                <td class="px-6 py-3 font-medium text-slate-800">${u.username}</td>
                <td class="px-6 py-3 text-slate-500 text-sm">${u.email}</td>
                <td class="px-6 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${roleBadge}">${roleLabel}</span></td>
                <td class="px-6 py-3 text-sm text-slate-500">${u.no_telephone || '-'}</td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button onclick='editItem(${JSON.stringify(u)})' class="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                        <button onclick="deleteItem(${u.id}, '${u.username.replace(/'/g, "\\'")}')" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </td>
            </tr>`;
            }).join('');
            lucide.createIcons();
        }

        function openModal(data = null) {
            document.getElementById('editId').value = data?.id || '';
            document.getElementById('f-username').value = data?.username || '';
            document.getElementById('f-email').value = data?.email || '';
            document.getElementById('f-is_admin').value = (data?.is_admin === true || data?.is_admin === 1 || data?.is_admin === '1') ? '1' : '0';
            document.getElementById('f-phone').value = data?.no_telephone || '';
            document.getElementById('f-password').value = '';
            document.getElementById('f-image').value = '';
            const isEdit = !!data;
            document.getElementById('f-password').required = !isEdit;
            document.getElementById('lbl-password').textContent = isEdit ? 'Password (Opsional)' : 'Password *';
            document.getElementById('hint-password').classList.toggle('hidden', !isEdit);
            document.getElementById('modalTitle').textContent = isEdit ? 'Edit User' : 'Tambah User';
            document.getElementById('modal').classList.remove('hidden'); document.getElementById('modal').classList.add('flex');
            lucide.createIcons();
        }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex'); }
        function editItem(u) { openModal(u); }
        function deleteItem(id, name) {
            confirmDelete(name, async () => {
                try { await Api.delete(`/users/${id}`); showToast('User berhasil dihapus!'); loadData(); }
                catch (err) { showToast(err.response?.message || 'Gagal menghapus', 'error'); }
            });
        }
        function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }
    </script>
@endpush