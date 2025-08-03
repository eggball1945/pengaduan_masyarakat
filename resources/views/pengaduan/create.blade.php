@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Buat Pengaduan</h2>

    @auth
    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="isi_laporan" class="form-label">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" id="isi_laporan" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" id="foto" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
    @else
        <div class="alert alert-warning">
            Silakan login terlebih dahulu untuk mengirim pengaduan.
        </div>
    @endauth
</div>
@endsection
