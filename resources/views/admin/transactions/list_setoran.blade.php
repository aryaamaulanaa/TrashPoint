@extends('layouts.admin')

@section('title', 'Riwayat Setoran Terbaru')
@section('page_title', '📦 Riwayat Setoran Sampah (Terbaru)')

@section('content')
    <table class="w-full table-auto border border-gray-300 rounded shadow-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">No</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Pengguna</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Berat Estimasi</th>
                <th class="p-3">Berat Aktual</th>
                <th class="p-3">Koin</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($setoranList as $i => $trx)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $i + 1 }}</td>
                    <td class="p-3">{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td class="p-3">{{ $trx->user->name }}</td>
                    <td class="p-3">{{ $trx->category->name ?? '-' }}</td>
                    <td class="p-3">{{ number_format($trx->estimated_weight_kg, 2) }} kg</td>
                    <td class="p-3">
                        {{ $trx->actual_weight_kg ? number_format($trx->actual_weight_kg, 2) . ' kg' : '-' }}
                    </td>
                    <td class="p-3">{{ number_format($trx->koin_earned ?? 0, 0) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white text-sm
                            {{ $trx->status == 'selesai' ? 'bg-green-600' :
                                ($trx->status == 'dibatalkan' ? 'bg-red-600' : 'bg-yellow-500') }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center p-4">Belum ada data setoran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
