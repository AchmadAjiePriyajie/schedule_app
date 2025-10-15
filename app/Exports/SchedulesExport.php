<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class SchedulesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Schedule::query();

        if ($this->startDate) {
            $query->whereDate('start_time', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('end_time', '<=', $this->endDate);
        }

        return $query->get()->map(function ($item) {
            return [
                'Nomor Surat' => $item->nomor_surat,
                'Nama Kegiatan' => $item->name,
                'Deskripsi' => $item->description,
                'Lokasi' => $item->location,
                'Waktu Mulai' => Carbon::parse($item->start_time)->locale('id')->translatedFormat('d F Y H:i'),
                'Waktu Selesai' => Carbon::parse($item->end_time)->locale('id')->translatedFormat('d F Y H:i'),
                'Status' => $this->statusLabel($item->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Nama Kegiatan',
            'Deskripsi',
            'Lokasi',
            'Waktu Mulai',
            'Waktu Selesai',
            'Status',
        ];
    }

    private function statusLabel($status)
    {
        return match ($status) {
            0 => 'Ditolak',
            1 => 'Disetujui',
            2 => 'Menunggu',
            default => 'Tidak Diketahui',
        };
    }
}
