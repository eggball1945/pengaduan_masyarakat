<!-- resources/views/admin/login_admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin/Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {  
            height: 100vh;
            background: linear-gradient(135deg, #f0f2f5, #dce3ec);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            animation: fadeInUp 0.8s ease forwards;
        }

        .login-card .card-header {
            background: #0d6efd;
            color: #fff;
            text-align: center;
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.15rem;
        }

        .login-card .form-control {
            border-radius: 50px;
            padding-left: 2.5rem;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #495057;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .alert {
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }

        @keyframes fadeInUp {
            0% {opacity: 0; transform: translateY(20px);}
            100% {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="card-header">
        Login Admin / Petugas
    </div>
    <div class="card-body position-relative p-4">
        <!-- Pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Pesan error -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3 position-relative">
                <i class="bi bi-person-fill input-icon"></i>
                <input 
                    type="text" 
                    name="username" 
                    class="form-control" 
                    placeholder="Username" 
                    value="{{ old('username') }}" 
                    required
                >
            </div>
            <div class="mb-3 position-relative">
                <i class="bi bi-lock-fill input-icon"></i>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Password" 
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                Login
            </button>
        </form>
    </div>
    <div class="card-footer text-center bg-light">
        <small class="text-muted">© {{ date('Y') }} Pengaduan Masyarakat</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
