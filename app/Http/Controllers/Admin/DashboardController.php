<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $eventQuery = Event::query();
        $transactionQuery = Transaction::query();
        
        // Jika organizer, filter data hanya untuk event mereka
        if ($user->role === 'organizer') {
            $eventQuery->where('organizer_id', $user->id);
            $transactionQuery->whereHas('event', function($q) use ($user) {
                $q->where('organizer_id', $user->id);
            });
        }

        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->count();

        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = (clone $eventQuery)->where('date', '>=', now())->count();

        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = (clone $transactionQuery)->where('status', 'pending')->count();

        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = (clone $transactionQuery)->with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions'));
    }
}
