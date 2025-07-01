<?php

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\TransactionController; // Admin Transaction Controller
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\SetoranController;
use App\Http\Controllers\User\RedeemController;
use App\Http\Controllers\User\TransactionHistoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.delete_picture');

    Route::get('/setor-sampah', [SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setor-sampah', [SetoranController::class, 'store'])->name('setoran.store');

    Route::get('/tukar-koin', [RedeemController::class, 'index'])->name('redeem.index');
    Route::post('/tukar-koin', [RedeemController::class, 'store'])->name('redeem.store');

    Route::get('/riwayat-transaksi-user', [TransactionHistoryController::class, 'index'])->name('user.transactions.index');
});

// =====================================================================
// === ROUTE UNTUK ADMIN PANEL ========================================
// =====================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Pengelolaan Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::put('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Kelola Kategori Sampah
    Route::resource('categories', CategoryController::class);

    // Kelola Hadiah
    Route::resource('rewards', RewardController::class);

    // Rute list setoran yang sudah ada (untuk admin.setoran.list)
    Route::get('/setoran/list', [TransactionController::class, 'listSetoran'])->name('setoran.list');

    // Rute list transaksi umum admin (yang sudah ada)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Rute transaksi per user (yang sudah ada)
    Route::get('/transactions/user/{user}', [TransactionController::class, 'userTransactions'])->name('transactions.user');

    // Rute untuk melihat detail SETORAN sampah
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    // Rute untuk mengedit SETORAN sampah
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    // Rute update status setoran sampah
    Route::put('/transactions/setoran/{transaction}/status', [TransactionController::class, 'updateSetoranStatus'])->name('transactions.setoran.updateStatus');

    // Rute untuk melihat detail PENUKARAN koin
    Route::get('/redeem/{redeemTransaction}', [TransactionController::class, 'showRedeem'])->name('redeem.show');
    // Rute untuk mengedit PENUKARAN koin
    Route::get('/redeem/{redeemTransaction}/edit', [TransactionController::class, 'editRedeem'])->name('redeem.edit');
    // Rute update status penukaran koin
    Route::put('/transactions/redeem/{redeemTransaction}/status', [TransactionController::class, 'updateRedeemStatus'])->name('transactions.redeem.updateStatus');

    // >>> PERUBAHAN DIAGNOSTIK: Rute all-history DIHAPUS DARI SINI <<<
    // Karena dipindahkan ke luar grup admin untuk sementara.

});
// >>> PERUBAHAN DIAGNOSTIK: Rute all-history DITAMBAHKAN DI SINI (di luar grup admin) <<<
// Ini adalah halaman yang akan menampilkan semua aktivitas 3 hari terakhir dalam tabel.
// Untuk tujuan diagnosa 404, kita coba tanpa middleware 'admin' dulu.
// Jika nanti berhasil, baru kita kembalikan middleware-nya atau sesuaikan.
Route::get('/admin/transactions/all-history', [TransactionController::class, 'allHistory'])->name('admin.transactions.all_history')->middleware(['auth']);


// File routes autentikasi bawaan Breeze
require __DIR__ . '/auth.php';