@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h2>Selamat Datang di Aplikasi Pengaduan Masyarakat</h2>
        <p>Silakan login atau register untuk membuat pengaduan.</p>

        @auth
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary mt-3">Buat Pengaduan</a>
        @endauth
    </div>
@endsection
