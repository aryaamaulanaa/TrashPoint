<?php
/** @var \App\Models\User $user */
?>
@extends('layouts.user')

@section('title', 'Profil Pengguna')
@section('page_title', 'Profil Pengguna')

@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg flex justify-center mt-10"
        style="padding: 50px;">
        <div class="w-full">
            {{-- Bagian Update Profile Information --}}
            <section>
                <header>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        {{ __('Informasi Profil') }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Perbarui informasi profil akun Anda dan alamat email.") }}
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 w-full"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Alamat email Anda belum diverifikasi.') }}

                                    <button form="send-verification"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                            :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                    </div>

                    <div>
                        <x-input-label for="address" :value="__('Alamat Lengkap')" />
                        <textarea id="address" name="address"
                            class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            rows="3">{{ old('address', $user->address) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    {{-- BAGIAN UNTUK FOTO PROFIL --}}
                    <div>
                        <x-input-label for="profile_picture" :value="__('Foto Profil')" />
                        <input id="profile_picture" name="profile_picture" type="file"
                            class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />
                        <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />

                        {{-- Menampilkan foto profil saat ini --}}
                        <p class="mt-2 text-sm text-gray-600">Foto profil saat ini:</p>
                        @if ($user->profile_picture && $user->profile_picture === 'images/default_profile.jpeg')
                            {{-- Jika ini adalah gambar default dari public/images --}}
                            <img src="{{ asset('images/default_profile.jpeg') }}" alt="Foto Profil Default"
                                class="mt-2 rounded-full w-24 h-24 object-cover">
                        @elseif ($user->profile_picture)
                            {{-- Jika ini adalah gambar kustom yang diupload ke storage --}}
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil Saat Ini"
                                class="mt-2 rounded-full w-24 h-24 object-cover">
                        @else
                            {{-- Jika profile_picture di DB null atau kosong, tampilkan default --}}
                            <img src="{{ asset('images/default_profile.jpeg') }}" alt="Foto Profil Default"
                                class="mt-2 rounded-full w-24 h-24 object-cover">
                        @endif
                    </div>
                    {{-- AKHIR BAGIAN FOTO PROFIL --}}

                    <div class="flex items-center gap-4">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">{{ __('Simpan') }}</x-primary-button>
                        <a href="{{ route('profile.show') }}">
                            <x-secondary-button type="button">{{ __('Batal') }}</x-secondary-button>
                        </a>
                        {{-- TOMBOL HAPUS FOTO PROFIL --}}
                        @if ($user->profile_picture && $user->profile_picture !== 'images/default_profile.jpeg')
                            {{-- MENGGANTI X-SECONDARY-BUTTON DENGAN <BUTTON> LANGSUNG UNTUK KONTROL STYLE PENUH --}}
                            <button type="button" onclick="confirmDeleteProfilePicture('{{ route('profile.delete_picture') }}', '{{ csrf_token() }}');"
                                class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Hapus Foto Profil') }}
                            </button>
                        @endif
                        {{-- AKHIR TOMBOL HAPUS FOTO PROFIL --}}
                        @if (session('status') === 'profile-updated')
                            <script>
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Profil berhasil diperbarui.',
                                    icon: 'success',
                                    confirmButtonColor: '#4CAF50' // Hijau
                                });
                            </script>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>

    <div class="w-full bg-white rounded-lg shadow-lg flex justify-center mt-10"
        style="padding: 50px;">
        <div class="w-full">
            {{-- Bagian Update Password --}}
            <section>
                <header>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        {{ __('Perbarui Kata Sandi') }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 w-full">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
                        <x-text-input id="current_password" name="current_password" type="password"
                            class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                            class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                            class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">{{ __('Simpan') }}</x-primary-button>
                        <a href="{{ route('profile.show') }}">
                            <x-secondary-button type="button">{{ __('Batal') }}</x-secondary-button>
                        </a>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>

    {{-- Script untuk fungsi hapus foto profil via JS --}}
    <script>
        function confirmDeleteProfilePicture(routeUrl, csrfToken) {
            Swal.fire({
                title: 'Konfirmasi Hapus Foto',
                text: "Apakah Anda yakin ingin menghapus foto profil? Ini akan mengembalikan ke foto default.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545', // Merah
                cancelButtonColor: '#6c757d', // Abu-abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis
                    let form = document.createElement('form');
                    form.action = routeUrl;
                    form.method = 'POST'; // method POST karena kita akan spoofing DELETE

                    // Tambahkan CSRF token
                    let csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Tambahkan method spoofing untuk DELETE
                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    // Tambahkan form ke body dan submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection