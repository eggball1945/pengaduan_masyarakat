@extends('layouts.app')

@section('title', 'Data Pengaduan')

@section('content')
<div class="container py-5">

    {{-- Hero Section --}}
    @if(Auth::guard('masyarakat')->check())
        <div class="card mb-5 shadow-lg rounded-4 p-4 text-center" style="background: linear-gradient(135deg, #e0f7ff, #ffffff);">
            <h2 class="fw-bold text-primary mb-2"><i class="bi bi-journal-text me-2"></i>Data Pengaduan Anda</h2>
            <p class="text-muted fs-5 mb-3">Kelola laporan Anda dengan mudah dan cepat.</p>
            <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-primary shadow-sm rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i> Buat Pengaduan
            </a>
        </div>
    @endif

    {{-- Tabel Pengaduan --}}
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle modern-table" id="pengaduanTable">
                    <thead class="bg-light rounded-4">
                        <tr>
                            <th class="text-center">#</th>
                            <th>NIK</th>
                            <th>Tanggal</th>
                            <th>Laporan</th>
                            <th>Status</th>
                            <th>Tanggapan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduans as $index => $p)
                        <tr class="align-middle">
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d M Y') }}</td>
                            <td>{{ Str::limit($p->isi_laporan, 50) }}</td>
                            <td>
                                @php
                                    $statusClass = $p->status == '0' ? 'secondary' : ($p->status == 'proses' ? 'warning text-dark' : 'success');
                                    $statusText = $p->status == '0' ? 'Belum Diproses' : ($p->status == 'proses' ? 'Proses' : 'Selesai');
                                @endphp
                                <span class="badge bg-{{ $statusClass }} rounded-pill px-3 py-2 fw-semibold">{{ $statusText }}</span>
                            </td>
                            <td>
                                @if($p->tanggapan)
                                    <div class="small text-truncate" style="max-width: 200px;">
                                        <strong>{{ Str::limit($p->tanggapan->tanggapan, 40) }}</strong><br>
                                        <span class="text-muted fst-italic">
                                            oleh {{ $p->tanggapan->petugas->nama_petugas ?? 'Petugas' }},
                                            {{ \Carbon\Carbon::parse($p->tanggapan->tgl_tanggapan)->format('d M Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Belum ada tanggapan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(Auth::guard('masyarakat')->check() && $p->nik == Auth::guard('masyarakat')->user()->nik)
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-pill shadow-sm" data-bs-toggle="collapse" data-bs-target="#editCard{{ $p->id_pengaduan }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="{{ route('pengaduan.destroy', $p->id_pengaduan) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Hapus pengaduan ini?')" class="btn btn-sm btn-outline-danger rounded-pill shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                        <div class="collapse mt-2" id="editCard{{ $p->id_pengaduan }}">
                                            <div class="card card-body shadow-sm rounded-4 p-3 bg-light">
                                                <form action="{{ route('pengaduan.update', $p->id_pengaduan) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="isi_laporan" class="form-control mb-2" rows="3">{{ $p->isi_laporan }}</textarea>
                                                    <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                                        <i class="bi bi-check2-circle me-1"></i> Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(Auth::guard('petugas')->check())
                                    <button class="btn btn-sm btn-outline-primary rounded-pill shadow-sm" data-bs-toggle="collapse" data-bs-target="#validasiCard{{ $p->id_pengaduan }}">
                                        <i class="bi bi-check-circle me-1"></i> Validasi
                                    </button>
                                    <div class="collapse mt-2" id="validasiCard{{ $p->id_pengaduan }}">
                                        <div class="card card-body shadow-sm rounded-4 p-3 bg-light">
                                            <form action="{{ route('admin.pengaduan.update', $p->id_pengaduan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select mb-2">
                                                    <option value="0" {{ $p->status == '0' ? 'selected' : '' }}>Belum Diproses</option>
                                                    <option value="proses" {{ $p->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                                <textarea name="tanggapan" class="form-control mb-2" rows="2">{{ $p->tanggapan->tanggapan ?? '' }}</textarea>
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                                    <i class="bi bi-check2 me-1"></i> Simpan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted rounded-pill px-2 py-1">Hanya melihat</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- DataTables & Script --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    if ($('#pengaduanTable').length) {
        $('#pengaduanTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "search": "🔍 Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "«",
                    "last": "»",
                    "next": "›",
                    "previous": "‹"
                }
            }
        });
    }
});
</script>

{{-- Custom CSS --}}
<style>
/* Hover Card Tabel */
table.modern-table tbody tr:hover {
    background: #f0f8ff;
    transition: background 0.3s ease;
}

/* Collapse Card */
.card-body .collapse .card-body {
    background: #f8f9fa;
}

/* Tombol Rounded Modern */
.btn-outline-warning, .btn-outline-danger, .btn-outline-primary, .btn-success {
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-outline-warning:hover, .btn-outline-danger:hover, .btn-outline-primary:hover, .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endsection
