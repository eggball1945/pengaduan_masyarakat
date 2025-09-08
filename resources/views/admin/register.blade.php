@extends('admin.layouts.app')

@section('title', 'Registrasi Petugas')

@section('content')
<div class="container-fluid py-5">
    {{-- Card Registrasi Petugas/Admin --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">🛡️ Registrasi Petugas/Admin</h3>
                </div>
                <form action="{{ route('admin.register.post') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="nama_petugas" class="form-control form-control-lg" placeholder="Nama Petugas" value="{{ old('nama_petugas') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" value="{{ old('username') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="telepon" class="form-control form-control-lg" placeholder="Telepon" value="{{ old('telepon') }}" required>
                        </div>
                        <div class="col-md-6">
                            <select name="level" class="form-select form-select-lg" required>
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Daftarkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Card Daftar Petugas --}}
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <h4 class="fw-semibold mb-3">Daftar Petugas & Admin</h4>
        <div class="row g-3">
            @forelse($petugas as $p)
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3 hover-shadow h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $p->nama_petugas }}</h5>
                                <p class="text-muted mb-1">
                                    <strong>Username:</strong> {{ $p->username }}<br>
                                    <strong>Telepon:</strong> {{ $p->telepon }}<br>
                                    <strong>Level:</strong> 
                                    @if($p->level=='admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-primary">Petugas</span>
                                    @endif
                                </p>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('admin.register.edit', $p->id_petugas) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.register.destroy',$p->id_petugas) }}" method="POST" onsubmit="return confirm('Yakin hapus petugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada petugas terdaftar.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
.hover-shadow:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    transition: 0.3s;
}
</style>
@endsection
