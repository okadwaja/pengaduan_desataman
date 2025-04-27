<?php

namespace App\Http\Controllers;

use Imagick;
use Illuminate\Support\Str;
use Spatie\ImageConverter\ImageConverter;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



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

                //Path simpan final
                $savePath = storage_path('app/public/foto_pengaduan/' . $filename);
                
                if (!file_exists(dirname($savePath))) {
                    mkdir(dirname($savePath), 0755, true);
                }

                
                try {
                    // Untuk file HEIC/HEIF (konversi ke JPG menggunakan Imagick)
                    if (in_array($extension, ['heic', 'heif'])) {
                        $tempFolder = storage_path('app/temp_upload');
                        if (!file_exists($tempFolder)) {
                            mkdir($tempFolder, 0755, true);
                        }
            
                        $tmpPath = $tempFolder . '/' . $file->getClientOriginalName();
                        $file->move($tempFolder, $file->getClientOriginalName());
            
                        // Gunakan Imagick untuk konversi ke JPG
                        $imagick = new \Imagick($tmpPath);
                        $imagick->setImageFormat('jpg');
                        $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                        $imagick->setImageCompressionQuality(10); // <= kualitas setelah dikompres
                        $imagick->stripImage(); // hapus metadata (bikin lebih kecil)
                        $imagick->writeImage($savePath);
                        $imagick->clear();
                        $imagick->destroy();
                        unlink($tmpPath);
                    } else {
                        // Untuk format JPG, PNG, JPEG biasa (gunakan Imagick untuk kompresi)
                        $imagick = new \Imagick();
                        $imagick->readImage($file->getPathname());
                        $imagick->setImageFormat('jpg'); // Pastikan hasil akhirnya JPG
                        $imageSize = $file->getSize();
            
                        if ($imageSize > 2 * 1024 * 1024) { // lebih dari 2 MB
                            $imagick->setImageCompressionQuality(10); // kompres kualitas 50%
                        } else {
                            $imagick->setImageCompressionQuality(30);
                        }
                        $imagick->writeImage($savePath);
                        $imagick->clear();
                        $imagick->destroy();
                    }
            
                    // Set path yang akan disimpan ke database
                    $fotoPath = 'foto_pengaduan/' . $filename;
                } catch (\Exception $e) {
                    \Log::error('Upload error dengan Imagick: ' . $e->getMessage());
                    return back()->withErrors(['foto' => 'Gagal memproses gambar: ' . $e->getMessage()]);
                }
            }

            if ($request->hasFile('foto') && $fotoPath === null) {
                return back()->withErrors(['foto' => 'File foto gagal diproses.']);
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
    // Ambil pengaduan berdasarkan ID
    $pengaduan = Pengaduan::findOrFail($id);

    // Cek apakah pengaduan milik pengguna yang sedang login
    if ($pengaduan->user_id !== Auth::id()) {
        // Jika bukan, beri pesan error atau redirect
        return redirect()->back()->with('error', 'Anda tidak dapat menghapus pengaduan ini.');
    }

    // Hapus pengaduan
    $pengaduan->delete();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
