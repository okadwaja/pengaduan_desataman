<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export PDF - Data Pengguna</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Pengguna</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                @php $masyarakat = $user->masyarakat; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $masyarakat?->nik ?? '-' }}</td>
                    <td>{{ $masyarakat?->no_telp ?? '-' }}</td>
                    <td>{{ $masyarakat?->alamat ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
