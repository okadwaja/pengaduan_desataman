<?php

namespace App\Http\Controllers;

use Imagick;
use Illuminate\Support\Str;
use Spatie\ImageConverter\ImageConverter;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengaduanExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;



class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $user = auth()->user();

        if ($user->role === 'admin') {
            $query = Pengaduan::with('user');

            // Search
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

            // Filter status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            // Jumlah data per halaman
            $perPage = $request->get('perPage', 10);

            // Ambil data dan jaga agar parameter tetap saat pagination
            $pengaduan = $query->latest()->paginate($perPage)->appends($request->all());

            return view('admin.pengaduan.index', compact('pengaduan', 'user'));
        } else {
            // Untuk masyarakat tetap gunakan pagination dan perPage
            $pengaduan = Pengaduan::where('user_id', $user->id)
                ->latest()
                ->get();

            return view('masyarakat.pengaduan.index', compact('pengaduan', 'user'));
        }
    }

    // FUNGSI EXPORT PDF
    public function exportPdf(Request $request)
    {
        $query = Pengaduan::with('user');

        // Search & Filter (optional)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('isi', 'like', "%{$search}%")
                ->orWhereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if (auth()->user()->role === 'kepala_desa') {
            $query->whereIn('status', ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak', 'ditunda']);
        }

        $pengaduan = $query->latest()->get();

        $pdf = Pdf::loadView('admin.pengaduan.export_pdf', compact('pengaduan'));

        return $pdf->download('data_pengaduan.pdf');
    }

    // Export excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new PengaduanExport($request), 'data_pengaduan.xlsx');
    }

    // Export detail
    public function exportDetailPdf($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapan'])->findOrFail($id);
        $user = auth()->user();

        // Hanya admin dan kepala desa yang boleh mengakses
        if (!in_array($user->role, ['admin', 'kepala_desa'])) {
            abort(403);
        }

        // Jika kepala desa, hanya boleh akses status tertentu
        if (
            $user->role === 'kepala_desa' &&
            !in_array($pengaduan->status, ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak' , 'ditunda'])
        ) {
            abort(403);
        }

        $pdf = Pdf::loadView('admin.pengaduan.detail_pdf', compact('pengaduan'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('detail_pengaduan_' . $pengaduan->id . '.pdf');
    }

    public function exportDetailPdfMasyarakat($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapan'])->findOrFail($id);

        // Pastikan user hanya bisa melihat miliknya
        if (auth()->user()->id !== $pengaduan->user_id) {
            abort(403);
        }

        return Pdf::loadView('masyarakat.pengaduan.detail_pdf', compact('pengaduan'))
            ->stream('pengaduan_detail_' . $pengaduan->id . '.pdf');
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
                'foto' => 'required|mimes:jpg,jpeg,png,heic,heif|max:10240',
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
                        $this->fixImageOrientation($imagick); // fix orientasi gambar (ROTATE)
                        $imagick->setImageFormat('jpg'); // Pastikan hasil akhirnya JPG
                        $imageSize = $file->getSize();
            
                        if ($imageSize > 2 * 1024 * 1024) { // lebih dari 2 MB
                            $imagick->setImageCompressionQuality(10); // kompres kualitas 10%
                        } else {
                            $imagick->setImageCompressionQuality(30);
                        }
                        $imagick->writeImage($savePath);
                        $imagick->clear();
                        $imagick->destroy();
                    }
            
                    // Set path yang akan disimpan ke database
                    $fotoPath = $filename;
                } catch (\Exception $e) {
                    \Log::error('Upload error dengan Imagick: ' . $e->getMessage());
                    return back()->withErrors(['foto' => 'Gagal memproses gambar: ' . $e->getMessage()]);
                }
            }

            if ($request->hasFile('foto') && $fotoPath === null) {
                return back()->withErrors(['foto' => 'File foto gagal diproses.']);
            }
            
            $pengaduan=Pengaduan::create([
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
        \Carbon\Carbon::setLocale('id');
        $pengaduan = Pengaduan::with('user', 'tanggapan')->findOrFail($id);
        $user = auth()->user();

        // Cek jika masyarakat hanya boleh lihat miliknya sendiri
        if ($user->role === 'masyarakat' && $pengaduan->user_id !== $user->id) {
            abort(403); // Forbidden
        }

        // Admin lihat semua
        if ($user->role === 'admin') {
            return view('admin.pengaduan.show', compact('pengaduan'));
        }

        // Kepala Desa hanya lihat pengaduan tertentu
        if ($user->role === 'kepala_desa') {
            if (in_array($pengaduan->status, ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak', 'ditunda'])) {
                return view('kepala_desa.pengaduan.show', compact('pengaduan'));
            } else {
                abort(403);
            }
        }

        // Default: masyarakat
        return view('masyarakat.pengaduan.show', compact('pengaduan'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Cek apakah pengaduan milik user yang sedang login
        if ($pengaduan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengedit pengaduan ini.');
        }

        // Cek status pengaduan
        if (!in_array($pengaduan->status, ['menunggu', 'berkas tidak valid'])) {
            return redirect()->back()->with('error', 'Pengaduan hanya bisa diedit ketika belum ditanggapi.');
        }

        return view('masyarakat.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengedit pengaduan ini.');
        }

        if (!in_array($pengaduan->status, ['menunggu', 'berkas tidak valid'])) {
            return redirect()->back()->with('error', 'Pengaduan hanya bisa diedit ketika belum ditanggapi.');
        }

        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|mimes:jpeg,png,jpg,heic,heif|max:10240',
        ]);

        $fotoPath = $pengaduan->foto;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pengaduan->foto) {
                Storage::delete('public/foto_pengaduan/' . $pengaduan->foto);
            }

            $file = $request->file('foto');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . Str::random(8) . '.jpg'; // Simpan sebagai JPG
            $savePath = storage_path('app/public/foto_pengaduan/' . $filename);

            if (!file_exists(dirname($savePath))) {
                mkdir(dirname($savePath), 0755, true);
            }

            try {
                if (in_array($extension, ['heic', 'heif'])) {
                    $tempFolder = storage_path('app/temp_upload');
                    if (!file_exists($tempFolder)) {
                        mkdir($tempFolder, 0755, true);
                    }

                    $tmpPath = $tempFolder . '/' . $file->getClientOriginalName();
                    $file->move($tempFolder, $file->getClientOriginalName());

                    $imagick = new \Imagick($tmpPath);
                    $imagick->setImageFormat('jpg');
                    $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                    $imagick->setImageCompressionQuality(10); // Kompres kualitas
                    $imagick->stripImage();
                    $imagick->writeImage($savePath);
                    $imagick->clear();
                    $imagick->destroy();
                    unlink($tmpPath);
                } else {
                    $imagick = new \Imagick();
                    $imagick->readImage($file->getPathname());
                    $this->fixImageOrientation($imagick); // Fix orientasi gambar (Rotate)
                    $imagick->setImageFormat('jpg');
                    $imageSize = $file->getSize();

                    if ($imageSize > 2 * 1024 * 1024) { // Kalau besar
                        $imagick->setImageCompressionQuality(10);
                    } else {
                        $imagick->setImageCompressionQuality(30);
                    }
                    $imagick->stripImage();
                    $imagick->writeImage($savePath);
                    $imagick->clear();
                    $imagick->destroy();
                }

                $fotoPath = $filename;
            } catch (\Exception $e) {
                \Log::error('Upload error saat update: ' . $e->getMessage());
                return back()->withErrors(['foto' => 'Gagal memproses foto baru: ' . $e->getMessage()]);
            }
        }

        // Perbarui data
        $dataToUpdate = [
            'judul' => $validatedData['judul'],
            'isi' => $validatedData['isi'],
            'foto' => $fotoPath,
        ];

        // Jika sebelumnya statusnya "berkas tidak valid", ubah ke "menunggu"
        if ($pengaduan->status === 'berkas tidak valid') {
            $dataToUpdate['status'] = 'menunggu';
        }

        $pengaduan->update($dataToUpdate);

        return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
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

            if (!in_array($pengaduan->status, ['menunggu', 'berkas tidak valid'])) {
        return redirect()->back()->with('error', 'Pengaduan hanya bisa dihapus ketika belum ditanggapi.');
    }

    // Hapus pengaduan
    $pengaduan->delete();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }


    // Action Buat Tanggapan
        public function createTanggapan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.tanggapan.create', compact('pengaduan'));
    }


    //Action Simpan Tanggapan
    public function storeTanggapan(Request $request, $id)
    {
        \Log::info('Memasuki fungsi simpanTanggapan');

        $request->validate([
            'komentar' => 'required|string',
            'status' => ['required', Rule::in([
                'menunggu',
                'diproses',
                'dieksekusi',
                'ditolak',
                'terverifikasi',
                'berkas tidak valid',
                'ditunda',
            ])],
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,heic,heif|max:10240',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            \Log::info('hasFile() result: true');
            $file = $request->file('foto');
            \Log::info('Input file data: ' . json_encode(['foto' => $file]));

            $extension = strtolower($file->getClientOriginalExtension());
            \Log::info('Ekstensi file: ' . $extension);

            $filename = time() . '_' . Str::random(8) . '.jpg';
            $savePath = storage_path('app/public/foto_tanggapan/' . $filename);

            if (!file_exists(dirname($savePath))) {
                mkdir(dirname($savePath), 0755, true);
            }

            try {
                if (in_array($extension, ['heic', 'heif'])) {
                    \Log::info('File HEIC terdeteksi');

                    $tempFolder = storage_path('app/temp_upload');
                    if (!file_exists($tempFolder)) {
                        mkdir($tempFolder, 0755, true);
                    }

                    $tmpPath = $tempFolder . '/' . uniqid() . '.' . $extension;
                    $file->move($tempFolder, basename($tmpPath));

                    \Log::info('File HEIC dipindahkan ke sementara: ' . $tmpPath);

                    $imagick = new \Imagick($tmpPath);
                    $imagick->setImageFormat('jpg');
                    $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                    $imagick->setImageCompressionQuality(10);
                    $imagick->stripImage();
                    $imagick->writeImage($savePath);
                    $imagick->clear();
                    $imagick->destroy();

                    unlink($tmpPath);
                    \Log::info('Konversi HEIC sukses');
                } else {
                    \Log::info('File selain HEIC, diproses langsung');

                    $imagick = new \Imagick($file->getPathname());
                    $this->fixImageOrientation($imagick); //Untuk rotate
                    $imagick->setImageFormat('jpg');

                    $imageSize = $file->getSize();
                    $imagick->setImageCompressionQuality($imageSize > 2 * 1024 * 1024 ? 10 : 30);

                    $imagick->stripImage();
                    $imagick->writeImage($savePath);
                    $imagick->clear();
                    $imagick->destroy();
                }

                $fotoPath = $filename;
            } catch (\Exception $e) {
                \Log::error('Gagal upload foto tanggapan (HEIC/JPG): ' . $e->getMessage());
                return back()->withErrors(['foto' => 'Upload gagal: ' . $e->getMessage()]);
            }
        }

        $pengaduan->status = $request->status;
        $pengaduan->save();

        $tanggapan = $pengaduan->tanggapan ?? new Tanggapan();
        $tanggapan->pengaduan_id = $pengaduan->id;
        $tanggapan->user_id = auth()->id();
        $tanggapan->komentar = $request->komentar;
        if ($fotoPath) {
            $tanggapan->foto = $fotoPath;
        }
        $tanggapan->save();

        // Kirim email ke pelapor saat status berubah
        try {
            $pengaduan->user->notify(new \App\Notifications\PengaduanStatusUpdated($pengaduan));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email status pengaduan: ' . $e->getMessage());
        }

        \Log::info('Tanggapan berhasil disimpan');

        $user = auth()->user();

        if ($user->role === 'kepala_desa') {
            $route = 'kepala_desa.pengaduan.index';
            $message = 'Tanggapan berhasil disimpan.';
        } else {
            $route = 'admin.pengaduan.index';
            $message = 'Verifikasi berhasil disimpan.';
        }

        return redirect()->route($route)->with('success', $message);

    }

    private function fixImageOrientation(\Imagick $image)
    {
        $orientation = $image->getImageOrientation();

        switch ($orientation) {
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateImage("#000", 180);
                break;
            case \Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateImage("#000", 90);
                break;
            case \Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateImage("#000", -90);
                break;
        }

        $image->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
    }

    public function indexKepalaDesa(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $user = auth()->user();

        $query = Pengaduan::with('user')
            ->whereIn('status', ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak', 'ditunda']);

        // Pencarian (search)
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

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Jumlah data per halaman (default 10)
        $perPage = $request->get('perPage', 10);

        // Ambil data dengan pagination, dan pertahankan query string saat berpindah halaman
        $pengaduan = $query->latest()->paginate($perPage)->appends($request->all());

        return view('kepala_desa.pengaduan.index', compact('pengaduan', 'user'));
    }




}
