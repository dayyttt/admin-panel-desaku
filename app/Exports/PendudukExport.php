<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class PendudukExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Penduduk::query()->with('keluarga', 'wilayahRt');

        if (!empty($this->filters['jenis_kelamin'])) {
            $query->where('jenis_kelamin', $this->filters['jenis_kelamin']);
        }
        if (!empty($this->filters['agama'])) {
            $query->where('agama', $this->filters['agama']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir',
            'Jenis Kelamin', 'Agama', 'Status Perkawinan',
            'Pendidikan', 'Pekerjaan', 'No. KK',
            'Alamat', 'RT', 'Status',
        ];
    }

    public function map($penduduk): array
    {
        return [
            $penduduk->nik,
            $penduduk->nama,
            $penduduk->tempat_lahir,
            $penduduk->tanggal_lahir?->format('d/m/Y'),
            $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            ucfirst($penduduk->agama ?? ''),
            str_replace('_', ' ', ucfirst($penduduk->status_perkawinan ?? '')),
            $penduduk->pendidikan_dalam_kk,
            $penduduk->pekerjaan,
            $penduduk->keluarga?->no_kk,
            $penduduk->alamat_lengkap,
            $penduduk->wilayahRt?->nama,
            ucfirst($penduduk->status ?? 'aktif'),
        ];
    }
}
