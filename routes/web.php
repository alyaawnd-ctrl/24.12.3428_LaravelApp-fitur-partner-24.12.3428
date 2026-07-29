<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

/*
|--------------------------------------------------------------------------
| Web Routes - AmikomEventHub (UTS Terpadu)
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE USER / PENGUNJUNG UMUM (FRONTEND)
// ==========================================
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [EventController::class, 'ticket'])->name('ticket');

// Rute Halaman Tentang Kami (Penyelenggara)
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Rute Halaman Bantuan / Cara Pesan
Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');


// ==========================================
// RUTE ADMINISTRATOR (BACKEND CRUD)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Login bebas akses
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Mengamankan Route Administrasi di balik tembok (Middleware)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index']);
        
        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('partners', PartnerController::class);
    });

});