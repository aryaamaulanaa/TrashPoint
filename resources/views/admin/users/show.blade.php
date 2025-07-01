@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            <path fill-rule="evenodd"
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
        </svg>
        <span class="leading-none">Detail Pengguna dari : {{ $user->name }}</span>
    </div>
@endsection
@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white rounded-xl shadow-lg p-10">
                <h1 class="text-4xl font-bold mb-8 text-center text-gray-800 border-b pb-4">Detail Pengguna</h1>

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 p-4 mb-6 rounded text-center font-medium shadow">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-center mb-8">
                    @php
                        $profilePictureUrl = '';
                        if (!empty($user->profile_picture)) {
                            if ($user->profile_picture === 'images/default_profile.jpeg') {
                                $profilePictureUrl = asset('images/default_profile.jpeg');
                            } else {
                                $profilePictureUrl = asset('storage/' . $user->profile_picture);
                            }
                        } else {
                            $profilePictureUrl = asset('images/default_profile.jpeg');
                        }
                    @endphp
                    <img src="{{ $profilePictureUrl }}" alt="Foto Profil"
                        class="w-32 h-32 sm:w-36 sm:h-36 rounded-full object-cover border-4 border-blue-300 shadow-lg">
                </div>

                <table class="w-full border border-gray-300 rounded overflow-hidden text-sm md:text-base">
                    <tbody>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 w-1/3 font-medium text-gray-700">Nama</th>
                            <td class="px-6 py-4 text-gray-900">{{ $user->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">Email</th>
                            <td class="px-6 py-4 text-gray-900">{{ $user->email }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">No. Telepon</th>
                            <td class="px-6 py-4 text-gray-900">{{ $user->phone_number ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">Alamat</th>
                            <td class="px-6 py-4 text-gray-900">{{ $user->address ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">Saldo Koin</th>
                            <td class="px-6 py-4 font-semibold text-yellow-700">{{ number_format($user->koin_balance, 2) }}
                                koin</td>
                        </tr>
                        <tr class="border-b">
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">Status Akun</th>
                            <td
                                class="px-6 py-4 font-semibold {{ $user->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($user->status) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-gray-50 text-left px-6 py-4 font-medium text-gray-700">Terdaftar Sejak</th>
                            <td class="px-6 py-4 text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-right mt-10">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection