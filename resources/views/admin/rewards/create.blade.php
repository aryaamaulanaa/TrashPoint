@extends('layouts.admin') {{-- Menggunakan layout admin.blade.php --}}

@section('title', 'Tambah Hadiah Baru')

@section('page_title')
    <div class="flex items-center text-gray-800 text-3xl font-bold">
        <svg class="inline w-10 h-10 mr-3 text-[#296FD8] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z" />
        </svg>
        <span class="leading-none">Tambah Hadiah Baru</span>
    </div>
@endsection

@push('styles')
    <style>
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            max-width: 100%;
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            margin-right: 10px;
            transition: background 0.3s ease;
        }

        .btn-success {
            background-color: #296FD8;
        }

        .btn-success:hover {
            background-color: #2057B0;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <form action="{{ route('admin.rewards.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Hadiah:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="koin_required">Koin Dibutuhkan:</label>
                <input type="number" id="koin_required" name="koin_required" value="{{ old('koin_required') }}" required
                    min="1">
                @error('koin_required')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stok:</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" required min="0">
                @error('stock')
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
            <div class="form-group">
                <label for="image">Gambar Hadiah :</label>
                <input type="file" id="image" name="image" accept="image/*">
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn-action btn-success">Simpan Hadiah</button>
            <a href="{{ route('admin.rewards.index') }}" class="btn-action btn-secondary btn-back">Batal</a>
        </form>
    </div>
@endsection