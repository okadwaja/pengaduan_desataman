@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pengaduan</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h4>{{ $pengaduan->judul }}</h4>
            <p>{{ $pengaduan->isi }}</p>
            <p>Status: <strong>{{ ucfirst($pengaduan->status) }}</strong></p>
            <p>Tanggal: {{ $pengaduan->created_at->format('d M Y') }}</p>

            @if ($pengaduan->foto)
                <div class="mt-3">
                    <img src="{{ asset('storage/foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="img-fluid" style="max-width: 400px;">
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
