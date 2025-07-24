<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Default bulan: bulan ini
        $bulan = $request->get('bulan', now()->format('m'));
        $tahun = $request->get('tahun', now()->format('Y'));

        $pengaduan = Pengaduan::with(['user', 'tanggapan'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        return view('welcome', compact('pengaduan', 'bulan', 'tahun'));
    }
}
