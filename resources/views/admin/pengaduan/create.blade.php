@extends('layouts.app')

@section('content')

<body id="page-top">
<div class="container">
    <h2>Form Pengaduan Masyarakat</h2>
    <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Isi Pengaduan</label>
            <textarea name="isi" class="form-control" rows="5" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
</div>

@endsection
