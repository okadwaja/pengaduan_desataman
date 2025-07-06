<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .row { display: flex; justify-content: space-between; }
        .col-text { width: 60%; }
        .col-image { width: 38%; margin-top: 20px; }
        .image { max-width: 100%; max-height: 200px; object-fit: cover; border: 1px solid #ccc; }
        .label { font-weight: bold; }
        p { margin: 4px 0; }
    </style>
</head>
<body>

    <div class="section">
        <div class="section-title">Data Pengaduan</div><hr>
        <div class="row">
            <div class="col-text">
                <p><span class="label">Nama Pengirim:</span> {{ $pengaduan->user->name }}</p>
                <p><span class="label">Email:</span> {{ $pengaduan->user->email }}</p>
                <p><span class="label">NIK:</span> {{ $pengaduan->user->nik }}</p>
                <p><span class="label">No Telepon:</span> {{ $pengaduan->user->no_telp }}</p>
                <p><span class="label">Alamat:</span> {{ $pengaduan->user->alamat }}</p>
                <br>
                <p><span class="label">Judul Pengaduan:</span> {{ $pengaduan->judul }}</p>
                <p><span class="label">Isi:</span> {{ $pengaduan->isi }}</p>
                <p><span class="label">Status:</span> {{ ucfirst($pengaduan->status) }}</p>
                <p><span class="label">Tanggal Pengaduan:</span> {{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-image">
                @if ($pengaduan->foto)
                    <img class="image" src="{{ public_path('storage/foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan">
                @else
                    <p>Tidak ada foto</p>
                @endif
            </div>
        </div>
    </div>

    @if ($pengaduan->tanggapan)
        <div class="section">
            <div class="section-title">Tanggapan</div><hr>
            <div class="row">
                <div class="col-text">
                    <p><span class="label">Komentar:</span> {{ $pengaduan->tanggapan->komentar }}</p>
                    <p><span class="label">Tanggal Tanggapan:</span> {{ $pengaduan->tanggapan->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-image">
                    @if ($pengaduan->tanggapan->foto)
                        <img class="image" src="{{ asset('storage/foto_tanggapan/' . $pengaduan->tanggapan->foto) }}" alt="Foto Tanggapan">
                    @else
                        <p>Tidak ada foto</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

</body>
</html>
