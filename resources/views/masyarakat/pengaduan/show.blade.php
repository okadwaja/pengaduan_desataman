@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-main">Detail Pengaduan</h1>

{{-- Card Pengaduan --}}
<div class="card mt-3 bg-main text-white">
    <div class="card-body">
        <div class="row">
            {{-- Foto Pengaduan --}}
            @if ($pengaduan->foto)
                <div class="col-md-4 mb-3">
                    <img src="{{ asset('storage/foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="img-fluid rounded shadow-sm" style="max-width: 100%;">
                </div>
            @endif

            {{-- Data --}}
            <div class="col-md-8">

                <div class="row mb-2">
                    <div class="col-sm-2 fw-semibold">Judul</div>
                    <div class="col-sm-9">: {{ $pengaduan->judul }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-2 fw-semibold">Isi</div>
                    <div class="col-sm-9">: {{ $pengaduan->isi }}</div>
                </div>

                @php
                    $status = strtolower($pengaduan->status);
                    $badgeClass = match($status) {
                        'menunggu' => 'warning',
                        'diproses' => 'primary',
                        'selesai'  => 'success',
                        'ditolak'  => 'danger',
                        default    => 'secondary'
                    };
                @endphp

                <div class="row mb-2">
                    <div class="col-sm-2 fw-semibold">Status</div>
                    <div class="col-sm-9">: <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($pengaduan->status) }}</span></div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2 fw-semibold">Waktu</div>
                    <div class="col-sm-9">: {{ $pengaduan->created_at->translatedFormat('d M Y H:i') }} WITA</div>
                </div>

                
            </div>
        </div>
    </div>
</div>

{{-- Card Tanggapan --}}
@if($pengaduan->tanggapan)
    <div class="card mt-4 bg-main text-white">
        <div class="card-body">
            <div class="row">
                {{-- Foto Tanggapan --}}
                @if($pengaduan->tanggapan->foto)
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('storage/foto_tanggapan/' . $pengaduan->tanggapan->foto) }}" alt="Foto Tanggapan" class="img-fluid rounded shadow-sm" style="max-width: 100%;">
                    </div>
                @endif

                {{-- Komentar dan Info --}}
                <div class="col-md-8">
                    <h5 class="mb-3">Tanggapan Admin</h5>
                    
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold">Komentar</div>
                        <div class="col-sm-9">: {{ $pengaduan->tanggapan->komentar }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold">Ditanggapi Oleh</div>
                        <div class="col-sm-9">: {{ $pengaduan->tanggapan->user->name ?? 'Admin' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 fw-semibold">Tanggal</div>
                        <div class="col-sm-9">: {{ \Carbon\Carbon::parse($pengaduan->tanggapan->updated_at)->translatedFormat('H:i, d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-secondary mt-4">
        Belum ada tanggapan dari admin.
    </div>
@endif

    <div class="mt-3">
        <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
