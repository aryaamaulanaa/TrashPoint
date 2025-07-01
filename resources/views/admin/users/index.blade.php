@push('styles')
    <style>
        .role-badge {
            padding: 5px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            display: inline-block;
            text-transform: capitalize;
        }

        .role-user {
            background-color: rgb(0, 168, 6);
        }

        .role-admin {
            background-color: #007bff;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            color: white;
        }

        .status-active {
            background-color: #28a745;
        }

        .status-nonaktif {
            background-color: #ffc107;
        }

        .btn-action {
            @apply inline-block px-3 py-1 rounded-md text-sm font-medium text-white mr-1;
        }

        .btn-primary {
            background-color: #296FD8;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
        }
    </style>
@endpush

@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            <path fill-rule="evenodd"
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
        </svg>
        <span class="leading-none">Kelola Pengguna</span>
    </div>
@endsection
@section('content')
    <div class="overflow-x-auto bg-white p-4 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">ID User</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">No. Telepon</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->phone_number ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="status-badge status-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span class="role-badge role-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 space-x-1">
                            @if ($user->role === 'user')
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-action btn-primary">
                                    Detail
                                </a>
                            @endif
                            @if ($user->role === 'admin')
                                <span class="text-gray-400 italic">Tidak tersedia</span>
                            @else
                                @if ($user->status == 'active')
                                    <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action btn-warning"
                                            onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?');">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action btn-success"
                                            onclick="return confirm('Yakin ingin mengaktifkan pengguna ini?');">
                                            Aktifkan
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.');">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada pengguna ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection