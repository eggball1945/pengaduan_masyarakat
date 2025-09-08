@extends('layouts.app')

@section('title', 'Dashboard Pengaduan')

@section('content')
<div class="container py-5">

    {{-- Hero Section --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-6 text-center text-md-start">
            <h1 class="fw-bold text-primary mb-3">
                Selamat Datang 👋
            </h1>
            <p class="lead text-muted">
                Aplikasi Pengaduan Masyarakat membantu Anda menyampaikan aspirasi dan melaporkan masalah di lingkungan sekitar dengan cepat dan mudah.
            </p>
            @auth('masyarakat')
                <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-primary shadow-sm mt-3">
                    <i class="bi bi-plus-circle me-2"></i> Buat Pengaduan
                </a>
            @else
                {{-- Trigger Modal Login --}}
                <button class="btn btn-lg btn-outline-primary shadow-sm mt-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login untuk Mengadu
                </button>
            @endauth
        </div>
        <div class="col-md-6 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png"
                 alt="Ilustrasi Orang"
                 class="img-fluid"
                 style="max-height: 300px;">
        </div>
    </div>

    {{-- Statistik Section --}}
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body py-4">
                    <h5 class="card-title text-muted">Total User</h5>
                    <h2 class="fw-bold text-primary">{{ $totalUser ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body py-4">
                    <h5 class="card-title text-muted">Total Pengaduan</h5>
                    <h2 class="fw-bold text-success">{{ $totalPengaduan ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body py-4">
                    <h5 class="card-title text-muted">Pengaduan Selesai</h5>
                    <h2 class="fw-bold text-info">{{ $pengaduanSelesai ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <h3 class="fw-bold text-center mb-4">❓ Frequently Asked Questions</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            Bagaimana cara membuat pengaduan?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1">
                        <div class="accordion-body">
                            Login terlebih dahulu, lalu klik tombol <strong>Buat Pengaduan</strong> dan isi form yang tersedia.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Apakah saya bisa melacak status pengaduan?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2">
                        <div class="accordion-body">
                            Ya, Anda bisa melihat status pengaduan pada halaman <strong>Data Pengaduan</strong>.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Siapa yang menangani laporan saya?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3">
                        <div class="accordion-body">
                            Pengaduan Anda akan ditangani oleh <strong>Petugas</strong> yang ditunjuk dan diverifikasi oleh <strong>Admin</strong> atau <strong>Petugas</strong>. 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
