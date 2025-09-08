@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')

@auth('masyarakat')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Header Actions -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bi bi-house-door-fill me-1"></i> Home
                </a>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bi bi-list-ul me-1"></i> Data Pengaduan
                </a>
            </div>

            <!-- Card Form -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="mb-4 fw-bold text-center text-primary">
                        <i class="bi bi-chat-dots-fill me-2"></i> Formulir Pengaduan
                    </h4>

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Isi Laporan -->
                        <div class="mb-4">
                            <label for="isi_laporan" class="form-label fw-semibold">Isi Laporan</label>
                            <textarea name="isi_laporan"
                                class="form-control form-control-lg rounded-3 shadow-sm"
                                id="isi_laporan"
                                rows="5"
                                placeholder="Tulis laporan Anda di sini..."
                                required>{{ old('isi_laporan') }}</textarea>
                        </div>

                        <!-- Foto -->
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold">Upload Foto (Opsional)</label>
                            <input type="file"
                                   name="foto"
                                   class="form-control shadow-sm rounded-3"
                                   id="foto"
                                   accept="image/*">
                        </div>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                <i class="bi bi-send-fill me-1"></i> Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@else
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-warning text-center shadow-sm rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Silakan login terlebih dahulu untuk mengirim pengaduan.
            </div>
        </div>
    </div>
</div>
@endauth

@endsection
