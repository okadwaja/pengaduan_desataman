@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <h1 class="text-main">Dashboard</h1>
</div>

<!-- Content Jumlah Pengaduan -->

<div class="row">
    
    <!-- Menunggu -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pengaduan Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-warning">{{ $jumlahMenunggu }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Terverifikasi -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pengaduan Terverifikasi</div>
                        <div class="h5 mb-0 font-weight-bold text-info">{{ $jumlahTerverifikasi }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Berkas Tidak Valid -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Berkas Tidak Valid</div>
                        <div class="h5 mb-0 font-weight-bold text-danger">{{ $jumlahBerkas_tidak_valid }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ban fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Diproses -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pengaduan Diproses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-primary">{{ $jumlahDiproses }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-redo fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pengaduan Selesai
                        </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-success">{{ $jumlahSelesai }}</div>
                        </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ditolak -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pengaduan Ditolak</div>
                        <div class="h5 mb-0 font-weight-bold text-danger">{{ $jumlahDitolak }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ban fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                            Total Pengaduan Anda</div>
                        <div class="h5 mb-0 font-weight-bold text-white">{{ $jumlahTotal }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="d-flex flex-column flex-md-row gap-2">
    <a href="{{ route('masyarakat.pengaduan.create') }}" class="btn btn-main mt-2">
        <i class="fas fa-pen me-2"></i> Buat Pengaduan Baru
    </a>
    <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-main mt-2">
        <i class="fas fa-inbox me-2"></i> Lihat Daftar Pengaduan
    </a>
</div> -->
<!-- End content jumlah pengaduan -->
@endsection
