@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')

@auth('masyarakat')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Header Actions --}}
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm shadow-sm rounded-pill">
                    <i class="bi bi-house-door-fill me-1"></i> Home
                </a>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm rounded-pill">
                    <i class="bi bi-list-ul me-1"></i> Data Pengaduan
                </a>
            </div>

            {{-- Card Form --}}
            <div class="card shadow-lg border-0 rounded-4" style="background: linear-gradient(135deg, #f0f8ff, #ffffff);">
                <div class="card-body p-5">
                    <h4 class="mb-4 fw-bold text-center text-primary">
                        <i class="bi bi-chat-dots-fill me-2"></i> Formulir Pengaduan
                    </h4>

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Isi Laporan --}}
                        <div class="mb-4">
                            <label for="isi_laporan" class="form-label fw-semibold">Isi Laporan</label>
                            <textarea name="isi_laporan"
                                      class="form-control form-control-lg rounded-3 shadow-sm border-0"
                                      id="isi_laporan"
                                      rows="5"
                                      placeholder="Tulis laporan Anda di sini..."
                                      required
                                      style="transition: box-shadow 0.3s; resize:none;"
                                      onfocus="this.style.boxShadow='0 0 12px rgba(0,123,255,0.4)';"
                                      onblur="this.style.boxShadow='0 0 8px rgba(0,0,0,0.1)';"
                            >{{ old('isi_laporan') }}</textarea>
                        </div>

                        {{-- Upload Foto Multi --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Foto (Opsional)</label>
                            <div class="card border-0 shadow-sm rounded-3 p-3" style="background-color:#f9f9f9;">
                                <input type="file" id="foto" name="foto[]" accept="image/*" multiple class="form-control mb-3" onchange="handleFiles(this.files)">
                                <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" style="transition: transform 0.2s;">
                                <i class="bi bi-send-fill me-1"></i> Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script Preview Multiple Files --}}
<script>
let filesArray = [];

function handleFiles(selectedFiles) {
    for (let i = 0; i < selectedFiles.length; i++) {
        filesArray.push(selectedFiles[i]);
    }
    updatePreview();
}

function updatePreview() {
    const previewContainer = document.getElementById('previewContainer');
    const input = document.getElementById('foto');
    previewContainer.innerHTML = '';

    filesArray.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'position-relative shadow-sm rounded overflow-hidden';
            div.style.width = '100px';
            div.style.height = '100px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid h-100 w-100 object-fit-cover';
            div.appendChild(img);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle';
            btn.style.fontSize = '0.7rem';
            btn.style.padding = '0.2rem 0.45rem';
            btn.innerHTML = '&times;';
            btn.onclick = function() { removeFile(index); };
            div.appendChild(btn);

            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });

    const dt = new DataTransfer();
    filesArray.forEach(file => dt.items.add(file));
    input.files = dt.files;
}

function removeFile(index) {
    filesArray.splice(index, 1);
    updatePreview();
}
</script>

{{-- Style --}}
<style>
#previewContainer div:hover {
    transform: scale(1.05);
    transition: transform 0.2s;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
</style>

@else
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-warning text-center shadow-sm rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Silakan login terlebih dahulu untuk mengirim pengaduan.
            </div>
        </div>
    </div>
</div>
@endauth

@endsection
