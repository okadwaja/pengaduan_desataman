<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{

    public function index(Request $request)
    {
        \Carbon\Carbon::setLocale('id');

        $query = User::with('masyarakat')->where('role', 'masyarakat');

        // Search by name, nik, email, or no_telp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('masyarakat', function ($q2) use ($search) {
                    $q2->where('nik', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%");
                });
            });
        }

        // Filter by alamat
        if ($request->filled('alamat')) {
            $query->whereHas('masyarakat', function ($q) use ($request) {
                $q->where('alamat', $request->alamat);
            });
        }

        // Jumlah data per halaman
        $perPage = $request->get('perPage', 10);

        // Pagination
        $users = $query->latest()->paginate($perPage)->appends($request->all());

        // Kirim list alamat untuk filter dropdown
        $alamatList = [
            'Br. Batubayan', 'Br. Dlodpasar', 'Br. Gunung', 'Br. Jempeng',
            'Br. Jempeng Kauh', 'Br. Ketogan', 'Br. Mambul', 'Br. Pegongan',
            'Br. Raketan', 'Br. Sukajati', 'Br. Tabah', 'Br. Tebejero'
        ];

        return view('admin.users.index', compact('users', 'alamatList'));
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function exportDetailPdf($id)
    {
        $user = User::findOrFail($id);

        $pdf = Pdf::loadView('admin.users.detail_pdf', compact('user'))->setPaper('a4', 'portrait');

        return $pdf->download('detail_user_'.$user->id.'.pdf');
}

}
