@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Daftar Pengaduan</h2>

    <table class="table table-striped mt-3">
        <thead style="background-color: #002d72; color: white;">
            <tr>
                <th>Nama Pengirim</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Status</th>
                <th>Waktu</th>
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
                    <td>
                        {{ $item->created_at->translatedFormat('d M Y') }}<br>
                        {{ $item->created_at->format('H:i') }} WITA
                    </td>
                        <td>
                            <a href="{{ route('admin.pengaduan.tanggapan.create', $item->id) }}" class="btn btn-sm btn-primary">Tanggapi</a>
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

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@endsection
