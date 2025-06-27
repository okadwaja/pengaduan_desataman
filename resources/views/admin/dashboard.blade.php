@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="text-main">Dashboard Admin</h1>
</div>

<!-- Content Jumlah Pengaduan -->
<div class="mb-2">
    <h4 class="text-main">Total Pengaduan Semua Status</h4>
</div>
<div class="row">
    <!-- Total -->
    <div class="col-xl-12 col-md-4 mb-4">
        <div class="card bg-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                            Total Pengaduan</div>
                        <div class="h5 mb-0 font-weight-bold text-white">{{ $jumlahTotal }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-2">
    <h4 class="text-main">Status Verifikasi</h4>
</div>
<div class="row">
    <!-- Menunggu -->
    <div class="col-xl-3 col-md-4 mb-4">
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
    <div class="col-xl-3 col-md-4 mb-4">
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
    <div class="col-xl-3 col-md-4 mb-4">
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
</div>

<div class="mb-2">
    <h4 class="text-main">Status Awal</h4>
</div>
<div class="row">
    <!-- Diproses -->
    <div class="col-xl-3 col-md-4 mb-4">
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
    <!-- Ditolak -->
    <div class="col-xl-3 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pengaduan Ditolak</div>
                        <div class="h5 mb-0 font-weight-bold text-danger">{{ $jumlahDitolak }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-2">
    <h4 class="text-main">Status Akhir</h4>
</div>
<div class="row">
    <!-- Dieksekusi -->
    <div class="col-xl-3 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pengaduan Dieksekusi
                        </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-success">{{ $jumlahDieksekusi }}</div>
                        </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ditunda -->
    <div class="col-xl-3 col-md-4 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Pengaduan Ditunda
                        </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-dark">{{ $jumlahDitunda }}</div>
                        </div>
                    <div class="col-auto">
                        <i class="fas fa-stop-circle fa-2x text-dark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tidak Dieksekusi -->
    <div class="col-xl-3 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pengaduan Tidak Dieksekusi
                        </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-danger">{{ $jumlahTidak_dieksekusi }}</div>
                        </div>
                    <div class="col-auto">
                        <i class="fas fa-times fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End content jumlah pengaduan -->

<!-- Area Chart -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-main">Grafik Pengaduan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="pengaduanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<style>
    .chart-area {
        position: relative;
        height: 300px;
    }
</style>
<script>
    const ctx = document.getElementById('pengaduanChart').getContext('2d');
    const pengaduanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: @json($monthlyData),
                backgroundColor: '#113974',
                borderWidth: 1

            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }

    });
</script>
@endpush


