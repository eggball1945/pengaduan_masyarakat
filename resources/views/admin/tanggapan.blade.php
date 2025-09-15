@extends('admin.layouts.app')

@section('title', 'Tanggapan')

@section('content')
<div class="container py-3">
    {{-- Header Card --}}
    <div class="card-body">
        <div class="mb-4 p-3 rounded-4 shadow-sm d-flex align-items-center gap-3" style="background-color:#ffffff;">
            <i class="bi bi-journal-text fs-4 text-primary"></i>
            <h5 class="mb-0 fw-bold text-primary">Data Tanggapan Pengaduan</h5>
        
        <div class="d-flex gap-2">
                <a href="{{ route('admin.laporan.export.pdf') }}" 
                   class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 rounded-pill shadow-sm"
                   style="transition: all 0.2s;">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.laporan.export.excel') }}" 
                   class="btn btn-outline-success btn-sm d-flex align-items-center gap-1 rounded-pill shadow-sm"
                   style="transition: all 0.2s;">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
        </div>    
        </div>
    </div>

    @php
        $guard = auth()->guard('admin')->check() ? 'admin' : 'petugas';
    @endphp

    @forelse($pengaduans as $data)
    @php $fotoList = json_decode($data->foto) ?? []; @endphp

    {{-- Card Pengaduan --}}
    <div class="card shadow-sm mb-3 modern-card border-0">
        {{-- Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-white shadow-sm rounded-3">
            <div class="d-flex align-items-center gap-2">
                <strong>NIK:</strong> {{ $data->nik }}
                <span class="badge 
                    @if($data->status == '0') bg-secondary
                    @elseif($data->status == 'proses') bg-warning text-dark
                    @else bg-success @endif
                    d-flex align-items-center gap-1">
                    @if($data->status == '0') <i class="bi bi-circle"></i> Belum
                    @elseif($data->status == 'proses') <i class="bi bi-hourglass-split"></i> Proses
                    @else <i class="bi bi-check-circle"></i> Selesai @endif
                </span>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-primary rounded-pill action-btn shadow-sm" data-bs-toggle="modal" data-bs-target="#tanggapanModal{{ $data->id_pengaduan }}">
                    {{ $data->tanggapan ? 'Edit Tanggapan' : 'Tambah Tanggapan' }}
                </button>

                <button class="btn btn-sm btn-warning rounded-pill action-btn shadow-sm" data-bs-toggle="modal" data-bs-target="#statusModal{{ $data->id_pengaduan }}">
                    Ubah Status
                </button>

                @if($data->tanggapan)
                <form action="{{ route($guard.'.tanggapan.destroy', $data->tanggapan->id_tanggapan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tanggapan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger rounded-pill action-btn shadow-sm">Hapus Tanggapan</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Konten --}}
        <div class="card-body">
            <p class="mb-1 fw-semibold">Isi Laporan:</p>
            <div class="border rounded p-3 bg-light mb-2">{{ $data->isi_laporan }}</div>

            @if(count($fotoList))
            <div class="d-flex flex-wrap gap-2 mb-2">
                @foreach($fotoList as $index => $foto)
                    <img src="{{ asset('storage/'.$foto) }}" 
                        class="img-thumbnail img-preview rounded-3 shadow-sm" 
                        style="width:120px;height:120px;object-fit:cover;cursor:pointer;"
                        data-bs-toggle="modal" 
                        data-bs-target="#fotoModal" 
                        data-src="{{ asset('storage/'.$foto) }}">
                @endforeach
            </div>
            @endif

            <p class="mb-1 fw-semibold">Tanggapan:</p>
            <div class="border rounded p-2 bg-light mb-2">{{ $data->tanggapan->tanggapan ?? '-' }}</div>

            <p class="mb-0"><strong>Petugas:</strong> {{ $data->tanggapan->petugas->nama_petugas ?? '-' }}</p>
        </div>
    </div>

    {{-- Modal Tambah/Edit Tanggapan --}}
    <div class="modal fade" id="tanggapanModal{{ $data->id_pengaduan }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route($guard.'.tanggapan.update', $data->id_pengaduan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $data->tanggapan ? 'Edit Tanggapan' : 'Tambah Tanggapan' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>NIK</label>
                            <input type="text" class="form-control" value="{{ $data->nik }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Isi Laporan</label>
                            <textarea class="form-control" readonly>{{ $data->isi_laporan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tanggapan</label>
                            <textarea name="tanggapan" class="form-control" required>{{ $data->tanggapan->tanggapan ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ubah Status --}}
    <div class="modal fade" id="statusModal{{ $data->id_pengaduan }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route($guard.'.tanggapan.status', $data->id_pengaduan) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select name="status" class="form-select" required>
                            <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Belum</option>
                            <option value="proses" {{ $data->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $data->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
    <div class="alert alert-info shadow-sm rounded-4">Belum ada data pengaduan</div>
    @endforelse
</div>

{{-- Modal Foto Global --}}
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid rounded" alt="Foto Pengaduan">
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Foto Preview */
.img-preview {
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.img-preview:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    cursor: pointer;
}
</style>

{{-- JS Modal Foto --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalImage = document.getElementById('modalImage');
    document.querySelectorAll('.img-preview').forEach(img => {
        img.addEventListener('click', function() {
            modalImage.src = this.dataset.src;
        });
    });
});
</script>
@endsection
