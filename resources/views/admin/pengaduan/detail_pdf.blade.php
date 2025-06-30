<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pengaduan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .col-text {
            width: 60%;
        }

        .col-image {
            width: 38%;
            text-align: right;
        }

        .image {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .label {
            font-weight: bold;
        }

        p {
            margin: 4px 0;
        }

    </style>
</head>
<body>

    <div class="section">
        <div class="section-title">Data Pengaduan</div><hr>

        @php
            $user = $pengaduan->user;
            $masyarakat = $user->masyarakat ?? null;
        @endphp

        <p><span class="label">Nama Pengirim:</span> {{ $user->name }}</p>
        <p><span class="label">Email:</span> {{ $user->email }}</p>
        <p><span class="label">NIK:</span> {{ $masyarakat?->nik ?? '-' }}</p>
        <p><span class="label">No Telepon:</span> {{ $masyarakat?->no_telp ?? '-' }}</p>
        <p><span class="label">Alamat:</span> {{ $masyarakat?->alamat ?? '-' }}</p>
        <br>
        <p><span class="label">Judul Pengaduan:</span> {{ $pengaduan->judul }}</p>
        <p><span class="label">Isi:</span> {{ $pengaduan->isi }}</p>
        <p><span class="label">Status:</span> {{ ucfirst($pengaduan->status) }}</p>
        <p><span class="label">Tanggal Pengaduan:</span> {{ $pengaduan->created_at->format('d/m/Y H:i') }} WITA</p>

        @if ($pengaduan->foto)
            <div style="margin-top: 10px; text-align: center;">
                <img class="image" src="{{ public_path('storage/foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan">
            </div>
        @else
            <p><em>Tidak ada foto pengaduan</em></p>
        @endif
    </div>

    @if ($pengaduan->tanggapan)
        <div class="section">
            <div class="section-title">Tanggapan</div><hr>

            <p><span class="label">Ditanggapi oleh:</span> {{ $pengaduan->tanggapan->user->name ?? '-' }}</p>
            <p><span class="label">Komentar:</span> {{ $pengaduan->tanggapan->komentar }}</p>
            <p><span class="label">Tanggal Tanggapan:</span> {{ $pengaduan->tanggapan->created_at->format('d/m/Y H:i') }} WITA</p>

            @if ($pengaduan->tanggapan->foto)
                <div style="margin-top: 10px; text-align: center;">
                    <img class="image" src="{{ public_path('storage/foto_tanggapan/' . $pengaduan->tanggapan->foto) }}" alt="Foto Tanggapan">
                </div>
            @else
                <p><em>Tidak ada foto tanggapan</em></p>
            @endif
        </div>
    @endif

</body>

</html>
