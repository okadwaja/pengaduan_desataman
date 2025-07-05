<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use PDF;
use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;

class PengaduanExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $pengaduan = $this->getFilteredPengaduan($request)->get();

        $pdf = PDF::loadView('admin.pengaduan.export_pdf', compact('pengaduan'));
        return $pdf->download('data_pengaduan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PengaduanExport($request), 'data_pengaduan.xlsx');
    }

    private function getFilteredPengaduan(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // filter sesuai role Kepala Desa
        if (auth()->user()->role === 'kepala_desa') {
            $query->whereIn('status', ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak', 'ditunda']);
        }

        return $query->latest();
    }
}
