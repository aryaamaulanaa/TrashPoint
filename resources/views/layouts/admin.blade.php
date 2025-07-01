<!DOCTYPE html>
<html lang="en">
@stack('styles')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - TrashPoint')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Gaya umum yang mungkin kamu butuhkan di seluruh admin panel */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            background-color: #4F98C8;
            /* Warna biru sesuai Figma */
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .admin-sidebar-header .logo-img {
            width: 40px;
            height: auto;
        }

        .admin-sidebar-header .logo-text {
            font-weight: bold;
            font-size: 1.8em;
            margin-bottom: 0;
            color: #255e31;
        }

        .admin-sidebar ul {
            list-style: none;
            padding: 0;
        }

        .admin-sidebar ul li {
            margin-bottom: 15px;
        }

        .admin-sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .admin-sidebar ul li a:hover,
        .admin-sidebar ul li a.active {
            background-color: #3a7aa6;
        }

        .admin-sidebar ul li a svg {
            vertical-align: middle;
        }

        .admin-content {
            flex-grow: 1;
            padding: 30px;
        }

        .admin-inner-content {
            background-color: #ffffff;
            margin: 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        /* --- BARU DITAMBAHKAN UNTUK JUDUL HALAMAN DI HEADER KONTEN --- */
        .admin-header h3 {
            font-size: 1.8em;
            /* Ukuran lebih besar */
            font-weight: bold;
            /* Tebal */
            color: #333;
            /* Warna yang sesuai jika sebelumnya berbeda */
            margin: 0;
            /* Hapus margin default jika ada */
        }

        /* ----------------------------------------------------------- */

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

        /* Styling Khusus Dashboard Cards */
        .dashboard-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 20px;
            flex: 1;
            min-width: 200px;
            max-width: calc(25% - 15px);
            box-sizing: border-box;
            text-align: center;
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.1em;
            color: #555;
        }

        .card .main-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .card .sub-value {
            font-size: 0.9em;
            color: #666;
        }

        .card .icon {
            font-size: 2em;
            color: #3b82f6;
            margin-bottom: 10px;
        }

        .text-green {
            color: #28a745;
        }

        .text-red {
            color: #dc3545;
        }

        /* Styling untuk tabel */
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

        /* Form styling */
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

        /* Status badges */
        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            color: white;
            font-weight: bold;
        }

        .status-active {
            background-color: #28a745;
        }

        .status-inactive {
            background-color: #dc3545;
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

        .btn-primary-alt {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-alt:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <img src="{{ asset('images/logo-sampah.png') }}" alt="Logo Sampah" class="logo-img">
                <div class="logo-text">TrashPoint</div>
            </div>
            <ul>
                {{-- Beranda --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 1.293a1 1 0 00-1.414 0l-8 8A1 1 0 002 10h1v7a1 1 0 001 1h5v-5h2v5h5a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-8-8z" />
                        </svg>
                        Beranda
                    </a>
                </li>

                {{-- Kelola Pengguna --}}
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        Kelola Pengguna
                    </a>
                </li>

                {{-- Kelola Kategori --}}
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
                        </svg>
                        Kelola Kategori
                    </a>
                </li>

                {{-- Kelola Hadiah --}}
                <li>
                    <a href="{{ route('admin.rewards.index') }}"
                        class=" {{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}">
                        <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z" />
                        </svg>
                        Kelola Hadiah
                    </a>
                </li>

                {{-- Riwayat Transaksi --}}
                <li>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
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
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
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

        <div class="admin-content">
            <div class="admin-header">
                {{-- Gaya untuk h3 di sini --}}
                <h3>@yield('page_title')</h3>
                <div>
                    Halo, {{ Auth::user()->name }}!
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>