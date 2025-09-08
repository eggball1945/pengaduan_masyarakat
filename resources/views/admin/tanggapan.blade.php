@extends('admin.layouts.app')

@section('title', 'Data Tanggapan')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">📝 Data Tanggapan Pengaduan</h3>

    @php
        $guard = auth()->guard('admin')->check() ? 'admin' : 'petugas';
    @endphp

    @forelse($pengaduans as $data)
    <div class="card shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>NIK:</strong> {{ $data->nik }}
                <span class="badge 
                    @if($data->status == '0') bg-secondary
                    @elseif($data->status == 'proses') bg-warning text-dark
                    @else bg-success @endif
                ms-2">
                    @if($data->status == '0') Belum
                    @elseif($data->status == 'proses') Proses
                    @else Selesai @endif
                </span>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2">
                {{-- Tambah / Edit Tanggapan --}}
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tanggapanModal{{ $data->id_pengaduan }}">
                    {{ $data->tanggapan ? 'Edit Tanggapan' : 'Tambah Tanggapan' }}
                </button>

                {{-- Ubah Status --}}
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal{{ $data->id_pengaduan }}">
                    Ubah Status
                </button>

                {{-- Hapus Tanggapan --}}
                @if($data->tanggapan)
                <form action="{{ route($guard.'.tanggapan.destroy', $data->tanggapan->id_tanggapan) }}" method="POST" onsubmit="return confirm('Yakin hapus tanggapan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus Tanggapan</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Konten Pengaduan --}}
        <div class="card-body">
            <p class="mb-2"><strong>Isi Laporan:</strong></p>
            <p class="border rounded p-2 bg-light">{{ $data->isi_laporan }}</p>

            @php $fotoList = json_decode($data->foto) ?? []; @endphp
            @if(count($fotoList))
            <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach($fotoList as $foto)
                    <img src="{{ asset('storage/'.$foto) }}" class="img-thumbnail" style="width:120px;height:120px;object-fit:cover;">
                @endforeach
            </div>
            @endif

            <p class="mb-0"><strong>Tanggapan:</strong> {{ $data->tanggapan->tanggapan ?? '-' }}</p>
            <p class="mb-0"><strong>Petugas:</strong> {{ $data->tanggapan->petugas->nama_petugas ?? '-' }}</p>
        </div>
    </div>

    {{-- Modal Tambah / Edit Tanggapan --}}
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
    <div class="alert alert-info">Belum ada data pengaduan</div>
    @endforelse
</div>

{{-- Pastikan Bootstrap JS di layout: bootstrap.bundle.min.js --}}
@endsection
