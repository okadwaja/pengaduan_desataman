@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pengaduan Anda</h2>

    <a href="{{ route('masyarakat.pengaduan.create') }}" class="btn btn-success mb-3">Buat Pengaduan Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
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
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('masyarakat.pengaduan.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('masyarakat.pengaduan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('masyarakat.pengaduan.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
