<table>
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
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->no_telp }}</td>
                <td>{{ $user->alamat }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
