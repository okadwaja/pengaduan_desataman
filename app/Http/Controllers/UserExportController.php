<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('alamat')) {
            $query->where('alamat', $request->alamat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->get();
        $pdf = PDF::loadView('admin.users.export_pdf', compact('users'))->setPaper('A4', 'landscape');
        return $pdf->download('daftar_pengguna.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new UsersExport($request), 'daftar_pengguna.xlsx');
    }
}

