@extends('layouts.app')

@section('content')
<div class="container text-main">
    <h1>Detail Pengaduan</h1>

    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.pengaduan.export.detail.pdf', $pengaduan->id) }}" class="btn btn-sm btn-danger mb-1" target="_blank">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>

{{-- Card Pengaduan --}}
<div class="card border-left-main">
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
                    <div class="col-sm-3 fw-semibold"><strong>Judul</strong></div>
                    <div class="col-sm-9">: {{ $pengaduan->judul }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Isi</strong></div>
                    <div class="col-sm-9">: {{ $pengaduan->isi }}</div>
                </div>

                @php
                    $status = strtolower($pengaduan->status);
                    $badgeClass = match($status) {
                        'menunggu' => 'warning',
                        'diproses' => 'primary',
                        'selesai'  => 'success',
                        'ditolak'  => 'danger',
                        'terverifikasi' => 'info',
                        'berkas tidak valid' => 'danger',
                        default    => 'secondary'
                    };
                @endphp

                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Status</strong></div>
                    <div class="col-sm-9">: <span class="badge bg-{{ $badgeClass }} text-white">{{ ucfirst($pengaduan->status) }}</span></div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-semibold"><strong>Waktu</strong></div>
                    <div class="col-sm-9">: {{ $pengaduan->created_at->translatedFormat('d M Y H:i') }} WITA</div>
                </div>

                <hr>
                <br>

                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Data Pengadu:</strong></div>
                </div>

                @php $user = $pengaduan->user; @endphp
                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Nama</strong></div>
                    <div class="col-sm-9">: {{ $user->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Alamat</strong></div>
                    <div class="col-sm-9">: {{ $user->alamat }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>Email</strong></div>
                    <div class="col-sm-9">: {{ $user->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-semibold"><strong>NIK</strong></div>
                    <div class="col-sm-9">: {{ $user->nik }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-3 fw-semibold"><strong>No. Telp</strong></div>
                    <div class="col-sm-9">: {{ $user->no_telp }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Card Tanggapan --}}
<h1 class="text-main mt-4">Tanggapan</h1>
@if($pengaduan->tanggapan)
    <div class="card mt-4 border-left-main">
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
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>Komentar</strong></div>
                        <div class="col-sm-9">: {{ $pengaduan->tanggapan->komentar }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>Ditanggapi Oleh</strong></div>
                        <div class="col-sm-9">: {{ $pengaduan->tanggapan->user->name ?? 'Admin' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 fw-semibold"><strong>Waktu</strong></div>
                        <div class="col-sm-9">: {{ \Carbon\Carbon::parse($pengaduan->tanggapan->updated_at)->translatedFormat('d M Y H:i') }} WITA</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card mt-4 border-left-main">
        <div class="card-body text-muted">
            <em>Belum ada tanggapan.</em>
        </div>
    </div>
@endif

    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-2">
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>

        @php
            $status = strtolower($pengaduan->status);
            $isEditable = in_array($status, ['menunggu', 'berkas tidak valid']);
        @endphp

        @if($isEditable)
            <a href="{{ route('admin.pengaduan.tanggapan.create', $pengaduan->id) }}" class="btn btn-primary">
                {{ $status === 'menunggu' ? 'Verifikasi' : 'Verifikasi' }}
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                Verifikasi
            </button>
        @endif

    </div>
</div>
@endsection
