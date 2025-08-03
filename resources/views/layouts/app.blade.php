<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Pengaduan Masyarakat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand text-white" href="#">Pengaduan Masyarakat</a>

    <div class="ms-auto">
        @if(Auth::check())
            <span class="me-3 text-white">Halo, {{ Auth::user()->nama }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout</button>
            </form>
        @else
            <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
        @endif
    </div>
</nav>

<div class="container mt-5">

@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('login.post') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input name="username" type="text" class="form-control mb-2" placeholder="Username" required>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('register') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input name="nik" type="text" class="form-control mb-2" placeholder="NIK" required>
        <input name="nama" type="text" class="form-control mb-2" placeholder="Nama Panjang" required>
        <input name="username" type="text" class="form-control mb-2" placeholder="Username" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
        <input name="telepon" type="text" class="form-control" placeholder="Telepon" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Register</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="adminLoginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.login') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Login Admin / Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input name="username" type="text" class="form-control mb-2" placeholder="Username" required>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Login Admin</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@if ($errors->any() || session('error'))
  <script>
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
  </script>
@endif

</body>
</html>
