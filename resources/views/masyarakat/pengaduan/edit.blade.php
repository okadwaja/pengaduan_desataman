@extends('layouts.app')

@section('content')
<div class="container px-1 text-main">
    <h1>Edit Pengaduan</h1>

    <form action="{{ route('masyarakat.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control border-left-main" value="{{ old('judul', $pengaduan->judul) }}" required>
            </div>

            <div class="form-group mb-3">
                <label>Isi Pengaduan</label>
                <textarea name="isi" class="form-control border-left-main" rows="5" required>{{ old('isi', $pengaduan->isi) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" id="foto-input" accept="image/*,.heic,.heif" onchange="previewImage(event)">
                <small class="text-muted">*Max 8Mb File:jpeg,png,jpg</small>
                
                <!-- Preview foto -->
                <div
                    id="preview-container"
                    class="d-flex overflow-auto mt-3"
                    style="{{ $pengaduan->foto ? '' : 'display: none;' }} max-width: 100%;"
                >
                    <div id="loading-spinner" style="display: none;">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <img
                        id="foto-preview"
                        src="{{ $pengaduan->foto ? asset('storage/foto_pengaduan/' . $pengaduan->foto) : '#' }}"
                        alt="Preview Foto"
                        class="img-fluid"
                        style="height: auto; border: 1px solid #ddd; padding: 5px; width: 100%; max-width: 300px;"
                    >
                </div>
            </div>


            <div class="d-flex flex-column flex-md-row gap-2">
                <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Pengaduan</button>
    `       </div>

        </form>
    </div>
@endsection

@push('scripts')
<!-- Tambahkan library heic2any -->
<script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const preview = document.getElementById('foto-preview');
    const loadingSpinner = document.getElementById('loading-spinner');

    if (!file) {
        resetPreview();
        return;
    }

    previewContainer.style.display = 'block';
    loadingSpinner.style.display = 'block';
    preview.style.display = 'none'; // Sembunyikan gambar dulu

    const fileExtension = file.name.split('.').pop().toLowerCase();

    if (fileExtension === 'heic' || fileExtension === 'heif') {
        heic2any({
            blob: file,
            toType: "image/jpeg",
            quality: 0.8,
        })
        .then(function(convertedBlob) {
            const url = URL.createObjectURL(convertedBlob);
            preview.src = url;
            loadingSpinner.style.display = 'none';
            preview.style.display = 'block';
        })
        .catch(function(error) {
            console.error(error);
            alert('Gagal menampilkan preview HEIC/HEIF. Silakan pilih file lain.');
            resetPreview();
        });
    } else if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            loadingSpinner.style.display = 'none';
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        alert('Format file tidak didukung. Mohon upload gambar JPG, PNG, atau HEIC.');
        resetPreview();
    }
}

function resetPreview() {
    const previewContainer = document.getElementById('preview-container');
    const preview = document.getElementById('foto-preview');
    const loadingSpinner = document.getElementById('loading-spinner');
    const fileInput = document.getElementById('foto-input');

    preview.src = '#';
    preview.style.display = 'none';
    loadingSpinner.style.display = 'none';
    previewContainer.style.display = 'none';
    fileInput.value = '';
}
</script>
@endpush
