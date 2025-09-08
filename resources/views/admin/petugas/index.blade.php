@extends('admin.layouts.app')

@section('content')
<div class="card shadow-sm p-4">
    <h4 class="mb-3">Daftar Petugas</h4>
    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary mb-3">Tambah Petugas</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Telepon</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($petugas as $p)
            <tr>
                <td>{{ $p->nama_petugas }}</td>
                <td>{{ $p->username }}</td>
                <td>{{ $p->telepon }}</td>
                <td>{{ $p->level }}</td>
                <td>
                    <a href="{{ route('admin.petugas.edit', $p->id_petugas) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.petugas.destroy', $p->id_petugas) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus petugas ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
