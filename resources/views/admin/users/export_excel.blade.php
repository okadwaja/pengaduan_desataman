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
            @php
                $masyarakat = $user->masyarakat;
            @endphp
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
