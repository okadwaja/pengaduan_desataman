<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KepalaDesaDashboardController extends Controller
{
    public function index()
    {
        $jumlahMenunggu = Pengaduan::where('status', 'menunggu')->count();
        $jumlahTerverifikasi = Pengaduan::where('status', 'terverifikasi')->count();
        $jumlahBerkas_tidak_valid = Pengaduan::where('status', 'berkas tidak valid')->count();
        $jumlahDiproses = Pengaduan::where('status', 'diproses')->count();
        $jumlahSelesai = Pengaduan::where('status', 'selesai')->count();
        $jumlahDitolak = Pengaduan::where('status', 'ditolak')->count();
        $jumlahTotal = Pengaduan::count();

        $monthlyData = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $count = Pengaduan::whereYear('created_at', Carbon::parse($month)->year)
                ->whereMonth('created_at', Carbon::parse($month)->month)
                ->count();

        $months[] = Carbon::parse($month)->translatedFormat('F Y');
        $monthlyData[] = $count;
        }

        return view('kepala_desa.dashboard', compact(
            'jumlahMenunggu',
            'jumlahTerverifikasi',
            'jumlahBerkas_tidak_valid',
            'jumlahDiproses',
            'jumlahSelesai',
            'jumlahDitolak',
            'jumlahTotal',
            'monthlyData',
            'months'
        ));
    }
}
