@extends('admin.layout')
@section('title', 'Categories')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Categories</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola kategori produk gitar</p>
            </div>
            <button onclick="openModal()"
                class="bg-gold hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium transition flex items-center gap-2 shadow-lg shadow-gold/20">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
            </button>
        </div>

        <!-- Search -->
        <div class="relative w-full sm:w-80">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" id="searchInput" placeholder="Cari kategori..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px] whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Slug</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-slate-100">
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="animate-pulse">
                                <td class="px-6 py-4" colspan="4">
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
    <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Kategori</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                        class="w-5 h-5"></i></button>
            </div>
            <form id="form" class="space-y-4">
                <input type="hidden" id="editId">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" id="name" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm transition">
                    <p id="err-name" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea id="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm transition resize-none"></textarea>
                </div>
                <button type="submit" id="submitBtn"
                    class="w-full bg-gold hover:bg-yellow-600 text-white font-medium py-2.5 rounded-xl transition">
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allData = [];

        document.addEventListener('DOMContentLoaded', () => { loadData(); });
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase();
            renderTable(allData.filter(c => c.name.toLowerCase().includes(q)));
        });
        document.getElementById('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const body = { name: document.getElementById('name').value, description: document.getElementById('description').value };
            document.getElementById('err-name').classList.add('hidden');
            try {
                if (id) { await Api.put(`/categories/${id}`, body); }
                else { await Api.post('/categories', body); }
                closeModal();
                showToast(id ? 'Kategori berhasil diupdate!' : 'Kategori berhasil ditambahkan!');
                loadData();
            } catch (err) {
                if (err.response?.errors?.name) {
                    document.getElementById('err-name').textContent = err.response.errors.name[0];
                    document.getElementById('err-name').classList.remove('hidden');
                } else {
                    showToast(err.response?.message || 'Terjadi kesalahan', 'error');
                }
            }
        });

        async function loadData() {
            try {
                const res = await Api.get('/categories');
                allData = res.data || [];
                renderTable(allData);
            } catch (e) { document.getElementById('tableBody').innerHTML = '<tr><td colspan="4" class="px-6 py-8 text-center text-red-400">Gagal memuat data.</td></tr>'; }
        }

        function renderTable(items) {
            const tbody = document.getElementById('tableBody');
            if (!items.length) { tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">Tidak ada data.</td></tr>'; return; }
            tbody.innerHTML = items.map(c => `
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-medium text-slate-800">${c.name}</td>
                <td class="px-6 py-4 text-slate-500 text-sm">${c.slug}</td>
                <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600">${c.products_count ?? 0}</span></td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button onclick='editItem(${JSON.stringify(c)})' class="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Edit"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                        <button onclick="deleteItem(${c.id}, '${c.name}')" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </td>
            </tr>
        `).join('');
            lucide.createIcons();
        }

        function openModal(data = null) {
            document.getElementById('editId').value = data?.id || '';
            document.getElementById('name').value = data?.name || '';
            document.getElementById('description').value = data?.description || '';
            document.getElementById('modalTitle').textContent = data ? 'Edit Kategori' : 'Tambah Kategori';
            document.getElementById('err-name').classList.add('hidden');
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex'); }
        function editItem(c) { openModal(c); }
        function deleteItem(id, name) {
            confirmDelete(name, async () => {
                try {
                    await Api.delete(`/categories/${id}`);
                    showToast('Kategori berhasil dihapus!');
                    loadData();
                } catch (err) { showToast(err.response?.message || 'Gagal menghapus', 'error'); }
            });
        }
    </script>
@endpush