@extends('layouts.user')

@section('title', 'Beranda TrashPoint')


@section('content')
    <div class="card" style="background-image: url('{{ asset('images/banner-sampah.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                min-height: 690px;
                border: none;">
        {{-- Gambar banner penuh, tanpa isi teks/konten --}}
    </div>
@endsection