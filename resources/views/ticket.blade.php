<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $event->title }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }

        /* Optimization for Print / PDF export */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .ticket-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-indigo-600 text-white min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="max-w-md w-full">
        
        <!-- Header / Success Banner (Hidden on Print) -->
        <div class="text-center mb-8 no-print">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white backdrop-blur-sm">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black tracking-tight">Pembayaran Berhasil!</h1>
            <p class="text-indigo-100 mt-2 font-medium">Tiket Anda telah terbit dan siap digunakan.</p>
        </div>

        <!-- Ticket Card -->
        <div class="ticket-card bg-white text-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl relative">
            
            <!-- Header Ticket -->
            <div class="p-8 bg-indigo-50 border-b-4 border-dashed border-indigo-100 text-center relative">
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-2">E-Ticket Resmi</p>
                <h2 class="text-2xl font-black leading-tight text-slate-800">{{ $event->title }}</h2>
                
                <!-- Ticket Cutouts (Notches) -->
                <div class="absolute -left-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full no-print"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full no-print"></div>
            </div>

            <!-- Ticket Body / Info -->
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Nama Pembeli</p>
                        <p class="font-bold text-slate-800 leading-snug">{{ $transaction->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tanggal & Waktu</p>
                        <p class="font-bold text-slate-800 leading-snug">{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Order ID</p>
                        <p class="font-mono font-bold text-slate-800 leading-snug">{{ $transaction->order_id }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Lokasi</p>
                        <p class="font-bold text-slate-800 leading-snug">{{ $event->location }}</p>
                    </div>
                </div>

                <!-- QR Code Box -->
                <div class="bg-slate-50 p-6 rounded-3xl flex flex-col items-center border border-slate-100">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-4">Scan QR untuk Check-in</p>
                    <div class="w-44 h-44 bg-white p-2.5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($transaction->order_id) }}" 
                             alt="QR Code Tiket" 
                             class="w-full h-full object-contain">
                    </div>
                    <p class="mt-4 font-mono font-bold text-slate-700 tracking-wider text-sm">{{ $transaction->ticket_code ?? 'TKT-' . $transaction->order_id }}</p>
                </div>
            </div>

            <!-- Ticket Actions / Buttons -->
            <div class="px-8 pb-8 space-y-3 no-print">
                <button onclick="window.print()" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-[0.99] transition-all duration-200">
                    Cetak / Simpan PDF
                </button>
                <a href="{{ route('home') }}" class="block w-full py-2 text-center text-slate-400 font-bold hover:text-indigo-600 transition">
                    Kembali ke Beranda
                </a>
            </div>

        </div>

        <!-- Footer Notice -->
        <p class="text-center text-xs text-indigo-200 mt-6 no-print">
            Tunjukkan E-Ticket ini kepada petugas di lokasi acara saat *check-in*.
        </p>

    </div>

</body>
</html>