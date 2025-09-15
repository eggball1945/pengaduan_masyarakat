{{-- Sidebar Modern dengan Efek Hover & Aktif --}}
<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm rounded-3 sidebar-modern" style="min-height: 100vh; width: 240px;">
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
    <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('petugas.dashboard') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.dashboard' : 'petugas.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> <span>Dashboard</span>
            </a>
        </li>

        
        {{-- Tanggapan --}}
        <li class="nav-item mb-2">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.tanggapan.index') : route('petugas.tanggapan.index') }}" 
            class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.tanggapan.*' : 'petugas.tanggapan.*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text me-2"></i> <span class="menu-text">Berikan Tanggapan</span>
        </a>
    </li>
    
    <!-- {{-- Verifikasi & Laporan --}}
    <li class="nav-item mb-2">
        <a href="{{ Auth::guard('admin')->check() ? route('admin.laporan') : route('petugas.laporan') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs(Auth::guard('admin')->check() ? 'admin.laporan' : 'petugas.laporan') ? 'active' : '' }}">
            <i class="bi bi-check2-circle me-2"></i> <span class="menu-text">Verifikasi & Laporan</span>
        </a>
    </li> -->
    
        {{-- Register Petugas (khusus admin) --}}
        @if(Auth::guard('admin')->check())
        <li class="nav-item mb-2">
            <a href="{{ route('admin.register') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.register') || request()->routeIs('admin.register.*') ? 'active' : '' }}">
                <i class="bi bi-person-plus me-2"></i> <span class="menu-text">Manajemen Petugas</span>
            </a>
        </li>
        @endif
    </ul>
    <hr>

    {{-- Tombol Logout --}}
    <form action="{{ Auth::guard('admin')->check() ? route('admin.logout') : route('petugas.logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center logout-btn">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</div>

{{-- Custom CSS Modern Sidebar --}}
<style>
.sidebar-modern {
    transition: all 0.3s ease;
}

.sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #495057;
    font-weight: 500;
    padding: 0.55rem 0.75rem;
    border-radius: 0.6rem;
    transition: all 0.3s ease;
}

/* khusus teks menu */
.sidebar-nav .nav-link .menu-text {
    font-size: 0.88rem;      /* sedikit lebih kecil */
    white-space: nowrap;     /* biar gak turun ke bawah */
}

.sidebar-nav .nav-link i {
    font-size: 1.2rem;
    transition: transform 0.3s ease, color 0.3s ease;
}

.sidebar-nav .nav-link:hover {
    background-color: #e7f1ff;
    color: #0d6efd;
    transform: translateX(5px);
}

.sidebar-nav .nav-link.active {
    background-color: #0d6efd;
    color: #fff !important;
    font-weight: 600;
}

.sidebar-nav .nav-link.active i {
    transform: scale(1.2);
    color: #fff !important;
}

.logout-btn {
    background-color: #fff;
    border: 2px solid #f03e3e;
    color: #f03e3e;
    font-weight: 600;
    padding: 0.55rem 0;
    border-radius: 0.6rem;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background-color: #f03e3e;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
