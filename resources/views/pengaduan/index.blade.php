@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
    <h1>Daftar Pengaduan</h1>

    @if($pengaduans->isEmpty())
        <p>Tidak ada pengaduan.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>NIK</th>
                    <th>Laporan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduans as $p)
                <tr>
                    <td>{{ $p->tgl_pengaduan }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->isi_laporan }}</td>
                    <td>{{ $p->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
