@extends('admin.layout')
@section('title', 'Banners')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Banners</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola banner tampilan website</p>
            </div>
            <button onclick="openModal()"
                class="bg-gold hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium transition flex items-center gap-2 shadow-lg shadow-gold/20">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Banner
            </button>
        </div>

        <div class="relative w-full sm:w-80">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" id="searchInput" placeholder="Cari banner..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Gambar</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Link</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-slate-100">
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="animate-pulse">
                                <td class="px-6 py-4" colspan="5">
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
                <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Banner</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                        class="w-5 h-5"></i></button>
            </div>
            <form id="form" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" id="editId">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label>
                    <input type="text" id="f-title" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Link (URL)</label>
                    <input type="text" id="f-link"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm"
                        placeholder="/products">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
                    <input type="file" id="f-image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-cream file:text-gold hover:file:bg-gold/20">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="f-active" checked
                        class="w-4 h-4 text-gold border-slate-300 rounded focus:ring-gold">
                    <label for="f-active" class="text-sm text-slate-700">Aktif</label>
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
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase();
            renderTable(allData.filter(b => b.title.toLowerCase().includes(q)));
        });
        document.getElementById('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const fd = new FormData();
            fd.append('title', document.getElementById('f-title').value);
            fd.append('link', document.getElementById('f-link').value);
            fd.append('is_active', document.getElementById('f-active').checked ? 1 : 0);
            const img = document.getElementById('f-image').files[0];
            if (img) fd.append('image', img);
            if (id) fd.append('_method', 'PUT');

            try {
                const url = id ? `/banners/${id}` : '/banners';
                await Api.post(url, fd);
                closeModal(); showToast(id ? 'Banner berhasil diupdate!' : 'Banner berhasil ditambahkan!'); loadData();
            } catch (err) { showToast(err.response?.message || 'Gagal menyimpan', 'error'); }
        });

        async function loadData() {
            try { const res = await Api.get('/banners'); allData = res.data || []; renderTable(allData); }
            catch (e) { document.getElementById('tableBody').innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-red-400">Gagal memuat data.</td></tr>'; }
        }

        function renderTable(items) {
            const tbody = document.getElementById('tableBody');
            if (!items.length) { tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">Tidak ada banner.</td></tr>'; return; }
            tbody.innerHTML = items.map(b => {
                const img = b.image ? (b.image.startsWith('http') ? b.image : `/storage/${b.image}`) : 'https://placehold.co/120x60?text=No+Img';
                return `
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3"><img src="${img}" class="w-24 h-12 rounded-xl object-cover border border-slate-100"></td>
                <td class="px-6 py-3 font-medium text-slate-800">${b.title}</td>
                <td class="px-6 py-3 text-sm text-slate-500">${b.link || '-'}</td>
                <td class="px-6 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${b.is_active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500'}">${b.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button onclick='editItem(${JSON.stringify(b)})' class="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                        <button onclick="deleteItem(${b.id}, '${b.title.replace(/'/g, "\\'")}')" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </td>
            </tr>`;
            }).join('');
            lucide.createIcons();
        }

        function openModal(data = null) {
            document.getElementById('editId').value = data?.id || '';
            document.getElementById('f-title').value = data?.title || '';
            document.getElementById('f-link').value = data?.link || '';
            document.getElementById('f-active').checked = data?.is_active ?? true;
            document.getElementById('f-image').value = '';
            document.getElementById('modalTitle').textContent = data ? 'Edit Banner' : 'Tambah Banner';
            document.getElementById('modal').classList.remove('hidden'); document.getElementById('modal').classList.add('flex');
            lucide.createIcons();
        }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex'); }
        function editItem(b) { openModal(b); }
        function deleteItem(id, name) {
            confirmDelete(name, async () => {
                try { await Api.delete(`/banners/${id}`); showToast('Banner berhasil dihapus!'); loadData(); }
                catch (err) { showToast(err.response?.message || 'Gagal menghapus', 'error'); }
            });
        }
    </script>
@endpush