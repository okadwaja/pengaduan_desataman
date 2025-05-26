<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail User PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .section {
            margin-bottom: 20px;
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
            margin-bottom: 20px;

        }

        .col-image {
            width: 38%;
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
        <div class="section-title">Data User</div><hr>
        <div class="row">
            <div class="col-text">
                <p><span class="label">Nama:</span> {{ $user->name }}</p>
                <p><span class="label">Email:</span> {{ $user->email }}</p>
                <p><span class="label">NIK:</span> {{ $user->nik }}</p>
                <p><span class="label">No Telepon:</span> {{ $user->no_telp }}</p>
                <p><span class="label">Alamat:</span> {{ $user->alamat }}</p>
                <p><span class="label">Tanggal Terdaftar:</span> {{ $user->created_at->format('d/m/Y H:i') }} WITA</p>
            </div>
            <div class="col-image">
                @if ($user->foto)
                    <img class="image" src="{{ public_path('storage/foto_profil/' . $user->foto) }}" alt="Foto User">
                @else
                    <p>Tidak ada foto</p>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
