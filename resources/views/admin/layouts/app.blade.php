<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel - Pengaduan Masyarakat')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background: #f5f6fa;
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar Modern */
        .sidebar {
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 20px 15px;
            transition: width 0.3s ease;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #495057;
            font-weight: 500;
            padding: 0.55rem 0.75rem;
            border-radius: 0.6rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link i {
            font-size: 1.2rem;
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #e7f1ff;
            color: #0d6efd;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
            font-weight: 600;
        }
        .sidebar .nav-link.active i {
            transform: scale(1.2);
            color: #fff !important;
        }

        /* Konten utama */
        .content {
            margin-left: 240px;
            padding: 30px 35px;
            transition: margin-left 0.3s ease;
        }

        /* Navbar Modern */
        .navbar-custom {
            margin-left: 240px;
            background: #fff;
            padding: 12px 25px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 12px 12px;
        }
        .navbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: #0d6efd;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }
        .dropdown-menu {
            border-radius: 0.75rem;
            min-width: 200px;
            padding: 0.5rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .dropdown-item:hover {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        /* Scrollbar modern untuk sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 60px;
            }
            .content {
                margin-left: 60px;
                padding: 20px 15px;
            }
            .sidebar .nav-link span {
                display: none;
            }
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        @include('admin.layouts.sidebar')
    </div>

    {{-- Navbar atas --}}
    <div class="navbar-custom">
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
