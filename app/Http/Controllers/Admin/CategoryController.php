<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Import model Category
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori sampah.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Nama harus unik
            'koin_per_kg' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kategori tertentu.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mengupdate kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)], // Nama unik kecuali dirinya sendiri
            'koin_per_kg' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori sampah berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // PENTING: Periksa apakah ada transaksi yang terkait dengan kategori ini
        // Jika ada relasi onDelete('restrict') di migrasi, database akan mencegah penghapusan otomatis.
        // Namun, baiknya ada pesan user-friendly.
        if ($category->transactions()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kategori karena masih terkait dengan transaksi sampah.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori sampah berhasil dihapus.');
    }
}