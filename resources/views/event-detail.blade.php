@extends('layouts.app')
@section('title', $event->title . ' - AmikomEventHub')

@section('content')
    @php
        $catName = strtolower($event->category->name ?? '');
        if (str_contains($catName, 'teknologi') || str_contains($catName, 'coding')) {
            $defaultImg = asset('assets/hackathon.png');
        } elseif (str_contains($catName, 'workshop') || str_contains($catName, 'seminar')) {
            $defaultImg = asset('assets/workshop.png');
        } else {
            $defaultImg = asset('assets/concert.png');
        }
        $imgSrc = ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path))
            ? asset('storage/' . $event->poster_path)
            : $defaultImg;
    @endphp

    <main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Poster -->
        <div class="lg:col-span-1">
            <div class="sticky top-32">
                <img src="{{ $imgSrc }}" alt="{{ $event->title }}"
                    class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
                <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            AH</div>
                        <div>
                            <p class="font-bold text-slate-800">AmikomEventHub Organizer</p>
                            <p class="text-xs text-slate-500">Verified Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Details -->
        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                <span
                    class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name ?? 'Uncategorized' }}</span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            <div
                class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                        <h2 class="text-5xl font-black">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            @if($event->price > 0)
                                <span class="text-lg font-medium text-indigo-200">/ orang</span>
                            @endif
                        </h2>
                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
                        <a href="{{ url('checkout/' . $event->id) }}"
                            class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>
        </div>

        <!-- Ulasan Section -->
        <div class="lg:col-span-3 mt-12">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100">
                <h3 class="text-3xl font-black mb-8 text-slate-800">Ulasan Pengunjung</h3>
                
                @auth
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reviews.store') }}" method="POST" class="mb-12 bg-slate-50 p-6 rounded-3xl border border-slate-200">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <h4 class="font-bold mb-4">Berikan Ulasan Anda</h4>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Rating</label>
                            <select name="rating" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5) Sangat Bagus</option>
                                <option value="4">⭐⭐⭐⭐ (4/5) Bagus</option>
                                <option value="3">⭐⭐⭐ (3/5) Cukup</option>
                                <option value="2">⭐⭐ (2/5) Kurang</option>
                                <option value="1">⭐ (1/5) Sangat Kurang</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Komentar</label>
                            <textarea name="comment" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Tulis pengalaman Anda mengenai acara ini..."></textarea>
                        </div>
                        
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">Kirim Ulasan</button>
                    </form>
                @else
                    <div class="mb-12 bg-indigo-50 p-6 rounded-3xl border border-indigo-100 text-center">
                        <p class="text-indigo-600 font-medium">Silakan <a href="{{ route('admin.login') }}" class="font-bold underline">Login</a> untuk memberikan ulasan.</p>
                    </div>
                @endauth

                <div class="space-y-6">
                    @forelse($reviews as $review)
                        <div class="p-6 border border-slate-100 rounded-3xl flex gap-4">
                            <div class="w-12 h-12 bg-slate-200 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-slate-500 uppercase">
                                {{ substr($review->user->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h5 class="font-bold text-lg">{{ $review->user->name }}</h5>
                                    <span class="text-xs text-slate-400">• {{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-yellow-400 text-sm mb-2">
                                    {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                                </div>
                                @if($review->comment)
                                    <p class="text-slate-600">{{ $review->comment }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-center py-8">Belum ada ulasan untuk acara ini. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
