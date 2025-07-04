<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminPetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'kepala_desa']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $perPage = $request->get('perPage', 10);
        $users = $query->latest()->paginate($perPage)->appends($request->all());

        $roleList = ['admin', 'kepala_desa'];

        return view('admin.petugas.index', compact('users', 'roleList'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'role'     => 'required|in:admin,kepala_desa',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik'      => ['required', 'regex:/^[0-9]{16}$/', 'unique:users,nik'],
            'no_telp'  => ['required', 'regex:/^[0-9+\-\s()]{8,20}$/'],
            'alamat'   => 'required|string|max:255',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'nik'      => $request->nik,
            'no_telp'  => $request->no_telp,
            'alamat'   => $request->alamat,
            'foto'     => 'default.png'
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.petugas.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
