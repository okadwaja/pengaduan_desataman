<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $user = $request->user();

        // Hapus foto lama jika akan diganti
        if ($request->filled('cropped_image')) {

            // Hapus foto lama
            if ($user->foto && $user->foto !== 'default.png' && \Storage::disk('public')->exists('foto_profil/' . $user->foto)) {
                \Storage::disk('public')->delete('foto_profil/' . $user->foto);
            }

            // Simpan foto baru dari base64
            $base64Image = $request->input('cropped_image');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $base64Image = base64_decode($base64Image);

                $manager = new ImageManager(new Driver());
                $image = $manager->read($base64Image)->toJpeg(80);
                $filename = 'foto_' . time() . '.jpg';

                \Storage::disk('public')->put("foto_profil/{$filename}", $image);
                $user->foto = $filename;
            } else {
                return back()->with('error', 'Gagal membaca gambar hasil crop.');
            }
        }

    // hanya proses file jika *tidak* ada cropped_image
    elseif (!$request->filled('cropped_image') && $request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('foto_profil', $filename, 'public');

        if ($user->foto && \Storage::disk('public')->exists('foto_profil/' . $user->foto)) {
            \Storage::disk('public')->delete('foto_profil/' . $user->foto);
        }

        $user->foto = $filename;
    }


        // Kalau tidak ada cropped_image tapi user upload langsung
        elseif ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_profil', $filename, 'public');

            if ($user->foto && \Storage::disk('public')->exists('foto_profil/' . $user->foto)) {
                \Storage::disk('public')->delete('foto_profil/' . $user->foto);
            }

            $user->foto = $filename;
        }

        // Simpan data lainnya
        // Ambil semua data validasi, tapi kecualikan field 'foto'
        $data = $request->except('foto', 'cropped_image');
        $user->fill($data);


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(Request $request): View
    {
        $user = $request->user();
        return view('profile.show', compact('user'));
    }

}
