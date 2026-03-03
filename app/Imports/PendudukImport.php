<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class PendudukImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Penduduk([
            'nik'                       => $row['nik'],
            'nama'                      => $row['nama'],
            'tempat_lahir'              => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'             => $row['tanggal_lahir'] ?? null,
            'jenis_kelamin'             => $row['jenis_kelamin'] ?? null,
            'agama'                     => $row['agama'] ?? null,
            'status_perkawinan'         => $row['status_perkawinan'] ?? null,
            'pendidikan_dalam_kk'       => $row['pendidikan'] ?? null,
            'pekerjaan'                 => $row['pekerjaan'] ?? null,
            'status_hubungan_keluarga'  => $row['hubungan_keluarga'] ?? null,
            'no_kk'                     => $row['no_kk'] ?? null,
            'alamat_lengkap'            => $row['alamat'] ?? null,
            'kewarganegaraan'           => $row['kewarganegaraan'] ?? 'WNI',
            'status'                    => 'aktif',
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nik' => 'required|string|size:16|unique:penduduk,nik',
            '*.nama' => 'required|string|max:255',
        ];
    }
}
