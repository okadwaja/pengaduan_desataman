@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped mt-3">
        <thead style="background-color: #002d72; color: white;">
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->no_telp }}</td>
                <td>{{ $user->alamat }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info me-2">View Detail</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
