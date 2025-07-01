<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Reward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Category::truncate();
        Reward::truncate();

        // 1. Buat Akun Admin Pertama
        User::create([
            'name' => 'Admin TrashPoint',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'koin_balance' => 0,
            'address' => 'Kantor Pusat TrashPoint',
            'phone_number' => '08123456789',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Aryaa Maulana',
            'email' => 'aryaa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'koin_balance' => 0,
            'address' => 'Jl Zambrud 9. RT.6/RW.8. Grogol Utara, Kota Jakarta Selatan, daerah Khusus Ibukota Jakarta',
            'phone_number' => '081216896539',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 2. Buat Beberapa Kategori Sampah Awal
        Category::create([
            'name' => 'Botol Plastik PET',
            'koin_per_kg' => 10,
            'description' => 'Botol air minum, wadah makanan transparan.'
        ]);
        Category::create([
            'name' => 'Kaleng Alumunium',
            'koin_per_kg' => 15,
            'description' => 'Kaleng soda, kaleng bir, kaleng kopi.'
        ]);
        Category::create([
            'name' => 'Kardus Bekas',
            'koin_per_kg' => 5,
            'description' => 'Kotak mie instan, dus sepatu, kemasan elektronik.'
        ]);
        Category::create([
            'name' => 'Kertas HVS',
            'koin_per_kg' => 3,
            'description' => 'Kertas print, fotokopi, laporan kerja.'
        ]);

        // 3. Buat Beberapa Reward Awal
        Reward::create([
            'name' => 'Voucher Pulsa 10K',
            'description' => 'Tukar koin Anda dengan voucher pulsa Rp 10.000 untuk semua jaringan.',
            'koin_required' => 100,
            'stock' => 50,
            'image' => 'isigambarsendiri.jpg'
        ]);
        Reward::create([
            'name' => 'Tumbler Eksklusif',
            'description' => 'Tumbler ramah lingkungan dari TrashPoint.',
            'koin_required' => 200,
            'stock' => 20,
            'image' => 'isigambarsendiri.jpg'
        ]);
        Reward::create([
            'name' => 'Diskon Belanja 5%',
            'description' => 'Voucher diskon 5% untuk pembelian di mitra kami.',
            'koin_required' => 100,
            'stock' => 100,
            'image' => 'isigambarsendiri.jpg'
        ]);

        // Opsional: Buat beberapa user biasa untuk testing
        // Pastikan UserFactory sudah disesuaikan dengan kolom baru di tabel users
        \App\Models\User::factory(5)->create();

        Schema::enableForeignKeyConstraints();
    }
}