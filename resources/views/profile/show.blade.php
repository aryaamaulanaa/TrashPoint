<?php
/** @var \App\Models\User $user */
?>
@extends('layouts.user') {{-- Menggunakan layout user yang sama --}}

@section('title', 'Detail Profil Pengguna')
@section('page_title', 'Detail Profil')

@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg py-10 px-6 sm:px-10 mt-10"> {{-- Menyesuaikan padding dan margin --}}
        <h1 class="text-3xl sm:text-4xl font-bold mb-8 text-center text-gray-800 border-b pb-4">
            {{ __('Detail Informasi Profil') }}
        </h1>

        {{-- Bagian Foto Profil --}}
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

        {{-- Detail Data dalam Tabel --}}
        <table class="w-full border border-gray-300 rounded overflow-hidden text-sm md:text-base">
            <tbody>
                <tr class="border-b">
                    <th class="bg-gray-50 text-left px-4 sm:px-6 py-3 sm:py-4 w-1/3 font-medium text-gray-700">Nama Lengkap
                    </th>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-900">{{ $user->name }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-50 text-left px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-700">Email</th>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-900">{{ $user->email }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-50 text-left px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-700">No. Telepon</th>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-900">{{ $user->phone_number ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-50 text-left px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-700">Alamat Lengkap</th>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-900">{{ $user->address ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-50 text-left px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-700">Saldo Koin</th>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 font-semibold text-green-900">
                        {{ number_format($user->koin_balance, 0, ',', '.') }} koin</td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-end gap-4 mt-6"> {{-- Tombol di kanan bawah --}}
            {{-- Tombol Edit Profil --}}
            <a href="{{ route('profile.edit') }}">
                <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                    {{ __('Edit Profil') }}
                </x-primary-button>
            </a>
            {{-- Tombol Kembali --}}
            <a href="{{ route('dashboard') }}">
                <x-secondary-button type="button">{{ __('Kembali') }}</x-secondary-button>
            </a>
        </div>
    </div>
@endsection