@extends('admin.layouts.app')

@section('title', 'Manajemen Petugas')

@section('content')
<div class="container-fluid py-3">

    {{-- Header Card --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-journal-text fs-4 text-primary"></i>
                <h5 class="mb-0 fw-bold text-primary">Register Petugas & Admin</h5>
            </div>

            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-primary rounded-pill px-4 action-btn shadow-sm" data-bs-toggle="modal" data-bs-target="#addPetugasModal">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Petugas
                </button>
            </div>
        </div>
    </div>

    {{-- Card Daftar Petugas --}}
    <div class="row g-3">
        @forelse($petugas as $p)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm modern-card p-3 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        {{-- Avatar / Logo Orang --}}
                        <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width:50px; height:50px;">
                            <i class="bi bi-person-fill fs-4"></i>
                        </div>
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
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-warning btn-sm action-btn w-100" data-bs-toggle="modal" data-bs-target="#editPetugasModal{{ $p->id_petugas }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.register.destroy',$p->id_petugas) }}" method="POST" class="w-100" onsubmit="return confirm('Yakin hapus petugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm action-btn w-100">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Edit Petugas --}}
            <div class="modal fade" id="editPetugasModal{{ $p->id_petugas }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="text-center mb-3">
                            <h5 class="fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Petugas/Admin</h5>
                        </div>
                        <form action="{{ route('admin.register.update', $p->id_petugas) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="text" name="nama_petugas" class="form-control form-control-lg" value="{{ $p->nama_petugas }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control form-control-lg" value="{{ $p->username }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Kosongkan jika tidak diganti">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="telepon" class="form-control form-control-lg" value="{{ $p->telepon }}" required>
                            </div>
                            <div class="mb-3">
                                <select name="level" class="form-select form-select-lg" required>
                                    <option value="petugas" {{ $p->level == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="admin" {{ $p->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 action-btn">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada petugas terdaftar.</p>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Petugas --}}
<div class="modal fade" id="addPetugasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            {{-- Header --}}
            <div class="modal-header bg-primary text-white rounded-top p-3">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Petugas/Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form action="{{ route('admin.register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="nama_petugas" class="form-control form-control-lg rounded-3" placeholder="Nama Petugas" value="{{ old('nama_petugas') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control form-control-lg rounded-3" placeholder="Username" value="{{ old('username') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg rounded-3" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="telepon" class="form-control form-control-lg rounded-3" placeholder="Telepon" value="{{ old('telepon') }}" required>
                    </div>
                    <div class="mb-3">
                        <select name="level" class="form-select form-select-lg rounded-3" required>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 action-btn shadow-sm">
                            <i class="bi bi-check-lg me-2"></i> Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
/* Card Modern */
.modern-card {
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.modern-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Tombol Aksi */
.action-btn {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Avatar / Logo Petugas */
.avatar i {
    font-size: 1.5rem;
}
</style>
@endsection
