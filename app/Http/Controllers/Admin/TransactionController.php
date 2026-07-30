<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $query = Transaction::with('event')->latest();
        
        if ($user->role === 'organizer') {
            $query->whereHas('event', function($q) use ($user) {
                $q->where('organizer_id', $user->id);
            });
        }
        
        $transactions = $query->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }
}