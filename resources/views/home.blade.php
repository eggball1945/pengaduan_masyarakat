@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5 fade-in">
            <div class="col-md-6 text-center text-md-start">
                <h1 class="fw-bold text-primary mb-3">Selamat Datang 👋</h1>
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
                     class="img-fluid hero-img"
                     style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

{{-- Statistik Section --}}
<section class="statistik-section py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5 g-4 fade-in">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center stat-card">
                    <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                    <h5 class="text-muted mb-1">Total User</h5>
                    <h2 class="fw-bold text-primary">{{ $totalUser ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center stat-card">
                    <i class="bi bi-journal-check fs-1 text-success mb-2"></i>
                    <h5 class="text-muted mb-1">Total Pengaduan</h5>
                    <h2 class="fw-bold text-success">{{ $totalPengaduan ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 h-100 p-4 text-center stat-card">
                    <i class="bi bi-check-circle fs-1 text-info mb-2"></i>
                    <h5 class="text-muted mb-1">Pengaduan Selesai</h5>
                    <h2 class="fw-bold text-info">{{ $pengaduanSelesai ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5 fade-in">
            <div class="col-md-8">
                <h3 class="fw-bold text-center mb-4">❓ Frequently Asked Questions</h3>
                <div class="accordion shadow-sm rounded-4 overflow-hidden" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                Bagaimana cara membuat pengaduan?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
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
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
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
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pengaduan Anda akan ditangani oleh <strong>Petugas</strong> yang ditunjuk dan diverifikasi oleh <strong>Admin</strong>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Alur Pengaduan --}}
<section class="alur-section py-5">
    <div class="container">
        <div class="bg-white shadow-lg rounded-4 p-5">
            <h3 class="fw-bold text-center mb-5 text-dark">Alur Pengaduan</h3>
            <div class="alur-wrapper fade-in">
                <div class="row text-center justify-content-center position-relative">
                    <div class="col-6 col-md-3">
                        <div class="alur-step">
                            <div class="alur-icon text-primary">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>
                            <h6 class="fw-semibold mt-2">1. Login / Register</h6>
                            <p class="text-muted small">Masuk atau daftar akun terlebih dahulu untuk mulai membuat pengaduan.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="alur-step">
                            <div class="alur-icon text-success">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <h6 class="fw-semibold mt-2">2. Buat Pengaduan</h6>
                            <p class="text-muted small">Klik tombol <strong>Buat Pengaduan</strong> dan isi form dengan jelas.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="alur-step">
                            <div class="alur-icon text-warning">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <h6 class="fw-semibold mt-2">3. Diverifikasi</h6>
                            <p class="text-muted small">Pengaduan akan diverifikasi dan ditangani oleh <strong>Petugas</strong>.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="alur-step">
                            <div class="alur-icon text-info">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h6 class="fw-semibold mt-2">4. Selesai</h6>
                            <p class="text-muted small">Status laporan dapat dipantau hingga pengaduan <strong>selesai</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bottom Bar (Mobile) --}}
<div class="bottom-bar bg-white border-top shadow-sm fixed-bottom">
    <div class="d-flex justify-content-between align-items-center px-3 py-2">

        {{-- Logo --}}
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="60" height="60" class="me-2">
        </div>

    {{-- Menu --}}
    <div class="d-flex justify-content-around flex-grow-1 text-center mx-3">
        <a href="https://www.instagram.com/fdball_" target="_blank" class="text-decoration-none text-primary mx-2">
            <i class="bi bi-instagram fs-4"></i>
            <div class="small">Instagram</div>
        </a>
        <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none text-success mx-2">
            <i class="bi bi-whatsapp fs-4"></i>
            <div class="small">WhatsApp</div>
        </a>
        @auth('masyarakat')
            <a href="{{ route('pengaduan.index') }}" class="text-decoration-none text-dark mx-2">
                <i class="bi bi-journal-text fs-4"></i>
                <div class="small">Pengaduan</div>
            </a>
        @else
            <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" class="text-decoration-none text-secondary mx-2">
                <i class="bi bi-box-arrow-in-right fs-4"></i>
                <div class="small">Login</div>
            </a>
        @endauth

        {{-- Email (direct to Gmail compose) --}}
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=lavviet20@gmail.com" 
        target="_blank" 
        class="text-decoration-none small text-muted mx-2">
            <i class="bi bi-envelope-fill me-1"></i>
            lavviet20@gmail.com
        </a>
    </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
/* Fade-in Animation */
.fade-in { animation: fadeInUp 1s ease; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hero Image Floating Effect */
.hero-img { animation: float 3s ease-in-out infinite; }
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Statistik Card */
.stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}
.stat-card i { transition: transform 0.3s ease; }
.stat-card:hover i { transform: scale(1.2); }

/* Tombol Hero Modern */
.btn-primary, .btn-outline-primary { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.btn-primary:hover, .btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Alur Section */
.alur-wrapper { position: relative; }
.alur-wrapper::before {
    content: "";
    position: absolute;
    top: 30px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: #dee2e6;
    z-index: 0;
}
.alur-step { position: relative; z-index: 1; padding: 0 10px; }
.alur-icon {
    width: 60px;
    height: 60px;
    background: #fff;
    border: 3px solid currentColor;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    margin: 0 auto;
    transition: all 0.3s ease;
}
.alur-icon:hover {
    background: currentColor;
    color: #fff;
    transform: scale(1.1);
}

/* Bottom Bar */
.bottom-bar a {
    flex: 1;
    text-align: center;
    color: inherit;
}
.bottom-bar i {
    display: block;
    line-height: 1;
}
.bottom-bar div.small {
    font-size: 12px;
}
</style>

@endsection
