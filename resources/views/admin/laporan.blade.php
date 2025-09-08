@extends(Auth::guard('admin')->check() ? 'admin.layouts.app' : 'admin.layouts.app')
{{-- Bisa tetap pakai admin.layouts.app untuk petugas agar tidak perlu buat folder baru --}}

@section('title', 'Verifikasi & Laporan')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">📑 Verifikasi & Laporan</h3>
                {{-- Tombol export hanya untuk admin --}}
                @if(Auth::guard('admin')->check())
                <div>
                    <a href="{{ route('admin.laporan.export.pdf') }}" class="btn btn-sm btn-danger me-2">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.laporan.export.excel') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </a>
                </div>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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
                        <tr class="@if($data->status == 'proses') table-warning @elseif($data->status == 'selesai') table-success-subtle @endif">
                            <td class="fw-semibold">{{ $data->nik }}</td>
                            <td>{{ Str::limit($data->isi_laporan, 80) }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_pengaduan)->format('Y-m-d') }}</td>
                            <td>
                                @if($data->tanggapan)
                                    {{ $data->tanggapan->tanggapan }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($data->tanggapan->tgl_tanggapan)->format('Y-m-d') }}
                                    </small>
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
                                {{-- Tombol verifikasi --}}
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

                                {{-- Tombol selesaikan --}}
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
</div>
@endsection
