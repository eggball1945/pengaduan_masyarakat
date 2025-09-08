{{-- Sidebar Modern --}}
<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm rounded-3" style="min-height: 100vh;">
    {{-- Panel Title --}}
    <a href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('petugas.dashboard') }}" 
       class="d-flex align-items-center mb-4 text-decoration-none">
        <i class="bi bi-speedometer2 fs-4 text-primary me-2"></i>
        <span class="fs-5 fw-bold text-primary">
            {{ Auth::guard('admin')->check() ? 'Admin Panel' : 'Petugas Panel' }}
        </span>
    </a>
    <hr>

    {{-- Navigation --}}
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('petugas.dashboard') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.dashboard' : 'petugas.dashboard') ? 'active' : 'text-dark' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        {{-- Verifikasi & Laporan --}}
        <li class="nav-item mb-2">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.laporan') : route('petugas.laporan') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.laporan' : 'petugas.laporan') ? 'active' : 'text-dark' }}">
                <i class="bi bi-check2-circle me-2"></i> Verifikasi & Laporan
            </a>
        </li>

        {{-- Tanggapan --}}
        <li class="nav-item mb-2">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.tanggapan.index') : route('petugas.tanggapan.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.tanggapan.*' : 'petugas.tanggapan.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-chat-left-text me-2"></i> Berikan Tanggapan
            </a>
        </li>

        {{-- Register Petugas (khusus admin) --}}
        @if(Auth::guard('admin')->check())
        <li class="nav-item mb-2">
            <a href="{{ route('admin.register') }}" 
                class="nav-link d-flex align-items-center {{ request()->routeIs('admin.register') || request()->routeIs('admin.register.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-person-plus me-2"></i> Register Petugas
            </a>
        </li>
        @endif
    </ul>
    <hr>

    {{-- Tombol Logout --}}
    <form action="{{ Auth::guard('admin')->check() ? route('admin.logout') : route('petugas.logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center 
            {{ Auth::guard('admin')->check() ? 'btn-outline-danger' : 'btn-outline-warning' }}">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</div>
