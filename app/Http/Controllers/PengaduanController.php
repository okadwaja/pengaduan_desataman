<?php

namespace App\Http\Controllers;

use Imagick;
use Illuminate\Support\Str;
use Spatie\ImageConverter\ImageConverter;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
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
        try {
            $request->validate([
                'judul' => 'required',
                'isi' => 'required',
                'foto' => 'nullable|mimes:jpg,jpeg,png,heic,heif|max:10240',
            ], [
                'foto.max' => 'Ukuran foto maksimal 10 MB.',
                'foto.mimes' => 'Format foto harus jpg, jpeg, png, heic, atau heif.',
            ]);
            

            $fotoPath = null;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = time() . '_' . Str::random(8) . '.jpg'; // hasil akhir tetap jpg
                $savePath = storage_path('app/public/foto_pengaduan/' . $filename);

                if (in_array($extension, ['heic', 'heif'])) {
                    $tempFolder = storage_path('app/temp_upload');
                    if (!file_exists($tempFolder)) {
                        mkdir($tempFolder, 0755, true);
                    }

                    $tmpPath = $tempFolder . '/' . $file->getClientOriginalName();
                    $file->move($tempFolder, $file->getClientOriginalName());

                    $imagick = new \Imagick();
                    $imagick->readImage($tmpPath);
                    $imagick->setImageFormat('jpg');
                    $imagick->setImageCompressionQuality(90);
                    $imagick->writeImage($savePath);
                    $imagick->clear();
                    $imagick->destroy();
                    
                    unlink($tmpPath);
                } else {
                    $file->move(storage_path('app/public/foto_pengaduan'), $filename);
                }

                $fotoPath = 'foto_pengaduan/' . $filename; // << pastikan ini diisi
            }

            Pengaduan::create([
                'user_id' => auth()->user()->id,
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $fotoPath,
                'status' => 'menunggu',
            ]);

            return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');

        } catch (\Throwable $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            return back()->withErrors(['foto' => 'Upload error: ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        $user = auth()->user();

        // Cek jika masyarakat hanya boleh lihat miliknya sendiri
        if ($user->role === 'masyarakat' && $pengaduan->user_id !== $user->id) {
            abort(403); // Forbidden
        }

        // Arahkan view berdasarkan role
        if ($user->role === 'admin') {
            return view('admin.pengaduan.show', compact('pengaduan'));
        }

        return view('masyarakat.pengaduan.show', compact('pengaduan'));
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
