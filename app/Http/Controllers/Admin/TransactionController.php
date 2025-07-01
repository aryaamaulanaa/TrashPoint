<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import model User
use App\Models\Transaction; // Import model Transaction (setoran sampah)
use App\Models\RedeemTransaction; // Import model RedeemTransaction (penukaran koin)
use App\Models\Category; // Import model Category (untuk relasi di Transaction)
use App\Models\Reward; // Import model Reward (untuk relasi di RedeemTransaction)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Illuminate\Support\Carbon; // Import Carbon untuk manipulasi tanggal/waktu

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar pengguna untuk memilih riwayat transaksi.
     */
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(10); // Hanya pengguna biasa
        return view('admin.transactions.index', compact('users'));
    }

    /**
     * Menampilkan riwayat transaksi (setoran dan penukaran) untuk pengguna tertentu.
     */
    public function userTransactions(User $user)
    {
        // Pastikan user yang dilihat adalah role 'user'
        if ($user->role !== 'user') {
            abort(404);
        }

        $setoranTransactions = $user->transactions()->with('category')->latest()->get(); // Relasi ke Category
        $redeemTransactions = $user->redeemTransactions()->with('reward')->latest()->get(); // Relasi ke Reward

        return view('admin.transactions.user_transactions', compact('user', 'setoranTransactions', 'redeemTransactions'));
    }

    /**
     * Mengupdate status transaksi setoran sampah.
     */
    public function updateSetoranStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,dijemput,selesai,dibatalkan',
            'admin_notes' => 'nullable|string|max:1000',
            'actual_weight_kg' => 'nullable|numeric|min:0', // Jika status 'selesai'
        ]);

        DB::transaction(function () use ($request, $transaction) {
            $oldStatus = $transaction->status; // Simpan status lama
            // Jika status diubah menjadi 'selesai'
            if ($request->status === 'selesai' && $oldStatus !== 'selesai') {
                // Validasi berat aktual harus ada jika statusnya 'selesai'
                if (is_null($request->actual_weight_kg)) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'actual_weight_kg' => 'Berat aktual harus diisi jika status Selesai.',
                    ]);
                }

                $koinEarned = $request->actual_weight_kg * ($transaction->category->koin_per_kg ?? 0); // Handle jika category tidak ditemukan

                // Tambahkan koin ke saldo user
                $transaction->user->increment('koin_balance', $koinEarned);

                // Update data transaksi
                $transaction->update([
                    'actual_weight_kg' => $request->actual_weight_kg,
                    'koin_earned' => $koinEarned,
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                ]);

            } elseif ($request->status === 'dibatalkan' && $oldStatus === 'selesai') {
                // Jika sebelumnya sudah 'selesai' dan sekarang dibatalkan, kurangi koin
                if ($transaction->koin_earned > 0) {
                    $transaction->user->decrement('koin_balance', $transaction->koin_earned);
                }
                $transaction->update([
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                    'koin_earned' => 0, // Koin yang diperoleh jadi 0
                    'actual_weight_kg' => 0, // Berat aktual juga jadi 0 atau null
                ]);
            } else {
                // Untuk status selain 'selesai' atau 'dibatalkan' dari 'selesai'
                $transaction->update([
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                    // Koin_earned dan actual_weight_kg tidak diubah kecuali status selesai atau dibatalkan dari selesai
                ]);
            }
        });

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Status setoran sampah berhasil diperbarui.');
    }


    /**
     * Mengupdate status transaksi penukaran koin.
     */
    public function updateRedeemStatus(Request $request, RedeemTransaction $redeemTransaction)
    {
        $request->validate([
            'status' => 'required|in:sedang_dikirim,selesai',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Tidak ada perubahan saldo koin di sini karena koin sudah dipotong saat user menukar
        $redeemTransaction->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Status penukaran koin berhasil diperbarui.');
    }

    // Method listSetoran yang sudah ada (mungkin tidak terlalu terpakai lagi setelah ada allHistory)
    public function listSetoran()
    {
        $setoranList = Transaction::with(['user', 'category'])
            ->latest()
            ->paginate(20);
        return view('admin.transactions.list_setoran', compact('setoranList'));
    }

    // BARU: Method untuk menampilkan halaman detail SETORAN sampah
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'category']); // Eager load relasi
        return view('admin.transactions.show', compact('transaction')); // Buat view ini jika belum ada
    }

    // BARU: Method untuk menampilkan halaman edit SETORAN sampah
    public function edit(Transaction $transaction)
    {
        $transaction->load(['user', 'category']); // Eager load relasi
        $categories = Category::all(); // Perlu daftar kategori untuk dropdown jika edit kategori juga
        return view('admin.transactions.edit', compact('transaction', 'categories')); // Buat view ini jika belum ada
    }

    // BARU: Method untuk menampilkan halaman detail PENUKARAN koin
    public function showRedeem(RedeemTransaction $redeemTransaction)
    {
        $redeemTransaction->load(['user', 'reward']); // Eager load relasi
        return view('admin.redeem.show', compact('redeemTransaction')); // Buat view ini jika belum ada
    }

    // BARU: Method untuk menampilkan halaman edit PENUKARAN koin
    public function editRedeem(RedeemTransaction $redeemTransaction)
    {
        $redeemTransaction->load(['user', 'reward']); // Eager load relasi
        $rewards = Reward::all(); // Perlu daftar reward untuk dropdown jika edit reward juga
        return view('admin.redeem.edit', compact('redeemTransaction', 'rewards')); // Buat view ini jika belum ada
    }


    /**
     * BARU: Menampilkan semua riwayat transaksi (setoran & penukaran) untuk admin.
     * Difilter hanya 3 hari terakhir dan memungkinkan update status langsung.
     */
    public function allHistory()
    {
        // Hitung tanggal 3 hari yang lalu dari sekarang
        // $threeDaysAgo = Carbon::now()->subDays(3);

        // Ambil setoran sampah dari 3 hari terakhir
        // $recentSetoran = Transaction::with(['user', 'category'])
            // ->where('created_at', '>=', $threeDaysAgo)
            // ->orderBy('created_at', 'desc')
            // ->get();

        // Ambil penukaran koin dari 3 hari terakhir
        // $recentRedeem = RedeemTransaction::with(['user', 'reward'])
            // ->where('created_at', '>=', $threeDaysAgo)
            // ->orderBy('created_at', 'desc')
            // ->get();

        // Gabungkan kedua koleksi transaksi dan format datanya untuk tampilan di tabel
        // $allActivities = collect([]);

        // foreach ($recentSetoran as $setoran) {
            // $allActivities->push([
                // 'id' => $setoran->id,
                // 'type' => 'setoran',
                // 'user_id' => $setoran->user_id,
                // 'user_name' => $setoran->user->name ?? 'User Tidak Dikenal',
                // 'description' => number_format($setoran->estimated_weight_kg, 2) . ' kg ' . ($setoran->category->name ?? 'Sampah Tidak Dikenal'),
                // 'status' => $setoran->status,
                // 'created_at' => $setoran->created_at,
                // Rute untuk update status langsung dari tabel (akan pakai form di Blade)
        //         'update_link' => route('admin.transactions.setoran.updateStatus', $setoran->id),
        //         'status_options' => ['pending', 'dijemput', 'selesai', 'dibatalkan'], // Opsi status untuk dropdown
        //         'actual_weight_kg' => $setoran->actual_weight_kg, // Tambahkan ini agar bisa di-prefill
        //     ]);
        // }

        // foreach ($recentRedeem as $redeem) {
        //     $allActivities->push([
        //         'id' => $redeem->id,
        //         'type' => 'tukar_koin',
        //         'user_id' => $redeem->user_id,
        //         'user_name' => $redeem->user->name ?? 'User Tidak Dikenal',
        //         'description' => number_format($redeem->koin_used, 0, ',', '.') . ' koin untuk ' . ($redeem->reward->name ?? 'Hadiah Tidak Dikenal'),
        //         'status' => $redeem->status,
        //         'created_at' => $redeem->created_at,
        //         // Rute untuk update status langsung dari tabel (akan pakai form di Blade)
        //         'update_link' => route('admin.transactions.redeem.updateStatus', $redeem->id),
        //         'status_options' => ['sedang_dikirim', 'selesai'], // Opsi status untuk dropdown
        //     ]);
        // }

        // Urutkan semua aktivitas dari yang terbaru (descending)
        // $activities = $allActivities->sortByDesc('created_at');

        return "Halaman All History Berhasil Diakses!";
    }
}
