@extends('layouts.admin') {{-- Menggunakan layout admin.blade.php --}}

@section('title', 'Riwayat Transaksi')

@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
            <path
                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
        </svg>
        <span class="leading-none">Pilih Pengguna untuk Riwayat Transaksi</span>
    </div>
@endsection

@push('styles')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        table th,
        table td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
            vertical-align: middle;
        }

        table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            font-size: 12px;
        }

        table tr:nth-child(even) {
            background-color: #f9fbfd;
        }

        table tr:hover {
            background-color: #eef4ff;
        }

        .btn-info {
            display: inline-block;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #296FD8;
            transition: background 0.3s ease;
        }

        .btn-info:hover {
            background-color: #2057B0;
        }

        .table-empty {
            text-align: center;
            padding: 30px;
            color: #777;
            font-style: italic;
        }
    </style>
@endpush

@section('content')
    <table>
        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td style="text-align: center;">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.transactions.user', $user->id) }}" class="btn-info">
                            Lihat Riwayat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="table-empty">Tidak ada pengguna biasa ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
@endsection