@extends('layouts.app')

@section('title', 'Home')

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
                <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-primary shadow-sm rounded-pill mt-3">
                    <i class="bi bi-plus-circle me-2"></i> Buat Pengaduan
                </a>
            @else
                <button class="btn btn-lg btn-outline-primary shadow-sm rounded-pill mt-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login untuk Mengadu
                </button>
            @endauth
        </div>
        <div class="col-md-6 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4144/4144517.png" 
                alt="Ilustrasi Pengaduan" 
                class="img-fluid rounded-4" 
                style="max-height: 400px;">
        </div>
    </div>

    {{-- Statistik Section --}}
    <div class="row text-center mb-5 g-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center">
                <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                <h5 class="text-muted mb-1">Total User</h5>
                <h2 class="fw-bold text-primary">{{ $totalUser ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center">
                <i class="bi bi-journal-check fs-1 text-success mb-2"></i>
                <h5 class="text-muted mb-1">Total Pengaduan</h5>
                <h2 class="fw-bold text-success">{{ $totalPengaduan ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center">
                <i class="bi bi-check-circle fs-1 text-info mb-2"></i>
                <h5 class="text-muted mb-1">Pengaduan Selesai</h5>
                <h2 class="fw-bold text-info">{{ $pengaduanSelesai ?? 0 }}</h2>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <h3 class="fw-bold text-center mb-4">❓ Frequently Asked Questions</h3>
            <div class="accordion shadow-sm rounded-4" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse"
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
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
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
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
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

{{-- Custom CSS --}}
<style>
/* Card Statistik Modern */
.card h2 {
    font-size: 2rem;
    margin-bottom: 0;
}
.card i {
    transition: transform 0.3s ease;
}
.card:hover i {
    transform: scale(1.2);
}

/* Tombol Hero Modern */
.btn-primary, .btn-outline-primary {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.btn-primary:hover, .btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endsection
