<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
    <a class="navbar-brand text-white" href="#">Admin Panel</a>

    <div class="ms-auto">
        @if(Auth::guard('petugas')->check())
            <span class="me-3 text-white">Halo, {{ Auth::guard('petugas')->user()->nama_petugas }} ({{ Auth::guard('petugas')->user()->level }})</span>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout</button>
            </form>
        @else
            <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login Admin</button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register Petugas</button>
        @endif
    </div>
</nav>

<div class="container mt-4">
    <h3>Data Pengaduan & Tanggapan</h3>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Tanggapan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $data)
                <tr>
                    <td>{{ $data->nik }}</td>
                    <td>{{ $data->isi_laporan }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->tanggapan->tanggapan ?? '-' }}</td>
                    <td>{{ $data->tanggapan->petugas->nama_petugas ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Login --}}
<div class="modal fade" id="loginModal" tabindex="-1">
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
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Register --}}
<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.register') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Register Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input name="nama_petugas" type="text" class="form-control mb-2" placeholder="Nama Petugas" required>
        <input name="username" type="text" class="form-control mb-2" placeholder="Username" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
        <input name="telepon" type="text" class="form-control mb-2" placeholder="Telepon" required>
        <select name="level" class="form-control" required>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Register</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
