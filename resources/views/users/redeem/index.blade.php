@extends('layouts.user')

@section('title', 'Tukar Koin')
@section('page_title', 'Tukar Koin')

@section('content')
    <div class="form-container w-full bg-white rounded-lg shadow-lg" style="max-width: 1300px; padding: 50px; min-height: 650px;">

        <h3 class="text-2xl font-bold text-gray-900 mb-4">Katalog Hadiah Tersedia</h3>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($rewards as $reward)
                <div class="border rounded-lg p-4 shadow-sm flex flex-col">
                    <div class="flex-shrink-0 mb-4 text-center">
                        @if ($reward->image)
                            <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}"
                                class="w-32 h-32 object-cover rounded-md mx-auto">
                        @else
                            <img src="{{ asset('images/default_reward.png') }}" alt="No Image"
                                class="w-32 h-32 object-cover rounded-md mx-auto">
                        @endif
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 text-center">{{ $reward->name }}</h4>
                    <p class="text-center text-sm text-gray-600 mt-1">{{ $reward->description }}</p>
                    <p class="text-center text-xl font-bold text-indigo-600 mt-3">
                        {{ number_format($reward->koin_required, 0, ',', '.') }} Koin</p>
                    <p class="text-center text-sm text-gray-500">Stok: {{ $reward->stock }}</p>

                    <div class="mt-4 flex-grow flex items-end">
                        @if (Auth::user()->koin_balance >= $reward->koin_required && $reward->stock > 0)
                            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-redeem-{{ $reward->id }}')"
                            class="bg-green-600 hover:bg-green-700 w-full justify-center">
                            {{ __('Tukar Sekarang') }} 
                            </x-primary-button>
                        @else
                            <button disabled
                                class="w-full justify-center opacity-50 cursor-not-allowed inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Tidak Cukup Koin / Stok Habis') }}
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Modal --}}
                <x-modal name="confirm-redeem-{{ $reward->id }}" :show="$errors->redeemValidation->isNotEmpty()" focusable
                    x-data="{ quantity: {{ old('quantity', 1) }} }">
                    <form method="post" action="{{ route('redeem.store') }}" class="p-6">
                        @csrf
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Konfirmasi Penukaran Hadiah') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Anda akan menukarkan <span class="font-bold text-indigo-600"
                                x-text="quantity * {{ $reward->koin_required }}"></span> Koin
                            untuk mendapatkan <span class="font-bold" x-text="quantity"></span> hadiah <span
                                class="font-bold">{{ $reward->name }}</span>.
                            Pastikan alamat pengiriman sudah benar.
                        </p>

                        <input type="hidden" name="reward_id" value="{{ $reward->id }}">

                        <div class="mt-4">
                            <x-input-label for="quantity_{{ $reward->id }}" :value="__('Kuantitas')" />
                            <x-text-input id="quantity_{{ $reward->id }}" name="quantity" type="number"
                                class="mt-1 block w-full" x-model.number="quantity"
                                required min="1"
                                max="{{ min($reward->stock, floor(Auth::user()->koin_balance / $reward->koin_required)) }}" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="recipient_name_{{ $reward->id }}" :value="__('Nama Penerima')" />
                            <x-text-input id="recipient_name_{{ $reward->id }}" name="recipient_name" type="text"
                                class="mt-1 block w-full" :value="old('recipient_name', Auth::user()->name)" required />
                            <x-input-error :messages="$errors->get('recipient_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="delivery_address_{{ $reward->id }}" :value="__('Alamat Pengiriman')" />
                            <textarea id="delivery_address_{{ $reward->id }}" name="delivery_address"
                                class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3" required>{{ old('delivery_address', Auth::user()->address) }}</textarea>
                            <x-input-error :messages="$errors->get('delivery_address')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="delivery_phone_number_{{ $reward->id }}" :value="__('Nomor Telepon Pengiriman')" />
                            <x-text-input id="delivery_phone_number_{{ $reward->id }}" name="delivery_phone_number" type="text"
                                class="mt-1 block w-full" :value="old('delivery_phone_number', Auth::user()->phone_number)"
                                required />
                            <x-input-error :messages="$errors->get('delivery_phone_number')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Batal') }}
                            </x-secondary-button>

                            <x-primary-button class="bg-green-600 hover:bg-green-700 text-white ms-3">
                                {{ __('Konfirmasi Penukaran') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    Tidak ada hadiah yang tersedia saat ini.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $rewards->links() }}
        </div>
    </div>
@endsection