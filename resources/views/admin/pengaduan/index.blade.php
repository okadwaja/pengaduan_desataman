@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Daftar Pengaduan</h2>

    <div class="table-responsive">
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
                    
                    @php
                        $status = strtolower($item->status);
                        $badgeClass = match($status) {
                            'menunggu' => 'warning',
                            'diproses' => 'primary',
                            'selesai'  => 'success',
                            'ditolak'  => 'danger',
                            default    => 'secondary'
                        };
                    @endphp
                    <td>
                        <span class="badge bg-{{ $badgeClass }} text-white">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $item->created_at->translatedFormat('d M Y') }}<br>
                        {{ $item->created_at->format('H:i') }} WITA
                    </td>
                        <td>
                        @php
                            $status = strtolower($item->status);
                            $disableTombol = in_array($status, ['selesai', 'ditolak']);
                        @endphp

                        @if($disableTombol)
                            <button class="btn btn-sm btn-secondary" disabled>Tanggapi</button>
                        @else
                            <a href="{{ route('admin.pengaduan.tanggapan.create', $item->id) }}" class="btn btn-sm btn-primary">Tanggapi</a>
                        @endif

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
