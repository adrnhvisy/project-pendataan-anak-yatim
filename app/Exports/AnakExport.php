<?php

namespace App\Exports;

use App\Models\Anak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; 
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class AnakExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filter;
    protected $onlyVerified;
    protected $tahun;

    // Menambahkan parameter baru pada constructor
    public function __construct($filter, $onlyVerified, $tahun)
    {
        $this->filter = $filter;
        $this->onlyVerified = $onlyVerified;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Anak::with(['alamatDomisili.kelurahan.kecamatan', 'pembuatData', 'orangTua']);

        // Filter status verifikasi (disetujui)
        if ($this->onlyVerified) {
            $query->where('status_data', 'Disetujui');
        }

        // Filter tahun
        if ($this->tahun && $this->tahun !== 'all') {
            $query->whereYear('created_at', $this->tahun);
        }

        // Filter umur
        if ($this->filter === 'under18') {
            $query->whereDate('tanggal_lahir', '>', Carbon::today()->subYears(18));
        }

        return $query->get();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF004AC6']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'No', 'Nomor Registrasi', 'Nama Anak', 'NIK', 'No KK', 'No Rekening', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'Umur', 'Status Anak', 'Status Data',
            'Alamat Domisili', 'Orang Tua (Ayah - Ibu)', 'Kelurahan', 'Kecamatan', 
            'Pendamping/Input Oleh', 'Tanggal Dibuat'
        ];
    }

    public function map($anak): array
    {
        $ayah = $anak->orangTua->where('jenis_orang_tua', 'Ayah')->first()->nama ?? '-';
        $ibu = $anak->orangTua->where('jenis_orang_tua', 'Ibu')->first()->nama ?? '-';
        
        $alamatLengkap = $anak->alamatDomisili->alamat_lengkap ?? '-';
        $rtRw = ($anak->alamatDomisili->rt ?? '-') . '/' . ($anak->alamatDomisili->rw ?? '-');
        $alamatFull = "{$alamatLengkap} (RT/RW: {$rtRw})";

        return [
            $anak->id,
            $anak->no_registrasi,
            $anak->nama_lengkap,
            "'" . $anak->nik, 
            "'" . $anak->no_kk,
            $anak->no_rekening ? "'" . $anak->no_rekening : '-', 
            $anak->jenis_kelamin,
            $anak->tempat_lahir,
            $anak->tanggal_lahir,
            Carbon::parse($anak->tanggal_lahir)->age . ' Tahun',
            $anak->status_anak,
            $anak->status_data,
            $alamatFull,
            "Ayah: {$ayah} | Ibu: {$ibu}",
            $anak->alamatDomisili->kelurahan->nama_kelurahan ?? '-',
            $anak->alamatDomisili->kelurahan->kecamatan->nama_kecamatan ?? '-',
            $anak->pembuatData->name ?? '-',
            $anak->created_at->format('d/m/Y'),
        ];
    }
}   