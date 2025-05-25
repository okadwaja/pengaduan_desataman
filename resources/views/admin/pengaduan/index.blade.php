@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="text-main mb-2">Data Pengaduan</h1>

    <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">

        {{-- Dropdown jumlah per halaman --}}
        <div>
            <select name="perPage" class="form-select" onchange="this.form.submit()">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('perPage') == $size ? 'selected' : '' }}>{{ $size }} data</option>
                @endforeach
            </select>
        </div>

        {{-- Filter status --}}
        <div>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                @foreach (['menunggu', 'diproses', 'selesai', 'ditolak'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul, isi, atau nama...">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>

    </form>





    <div class="table-responsive">

    <table class="table table-striped">
        <thead class="bg-main">
            <tr>
                <th>No.</td>
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
                    <td>{{ ($pengaduan->currentPage() - 1) * $pengaduan->perPage() + $loop->iteration }}</td>
                    <td style="max-width: 200px;" class="text-truncate">{{ $item->user->name }}</td>
                    <td style="max-width: 200px;" class="text-truncate">{{ $item->judul }}</td>
                    <td style="max-width: 300px;" class="text-truncate">{{ $item->isi }}</td>

                    
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

                    <td style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 120px;">
                        {{ $item->created_at->translatedFormat('d M Y') }}<br>
                        {{ $item->created_at->format('H:i') }} WITA
                    </td>

                        <td>
                        @php
                            $status = strtolower($item->status);
                            $disableTombol = in_array($status, ['selesai', 'ditolak']);
                        @endphp

                        @if($disableTombol)
                            <button class="btn btn-sm btn-secondary mb-1" disabled>Tanggapi</button>
                        @else
                            <a href="{{ route('admin.pengaduan.tanggapan.create', $item->id) }}" class="btn btn-sm btn-primary mb-1">Tanggapi</a>
                        @endif

                            <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="btn btn-info btn-sm mb-1">Detail</a>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $pengaduan->withQueryString()->links() }}
    </div>

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
