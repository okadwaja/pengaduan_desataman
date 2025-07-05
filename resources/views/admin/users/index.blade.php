@extends('layouts.app')

@section('content')

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

<div class="container">
    <h1 class="text-main mb-2">Daftar Masyarakat</h1>

    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">

        {{-- Jumlah data per halaman --}}
        <div>
            <select name="perPage" class="form-select" onchange="this.form.submit()">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('perPage') == $size ? 'selected' : '' }}>{{ $size }} data</option>
                @endforeach
            </select>
        </div>

        {{-- Filter alamat --}}
        <div>
            <select name="alamat" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Alamat --</option>
                @foreach ([
                    'Br. Batubayan', 'Br. Dlodpasar', 'Br. Gunung', 'Br. Jempeng',
                    'Br. Jempeng Kauh', 'Br. Ketogan', 'Br. Mambul', 'Br. Pegongan',
                    'Br. Raketan', 'Br. Sukajati', 'Br. Tabah', 'Br. Tebejero'
                ] as $alamat)
                    <option value="{{ $alamat }}" {{ request('alamat') == $alamat ? 'selected' : '' }}>{{ $alamat }}</option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari...">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>

        {{-- Export Data --}}
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.users.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm me-2">
                <i class="fas fa-file-pdf"></i> Cetak Laporan Pengguna
            </a>

        </div>


    </form>


    <div class="table-responsive">
    <table class="table table-striped">
        <thead class="bg-main">
            <tr>
                <th>No.</td>
                <th>Nama</th>
                <th>NIK</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->no_telp }}</td>
                <td>{{ $user->alamat }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info me-2">View Detail</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm ms-2" onclick="confirmDelete({{ $user->id }})">Hapus</button>
                        </form>
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7">Belum ada user.</td>
            </tr>
            @endforelse

            <script>
                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data masyarakat ini akan dihapus!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                }
            </script>
            
        </tbody>
    </table>
    <div class="mt-3">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
</div>
@endsection
