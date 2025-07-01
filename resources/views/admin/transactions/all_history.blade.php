@extends('layouts.admin') {{-- Menggunakan layout admin.blade.php --}}

@section('title', 'Riwayat Transaksi Admin') {{-- Judul untuk tag <title> di browser --}}
@section('page_title', 'Riwayat Transaksi') {{-- Judul yang tampil di header konten admin --}}

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Riwayat Transaksi Admin</h1>
    <p class="text-gray-600 mb-6">Daftar semua transaksi (setoran & penukaran) dari 3 hari terakhir.</p>

    {{-- Menampilkan pesan sukses/error dari session, sama seperti di layout user --}}
    @if (session('success'))
        {{-- SweetAlert sudah dihandle di layout admin, jadi tidak perlu div ini --}}
    @endif
    @if (session('error'))
        {{-- SweetAlert sudah dihandle di layout admin, jadi tidak perlu div ini --}}
    @endif
    @if ($errors->any())
        <div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID Transaksi
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tipe
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengguna
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($activities as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $activity['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $activity['type'] == 'setoran' ? 'Setoran Sampah' : 'Penukaran Koin' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $activity['user_name'] }}
                            {{-- Opsional: link ke detail user --}}
                            {{-- <a href="{{ route('admin.users.show', $activity['user_id']) }}" class="text-blue-500 hover:underline">
                                {{ $activity['user_name'] }}
                            </a> --}}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $activity['description'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activity['created_at']->format('d M Y H:i') }} ({{ $activity['created_at']->diffForHumans() }})
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="status-badge 
                                @if ($activity['status'] == 'pending') status-pending
                                @elseif ($activity['status'] == 'dijemput') status-dijemput
                                @elseif ($activity['status'] == 'selesai') status-selesai
                                @elseif ($activity['status'] == 'dibatalkan') status-dibatalkan
                                @elseif ($activity['status'] == 'sedang_dikirim') status-sedang_dikirim
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ $activity['update_link'] }}" method="POST" class="inline-flex items-center space-x-2">
                                @csrf
                                @method('PATCH') {{-- Menggunakan PATCH method untuk update sebagian resource --}}

                                <select name="status" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($activity['status_options'] as $option)
                                        <option value="{{ $option }}" {{ $activity['status'] == $option ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $option)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="actual_weight_kg" placeholder="Berat Aktual (kg)" class="w-32 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm"
                                    value="{{ $activity['type'] == 'setoran' && $activity['status'] == 'selesai' ? number_format($activity['actual_weight_kg'], 2, '.', '') : '' }}"
                                    {{ $activity['type'] == 'tukar_koin' ? 'disabled' : '' }}
                                    >
                                <input type="text" name="admin_notes" placeholder="Catatan Admin" class="w-40 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm">

                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Update
                                </button>
                                @if (isset($activity['detail_link']))
                                    <a href="{{ $activity['detail_link'] }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada aktivitas transaksi dalam 3 hari terakhir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
