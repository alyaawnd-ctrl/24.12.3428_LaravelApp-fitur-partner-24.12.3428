<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;

class EventController extends Controller
{
    /**
     * Menampilkan halaman utama dengan Filter Kategori & Data Partner (SOAL 4)
     */
    public function index(Request $request)
    {
        // 1. Ambil data kategori untuk filter
        $categories = Category::all();

        // 2. Ambil data partner untuk Soal 4 UTS
        $partners = Partner::latest()->get();

        // 3. Kueri data event
        $query = Event::with('category')->where('date', '>', now())->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();

        // 4. Kirim semua variabel ke view 'welcome'
        return view('welcome', compact('events', 'categories', 'partners'));
    }

    public function show(Event $event)
    {
        $categories = Category::all();
        return view('event-detail', compact('categories', 'event'));
    }

    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    public function ticket(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $orderId = 'TRX-' . rand(10000, 99999);

        // Objek transaksi dummy untuk data di tiket
        $transaction = (object) [
            'customer_name' => $request->input('name', 'John Doe'),
            'order_id'      => $orderId,
            'ticket_code'   => 'TKT-' . rand(100000, 999999)
        ];

        return view('ticket', compact('event', 'orderId', 'transaction'));
    }
}