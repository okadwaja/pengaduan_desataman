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

        // Tentukan model tempat menyimpan foto berdasarkan role
        $profilModel = null;

        if ($user->role === 'masyarakat') {
            $profilModel = $user->masyarakat;
        } elseif ($user->role === 'admin') {
            $profilModel = $user->admin;
        } elseif ($user->role === 'kepala_desa') {
            $profilModel = $user->kepalaDesa;
        }

        // === HANDLE FOTO === //
        if ($profilModel) {
            if ($request->filled('cropped_image')) {
                if ($profilModel->foto && $profilModel->foto !== 'default.png' && \Storage::disk('public')->exists('foto_profil/' . $profilModel->foto)) {
                    \Storage::disk('public')->delete('foto_profil/' . $profilModel->foto);
                }

                $base64Image = $request->input('cropped_image');
                if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
                    $base64Image = base64_decode(substr($base64Image, strpos($base64Image, ',') + 1));
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($base64Image)->toJpeg(80);
                    $filename = 'foto_' . time() . '.jpg';
                    \Storage::disk('public')->put("foto_profil/{$filename}", $image);
                    $profilModel->foto = $filename;
                } else {
                    return back()->with('error', 'Gagal membaca gambar hasil crop.');
                }
            } elseif ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_profil', $filename, 'public');

                if ($profilModel->foto && $profilModel->foto !== 'default.png' && \Storage::disk('public')->exists('foto_profil/' . $profilModel->foto)) {
                    \Storage::disk('public')->delete('foto_profil/' . $profilModel->foto);
                }

                $profilModel->foto = $filename;
            }

            $profilModel->save();
        }

        // === UPDATE DATA USER === //
        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // === UPDATE DATA DETAIL SESUAI ROLE === //
        if ($user->role === 'masyarakat' && $user->masyarakat) {
            $user->masyarakat->update([
                'nik' => $request->input('nik'),
                'no_telp' => $request->input('no_telp'),
                'alamat' => $request->input('alamat'),
            ]);
        }

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
