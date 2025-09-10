@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-3">

    {{-- Ringkasan Statistik --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card text-white shadow-sm rounded-4" style="background-color: #4facfe;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-white text-primary rounded-circle me-3 shadow-sm">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Total Pengaduan</h6>
                        <h3 class="mb-0">{{ $pengaduans->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-dark shadow-sm rounded-4" style="background-color: #fddb92;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-warning text-dark rounded-circle me-3 shadow-sm">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Sedang Proses</h6>
                        <h3 class="mb-0">{{ $pengaduans->where('status','proses')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white shadow-sm rounded-4" style="background-color: #43e97b;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-success text-white rounded-circle me-3 shadow-sm">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Selesai</h6>
                        <h3 class="mb-0">{{ $pengaduans->where('status','selesai')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Header Tabel --}}
    <div class="card-body">
        <div class="mb-4 p-3 rounded-4 shadow-sm d-flex align-items-center gap-3" style="background-color:#ffffff;">
            <i class="bi bi-journal-text fs-4 text-primary"></i>
            <h5 class="mb-0 fw-bold text-primary">Data Pengaduan & Tanggapan</h5>
        </div>
    </div>

    {{-- Tabel Data Pengaduan --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive p-3">
            <table class="table align-middle modern-table">
                <thead class="table-header-modern">
                    <tr>
                        <th>NIK</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Tanggapan</th>
                        <th>Petugas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $data)
                    @php
                        $fotoList = is_null($data->foto) ? [] : json_decode($data->foto, true);
                    @endphp
                    <tr class="@if($data->status == 'proses') table-warning-subtle @elseif($data->status == 'selesai') table-success-subtle @endif">
                        <td class="fw-semibold">{{ $data->nik }}</td>
                        <td>{{ Str::limit($data->isi_laporan, 70) }}</td>
                        <td>
                            @if($data->status == '0')
                                <span class="badge bg-secondary d-flex align-items-center gap-1">
                                    <i class="bi bi-circle"></i> Belum
                                </span>
                            @elseif($data->status == 'proses')
                                <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-hourglass-split"></i> Proses
                                </span>
                            @else
                                <span class="badge bg-success d-flex align-items-center gap-1">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(count($fotoList))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($fotoList as $index => $foto)
                                        <img src="{{ asset('storage/'.$foto) }}" 
                                             class="img-thumbnail img-preview" 
                                             alt="Foto Pengaduan" 
                                             style="width:60px; height:60px;" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#fotoModal{{ $data->id_pengaduan }}_{{ $index }}">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $data->tanggapan->tanggapan ?? '-' }}</td>
                        <td>{{ $data->tanggapan->petugas->nama_petugas ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.pengaduan.destroy', $data->id_pengaduan) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Yakin hapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Foto --}}
                    @foreach($fotoList as $index => $foto)
                    <div class="modal fade" id="fotoModal{{ $data->id_pengaduan }}_{{ $index }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-body text-center p-0">
                                    <img src="{{ asset('storage/'.$foto) }}" class="img-fluid rounded" alt="Foto Pengaduan">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 mb-2"></i> Belum ada data pengaduan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
/* Card Icon */
.icon { 
    width: 60px; 
    height: 60px; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    font-size: 1.4rem;
}

/* Modern Table */
.modern-table {
    border-collapse: separate;
    border-spacing: 0 10px;
    width: 100%;
}
.modern-table thead.table-header-modern th {
    background: linear-gradient(90deg, #0d6efd33, #0b5ed733);
    color: #0d6efd;
    font-weight: 600;
    padding: 12px 15px;
    text-align: left;
    border-bottom: none;
    border-radius: 12px 12px 0 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s;
}
.modern-table thead.table-header-modern th.text-center { text-align: center; }
.modern-table thead.table-header-modern th:hover { color: #0b5ed7; }

.modern-table tbody tr {
    background-color: #ffffff;
    border-radius: 12px;
    transition: all 0.2s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.modern-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.modern-table td {
    padding: 12px 15px;
    vertical-align: middle;
}

/* Badge */
.badge {
    font-size: 0.85rem;
    border-radius: 12px;
    padding: 5px 10px;
    transition: all 0.2s;
}
.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

/* Foto preview */
.img-preview { 
    transition: transform 0.3s ease, box-shadow 0.3s ease; 
    cursor:pointer; 
    border-radius: 8px;
}
.img-preview:hover { 
    transform: scale(1.2); 
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Tombol aksi */
button.btn {
    transition: all 0.2s ease-in-out;
}
button.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.12);
}
</style>
@endsection
