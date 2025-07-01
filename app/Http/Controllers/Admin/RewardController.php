<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward; // Import model Reward
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus gambar

class RewardController extends Controller
{
    /**
     * Menampilkan daftar semua hadiah/reward.
     */
    public function index()
    {
        $rewards = Reward::latest()->paginate(10);
        $totalRewardCount = Reward::count();
        return view('admin.rewards.index', compact('rewards'));
    }

    /**
     * Menampilkan form untuk menambah hadiah baru.
     */
    public function create()
    {
        return view('admin.rewards.create');
    }

    /**
     * Menyimpan hadiah baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rewards,name',
            'description' => 'nullable|string|max:1000',
            'koin_required' => 'required|integer|min:1', // Koin harus integer positif
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        $data = $request->except('image'); // Ambil semua data kecuali image

        if ($request->hasFile('image')) {
            // Simpan gambar ke folder storage/app/public/rewards
            $imagePath = $request->file('image')->store('rewards', 'public');
            $data['image'] = $imagePath;
        }

        Reward::create($data);

        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit hadiah tertentu.
     */
    public function edit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    /**
     * Mengupdate hadiah di database.
     */
    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('rewards')->ignore($reward->id)],
            'description' => 'nullable|string|max:1000',
            'koin_required' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($reward->image && Storage::disk('public')->exists($reward->image)) {
                Storage::disk('public')->delete($reward->image);
            }
            $imagePath = $request->file('image')->store('rewards', 'public');
            $data['image'] = $imagePath;
        }

        $reward->update($data);

        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil diperbarui.');
    }

    /**
     * Menghapus hadiah dari database.
     */
    public function destroy(Reward $reward)
    {
        // PENTING: Periksa apakah ada transaksi penukaran yang terkait dengan hadiah ini
        if ($reward->redeemTransactions()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus hadiah karena masih terkait dengan transaksi penukaran.');
        }

        // Hapus gambar dari storage jika ada
        if ($reward->image && Storage::disk('public')->exists($reward->image)) {
            Storage::disk('public')->delete($reward->image);
        }

        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil dihapus.');
    }
}