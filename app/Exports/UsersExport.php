<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = User::with('masyarakat')->where('role', 'masyarakat');

        if ($this->request->filled('alamat')) {
            $query->whereHas('masyarakat', function ($q) {
                $q->where('alamat', $this->request->alamat);
            });
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('masyarakat', function ($q2) use ($search) {
                        $q2->where('nik', 'like', "%{$search}%")
                            ->orWhere('no_telp', 'like', "%{$search}%");
                    });
            });
        }

        return $query->latest()->get(); // Kembalikan object, BUKAN array
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email',
            'NIK',
            'No Telepon',
            'Alamat',
            'Tanggal Daftar',
        ];
    }

    public function map($user): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $user->name,
            $user->email,
            "'" . ($user->masyarakat->nik ?? '-'),
            "'" . ($user->masyarakat->no_telp ?? '-'),
            $user->masyarakat->alamat ?? '-',
            $user->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
