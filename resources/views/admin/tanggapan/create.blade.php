@extends('layouts.app')

@section('content')

    @php
        $user = auth()->user();
        $isKepalaDesa = $user->role === 'kepala_desa';

        // Default
        $judulKades = 'Tanggapi Pengaduan';
        $labelKomentar = 'Komentar Tanggapan';
        $statusOptions = [];

        if ($isKepalaDesa) {
            if ($pengaduan->status === 'terverifikasi') {
                $judulKades = 'Pemeriksaan ke Lapangan';
                $labelKomentar = 'Komentar';
                $statusOptions = ['diproses' => 'Diproses', 'ditolak' => 'Ditolak'];
            } elseif (in_array($pengaduan->status, ['diproses', 'ditunda'])) {
                $judulKades = 'Pengambilan Keputusan';
                $labelKomentar = 'Analisis Keputusan';
                $statusOptions = [
                    'dieksekusi' => 'Dieksekusi',
                    'ditunda' => 'Ditunda',
                ];
            } else {
                $statusOptions = ['diproses' => 'Diproses', 'ditolak' => 'Ditolak']; // fallback
            }
        }
    @endphp


<div class="container text-main">
    <h1>{{ $isKepalaDesa ? $judulKades : 'Verifikasi Berkas Pengaduan' }}</h1>

    <div class="card mt-3 border-left-main">
        <div class="card-body">
            <h5><strong>Judul: </strong>{{ $pengaduan->judul }}</h5>
            <p><strong>Isi: </strong>{{ $pengaduan->isi }}</p>
        </div>
    </div>

    <form action="{{ $isKepalaDesa ? route('kepala_desa.pengaduan.tanggapan.store', $pengaduan->id) : route('admin.pengaduan.tanggapan.store', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        <div class="form-group mb-3">
            <label><strong>{{ $isKepalaDesa ? $labelKomentar : 'Pesan' }}</strong></label>
            <textarea name="komentar" class="form-control border-left-main" rows="4" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label><strong>Status Pengaduan</strong></label>
            <select name="status" class="form-control border-left-main" required>
                @if ($isKepalaDesa)
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ $pengaduan->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                @else
                    <option value="terverifikasi" {{ $pengaduan->status === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="berkas tidak valid" {{ $pengaduan->status === 'berkas tidak valid' ? 'selected' : '' }}>Berkas Tidak Valid</option>
                @endif
            </select>

        </div>

        @if ($isKepalaDesa && in_array($pengaduan->status, ['diproses', 'ditunda']))
        <div class="form-group mb-3">
            <label><strong>Foto Tanggapan (Opsional)</strong></label>
            <input type="file" name="foto" class="form-control" accept="image/*,.heic,.heif" onchange="previewImage(event)">
            <small class="text-muted">*Max 8Mb File:jpeg,png,jpg</small>
        </div>

        <div id="preview-container" style="margin-top: 10px; display: none;">
            <div id="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
            <img id="preview-image" src="#" alt="Preview Foto" style="max-width: 300px; border: 1px solid #ddd; padding: 5px;">
        </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
            <a href="{{ $isKepalaDesa ? route('kepala_desa.pengaduan.index') : route('admin.pengaduan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ $isKepalaDesa ? 'Simpan Tanggapan' : 'Simpan Verifikasi' }}
            </button>
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
