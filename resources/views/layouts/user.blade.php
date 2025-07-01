<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TrashPoint App')</title>
    {{-- SweetAlert2 CDN sudah ada, bagus! --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Gaya umum yang mirip admin, tapi disesuaikan untuk user */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .user-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .user-sidebar {
            width: 250px;
            background-color: #4F98C8;
            /* Warna biru muda, mendekati screenshot */
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .user-sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            /* Menggunakan flexbox untuk logo dan teks */
            align-items: center;
            /* Menyelaraskan secara vertikal */
            justify-content: center;
            /* Menyelaraskan secara horizontal */
            gap: 10px;
            /* Jarak antara logo dan teks */
        }

        .user-sidebar-header .logo-img {
            width: 40px;
            /* Ukuran logo */
            height: auto;
        }

        .user-sidebar-header .logo-text {
            font-weight: bold;
            font-size: 1.8em;
            margin-bottom: 0;
            color: #255e31;
            /* Hapus margin default */
        }

        .user-sidebar-header .coin-display {
            font-size: 1em;
            margin-top: 10px;
            /* Jarak dari logo/teks */
        }

        .user-sidebar-header .coin-value {
            font-size: 1.5em;
            font-weight: bold;
            color: #FFD700;
        }

        .user-sidebar ul {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }

        .user-sidebar ul li {
            margin-bottom: 15px;
        }

        .user-sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .user-sidebar ul li a:hover,
        .user-sidebar ul li a.active {
            background-color: #3a7aa6;
            /* Biru lebih gelap saat hover/active */
        }

        .user-sidebar ul li a svg {
            vertical-align: middle;
        }


        .user-content {
            flex-grow: 1;
            padding: 30px;
        }

        .user-inner-content {
            background-color: #ffffff;
            margin: 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-header-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-header-info .profile-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            gap: 8px;
        }

        .user-header-info .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #87CEEB;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Styling untuk tabel (mirip admin) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .btn-action {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: white;
            margin-right: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-info {
            background-color: #17a2b8;
        }

        /* Form styling (mirip admin) */
        .form-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group input[type="file"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .current-image {
            max-width: 150px;
            height: auto;
            margin-top: 10px;
            border: 1px solid #eee;
        }

        /* Status badges (mirip admin) */
        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            color: white;
            font-weight: bold;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-dijemput {
            background-color: #17a2b8;
        }

        .status-selesai {
            background-color: #28a745;
        }

        .status-dibatalkan {
            background-color: #dc3545;
        }

        .status-sedang_dikirim {
            background-color: #6c757d;
        }

        .form-inline {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .form-inline select,
        .form-inline input {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="user-wrapper">
        <div class="user-sidebar">
            <div class="user-sidebar-header">
                {{-- Tambahkan logo di sini --}}
                <img src="{{ asset('images/logo-sampah.png') }}" alt="Logo Sampah" class="logo-img">
                <div class="logo-text">TrashPoint</div>
                {{-- Kamu bisa tambahkan tampilan koin di sini jika ingin, misal: --}}
                {{-- <div class="coin-display">
                    Koin Anda: <span class="coin-value">{{ Auth::user()->coins ?? 0 }}</span>
                </div> --}}
            </div>
            <ul>
                {{-- Beranda --}}
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 1.293a1 1 0 00-1.414 0l-8 8A1 1 0 002 10h1v7a1 1 0 001 1h5v-5h2v5h5a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-8-8z" />
                        </svg>
                        Beranda
                    </a>
                </li>

                {{-- Setor Sampah --}}
                <li>
                    <a href="{{ route('setoran.create') }}"
                        class="{{ request()->routeIs('setoran.create') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-3 text-white"
                            fill="currentColor" viewBox="0 0 512 512">
                            <path
                                d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448l0 32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2l0 32 96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z" />
                        </svg>
                        Setor Sampah
                    </a>
                </li>

                {{-- Tukar Koin --}}
                <li>
                    <a href="{{ route('redeem.index') }}" class="{{ request()->routeIs('redeem.*') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                        </svg>
                        Tukar Koin
                    </a>
                </li>

                {{-- Riwayat Transaksi --}}
                <li>
                    <a href="{{ route('user.transactions.index') }}"
                        class="{{ request()->routeIs('user.transactions.index') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                            <path
                                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        Riwayat Transaksi
                    </a>
                </li>

                {{-- Keluar --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: block;">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            style="color: white; text-decoration: none; display: block; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s ease;">
                            <svg class="inline w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                            Keluar
                        </a>
                    </form>
                </li>
            </ul>
        </div>
        <div class="user-content">
            <div class="user-inner-content">
                <div class="user-header" style="display: flex; justify-content: space-between; align-items: center;">
                    {{-- Koin di kiri --}}
                    @if(Auth::check())
                        <div style="display: flex; flex-direction: column; align-items: flex-start; margin-right: 20px;">
                            <div style="font-size: 0.9em; color: #333;">Total Koin Anda:</div>
                            <div style="font-size: 1.4em; font-weight: bold; color:rgb(3, 114, 16);">
                                {{ number_format(Auth::user()->koin_balance, 0, ',', '.') }} Koin
                            </div>
                        </div>
                    @endif

                    {{-- Foto profil di kanan --}}
                    <div class="user-header-info">
                        @if(Auth::check())
                            {{-- **PERUBAHAN DI SINI: Arahkan ke route('profile.show')** --}}
                            <a href="{{ route('profile.show') }}" class="profile-link">
                                {{-- Logic untuk menentukan URL foto profil (ini tidak berubah) --}}
                                @php
                                    $profilePictureUrl = '';
                                    // Jika ada path profile_picture di database
                                    if (!empty(Auth::user()->profile_picture)) {
                                        // Jika path-nya adalah 'images/default_profile.jpeg' (dari public folder)
                                        if (Auth::user()->profile_picture === 'images/default_profile.jpeg') {
                                            $profilePictureUrl = asset('images/default_profile.jpeg');
                                        } else {
                                            // Jika path-nya adalah gambar kustom (dari storage folder)
                                            $profilePictureUrl = asset('storage/' . Auth::user()->profile_picture);
                                        }
                                    } else {
                                        // Jika profile_picture di database NULL atau kosong, gunakan default juga
                                        $profilePictureUrl = asset('images/default_profile.jpeg');
                                    }
                                @endphp

                                <span>{{ Auth::user()->name }}</span> {{-- Nama di kiri --}}
                                <img src="{{ $profilePictureUrl }}" alt="{{ Auth::user()->name }}" class="profile-pic"> {{--
                                Foto profil di kanan --}}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Blok ini dibiarkan untuk error validasi form, karena lebih cocok di tampilkan di HTML biasa --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content') {{-- Ini adalah tempat konten spesifik halaman akan diinject --}}
            </div>
        </div>

        {{-- Script SweetAlert2 untuk semua notifikasi sukses/error --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let title = '';
                let text = '';
                let icon = '';
                let confirmButtonColor = '';

                // Handle success messages (termasuk 'profile-updated' dan 'success' umum)
                @if (session('success'))
                    title = 'Berhasil!';
                    text = '{{ session('success') }}';
                    icon = 'success';
                    confirmButtonColor = '#28a745'; // Green
                @elseif (session('status') === 'profile-updated')
                    title = 'Berhasil!';
                    text = 'Profil berhasil diperbarui.';
                    icon = 'success';
                    confirmButtonColor = '#28a745'; // Green
                @endif

                // Handle error messages (non-validation errors)
                @if (session('error'))
                    title = 'Gagal!';
                    text = '{{ session('error') }}';
                    icon = 'error';
                    confirmButtonColor = '#dc3545'; // Red
                @endif

            // Tampilkan SweetAlert jika ada pesan yang disetel
            if (title && text && icon) {
                    Swal.fire({
                        icon: icon,
                        title: title,
                        text: text,
                        confirmButtonText: 'OK',
                        confirmButtonColor: confirmButtonColor
                    });
                }
            });
        </script>
</body>

</html>