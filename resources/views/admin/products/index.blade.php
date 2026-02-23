@extends('admin.layout')
@section('title', 'Products')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Products</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola produk gitar</p>
            </div>
            <button onclick="openModal()"
                class="bg-gold hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium transition flex items-center gap-2 shadow-lg shadow-gold/20">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Produk
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
            </div>
            <select id="categoryFilter"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Kategori</option>
            </select>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px] whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Gambar</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Nama Produk
                            </th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Kategori
                            </th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Stok</th>
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
            <div id="pagination"
                class="p-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-500"></div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 overflow-y-auto py-8">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Produk</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                        class="w-5 h-5"></i></button>
            </div>
            <form id="form" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" id="editId">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk *</label>
                    <input type="text" id="f-name" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none text-sm">
                    <p id="err-name" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori *</label>
                        <select id="f-category" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none"></select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                        <input type="number" id="f-stock" value="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp) *</label>
                    <input type="number" id="f-price" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea id="f-desc" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
                    <input type="file" id="f-image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-cream file:text-gold hover:file:bg-gold/20">
                </div>
                <button type="submit"
                    class="w-full bg-gold hover:bg-yellow-600 text-white font-medium py-2.5 rounded-xl transition">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allData = [], categories = [], currentPage = 1;

        document.addEventListener('DOMContentLoaded', () => { loadCategories(); loadData(); });

        document.getElementById('searchInput').addEventListener('input', debounce(() => { currentPage = 1; loadData(); }, 300));
        document.getElementById('categoryFilter').addEventListener('change', () => { currentPage = 1; loadData(); });

        document.getElementById('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const fd = new FormData();
            fd.append('name', document.getElementById('f-name').value);
            fd.append('category_id', document.getElementById('f-category').value);
            fd.append('price', document.getElementById('f-price').value);
            fd.append('stock', document.getElementById('f-stock').value || 0);
            fd.append('description', document.getElementById('f-desc').value);
            const img = document.getElementById('f-image').files[0];
            if (img) fd.append('image', img);

            if (id) fd.append('_method', 'PUT');

            try {
                const url = id ? `/products/${id}` : '/products';
                await Api.post(url, fd);
                closeModal(); showToast(id ? 'Produk berhasil diupdate!' : 'Produk berhasil ditambahkan!'); loadData();
            } catch (err) {
                const errors = err.response?.errors;
                if (errors) { Object.entries(errors).forEach(([k, v]) => showToast(v[0], 'error')); }
                else showToast(err.response?.message || 'Gagal menyimpan', 'error');
            }
        });

        async function loadCategories() {
            try {
                const res = await Api.get('/categories');
                categories = res.data || [];
                const sel = document.getElementById('categoryFilter');
                const formSel = document.getElementById('f-category');
                categories.forEach(c => {
                    sel.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                    formSel.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                });
            } catch (e) { }
        }

        async function loadData() {
            const search = document.getElementById('searchInput').value;
            const catId = document.getElementById('categoryFilter').value;
            let url = `/products?page=${currentPage}`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (catId) url += `&category_id=${catId}`;
            try {
                const res = await Api.get(url);
                allData = res.data || [];
                renderTable(allData);
                renderPagination(res.pagination);
            } catch (e) { document.getElementById('tableBody').innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-400">Gagal memuat data.</td></tr>'; }
        }

        function renderTable(items) {
            const tbody = document.getElementById('tableBody');
            if (!items.length) { tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Tidak ada produk.</td></tr>'; return; }
            tbody.innerHTML = items.map(p => {
                const img = p.image ? (p.image.startsWith('http') ? p.image : `/storage/${p.image}`) : 'https://placehold.co/80?text=No+Img';
                const catName = p.category?.name || 'Uncategorized';
                return `
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3"><img src="${img}" class="w-12 h-12 rounded-xl object-cover border border-slate-100"></td>
                <td class="px-6 py-3"><div class="font-medium text-slate-800">${p.name}</div><div class="text-xs text-slate-400">${p.slug}</div></td>
                <td class="px-6 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">${catName}</span></td>
                <td class="px-6 py-3 font-medium text-slate-700">${formatRupiah(p.price)}</td>
                <td class="px-6 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${p.stock > 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'}">${p.stock}</span></td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button onclick='editItem(${JSON.stringify(p).replace(/'/g, "&#39;")})' class="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                        <button onclick="deleteItem('${p.slug}', '${p.name.replace(/'/g, "\\'")}')" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </td>
            </tr>`;
            }).join('');
            lucide.createIcons();
        }

        function renderPagination(pg) {
            if (!pg) return;
            document.getElementById('pagination').innerHTML = `
            <span>Menampilkan ${pg.from || 0}–${pg.to || 0} dari ${pg.total} data</span>
            <div class="flex gap-2">
                <button onclick="goPage(${pg.current_page - 1})" ${pg.current_page <= 1 ? 'disabled' : ''} class="px-3 py-1 rounded-lg border text-sm disabled:opacity-40 hover:bg-slate-50 transition">Prev</button>
                <button onclick="goPage(${pg.current_page + 1})" ${pg.current_page >= pg.last_page ? 'disabled' : ''} class="px-3 py-1 rounded-lg border text-sm disabled:opacity-40 hover:bg-slate-50 transition">Next</button>
            </div>`;
        }
        function goPage(p) { currentPage = p; loadData(); }

        function openModal(data = null) {
            document.getElementById('editId').value = data?.slug || '';
            document.getElementById('f-name').value = data?.name || '';
            document.getElementById('f-price').value = data?.price || '';
            document.getElementById('f-stock').value = data?.stock ?? 0;
            document.getElementById('f-desc').value = data?.description || '';
            document.getElementById('f-image').value = '';
            if (data?.category_id) document.getElementById('f-category').value = data.category_id;
            document.getElementById('modalTitle').textContent = data ? 'Edit Produk' : 'Tambah Produk';
            document.getElementById('modal').classList.remove('hidden'); document.getElementById('modal').classList.add('flex');
            lucide.createIcons();
        }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex'); }
        function editItem(p) { openModal(p); }
        function deleteItem(slug, name) {
            confirmDelete(name, async () => {
                try { await Api.delete(`/products/${slug}`); showToast('Produk berhasil dihapus!'); loadData(); }
                catch (err) { showToast(err.response?.message || 'Gagal menghapus', 'error'); }
            });
        }
        function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }
    </script>
@endpush