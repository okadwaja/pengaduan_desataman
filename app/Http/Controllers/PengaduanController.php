<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'nullable|mimes:jpg,jpeg,png,heic,heif|max:3048',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . Str::random(8) . '.jpg'; // hasil akhir tetap jpg

            // Path simpan
            $savePath = storage_path('app/public/foto_pengaduan/' . $filename);

            if (in_array($extension, ['HEIC', 'HEIF'])) {
                // Konversi HEIC ke JPG pakai Intervention
                $image = Image::make($file->getPathname())->encode('jpg', 90);
                $image->save($savePath);
            } else {
                // Format selain HEIC langsung disimpan
                $file->move(storage_path('app/public/foto_pengaduan'), $filename);
            }

            // Set path untuk disimpan di DB
            $fotoPath = 'foto_pengaduan/' . $filename;
        }

        Pengaduan::create([
            'user_id' => auth()->user()->id,
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
