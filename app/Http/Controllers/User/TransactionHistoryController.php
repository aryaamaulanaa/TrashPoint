<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class TransactionHistoryController extends Controller
{
    /**
     * Menampilkan riwayat transaksi (setoran dan penukaran) untuk user yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil riwayat setoran sampah milik user yang login
        // Gunakan with('category') untuk eager load relasi Category
        $setoranTransactions = $user->transactions()->with('category')->latest()->paginate(5, ['*'], 'setoranPage');

        // Ambil riwayat penukaran koin milik user yang login
        // Gunakan with('reward') untuk eager load relasi Reward
        $redeemTransactions = $user->redeemTransactions()->with('reward')->latest()->paginate(5, ['*'], 'redeemPage');

        return view('users.transactions.index', compact('setoranTransactions', 'redeemTransactions'));
    }
}