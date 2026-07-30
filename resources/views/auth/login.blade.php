<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
    <body class="bg-slate-50 text-slate-900 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white border border-slate-200 rounded-3xl p-8 shadow-xl">
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#1C3B29] rounded-2xl mb-4 text-white font-bold text-2xl shadow-lg shadow-[#1C3B29]/30">
                AH
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Login</h1>
            <p class="text-slate-500 text-sm mt-1">Masuk untuk mengelola sistem AmikomEventHub</p>
        </div>

        <!-- Alert Notification -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Field Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#1C3B29] focus:ring-1 focus:ring-[#1C3B29] transition"
                       placeholder="admin@amikom.ac.id">
            </div>

            <!-- Field Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#1C3B29] focus:ring-1 focus:ring-[#1C3B29] transition"
                       placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-3.5 px-4 bg-[#1C3B29] hover:bg-[#2a583d] text-white font-bold rounded-xl shadow-lg shadow-[#1C3B29]/30 transition duration-200 mt-2">
                Masuk
            </button>
            
            <div class="relative flex py-4 items-center">
                <div class="flex-grow border-t border-slate-300"></div>
                <span class="shrink-0 px-4 text-slate-400 text-sm">atau login dengan</span>
                <div class="flex-grow border-t border-slate-300"></div>
            </div>
            
            <a href="{{ route('google.login') }}"
                    class="w-full py-3.5 px-4 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl flex items-center justify-center transition duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Continue with Google
            </a>
        </form>

        <div class="mt-8 text-center border-t border-slate-200 pt-6">
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-[#1C3B29] transition">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>
