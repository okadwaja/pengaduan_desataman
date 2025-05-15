@extends('layouts.app')

@section('content')
<div class="container px-1 text-main">
    <h1>Form Pengaduan Masyarakat</h1>
    
    <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control border-left-main" required>
        </div>

        <div class="form-group mb-3">
            <label>Isi Pengaduan</label>
            <textarea name="isi" class="form-control border-left-main" rows="5" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Foto</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*,.heic,.heif" onchange="previewImage(event)" required>

            <div id="preview-container" style="max-width: 100%; display: none;">
                <div id="loading-spinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
                <img id="preview-image"
                    src="#"
                    alt="Preview Foto"
                    class="img-fluid"
                    style="height: auto; border: 1px solid #ddd; padding: 5px; width: 100%; max-width: 300px;"
                >
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
        </div>
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
    const preview = document.getElementById('preview-image');
    const loadingSpinner = document.getElementById('loading-spinner');

    if (!file) {
        resetPreview();
        return;
    }

    previewContainer.style.display = 'block';
    loadingSpinner.style.display = 'block';
    preview.style.display = 'none'; // Sembunyikan gambar dulu

    // Mendapatkan ekstensi file
    const fileExtension = file.name.split('.').pop().toLowerCase();

    if (fileExtension === 'heic' || fileExtension === 'heif') {
        // Jika file HEIC atau HEIF
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
        // Jika file adalah gambar biasa (JPG, PNG, dll)
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            loadingSpinner.style.display = 'none';
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        // Jika file bukan gambar atau tidak sesuai format
        alert('Format file tidak didukung. Mohon upload gambar JPG, PNG, atau HEIC.');
        resetPreview();
    }
}

function resetPreview() {
    const previewContainer = document.getElementById('preview-container');
    const preview = document.getElementById('preview-image');
    const loadingSpinner = document.getElementById('loading-spinner');
    const fileInput = document.getElementById('foto');

    preview.src = '#';
    preview.style.display = 'none';
    loadingSpinner.style.display = 'none';
    previewContainer.style.display = 'none';
    fileInput.value = ''; // Reset input file
}

document.getElementById('remove-preview').addEventListener('click', function() {
    resetPreview();
});
</script>
@endpush
