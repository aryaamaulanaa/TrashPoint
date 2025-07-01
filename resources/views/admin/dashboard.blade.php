@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title')
    <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 rounded-xl bg-gradient-to-r from-[#296FD8] to-[#2149A6] text-white shadow-md">
        <div class="flex items-center space-x-3">
            {{-- SVG Icon --}}
            <svg class="w-12 h-12 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>

            {{-- Page Title - Tambahkan 'relative -translate-y-1' atau angka lain --}}
            <h1 class="text-4xl font-bold leading-tight m-0 p-0 relative -translate-y-1">Dashboard Admin</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">👋 Selamat Datang, Admin!</h2>
        <p class="text-gray-600 mb-8">Gunakan dashboard ini untuk mengelola data dan memantau aktivitas sistem.</p>

        {{-- Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-7">
            {{-- Total Sampah Masuk --}}
            <a href="{{ route('admin.setoran.list') }}"
                class="p-7 rounded-2xl border-t-4 border-green-500 bg-white shadow-md hover:shadow-lg transition duration-300 min-h-[160px] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-700">Total Sampah Masuk</h3>
                    <div class="text-green-600">
                        {{-- SVG sama seperti versi awal --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-11 h-11" viewBox="0 0 18 18">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ number_format($totalSampahMasuk, 2) }} kg</p>
                <p class="text-sm mt-2 text-green-700">↑ {{ number_format($sampahHariIni, 2) }} kg Hari Ini</p>
            </a>

            {{-- Total Pengguna --}}
            <a href="{{ route('admin.users.index') }}"
                class="p-7 rounded-2xl border-t-4 border-blue-500 bg-white shadow-md hover:shadow-lg transition duration-300 min-h-[160px] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-700">Total Pengguna</h3>
                    <div class="text-blue-600">
                        <svg class="w-12 h-12 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalPengguna }}</p>
                <p class="text-sm mt-2">
                    <span class="text-green-600">{{ $penggunaAktif }} Aktif</span> |
                    <span class="text-red-600">{{ $penggunaNonaktif }} Nonaktif</span>
                </p>
            </a>

            {{-- Kategori Sampah --}}
            <a href="{{ route('admin.categories.index') }}"
                class="p-7 rounded-2xl border-t-4 border-yellow-500 bg-white shadow-md hover:shadow-lg transition duration-300 min-h-[160px] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-700">Total Kategori Sampah</h3>
                    <div class="text-yellow-500">
                        <svg class="inline w-12 h-12 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalKategoriSampah }}</p>
                <p class="text-sm mt-2 text-gray-600">Kategori Sampah</p>
            </a>

            {{-- Total Reward --}}
            <a href="{{ route('admin.rewards.index') }}"
                class="p-7 rounded-2xl border-t-4 border-purple-500 bg-white shadow-md hover:shadow-lg transition duration-300 min-h-[160px] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-700">Total Reward</h3>
                    <div class="text-purple-500">
                        <svg class="inline w-12 h-12 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalRewardCount }}</p>
                <p class="text-sm mt-2 text-gray-600">Jumlah Hadiah</p>
            </a>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="mt-10">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse ($activities as $activity)
                        <li class="py-3 flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $activity['user_name'] }} {{ $activity['main_text'] }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $activity['description'] }}
                                    @if ($activity['status'])
                                        •
                                        <span class="inline-block rounded-full px-2 py-0.5 text-xs font-semibold
                                                                    @if($activity['status'] == 'pending') bg-yellow-100 text-yellow-800
                                                                    @elseif($activity['status'] == 'dijemput') bg-blue-100 text-blue-800
                                                                    @elseif($activity['status'] == 'selesai') bg-green-100 text-green-800
                                                                    @elseif($activity['status'] == 'dibatalkan') bg-red-100 text-red-800
                                                                    @elseif($activity['status'] == 'sedang_dikirim') bg-purple-100 text-purple-800
                                                                    @endif">
                                            {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <span
                                class="text-sm text-gray-500 whitespace-nowrap">{{ $activity['created_at']->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="py-3 text-center text-gray-500">Tidak ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection