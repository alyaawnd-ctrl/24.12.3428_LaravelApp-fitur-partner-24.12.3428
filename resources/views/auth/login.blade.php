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
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-2xl">
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl mb-4 text-white font-bold text-2xl shadow-lg shadow-indigo-500/30">
                AH
            </div>
            <h1 class="text-2xl font-extrabold text-white">Login Admin</h1>
            <p class="text-slate-400 text-sm mt-1">Masuk untuk mengelola sistem AmikomEventHub</p>
        </div>

        <!-- Alert Notification -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-400 text-sm">
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
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                       placeholder="admin@amikom.ac.id">
            </div>

            <!-- Field Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                       placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200 mt-2">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-700/60 pt-6">
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-400 hover:text-indigo-400 transition">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>
