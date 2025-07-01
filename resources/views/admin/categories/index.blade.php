@extends('layouts.admin')

@section('title', 'Kelola Kategori Sampah')
@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
        </svg>
        <span class="leading-none">Kelola Kategori Sampah</span>
    </div>
@endsection

@push('styles')
    <style>
        .btn-action {
            @apply inline-block px-4 py-2 rounded-md text-sm font-medium text-white;
        }

        .btn-primary {
            background-color: #296FD8;
        }

        .btn-primary:hover {
            background-color: #2057B0;
        }

        .btn-primary:active {
            background-color: #1A448C;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
        }
    </style>
@endpush

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.categories.create') }}" class="btn-action btn-primary">
            + Tambah Kategori Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white p-4 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nama Kategori</th>
                    <th class="px-4 py-2">Koin per Kg</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $category->id }}</td>
                        <td class="px-4 py-2">{{ $category->name }}</td>
                        <td class="px-4 py-2">{{ number_format($category->koin_per_kg, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $category->description ?? '-' }}</td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-action btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus kategori ini? Data transaksi yang terkait mungkin akan terpengaruh.');">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">
                            Tidak ada kategori sampah ditemukan. Silakan tambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection