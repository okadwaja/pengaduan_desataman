@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Daftar Pengaduan</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Pengirim</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduan as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Tanggapi</a>
                            <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
