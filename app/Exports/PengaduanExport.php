<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Pengaduan::with('user');

        // Filter untuk role kepala desa
        if (auth()->user()->role === 'kepala_desa') {
            $query->whereIn('status', ['terverifikasi', 'diproses', 'dieksekusi', 'ditolak', 'ditunda']);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('created_at', [$this->request->start_date, $this->request->end_date]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Pengirim', 'Judul', 'Isi', 'Status', 'Waktu'];
    }

    public function map($item): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $item->user->name ?? '-',
            $item->judul,
            $item->isi,
            ucfirst($item->status),
            $item->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold header
        ];
    }
}
