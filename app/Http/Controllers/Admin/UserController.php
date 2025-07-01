<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN BARIS INI

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna biasa (role 'user').
     */
    public function index()
    {
        $users = User::latest()->paginate(10); // Ambil semua user (admin & user biasa)
        return view('admin.users.index', compact('users'));
    }



    /**
     * Menampilkan detail dari pengguna tertentu.
     */
    public function show(User $user)
    {
        // Pastikan user yang dilihat adalah role 'user' dan bukan admin lain
        if ($user->role !== 'user') {
            abort(404); // Atau redirect dengan pesan error
        }
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menonaktifkan akun pengguna.
     */
    public function deactivate(User $user)
    {
        // Cek agar tidak menonaktifkan admin lain atau akun sendiri
        if ($user->role === 'admin' || $user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menonaktifkan akun admin atau akun Anda sendiri.');
        }

        $user->update(['status' => 'inactive']);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dinonaktifkan.');
    }

    /**
     * Mengaktifkan kembali akun pengguna.
     */
    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diaktifkan kembali.');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(User $user)
    {
        // Cek agar tidak menghapus admin lain atau akun sendiri
        if ($user->role === 'admin' || $user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun admin atau akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}