@extends('layouts.admin')

@section('title', 'Tambah Kategori Sampah')

@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
        </svg>
        <span class="leading-none">Tambah Kategori Sampah Baru</span>
    </div>
@endsection

@push('styles')
    <style>
        .form-container {
            width: 100%;
            max-width: none;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333333;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #296FD8;
            outline: none;
            box-shadow: 0 0 5px rgba(41, 111, 216, 0.3);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            color: #ffffff;
        }

        .btn-primary {
            background-color: #296FD8;
        }

        .btn-primary:hover {
            background-color: #2057B0;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-back {
            margin-left: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="koin_per_kg">Koin per Kg:</label>
                <input type="number" id="koin_per_kg" name="koin_per_kg" step="0.01" value="{{ old('koin_per_kg') }}"
                    required>
                @error('koin_per_kg')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi (Opsional):</label>
                <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-action btn-primary">Simpan Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-action btn-secondary btn-back">Batal</a>
        </form>
    </div>
@endsection