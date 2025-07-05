<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;


class MasyarakatDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jumlahTotal = Pengaduan::where('user_id', $user->id)->count();
        $jumlahMenunggu = Pengaduan::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $jumlahTerverifikasi = Pengaduan::where('status', 'terverifikasi')->count();
        $jumlahBerkas_tidak_valid = Pengaduan::where('status', 'berkas tidak valid')->count();
        $jumlahDiproses = Pengaduan::where('user_id', $user->id)->where('status', 'diproses')->count();
        $jumlahDieksekusi = Pengaduan::where('user_id', $user->id)->where('status', 'dieksekusi')->count();
        $jumlahDitunda = Pengaduan::where('status', 'ditunda')->count();
        $jumlahDitolak = Pengaduan::where('user_id', $user->id)->where('status', 'ditolak')->count();

        return view('masyarakat.dashboard', compact(
            'jumlahTotal',
            'jumlahMenunggu',
            'jumlahTerverifikasi',
            'jumlahBerkas_tidak_valid',
            'jumlahDiproses',
            'jumlahDieksekusi',
            'jumlahDitunda',
            'jumlahDitolak'
        ));
    }
}
