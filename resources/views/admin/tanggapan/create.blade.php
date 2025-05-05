@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tanggapi Pengaduan</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h5>{{ $pengaduan->judul }}</h5>
            <p>{{ $pengaduan->isi }}</p>
        </div>
    </div>

    <form action="{{ route('admin.pengaduan.tanggapan.store', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        <div class="form-group mb-3">
            <label>Komentar Tanggapan</label>
            <textarea name="komentar" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Status Pengaduan</label>
            <select name="status" class="form-control" required>
                <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Foto Tanggapan (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*,.heic,.heif" onchange="previewImage(event)">
        </div>

        <div id="preview-container" style="margin-top: 10px; display: none;">
            <div id="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
            <img id="preview-image" src="#" alt="Preview Foto" style="max-width: 300px; border: 1px solid #ddd; padding: 5px;">
        </div>

        <button type="submit" class="btn btn-success">Simpan Tanggapan</button>
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">Batal</a>
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
