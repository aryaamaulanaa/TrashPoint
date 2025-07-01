@extends('layouts.admin')

@section('title', 'Kelola Hadiah')

@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="inline w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z" />
        </svg>
        <span class="leading-none">Kelola Hadiah</span>
    </div>
@endsection


@push('styles')
    <style>
        .btn-primary-alt {
            background-color: #296FD8;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .btn-primary-alt:hover {
            background-color: #2057B0;
        }

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

        .reward-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
        }

        .btn-action {
            display: inline-block;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            margin: 2px;
        }

        .btn-warning {
            background-color: #f0ad4e;
        }

        .btn-warning:hover {
            background-color: #ec971f;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
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
    <div class="flex justify-end mb-5">
        <a href="{{ route('admin.rewards.create') }}" class="btn-primary-alt">+ Tambah Hadiah Baru</a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th>Gambar</th>
                <th>Nama Hadiah</th>
                <th>Koin Dibutuhkan</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rewards as $reward)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>
                        @if ($reward->image)
                            <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}" class="reward-image">
                        @else
                            <img src="{{ asset('images/default_reward.png') }}" alt="No Image" class="reward-image">
                        @endif
                    </td>
                    <td>{{ $reward->name }}</td>
                    <td>{{ number_format($reward->koin_required, 0, ',', '.') }}</td>
                    <td>{{ $reward->stock }}</td>
                    <td>
                        <a href="{{ route('admin.rewards.edit', $reward->id) }}" class="btn-action btn-warning">Edit</a>
                        <form action="{{ route('admin.rewards.destroy', $reward->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger"
                                onclick="return confirm('Yakin ingin menghapus hadiah ini? Data transaksi penukaran yang terkait mungkin akan terpengaruh.');">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="table-empty">Tidak ada hadiah ditemukan. Silakan tambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $rewards->links() }}
    </div>
@endsection