<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Pengaduan Masyarakat')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body { background-color: #f9f9f9; color: #212529; }
    .navbar { background-color: #fff; }
    .btn-soft-primary {
        background-color: #5b8efc; color: #fff; border-radius: 50px; font-weight: 500; transition: all 0.2s ease;
    }
    .btn-soft-primary:hover { background-color: #497ae0; transform: translateY(-2px); }
    .btn-soft-secondary {
        background-color: #e0e0e0; color: #333; border-radius: 50px; font-weight: 500; transition: all 0.2s ease;
    }
    .btn-soft-secondary:hover { background-color: #c7c7c7; transform: translateY(-2px); }
    .card { border-radius: 12px; }
    .form-floating input:focus { border-color: #5b8efc; box-shadow: none; }
    footer { background-color: #fff; }
</style>
</head>
<body class="d-flex flex-column min-vh-100">

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
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::guard('masyarakat')->user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('pengaduan.index') }}"><i class="bi bi-list-task me-2"></i>Data Pengaduan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
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

{{-- Main --}}
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

{{-- Footer --}}
<footer class="bg-white shadow-sm text-center py-3 mt-auto">
    <small class="text-muted">&copy; {{ date('Y') }} Pengaduan Masyarakat. All Rights Reserved.</small>
</footer>

{{-- Modal Auth --}}
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="text-center mb-4" id="authTitle">Login Masyarakat</h5>

            {{-- Login Form --}}
            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input name="nik" type="text" class="form-control" placeholder="NIK" required>
                    <label>NIK</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                    <label>Password</label>
                </div>
                <div class="text-end mb-3">
                    <a href="#" id="showRegisterFromLogin" class="small text-decoration-none">Tidak punya akun? Register</a>
                </div>
                <button type="submit" class="btn btn-soft-primary w-100 shadow-sm">Login</button>
            </form>

            {{-- Register Form --}}
            <form id="registerForm" action="{{ route('register') }}" method="POST" class="d-none">
                @csrf
                <div class="form-floating mb-3">
                    <input name="nik" type="text" class="form-control" placeholder="NIK" required>
                    <label>NIK</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="nama" type="text" class="form-control" placeholder="Nama" required>
                    <label>Nama Lengkap</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="username" type="text" class="form-control" placeholder="Username" required>
                    <label>Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                    <label>Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="telepon" type="text" class="form-control" placeholder="Telepon" required>
                    <label>Telepon</label>
                </div>
                <div class="text-center">
                    <a href="#" id="backToLoginFromRegister" class="small text-decoration-none">Sudah punya akun? Login</a>
                </div>
                <button type="submit" class="btn btn-soft-primary w-100 shadow-sm mt-3">Register</button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const authTitle = document.getElementById('authTitle');

const btnLoginNavbar = document.getElementById('btnLoginNavbar');
const btnRegisterNavbar = document.getElementById('btnRegisterNavbar');

// Navbar button Login
btnLoginNavbar.addEventListener('click', () => {
    loginForm.classList.remove('d-none');
    registerForm.classList.add('d-none');
    authTitle.innerText = 'Login Masyarakat';
});

// Navbar button Register
btnRegisterNavbar.addEventListener('click', () => {
    loginForm.classList.add('d-none');
    registerForm.classList.remove('d-none');
    authTitle.innerText = 'Register';
});

// Modal links
document.getElementById('showRegisterFromLogin').addEventListener('click', e => {
    e.preventDefault();
    loginForm.classList.add('d-none');
    registerForm.classList.remove('d-none');
    authTitle.innerText = 'Register';
});

document.getElementById('backToLoginFromRegister').addEventListener('click', e => {
    e.preventDefault();
    registerForm.classList.add('d-none');
    loginForm.classList.remove('d-none');
    authTitle.innerText = 'Login Masyarakat';
});

// Auto show modal jika ada error
@if ($errors->any() || session('error'))
const authModal = new bootstrap.Modal(document.getElementById('authModal'));
authModal.show();
@endif
</script>

</body>
</html>
