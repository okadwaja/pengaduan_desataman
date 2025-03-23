<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        // Admin melihat semua pengaduan
        $pengaduan = Pengaduan::with('user')->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan', 'user'));
    } else {
        // Masyarakat hanya melihat pengaduan miliknya
        $pengaduan = Pengaduan::where('user_id', $user->id)->latest()->get();
        return view('masyarakat.pengaduan.index', compact('pengaduan', 'user'));

    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('masyarakat.pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
        ]);
    
        $fotoPath = null;
    
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_pengaduan', 'public');
        }
    
        \App\Models\Pengaduan::create([
            'user_id' => auth()->user()->id, // ambil ID user yang sedang login
            'judul' => $request->judul,
            'isi' => $request->isi,
            'foto' => $fotoPath,
            'status' => 'menunggu',
        ]);
    
        return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
