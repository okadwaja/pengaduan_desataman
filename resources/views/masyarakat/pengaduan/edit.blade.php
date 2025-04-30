@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pengaduan</h2>
    <form action="{{ route('masyarakat.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengaduan->judul) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Isi Pengaduan</label>
            <textarea name="isi" class="form-control" rows="5" required>{{ old('isi', $pengaduan->isi) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" id="foto-input" accept="image/*,.heic,.heif" onchange="previewImage(event)">

            <!-- Preview foto -->
            <div id="preview-container" style="margin-top: 10px; {{ $pengaduan->foto ? '' : 'display: none;' }}">
            <div id="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
                <img id="foto-preview" src="{{ $pengaduan->foto ? asset('storage/foto_pengaduan/' . $pengaduan->foto) : '#' }}" alt="Preview Foto" style="max-width: 300px; border: 1px solid #ddd; padding: 5px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Pengaduan</button>
    </form>
    <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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
