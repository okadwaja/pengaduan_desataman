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

    <form action="{{ route('admin.pengaduan.simpanTanggapan', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
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
            <input type="file" name="foto" class="form-control" accept="image/*,.heic,.heif">
        </div>

        <button type="submit" class="btn btn-success">Simpan Tanggapan</button>
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
