@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
        @if($pengaduan->foto)
                <div class="mt-3">
                    <label>Foto</label>
                    <br>
                    <!-- Menggunakan asset() untuk mengambil path gambar yang benar -->
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" id="foto-preview" style="max-width: 300px; max-height: 300px; margin-bottom: 10px;">
                </div>
            @endif
            <input type="file" name="foto" class="form-control" accept="image/*" id="foto-input">
        </div>

        <button type="submit" class="btn btn-primary">Update Pengaduan</button>
    </form>
    <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>

<script>
    // Menampilkan preview gambar setelah memilih file
    document.getElementById('foto-input').addEventListener('change', function (e) {
        var reader = new FileReader();
        reader.onload = function (event) {
            var preview = document.getElementById('foto-preview');
            preview.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(e.target.files[0]);
    });
</script>

@endsection
