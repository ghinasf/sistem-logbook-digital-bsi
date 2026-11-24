<?php

namespace App\Exports;

use App\Models\Logbook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogbookExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Logbook::with(['guest', 'purpose'])
            ->whereBetween('check_in', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jam Masuk', 'Jam Keluar', 'Nama Tamu', 'Instansi', 'Tujuan', 'Status'];
    }

    public function map($logbook): array
    {
        return [
            $logbook->check_in,
            \Carbon\Carbon::parse($logbook->check_in)->format('H:i'),
            $logbook->check_out ? \Carbon\Carbon::parse($logbook->check_out)->format('H:i') : '-',
            $logbook->guest->name,
            $logbook->guest->institution,
            $logbook->purpose->name,
            $logbook->status,
        ];
    }
}
