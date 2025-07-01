<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reward; // Import model Reward
use App\Models\RedeemTransaction; // Import model RedeemTransaction
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class RedeemController extends Controller
{
    /**
     * Menampilkan katalog hadiah yang tersedia.
     */
    public function index()
    {
        $rewards = Reward::where('stock', '>', 0)->latest()->paginate(10); // Hanya tampilkan hadiah yang stoknya > 0
        return view('users.redeem.index', compact('rewards'));
    }

    /**
     * Memproses penukaran koin oleh user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:rewards,id',
            'quantity' => 'required|integer|min:1', // Validasi untuk kuantitas
            'recipient_name' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:500',
            'delivery_phone_number' => 'required|string|max:20',
        ]);

        $reward = Reward::find($request->reward_id);
        $user = Auth::user();
        $quantity = $request->quantity; // Ambil kuantitas dari request

        $totalKoinRequired = $quantity * $reward->koin_required; // Hitung total koin

        // Cek ketersediaan stok dan koin user
        if (!$reward) {
            return redirect()->back()->with('error', 'Hadiah tidak ditemukan.');
        }
        if ($reward->stock < $quantity) { // Stok harus cukup untuk kuantitas
            return redirect()->back()->with('error', 'Maaf, stok hadiah ini tidak cukup untuk kuantitas yang diminta.');
        }
        if ($user->koin_balance < $totalKoinRequired) { // Koin harus cukup untuk total
            return redirect()->back()->with('error', 'Koin Anda tidak cukup untuk menukarkan hadiah ini dengan kuantitas tersebut.');
        }

        // Gunakan transaksi database untuk memastikan proses atomik
        DB::transaction(function () use ($request, $user, $reward, $quantity, $totalKoinRequired) {
            // Kurangi saldo koin user
            $user->decrement('koin_balance', $totalKoinRequired);

            // Kurangi stok hadiah
            $reward->decrement('stock', $quantity);

            // Catat transaksi penukaran
            RedeemTransaction::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'koin_used' => $totalKoinRequired, // Koin yang digunakan adalah total
                'quantity' => $quantity, // Simpan kuantitas
                'recipient_name' => $request->recipient_name,
                'delivery_address' => $request->delivery_address,
                'delivery_phone_number' => $request->delivery_phone_number,
                'status' => 'sedang_dikirim',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Penukaran koin berhasil! Hadiah Anda akan segera diproses dan dikirim.');
    }
}