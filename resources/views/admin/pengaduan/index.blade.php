@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<div class="container">
    <h2>Daftar Pengaduan</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                @if($user->role === 'admin')
                    <th>Nama Pengirim</th>
                @endif
                <th>Judul</th>
                <th>Isi</th>
                <th>Status</th>
                <th>Tanggal</th>
                @if($user->role === 'admin')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduan as $item)
                <tr>
                    @if($user->role === 'admin')
                        <td>{{ $item->user->name }}</td>
                    @endif
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    @if($user->role === 'admin')
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Tanggapi</a>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $user->role === 'admin' ? 6 : 4 }}">Belum ada pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

</body>

</html>

@endsection
