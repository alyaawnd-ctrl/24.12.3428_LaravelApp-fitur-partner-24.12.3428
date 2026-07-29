@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin Panel')

@section('content')
<header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Kelola Partner</h1>
        <p class="text-slate-500 font-medium">Atur data partner pendukung platform AmikomEventHub.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2">
        <span>+ Tambah Partner Baru</span>
    </a>
</header>

<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
    <form action="{{ route('admin.partners.index') }}" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama partner atau instansi..." class="flex-1 px-5 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-indigo-500 transition font-medium">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition flex items-center">Reset</a>
        @endif
    </form>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl border border-green-200 mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-rose-100 text-rose-700 p-4 rounded-xl border border-rose-200 mb-6 font-bold">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo Partner</th>
                    <th class="px-8 py-4">Nama Perusahaan / Instansi</th>
                    <th class="px-8 py-4">Tanggal Bergabung</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    
                    <td class="px-8 py-6">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 flex items-center justify-center p-1 shadow-sm">
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-full h-full object-contain">
                        </div>
                    </td>
                    
                    <td class="px-8 py-6 font-black text-slate-800 text-base">
                        {{ $partner->name }}
                    </td>
                    
                    <td class="px-8 py-6 text-slate-500 font-medium">
                        {{ $partner->created_at ? $partner->created_at->format('d M Y') : '-' }}
                    </td>
                    
                    <td class="px-8 py-6">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition text-sm">
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold hover:bg-rose-600 hover:text-white transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold">Data partner tidak ditemukan atau kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection