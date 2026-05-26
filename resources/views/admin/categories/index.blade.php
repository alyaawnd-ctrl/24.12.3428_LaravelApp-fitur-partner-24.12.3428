@extends('layouts.admin')
@section('title', 'Data Kategori - Admin Panel')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Data Kategori</h1>
</div>

<div class="mb-4">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="px-3 py-1.5 border border-slate-300 rounded outline-none text-sm w-64 focus:border-blue-500">
        <button type="submit" class="px-4 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-1.5 bg-slate-200 text-slate-700 rounded text-sm hover:bg-slate-300 transition flex items-center">Reset</a>
        @endif
    </form>
</div>

<div class="mb-4">
    <button onclick="bukaModalTambah()" class="px-4 py-1.5 bg-emerald-500 text-white rounded text-sm font-medium hover:bg-emerald-600 transition">
        Tambah Kategori
    </button>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 font-bold text-sm border border-green-200">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-rose-100 text-rose-700 p-3 rounded mb-4 font-bold text-sm border border-rose-200">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white border border-slate-200 rounded overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-100 border-b border-slate-200 text-slate-800 text-sm font-bold">
            <tr>
                <th class="px-4 py-3 w-20">ID</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3 w-48">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
            @forelse($categories as $category)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-4 py-3 font-medium">{{ $category->id }}</td>
                
                <td class="px-4 py-3">{{ $category->name }}</td>
                
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <button onclick="bukaModalEdit('{{ $category->id }}', '{{ $category->name }}')" class="px-3 py-1 bg-amber-500 text-white rounded text-xs font-semibold hover:bg-amber-600 transition">
                            Edit
                        </button>
                        
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-rose-500 text-white rounded text-xs font-semibold hover:bg-rose-600 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-4 py-6 text-center text-slate-400 font-bold">Data kategori tidak ditemukan atau kosong.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

---

<div id="modal-tambah-kategori" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-xl p-6 border shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Tambah Kategori Baru</h3>
            <button onclick="tutupModalTambah()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Nama Kategori</label>
                <input type="text" name="name" placeholder="Misal: Entertainment Nasional" class="w-full px-3 py-2 border border-slate-300 rounded text-sm outline-none focus:border-blue-500" required>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="tutupModalTambah()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded text-sm font-medium hover:bg-slate-200">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded text-sm font-medium hover:bg-emerald-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-kategori" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-xl p-6 border shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Edit Nama Kategori</h3>
            <button onclick="tutupModalEdit()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>
        <form id="form-edit-kategori" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Ubah Nama</label>
                <input type="text" id="input-edit-nama" name="name" class="w-full px-3 py-2 border border-slate-300 rounded text-sm outline-none focus:border-blue-500" required>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="tutupModalEdit()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded text-sm font-medium hover:bg-slate-200">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded text-sm font-medium hover:bg-amber-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Tambah
    function bukaModalTambah() {
        const modal = document.getElementById('modal-tambah-kategori');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function tutupModalTambah() {
        const modal = document.getElementById('modal-tambah-kategori');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function bukaModalEdit(id, nama) {
        const modal = document.getElementById('modal-edit-kategori');
        const form = document.getElementById('form-edit-kategori');
        const input = document.getElementById('input-edit-nama');
        
        form.action = `/admin/categories/${id}`;
        input.value = nama;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function tutupModalEdit() {
        const modal = document.getElementById('modal-edit-kategori');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection