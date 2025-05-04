@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pengaduan</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h4>Judul: {{ $pengaduan->judul }}</h4>
            <p>Isi: {{ $pengaduan->isi }}</p>
            <p>Status: <strong>{{ ucfirst($pengaduan->status) }}</strong></p>
            <p>Tanggal: {{ $pengaduan->created_at->translatedFormat('d M Y H:i') }} WITA</p>
            <br>

            <hr>
            <h5>Data Pengadu:</h5>
            <ul>
                <li><strong>Nama:</strong> {{ $pengaduan->user->name }}</li>
                <li><strong>Email:</strong> {{ $pengaduan->user->email }}</li>
                <li><strong>NIK:</strong> {{ $pengaduan->user->nik }}</li>
                <li><strong>No. Telp:</strong> {{ $pengaduan->user->no_telp }}</li>
            </ul>
                @if ($pengaduan->foto)
                    <div class="mt-3">
                        <img src="{{ asset('storage/foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="img-fluid" style="max-width: 400px;">
                    </div>
                @endif
        </div>

        @if($pengaduan->tanggapan)
            <div class="card mt-4">
                <div class="card-header">
                    <strong>Tanggapan Admin</strong>
                </div>
                <div class="card-body">
                    <p>{{ $pengaduan->tanggapan->komentar }}</p>

                    @if($pengaduan->tanggapan->foto)
                        <div class="mt-3">
                            <img src="{{ asset('storage/foto_tanggapan/' . $pengaduan->tanggapan->foto) }}" alt="Foto Tanggapan" class="img-fluid" style="max-width: 400px;">
                        </div>
                    @endif

                    <p class="text-muted mt-2">
                        Ditanggapi oleh: {{ $pengaduan->tanggapan->user->name ?? 'Admin' }} <br>
                        Pada: {{ \Carbon\Carbon::parse($pengaduan->tanggapan->updated_at)->translatedFormat('H:i, d F Y') }}
                    </p>
                </div>
            </div>
        @else
            <div class="alert alert-secondary mt-4">
                Belum ada tanggapan dari admin.
            </div>
        @endif

    </div>

    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
