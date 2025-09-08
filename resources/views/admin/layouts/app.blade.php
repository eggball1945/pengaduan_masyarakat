<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel - Pengaduan Masyarakat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { overflow-x: hidden; background: #f5f6fa; }
        /* Sidebar */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 20px;
        }
        /* Konten utama */
        .content {
            margin-left: 250px;
            padding: 30px;
        }
        /* Navbar modern */
        .navbar-custom {
            margin-left: 250px;
            background: linear-gradient(90deg, #0d6efd, #0b5ed7);
            color: #fff;
            padding: 12px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .navbar-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #fff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        @include('admin.layouts.sidebar')
    </div>

    {{-- Navbar atas --}}
    <div class="navbar-custom d-flex justify-content-between align-items-center">
        <h5 class="navbar-title">@yield('title')</h5>

        @if(Auth::guard('petugas')->check() || Auth::guard('admin')->check())
            <div class="dropdown">
                <div class="user-menu dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->nama_petugas ?? Auth::user()->nama_admin, 0, 1)) }}
                    </div>
                    <span class="fw-semibold">
                        {{ Auth::guard('petugas')->check() ? Auth::guard('petugas')->user()->nama_petugas : Auth::guard('admin')->user()->nama_petugas }}
                    </span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li class="dropdown-header">
                        <small class="text-muted">
                            {{ Auth::guard('petugas')->check() ? Auth::guard('petugas')->user()->level : 'Admin' }}
                        </small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ Auth::guard('petugas')->check() ? route('petugas.logout') : route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
    </div>

    {{-- Konten utama --}}
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
