# APLIKASI EDUKASI DAN PENGELOLAAN SAMPAH BERBASIS WEB

APLIKASI EDUKASI DAN PENGELOLAAN SAMPAH BERBASIS WEB (Trashpoint) adalah sebuah platform digital yang dirancang untuk memfasilitasi pengelolaan sampah yang lebih terorganisir dan teredukasi di masyarakat. Aplikasi ini memungkinkan user untuk mengajukan penyetoran sampah, mengumpulkan koin dari setiap setoran, dan menukarkan koin tersebut dengan berbagai hadiah. Selain itu, aplikasi ini juga bertujuan meningkatkan kesadaran masyarakat melalui edukasi tentang pentingnya pengelolaan sampah yang bertanggung jawab, demi menciptakan lingkungan yang lebih bersih dan sehat.

## Fitur Utama

* Pengelolaan Jenis Sampah (dengan nilai koin per kilogramnya)
* Pengelolaan User (melihat detail, mengaktifkan/menonaktifkan, menghapus akun user)
* Pengajuan Penyetoran Sampah oleh User
* Sistem Poin (Koin) User
* Penukaran Hadiah dengan Koin
* Riwayat Transaksi Setoran dan Penukaran Koin untuk Administrator dan User

## Persyaratan Sistem

Pastikan Anda memiliki perangkat lunak berikut terinstal di sistem Anda:

* **PHP:** Versi 8.1 atau lebih tinggi
* **Composer:** Manajer paket PHP
* **Node.js & npm (atau Yarn):** Untuk mengelola dependensi JavaScript dan mengkompilasi aset
* **Database:** MySQL, PostgreSQL, atau SQLite (pilih salah satu)

## Instalasi Proyek

Ikuti salah satu metode di bawah ini untuk menginstal dan menjalankan proyek ini di mesin lokal Anda.

### Metode 1: Menggunakan Git Repository (Disarankan)

Metode ini cocok jika Anda terbiasa dengan Git dan ingin selalu memiliki versi terbaru proyek.

1.  **Kloning Repositori:**
    Buka terminal atau Git Bash Anda, lalu navigasikan ke direktori tempat Anda ingin menyimpan proyek. Jalankan perintah berikut untuk mengkloning repositori Anda:
    ```bash
    git clone [https://github.com/aryaamaulanaa/TrashPoint.git](https://github.com/aryaamaulanaa/TrashPoint.git)
    ```
    Setelah selesai, masuk ke dalam folder proyek yang baru saja dikloning:
    ```bash
    cd [nama_folder_proyekmu_misal_TrashPoint]
    ```

2.  **Instal Dependensi Composer:**
    Pastikan Composer sudah terinstal dengan benar. Jalankan perintah ini untuk menginstal semua dependensi PHP yang dibutuhkan proyek:
    ```bash
    composer install
    ```

3.  **Salin File Environment:**
    Laravel menggunakan file `.env` untuk konfigurasi lingkungan. Buat salinan dari file contoh:
    ```bash
    cp .env.example .env
    ```

4.  **Konfigurasi Environment (`.env`):**
    Buka file `.env` yang baru saja Anda salin dengan editor teks (seperti VS Code, Sublime Text, Notepad++). Sesuaikan pengaturan database Anda (misalnya `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) agar sesuai dengan konfigurasi database lokal Anda. Anda juga mungkin perlu menyesuaikan `APP_URL` jika tidak menggunakan `http://localhost:8000`.

5.  **Generate Application Key:**
    Laravel membutuhkan kunci aplikasi untuk keamanan. Jalankan perintah ini:
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Database:**
    Ini akan membuat semua tabel yang diperlukan di database yang telah Anda konfigurasi di file `.env`:
    ```bash
    php artisan migrate
    ```

7.  **Seed Data (Opsional tapi Disarankan):**
    Jika Anda memiliki *seeder* yang telah disiapkan untuk mengisi data awal (misal: akun admin default, jenis sampah awal, daftar hadiah), jalankan perintah ini:
    ```bash
    php artisan db:seed
    ```
    *(Jika Anda ingin menjalankan seeder tertentu, misal hanya `UserSeeder`, Anda bisa menggunakan: `php artisan db:seed --class=UserSeeder`)*

8.  **Instal Dependensi Node.js:**
    Pastikan Node.js dan npm (atau Yarn) sudah terinstal. Jalankan perintah ini untuk menginstal semua dependensi JavaScript/frontend:
    ```bash
    npm install
    # atau jika Anda menggunakan Yarn:
    # yarn
    ```

9.  **Compile Assets (CSS/JS):**
    Ini akan mengkompilasi file CSS dan JavaScript Anda untuk digunakan di aplikasi:
    ```bash
    npm run dev
    # Gunakan npm run build untuk kompilasi versi produksi (minified):
    # npm run build
    ```

10. **Jalankan Server Lokal Laravel:**
    Aplikasi akan berjalan di `http://localhost:8000` secara default:
    ```bash
    php artisan serve
    ```

11. **Akses Aplikasi:**
    Buka browser web Anda dan kunjungi URL yang ditampilkan oleh perintah `php artisan serve` (biasanya `http://127.0.0.1:8000` atau `http://localhost:8000`).

### Metode 2: Menggunakan Download File ZIP

Metode ini cocok jika Anda lebih suka mengunduh proyek secara langsung tanpa menggunakan Git secara penuh.

1.  **Unduh File Proyek:**
    * Buka halaman repositori GitHub Anda di browser: `https://github.com/aryaamaulanaa/TrashPoint.git`
    * Cari dan klik tombol hijau bertuliskan "<> Code", lalu pilih opsi "Download ZIP".

2.  **Ekstrak File ZIP:**
    Setelah file ZIP terunduh, ekstrak (unzip) kontennya ke lokasi yang Anda inginkan di komputer Anda. Ini akan membuat folder proyek Anda.

3.  **Buka Terminal di Direktori Proyek:**
    Navigasikan terminal atau Command Prompt Anda ke dalam folder proyek yang telah Anda ekstrak.

4.  **Lanjutkan dengan Langkah Instalasi Umum:**
    Mulai dari sini, langkah-langkah instalasinya sama persis dengan Metode 1, dari poin 2 hingga 11.
    * **Instal Dependensi Composer:** `composer install`
    * **Salin File Environment:** `cp .env.example .env`
    * **Konfigurasi Environment (`.env`):** Sesuaikan pengaturan database dan `APP_URL`.
    * **Generate Application Key:** `php artisan key:generate`
    * **Jalankan Migrasi Database:** `php artisan migrate`
    * **Seed Data (Opsional):** `php artisan db:seed`
    * **Instal Dependensi Node.js:** `npm install` (atau `yarn`)
    * **Compile Assets (CSS/JS):** `npm run dev` (atau `npm run build`)
    * **Jalankan Server Lokal Laravel:** `php artisan serve`
    * **Akses Aplikasi:** Buka browser Anda dan kunjungi `http://127.0.0.1:8000` (atau URL yang ditampilkan).

## Kredensial Default (jika Anda menggunakan seeder)

Jika Anda menjalankan `php artisan db:seed` dan seeder Anda membuat akun default, berikut adalah contoh kredensial yang mungkin dapat digunakan untuk login:

* **Email Admin:** `admin@gmail.com`
* **Password Admin:** `password`
* **Email User Biasa:** `aryaa@gmail.com`
* **Password User Biasa:** `password`

## Pengujian

* [Jelaskan cara melakukan pengujian dasar, misal: login sebagai admin, tambahkan jenis sampah baru, daftarkan user baru, dll.]'


