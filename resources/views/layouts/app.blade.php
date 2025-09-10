<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Pengaduan Masyarakat')</title>
<link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* ===== Global ===== */
body { 
    background-color: #f5f7fa; 
    color: #212529; 
    display: flex; 
    flex-direction: column; 
    min-height: 100vh; 
    font-family: 'Inter', sans-serif; 
    line-height: 1.6;
}
main, .container.mt-4 { flex: 1 0 auto; }

/* ===== Navbar ===== */
.navbar { 
    background-color: #fff; 
    box-shadow: 0 2px 6px rgba(0,0,0,0.05); 
}

/* ===== Buttons Soft ===== */
.btn-soft-primary, .btn-soft-secondary {
    font-weight: 500; 
    transition: all 0.25s ease, box-shadow 0.3s ease;
}
.btn-soft-primary {
    background: linear-gradient(135deg, #5b8efc, #497ae0);
    color: #fff; 
    border-radius: 50px;
    box-shadow: 0 4px 12px rgba(91,142,252,0.2);
}
.btn-soft-primary:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 8px 20px rgba(73,122,224,0.3);
}
.btn-soft-secondary {
    background-color: #e0e0e0; 
    color: #333; 
    border-radius: 50px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.btn-soft-secondary:hover { 
    transform: translateY(-1px); 
    background-color: #c7c7c7; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

/* ===== Cards ===== */
.card { 
    border-radius: 16px; 
    transition: transform 0.3s ease, box-shadow 0.3s ease; 
    background-color: #fff;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.08);
}

/* ===== Form Floating Input Focus ===== */
.form-floating input:focus, 
.form-floating textarea:focus, 
.input-group .form-control:focus {
    border-color: #5b8efc; 
    box-shadow: 0 0 15px rgba(91,142,252,0.25);
    outline: none;
}
.input-group-text {
    background-color: #5b8efc; 
    color: #fff; 
    border: none; 
    border-radius: 0.5rem 0 0 0.5rem; 
    transition: all 0.25s ease;
}
.input-group-text:hover {
    background-color: #497ae0;
}

/* ===== Footer ===== */
footer {
    flex-shrink: 0;
    background-color: #fff;
    padding: 1rem 0;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    font-size: 0.9rem;
}
footer a {
    transition: color 0.25s ease;
    color: #6c757d;
}
footer a:hover { 
    color: #5b8efc; 
}

/* ===== Modal Auth ===== */
#authModal .modal-content {
    border-radius: 20px;
    transition: all 0.3s ease;
    padding: 2rem;
}
#authModal .modal-content h5 {
    font-weight: 600;
    color: #5b8efc;
}
#authModal form { 
    transition: opacity 0.3s ease, transform 0.3s ease; 
}
#authModal form.d-none { 
    opacity: 0; 
    transform: scale(0.95); 
    height: 0; 
    overflow: hidden; 
    pointer-events: none; 
}
#authModal form:not(.d-none) {
    opacity: 1;
    transform: scale(1);
    height: auto;
    pointer-events: auto;
}

/* ===== Responsive Enhancements ===== */
@media (max-width: 576px) {
    .btn-soft-primary, .btn-soft-secondary { font-size: 0.9rem; padding: 0.5rem 1.5rem; }
    .card { border-radius: 12px; }
}
</style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            <i class="bi bi-megaphone-fill me-2"></i> Pengaduan Masyarakat
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @if(Auth::guard('masyarakat')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{-- Avatar Bulat --}}
                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2" 
                                style="width:32px; height:32px; font-size:0.9rem; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                                {{ strtoupper(substr(Auth::guard('masyarakat')->user()->nama,0,1)) }}
                            </div>
                            <span class="fw-semibold">{{ Auth::guard('masyarakat')->user()->nama }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 border-0" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('pengaduan.index') }}">
                                    <i class="bi bi-list-task fs-5 text-primary"></i>
                                    <span>Data Pengaduan</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                        <i class="bi bi-box-arrow-right fs-5"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else

                    <li class="nav-item me-2">
                        <button id="btnLoginNavbar" class="btn btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#authModal">Login</button>
                    </li>
                    <li class="nav-item">
                        <button id="btnRegisterNavbar" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#authModal">Register</button>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<div class="container mt-4 flex-grow-1">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</div>

{{-- Footer Minimalis hanya untuk Home --}}
@if(Route::currentRouteName() == 'home')
<footer class="bg-white shadow-sm mt-auto py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center gap-3">

        {{-- Teks SMK Citra Negara --}}
        <div class="mb-2 mb-md-0 text-primary fw-semibold">
            SMK Citra Negara
        </div>

        {{-- Links --}}
        <div class="d-flex gap-3 mb-2 mb-md-0">
            <a href="https://wa.me/6289630786654" target="_blank" class="text-muted d-flex align-items-center gap-1">
                <i class="bi bi-whatsapp fs-5"></i>
            </a>
            <a href="https://instagram.com/fdball_" target="_blank" class="text-muted d-flex align-items-center gap-1">
                <i class="bi bi-instagram fs-5"></i>
            </a>
            <a href="{{ route('home') }}" class="text-muted d-flex align-items-center gap-1">
                <i class="bi bi-house-door-fill fs-5"></i>
            </a>
            <a href="{{ route('pengaduan.index') }}" class="text-muted d-flex align-items-center gap-1">
                <i class="bi bi-list-ul fs-5"></i>
            </a>
        </div>

        {{-- Copyright --}}
        <div class="text-muted small text-center text-md-end mt-2 mt-md-0">
            &copy; Pengaduan Masyarakat {{ date('Y') }}
        </div>

    </div>
</footer>
@endif


{{-- Modal Auth Modern dengan Logo di Input --}}
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content p-4 rounded-4 shadow-lg">

            {{-- Title --}}
            <h5 class="text-center mb-4 fw-bold" id="authTitle">Login Masyarakat</h5>

            {{-- Login Form --}}
            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <input name="nik" type="text" class="form-control rounded-end" placeholder="NIK" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input name="password" type="password" class="form-control rounded-end" placeholder="Password" required>
                </div>
                <div class="text-end mb-3">
                    <a href="#" id="showRegisterFromLogin" class="small text-decoration-none">Tidak punya akun? Register</a>
                </div>
                <button type="submit" class="btn btn-soft-primary w-100 shadow-sm rounded-pill py-2">Login</button>
            </form>

            <hr class="my-4">

            {{-- Register Form --}}
            <form id="registerForm" action="{{ route('register') }}" method="POST" class="d-none">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <input name="nik" type="text" class="form-control rounded-end" placeholder="NIK" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <input name="nama" type="text" class="form-control rounded-end" placeholder="Nama Lengkap" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-person-badge-fill"></i>
                    </span>
                    <input name="username" type="text" class="form-control rounded-end" placeholder="Username" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input name="password" type="password" class="form-control rounded-end" placeholder="Password" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-primary text-white rounded-start">
                        <i class="bi bi-telephone-fill"></i>
                    </span>
                    <input name="telepon" type="text" class="form-control rounded-end" placeholder="Telepon" required>
                </div>
                <div class="text-center mb-3">
                    <a href="#" id="backToLoginFromRegister" class="small text-decoration-none">Sudah punya akun? Login</a>
                </div>
                <button type="submit" class="btn btn-soft-primary w-100 shadow-sm rounded-pill py-2">Register</button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Ambil elemen
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const authTitle = document.getElementById('authTitle');
const btnLoginNavbar = document.getElementById('btnLoginNavbar');
const btnRegisterNavbar = document.getElementById('btnRegisterNavbar');
const showRegisterLink = document.getElementById('showRegisterFromLogin');
const backToLoginLink = document.getElementById('backToLoginFromRegister');

// Fungsi toggle form
function showLoginForm() {
    registerForm.classList.add('d-none');
    loginForm.classList.remove('d-none');
    authTitle.innerText = 'Login Masyarakat';
}
function showRegisterForm() {
    loginForm.classList.add('d-none');
    registerForm.classList.remove('d-none');
    authTitle.innerText = 'Register';
}

// Navbar button
btnLoginNavbar?.addEventListener('click', showLoginForm);
btnRegisterNavbar?.addEventListener('click', showRegisterForm);

// Modal link toggle
showRegisterLink?.addEventListener('click', e => { e.preventDefault(); showRegisterForm(); });
backToLoginLink?.addEventListener('click', e => { e.preventDefault(); showLoginForm(); });

// Auto show modal jika ada error
@if ($errors->any() || session('error'))
document.addEventListener('DOMContentLoaded', function() {
    const authModal = new bootstrap.Modal(document.getElementById('authModal'));
    authModal.show();
});
@endif
</script>
</body>
</html>