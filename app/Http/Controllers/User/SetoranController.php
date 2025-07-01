<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category; // Import model Category
use App\Models\Transaction; // Import model Transaction (setoran sampah)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class SetoranController extends Controller
{
    /**
     * Menampilkan form untuk mengajukan setoran sampah.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(); // Ambil semua kategori sampah dari DB
        // Pastikan path view ini benar: 'users.setoran.create'
        return view('users.setoran.create', compact('categories'));
    }

    /**
     * Menyimpan pengajuan setoran sampah dari user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Kategori harus ada di tabel categories
            'estimated_weight_kg' => 'required|numeric|min:0.1', // Minimal 0.1 kg
            'pickup_address' => 'required|string|max:500',
            'pickup_phone_number' => 'required|string|max:20', // Sesuaikan validasi nomor telepon
        ]);

        // Buat transaksi baru
        Transaction::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'category_id' => $request->category_id,
            'estimated_weight_kg' => $request->estimated_weight_kg,
            'pickup_address' => $request->pickup_address,
            'pickup_phone_number' => $request->pickup_phone_number,
            'status' => 'pending', // Status awal selalu 'pending'
            // actual_weight_kg dan koin_earned akan diisi oleh admin nanti
        ]);
        return redirect()->route('dashboard')->with('success', 'Permintaan setoran sampah Anda berhasil diajukan! Menunggu verifikasi Admin.');
    }
}