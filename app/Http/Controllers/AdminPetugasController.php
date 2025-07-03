<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\KepalaDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminPetugasController extends Controller
{
    /**
     * Tampilkan daftar petugas (admin dan kepala desa).
     */
    public function index(Request $request)
    {
        \Carbon\Carbon::setLocale('id');

        $query = User::whereIn('role', ['admin', 'kepala_desa'])
                    ->with(['admin', 'kepalaDesa']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('admin', function ($q2) use ($search) {
                        $q2->where('nip', 'like', "%{$search}%")
                            ->orWhere('no_telp', 'like', "%{$search}%")
                            ->orWhere('jabatan', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kepalaDesa', function ($q3) use ($search) {
                        $q3->where('nip', 'like', "%{$search}%")
                            ->orWhere('no_telp', 'like', "%{$search}%")
                            ->orWhere('masa_jabatan', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Jumlah data per halaman
        $perPage = $request->get('perPage', 10);

        $users = $query->latest()->paginate($perPage)->appends($request->all());

        // Daftar role untuk dropdown
        $roleList = ['admin', 'kepala_desa'];

        return view('admin.petugas.index', compact('users', 'roleList'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function show($id)
    {
        $user = User::with(['admin', 'kepalaDesa'])->findOrFail($id);

        if (!in_array($user->role, ['admin', 'kepala_desa'])) {
            return redirect()->route('admin.petugas.index')->with('error', 'Data tidak ditemukan atau bukan petugas.');
        }

        return view('admin.petugas.show', compact('user'));
    }


    /**
     * Simpan petugas baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'role'        => ['required', Rule::in(['admin', 'kepala_desa'])],
            'nip'         => ['required', 'numeric', 'digits_between:8,20'],
            'no_telp'     => ['required', 'regex:/^[0-9+\-\s()]{8,20}$/'],
            'jabatan'     => ['nullable', 'string', 'max:255'],         // hanya untuk admin
            'masa_jabatan'=> ['nullable', 'string', 'max:255'],         // hanya untuk kepala desa
        ]);

        // Buat user utama
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Tambahkan ke tabel relasi sesuai role
        if ($request->role === 'admin') {
            Admin::create([
                'user_id' => $user->id,
                'nip'     => $request->nip,
                'jabatan' => $request->jabatan ?? 'Staf',
                'no_telp' => $request->no_telp,
                'foto'    => 'default.png',
            ]);
        } elseif ($request->role === 'kepala_desa') {
            KepalaDesa::create([
                'user_id'      => $user->id,
                'nip'          => $request->nip,
                'masa_jabatan' => $request->masa_jabatan ?? '-',
                'no_telp'      => $request->no_telp,
                'foto'         => 'default.png',
            ]);
        }

        return redirect()->route('admin.petugas.index')->with('success', 'Akun petugas berhasil ditambahkan.');
    }
}
