@extends('layouts.admin')

@section('title', 'Riwayat Transaksi ' . $user->name)

@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
            <path
                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
        </svg>
        <span class="leading-none">Riwayat Transaksi untuk {{ $user->name }}</span>
    </div>
@endsection

@section('content')
    <div class="admin-inner-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.transactions.index') }}"
            class="inline-flex items-center mb-6 px-4 py-2 bg-[#296FD8] text-white rounded-md text-sm font-semibold hover:bg-[#2057B0]">
            ← Kembali ke Daftar Pengguna
        </a>

        {{-- Setoran Sampah --}}
        <h2 class="text-xl font-bold text-gray-700 mt-8 mb-4">Riwayat Setoran Sampah</h2>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Estimasi Berat</th>
                        <th class="px-4 py-2">Berat Aktual</th>
                        <th class="px-4 py-2">Koin Didapat</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($setoranTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $transaction->id }}</td>
                            <td class="px-4 py-2">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $transaction->category->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ number_format($transaction->estimated_weight_kg, 2) }} kg</td>
                            <td class="px-4 py-2">
                                @if($transaction->actual_weight_kg)
                                    {{ number_format($transaction->actual_weight_kg, 2) }} kg
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ number_format($transaction->koin_earned, 0) }}</td>
                            <td class="px-4 py-2">
                                <span class="status-badge status-{{ $transaction->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.transactions.setoran.updateStatus', $transaction->id) }}"
                                    method="POST" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="border-gray-300 rounded-md text-sm">
                                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="dijemput" {{ $transaction->status == 'dijemput' ? 'selected' : '' }}>
                                            Dijemput</option>
                                        <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                        <option value="dibatalkan" {{ $transaction->status == 'dibatalkan' ? 'selected' : '' }}>
                                            Dibatalkan</option>
                                    </select>
                                    @if ($transaction->status !== 'selesai')
                                        <input type="number" name="actual_weight_kg" placeholder="Berat Aktual (kg)" step="0.01"
                                            value="{{ old('actual_weight_kg', $transaction->actual_weight_kg) }}"
                                            class="border-gray-300 rounded-md text-sm w-28">
                                    @endif
                                    <button type="submit" class="btn-action btn-primary">
                                        Update
                                    </button>
                                </form>
                                @error('actual_weight_kg')
                                    <div class="error-message text-red-600 mt-1 text-xs">{{ $message }}</div>
                                @enderror
                                @error('status')
                                    <div class="error-message text-red-600 mt-1 text-xs">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">Tidak ada riwayat setoran sampah untuk
                                pengguna ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Penukaran Koin --}}
        <h2 class="text-xl font-bold text-gray-700 mt-10 mb-4">Riwayat Penukaran Koin</h2>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Hadiah</th>
                        <th class="px-4 py-2">Koin Digunakan</th>
                        <th class="px-4 py-2">Nama Penerima</th>
                        <th class="px-4 py-2">Alamat Pengiriman</th>
                        <th class="px-4 py-2">No. Telp Pengiriman</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($redeemTransactions as $redeem)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $redeem->id }}</td>
                            <td class="px-4 py-2">{{ $redeem->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $redeem->reward->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ number_format($redeem->koin_used, 0) }}</td>
                            <td class="px-4 py-2 max-w-xs break-words">{{ $redeem->recipient_name }}</td>
                            <td class="px-4 py-2 max-w-xs break-words">{{ $redeem->delivery_address }}</td>
                            <td class="px-4 py-2">{{ $redeem->delivery_phone_number }}</td>
                            <td class="px-4 py-2">
                                <span class="status-badge status-{{ str_replace('_', '', $redeem->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $redeem->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.transactions.redeem.updateStatus', $redeem->id) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="border-gray-300 rounded-md text-sm">
                                        <option value="sedang_dikirim" {{ $redeem->status == 'sedang_dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="selesai" {{ $redeem->status == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                    <button type="submit" class="btn-action btn-primary">
                                        Update
                                    </button>
                                </form>
                                @error('status')
                                    <div class="error-message text-red-600 mt-1 text-xs">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">Tidak ada riwayat penukaran koin untuk
                                pengguna ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection