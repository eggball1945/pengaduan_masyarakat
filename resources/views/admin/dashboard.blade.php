@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        {{-- Ringkasan Statistik --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon bg-primary text-white rounded-circle p-3 me-3">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Total Pengaduan</h6>
                            <h4 class="mb-0">{{ $pengaduans->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon bg-warning text-dark rounded-circle p-3 me-3">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Sedang Proses</h6>
                            <h4 class="mb-0">{{ $pengaduans->where('status','proses')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon bg-success text-white rounded-circle p-3 me-3">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Selesai</h6>
                            <h4 class="mb-0">{{ $pengaduans->where('status','selesai')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Pengaduan --}}
        <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h3 class="mb-4">📊 Data Pengaduan & Tanggapan</h3>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">NIK</th>
                            <th>Isi Laporan</th>
                            <th>Status</th>
                            <th>Tanggapan</th>
                            <th>Petugas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $data)
                            <tr class="
                                @if($data->status == 'proses') table-warning
                                @elseif($data->status == 'selesai') table-success-subtle
                                @endif
                            ">
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
                                <td>{{ $data->tanggapan->tanggapan ?? '-' }}</td>
                                <td>{{ $data->tanggapan->petugas->nama_petugas ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- Tombol Edit --}}
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id_pengaduan }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Tombol Delete --}}
                                    <form action="{{ route('admin.pengaduan.destroy', $data->id_pengaduan) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"
                                                onclick="return confirm('Yakin hapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data pengaduan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
