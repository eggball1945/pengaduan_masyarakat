@extends(Auth::guard('admin')->check() ? 'admin.layouts.app' : 'admin.layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid py-3">

    {{-- Header Card --}}
    <div class="card-body">
        <div class="mb-4 p-3 rounded-4 shadow-sm d-flex justify-content-between align-items-center" style="background-color:#ffffff;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check2-circle fs-4 text-primary"></i>
                <h5 class="mb-0 fw-bold text-primary">Laporan</h5>
            </div>

            @if(Auth::guard('admin')->check())
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
            @endif
        </div>
    </div>

    <!-- {{-- Tabel Modern --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table modern-table align-middle">
                    <thead class="table-header-modern">
                        <tr>
                            <th>NIK</th>
                            <th>Isi Pengaduan</th>
                            <th>Tanggal</th>
                            <th>Tanggapan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $data)
                        <tr class="@if($data->status == 'proses') table-warning-subtle @elseif($data->status == 'selesai') table-success-subtle @endif">
                            <td class="fw-semibold">{{ $data->nik }}</td>
                            <td>{{ Str::limit($data->isi_laporan, 80) }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_pengaduan)->format('Y-m-d') }}</td>
                            <td>
                                @if($data->tanggapan)
                                    {{ $data->tanggapan->tanggapan }}
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($data->tanggapan->tgl_tanggapan)->format('Y-m-d') }}</small>
                                @else
                                    <span class="text-danger">Belum ada tanggapan</span>
                                @endif
                            </td>
                            <td>
                                @if($data->status === '0')
                                    <span class="badge bg-secondary d-flex align-items-center gap-1">
                                        <i class="bi bi-circle"></i> Belum
                                    </span>
                                @elseif($data->status === 'proses')
                                    <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                        <i class="bi bi-hourglass-split"></i> Proses
                                    </span>
                                @elseif($data->status === 'selesai')
                                    <span class="badge bg-success d-flex align-items-center gap-1">
                                        <i class="bi bi-check-circle"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Verifikasi --}}
                                @if($data->status === '0')
                                    <form action="{{ Auth::guard('admin')->check() 
                                        ? route('admin.pengaduan.verifikasi', $data->id_pengaduan) 
                                        : route('petugas.pengaduan.verifikasi', $data->id_pengaduan) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-check2"></i> Verifikasi
                                        </button>
                                    </form>
                                @endif

                                {{-- Selesaikan --}}
                                @if($data->status !== 'selesai')
                                    <form action="{{ Auth::guard('admin')->check() 
                                        ? route('admin.pengaduan.selesai', $data->id_pengaduan) 
                                        : route('petugas.pengaduan.selesai', $data->id_pengaduan) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill">
                                            <i class="bi bi-check-circle"></i> Selesaikan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada laporan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->

{{-- Custom CSS --}}
<style>
/* Modern Table */
.modern-table {
    border-collapse: separate;
    border-spacing: 0 8px;
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
.modern-table thead.table-header-modern th:hover {
    background: linear-gradient(90deg, #0d6efd55, #0b5ed755);
    color: #0b5ed7;
}

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
}

/* Tombol aksi */
button.btn {
    transition: all 0.2s ease-in-out;
}
button.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.12);
}

/* Header Card */
.card-body > .d-flex {
    background-color: #ffffff;
    padding: 10px 15px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
</style>
@endsection
