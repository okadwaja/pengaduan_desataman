@extends('layouts.app')

@section('content')

    <h1 class="text-main mb-2">Daftar Pengaduan</h1>

    <form method="GET" action="{{ route('kepala_desa.pengaduan.index') }}" class="d-flex flex-wrap gap-2 mb-3">

        {{-- Jumlah per halaman --}}
        <div class="flex-grow-1" style="min-width: 150px;">
            <select name="perPage" class="form-select" onchange="this.form.submit()">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('perPage') == $size ? 'selected' : '' }}>{{ $size }} data</option>
                @endforeach
            </select>
        </div>

        {{-- Filter status --}}
        <div class="flex-grow-1" style="min-width: 180px;">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                @foreach (['terverifikasi', 'diproses', 'ditolak', 'dieksekusi', 'ditunda' ] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter waktu --}}
        <div class="d-flex align-items-center gap-1 flex-grow-1" style="min-width: 250px;">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            <span class="mx-1">s/d</span>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>

        {{-- Search --}}
        <div class="input-group flex-grow-1" style="min-width: 250px; max-width: 300px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul, isi, atau nama...">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>

        {{-- Tombol Export --}}
        <div class="d-flex gap-2">
            <a href="{{ route('kepala_desa.pengaduan.export.pdf', request()->query()) }}" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf"></i> Cetak Laporan Pengaduan
            </a>
            <!-- <a href="{{ route('kepala_desa.pengaduan.export.excel', request()->query()) }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel"></i> Excel
            </a> -->
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
                            'dieksekusi'  => 'success',
                            'ditunda' => 'dark',
                            'ditolak'  => 'danger',
                            'terverifikasi' => 'info',
                            'berkas tidak valid' => 'danger',
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
                            $disableTombol = in_array($status, ['dieksekusi', 'ditolak']);
                        @endphp

                        @if($disableTombol)
                            <button class="btn btn-sm btn-secondary mb-1" disabled>Tanggapi</button>
                        @else
                            <a href="{{ route('kepala_desa.pengaduan.tanggapan.create', $item->id) }}" class="btn btn-sm btn-primary mb-1">Tanggapi</a>
                        @endif

                            <a href="{{ route('kepala_desa.pengaduan.show', $item->id) }}" class="btn btn-info btn-sm mb-1">Detail</a>
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
