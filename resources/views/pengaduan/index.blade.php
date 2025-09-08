@extends('layouts.app')

@section('title', 'Data Pengaduan')

@section('content')
<div class="container py-5">

    {{-- Tombol Buat Pengaduan --}}
    @if(Auth::guard('masyarakat')->check())
        <div class="text-center mb-4">
            <a href="{{ route('pengaduan.create') }}" class="btn btn-lg btn-primary shadow-sm px-4 rounded-pill">
                <i class="bi bi-plus-circle me-2"></i> Buat Pengaduan
            </a>
        </div>
    @endif

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">📋 Data Pengaduan</h2>
        <p class="text-muted">Lihat, kelola, dan tindaklanjuti laporan anda.</p>
    </div>

    {{-- Card Tabel --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="pengaduanTable">
                    <thead class="bg-light">
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
                            <tr>
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td>{{ $p->nik }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d M Y') }}</td>
                                <td>{{ Str::limit($p->isi_laporan, 50) }}</td>
                                <td>
                                    @if($p->status == '0')
                                        <span class="badge bg-secondary rounded-pill">Belum Diproses</span>
                                    @elseif($p->status == 'proses')
                                        <span class="badge bg-warning text-dark rounded-pill">Proses</span>
                                    @elseif($p->status == 'selesai')
                                        <span class="badge bg-success rounded-pill">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->tanggapan)
                                        <div class="small">
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
                                    {{-- Aksi untuk masyarakat --}}
                                    @if(Auth::guard('masyarakat')->check() && $p->nik == Auth::guard('masyarakat')->user()->nik)
                                        <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="collapse" data-bs-target="#editCard{{ $p->id_pengaduan }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('pengaduan.destroy', $p->id_pengaduan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Hapus pengaduan ini?')" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                        {{-- Edit inline --}}
                                        <div class="collapse mt-2" id="editCard{{ $p->id_pengaduan }}">
                                            <div class="card card-body border shadow-sm">
                                                <form action="{{ route('pengaduan.update', $p->id_pengaduan) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="isi_laporan" class="form-control mb-2" rows="3">{{ $p->isi_laporan }}</textarea>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-check2-circle"></i> Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif(Auth::guard('petugas')->check())
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#validasiCard{{ $p->id_pengaduan }}" title="Validasi">
                                            <i class="bi bi-check-circle"></i>
                                        </button>

                                        <div class="collapse mt-2" id="validasiCard{{ $p->id_pengaduan }}">
                                            <div class="card card-body border shadow-sm">
                                                <form action="{{ route('admin.pengaduan.update', $p->id_pengaduan) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" class="form-select mb-2">
                                                        <option value="0" {{ $p->status == '0' ? 'selected' : '' }}>Belum Diproses</option>
                                                        <option value="proses" {{ $p->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                        <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                    </select>
                                                    <textarea name="tanggapan" class="form-control mb-2" rows="2">{{ $p->tanggapan->tanggapan ?? '' }}</textarea>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-check2"></i> Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif(Auth::guard('admin')->check())
                                        <span class="badge bg-light text-muted">Hanya melihat</span>
                                    @else
                                        <span class="text-muted">-</span>
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

{{-- DataTables --}}
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
@endsection
