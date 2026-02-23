@extends('admin.layout')
@section('title', 'Contacts')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Contacts</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola pesan masuk dari pelanggan</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari pesan..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
            </div>
            <select id="statusFilter"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="read">Dibaca</option>
                <option value="replied">Dibalas</option>
            </select>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px] whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Pengirim
                            </th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Pesan</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs uppercase text-slate-500 font-semibold tracking-wider">Tanggal</th>
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

    <!-- Detail Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Detail Pesan</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                        class="w-5 h-5"></i></button>
            </div>
            <div id="detailContent" class="space-y-4">
                <div><span class="text-xs text-slate-500 uppercase">Pengirim</span>
                    <p id="d-sender" class="font-medium text-slate-800"></p>
                </div>
                <div><span class="text-xs text-slate-500 uppercase">Subject</span>
                    <p id="d-subject" class="font-medium text-slate-800"></p>
                </div>
                <div><span class="text-xs text-slate-500 uppercase">Pesan</span>
                    <p id="d-message" class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap"></p>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <span class="text-xs text-slate-500 uppercase">Status:</span>
                    <select id="d-status"
                        class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-gold/20 outline-none">
                        <option value="pending">Pending</option>
                        <option value="read">Dibaca</option>
                        <option value="replied">Dibalas</option>
                    </select>
                    <button onclick="updateStatus()"
                        class="bg-gold hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allData = [], currentContact = null;
        document.addEventListener('DOMContentLoaded', () => loadData());
        document.getElementById('searchInput').addEventListener('input', (e) => filterAndRender());
        document.getElementById('statusFilter').addEventListener('change', () => filterAndRender());

        function filterAndRender() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const st = document.getElementById('statusFilter').value;
            let filtered = allData;
            if (q) filtered = filtered.filter(c => (c.subject || '').toLowerCase().includes(q) || (c.message || '').toLowerCase().includes(q) || (c.user?.username || '').toLowerCase().includes(q));
            if (st) filtered = filtered.filter(c => c.status === st);
            renderTable(filtered);
        }

        async function loadData() {
            try { const res = await Api.get('/contacts'); allData = res.data || []; renderTable(allData); }
            catch (e) { document.getElementById('tableBody').innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-400">Gagal memuat data.</td></tr>'; }
        }

        function statusBadge(s) {
            const map = { pending: 'bg-yellow-50 text-yellow-600', read: 'bg-blue-50 text-blue-600', replied: 'bg-green-50 text-green-600' };
            return `<span class="px-2.5 py-1 rounded-full text-xs font-semibold ${map[s] || 'bg-slate-100 text-slate-500'}">${s}</span>`;
        }

        function renderTable(items) {
            const tbody = document.getElementById('tableBody');
            if (!items.length) { tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Tidak ada pesan.</td></tr>'; return; }
            tbody.innerHTML = items.map(c => `
            <tr class="hover:bg-slate-50 transition-colors ${c.status === 'pending' ? 'font-medium' : ''}">
                <td class="px-6 py-4 text-slate-800">${c.user?.username || 'Guest'}</td>
                <td class="px-6 py-4 text-slate-700">${c.subject}</td>
                <td class="px-6 py-4 text-slate-500 text-sm max-w-[200px] truncate">${c.message}</td>
                <td class="px-6 py-4">${statusBadge(c.status)}</td>
                <td class="px-6 py-4 text-sm text-slate-400">${new Date(c.created_at).toLocaleDateString('id-ID')}</td>
                <td class="px-6 py-4 text-right">
                    <button onclick='viewContact(${JSON.stringify(c)})' class="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition"><i data-lucide="eye" class="w-4 h-4"></i></button>
                </td>
            </tr>
        `).join('');
            lucide.createIcons();
        }

        function viewContact(c) {
            currentContact = c;
            document.getElementById('d-sender').textContent = c.user?.username || 'Guest';
            document.getElementById('d-subject').textContent = c.subject;
            document.getElementById('d-message').textContent = c.message;
            document.getElementById('d-status').value = c.status;
            document.getElementById('modal').classList.remove('hidden'); document.getElementById('modal').classList.add('flex');
            lucide.createIcons();
        }

        async function updateStatus() {
            if (!currentContact) return;
            try {
                await Api.put(`/contacts/${currentContact.id}`, { status: document.getElementById('d-status').value });
                showToast('Status pesan berhasil diupdate!'); closeModal(); loadData();
            } catch (err) { showToast(err.response?.message || 'Gagal update status', 'error'); }
        }

        function closeModal() { document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex'); }
    </script>
@endpush