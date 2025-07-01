@extends('layouts.user') {{-- Menggunakan layout user.blade.php --}}

@section('title', 'Riwayat Transaksi Saya')
@section('page_title', 'Riwayat Transaksi Saya')

@section('content')
    <div class="form-container w-full bg-white rounded-lg shadow-lg" style="max-width: 1300px; padding: 50px; min-height: 650px;">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Setoran Sampah</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Jenis Sampah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Est. Berat (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Aktual Berat (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Koin Didapat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($setoranTransactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $transaction->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($transaction->estimated_weight_kg, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->actual_weight_kg ? number_format($transaction->actual_weight_kg, 2) : '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($transaction->koin_earned, 0) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($transaction->status == 'dijemput') bg-blue-100 text-blue-800
                                    @elseif($transaction->status == 'selesai') bg-green-100 text-green-800
                                    @elseif($transaction->status == 'dibatalkan') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">Tidak ada riwayat setoran sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $setoranTransactions->links('pagination::tailwind') }}
        </div>

        <h3 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Riwayat Penukaran Koin</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Hadiah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Kuantitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Koin Digunakan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($redeemTransactions as $redeem)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $redeem->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $redeem->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $redeem->reward->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $redeem->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($redeem->koin_used, 0) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($redeem->status == 'sedang_dikirim') bg-gray-100 text-gray-800
                                    @elseif($redeem->status == 'selesai') bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $redeem->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">Tidak ada riwayat penukaran koin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $redeemTransactions->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
