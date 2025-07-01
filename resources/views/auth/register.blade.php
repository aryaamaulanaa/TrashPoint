<x-guest-layout>
    <h2 class="text-center text-3xl font-bold mb-6 text-gray-800">Buat Akun Kamu!</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Address --}}
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Phone Number --}}
        <div class="mb-4">
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        {{-- Addres --}}
        <div class="mb-4">
            <x-input-label for="address" :value="__('Alamat')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Tombol Daftar --}}
        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="w-full flex items-center justify-center
    bg-[#296FD8] hover:bg-[#2057B0] active:bg-[#1A448C] focus:ring-[#296FD8]">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        {{-- PERUBAHAN DI SINI: Link "Masuk di sini" berdampingan --}}
        <div class="mt-4 flex justify-center items-center gap-1"> {{-- 'text-center' diubah jadi 'flex justify-center items-center gap-1' --}}
            <p class="text-sm text-gray-600 mb-0">Sudah punya akun?</p>
            <a class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Masuk') }}
            </a>
        </div>
        {{-- END PERUBAHAN --}}
    </form>
</x-guest-layout>