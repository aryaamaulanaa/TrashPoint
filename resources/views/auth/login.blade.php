<x-guest-layout>
    <h2 class="text-center text-3xl font-bold mb-6 text-gray-800">Masuk TrashPoint</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 text-left">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        {{-- PERBAIKAN DI SINI: Tambahkan 'flex' dan 'justify-center' ke tombol --}}
        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="w-full flex items-center justify-center
    bg-[#296FD8] hover:bg-[#2057B0] active:bg-[#1A448C] focus:ring-[#296FD8]">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
        {{-- END PERBAIKAN --}}

        <div class="mt-6 flex justify-center items-center">
            <p class="text-sm text-gray-600 mb-0">Belum punya akun?</p>
            @if (Route::has('register'))
                <a class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-1"
                    href="{{ route('register') }}">
                    {{ __('Daftar') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>