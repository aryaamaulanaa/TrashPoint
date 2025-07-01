<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User di-import
use App\Models\Category; // Pastikan model Category di-import
use App\Models\Reward; // Pastikan model Reward di-import
use App\Models\Transaction; // Pastikan model Transaction di-import
use App\Models\RedeemTransaction; // Pastikan model RedeemTransaction di-import
use Illuminate\Support\Carbon; // Pastikan Carbon di-import

class DashboardController extends Controller
{
    public function index()
    {
        // --- DATA STATISTIK DASHBOARD ---
        $totalSampahMasuk = Transaction::where('status', 'selesai')->sum('actual_weight_kg');
        $sampahHariIni = Transaction::where('status', 'selesai')
            ->whereDate('created_at', Carbon::today()) // Menggunakan created_at
            ->sum('actual_weight_kg');

        $totalPengguna = User::where('role', 'user')->count();
        $penggunaAktif = User::where('role', 'user')->where('status', 'active')->count();
        $penggunaNonaktif = User::where('role', 'user')->where('status', 'inactive')->count();

        $totalKategoriSampah = Category::count();
        $totalRewardCount = Reward::count(); // Menghitung total stok


        // --- LOGIKA UNTUK AKTIVITAS TERBARU DI DASHBOARD (Hanya untuk Tampilan) ---
        // Ambil 5 setoran sampah terbaru dengan relasi user dan category
        $recentSetoran = Transaction::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(5) // Ambil 5 data terbaru
            ->get();

        // Ambil 5 penukaran koin terbaru dengan relasi user dan reward
        $recentRedeem = RedeemTransaction::with(['user', 'reward'])
            ->orderBy('created_at', 'desc')
            ->take(5) // Ambil 5 data terbaru
            ->get();

        // Gabungkan kedua koleksi transaksi dan ubah formatnya agar seragam
        $allActivities = collect([]);

        foreach ($recentSetoran as $setoran) {
            $allActivities->push([
                'id' => $setoran->id,
                'type' => 'setoran',
                'user_name' => $setoran->user->name ?? 'User Tidak Dikenal',
                'main_text' => 'mengajukan setoran',
                'description' => number_format($setoran->estimated_weight_kg, 2) . ' kg ' . ($setoran->category->name ?? 'Sampah Tidak Dikenal'),
                'status' => $setoran->status,
                'created_at' => $setoran->created_at,
                // detail_link DIHAPUS karena tidak lagi ada link individu di dashboard
            ]);
        }

        foreach ($recentRedeem as $redeem) {
            $allActivities->push([
                'id' => $redeem->id,
                'type' => 'tukar_koin',
                'user_name' => $redeem->user->name ?? 'User Tidak Dikenal',
                'main_text' => 'menukar koin',
                'description' => number_format($redeem->koin_used, 0, ',', '.') . ' koin untuk ' . ($redeem->reward->name ?? 'Hadiah Tidak Dikenal'),
                'status' => $redeem->status,
                'created_at' => $redeem->created_at,
                // detail_link DIHAPUS karena tidak lagi ada link individu di dashboard
            ]);
        }

        // Urutkan semua aktivitas dari yang terbaru dan ambil 5 teratas untuk dashboard
        $activities = $allActivities->sortByDesc('created_at')->take(5);

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalSampahMasuk',
            'sampahHariIni',
            'totalPengguna',
            'penggunaAktif',
            'penggunaNonaktif',
            'totalKategoriSampah',
            'totalRewardCount',
            'activities' // PASTIKAN activities DIKIRIM KE VIEW
        ));
    }
}
