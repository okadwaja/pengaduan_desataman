<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Masyarakat;
use App\Models\Admin;
use App\Models\KepalaDesa;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->role === 'masyarakat') {
                Masyarakat::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nik' => $user->nik,
                        'no_telp' => $user->no_telp,
                        'alamat' => $user->alamat,
                        'foto' => $user->foto,
                    ]
                );
            } elseif ($user->role === 'admin') {
                Admin::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $user->nik, // Asumsi pakai NIK sebagai NIP dulu
                        'jabatan' => 'Admin Desa', // Default saja
                        'no_telp' => '081234567890',
                        'foto' => $user->foto,
                    ]
                );
            } elseif ($user->role === 'kepala_desa') {
                KepalaDesa::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $user->nik, // Asumsi pakai NIK sebagai NIP dulu
                        'masa_jabatan' => '2023-2029', // Bisa sesuaikan nanti
                        'no_telp' => '081234567890',
                        'foto' => $user->foto,
                    ]
                );
            }
        }

        $this->command->info('Data berhasil disalin ke tabel masyarakat, admin, dan kepala_desa.');
    }
}
