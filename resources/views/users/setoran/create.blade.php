@extends('layouts.user')

@section('title', 'Ajukan Setoran Sampah')
@section('page_title', 'Ajukan Setoran Sampah')

@section('content')
    <div class="form-container w-full bg-white rounded-lg shadow-lg"
        style="max-width: 1300px; padding: 50px; min-height: 650px;">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Form Pengajuan Setoran Sampah</h3>
        <p class="mt-1 text-sm text-gray-600 mb-4">
            Isi data di bawah untuk mengajukan penjemputan/penyetoran sampah Anda.
        </p>
        {{-- x-data ada di elemen form ini --}}
        <form method="POST" action="{{ route('setoran.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6"
            x-data="{ selectedCategory: '{{ old('category_id') }}' }">
            @csrf

            <div class="md:col-span-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Pilih Jenis Sampah</h3>
                {{-- Input tersembunyi untuk menyimpan ID kategori yang dipilih --}}
                <input type="hidden" name="category_id" id="category_id" x-model="selectedCategory" required>

                {{-- Grid untuk menampilkan kartu-kartu jenis sampah --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($categories as $category)
                        <div class="
                                                                            p-6 border border-gray-300 rounded-xl cursor-pointer
                                                                            flex flex-col items-center justify-center text-center
                                                                            transition duration-200 ease-in-out
                                                                            hover:border-blue-500 hover:shadow-md
                                                                            "
                            :class="{ 'bg-blue-50 border-blue-500 shadow-lg': selectedCategory == '{{ $category->id }}' }" {{--
                            ATRIBUT :class ini KEMBALI ADA --}} x-on:click="selectedCategory = '{{ $category->id }}'">
                            <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $category->name }}</h4>
                            <p class="text-lg text-gray-600">{{ number_format($category->koin_per_kg, 0, ',', '.') }} Koin/kg
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- Menampilkan error validasi jika ada --}}
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            {{-- Estimasi Berat --}}
            <div class="md:col-span-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Masukkan Berat (kg)</h3>
                <div>
                    <x-input-label for="estimated_weight_kg" :value="__('Estimasi Berat Sampah (kg)')" />
                    <x-text-input id="estimated_weight_kg" name="estimated_weight_kg" type="number" step="0.1" min="0.1"
                        class="mt-1 block w-full" :value="old('estimated_weight_kg')" required />
                    <x-input-error :messages="$errors->get('estimated_weight_kg')" class="mt-2" />
                </div>
            </div>

            {{-- Alamat Penjemputan (span 2 kolom) --}}
            <div class="md:col-span-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">3. Detail Alamat Penjemputan</h3>
                <div>
                    <x-input-label for="pickup_address" :value="__('Alamat Penjemputan')" />
                    <textarea id="pickup_address" name="pickup_address"
                        class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        rows="4" required>{{ old('pickup_address', Auth::user()->address) }}</textarea>
                    <x-input-error :messages="$errors->get('pickup_address')" class="mt-2" />
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div class="md:col-span-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">4. Nomor Telepon Penjemputan</h3>
                <div>
                    <x-input-label for="pickup_phone_number" :value="__('Nomor Telepon Penjemputan')" />
                    <x-text-input id="pickup_phone_number" name="pickup_phone_number" type="text" class="mt-1 block w-full"
                        :value="old('pickup_phone_number', Auth::user()->phone_number)" required />
                    <x-input-error :messages="$errors->get('pickup_phone_number')" class="mt-2" />
                </div>
            </div>

            {{-- Tombol Submit (span 2 kolom) --}}
            <div class="md:col-span-2 w-full flex justify-end">
                <x-primary-button class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2">
                    Ajukan Setoran
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection