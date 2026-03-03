<?php

namespace App\Http\Controllers\Api;

use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Kelahiran;
use App\Models\Kematian;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatistikController
{
    public function index(): JsonResponse
    {
        $totalPenduduk = Penduduk::count();
        $lk = Penduduk::where('jenis_kelamin', 'L')->count();
        $pr = Penduduk::where('jenis_kelamin', 'P')->count();

        return response()->json([
            'data' => [
                'total_penduduk' => $totalPenduduk,
                'laki_laki' => $lk,
                'perempuan' => $pr,
                'total_kk' => Keluarga::count(),
                'kelahiran_tahun_ini' => Kelahiran::whereYear('tanggal_lahir', now()->year)->count(),
                'kematian_tahun_ini' => Kematian::whereYear('tanggal_kematian', now()->year)->count(),
            ],
        ]);
    }

    public function agama(): JsonResponse
    {
        $data = Penduduk::select('agama', DB::raw('count(*) as total'))
            ->whereNotNull('agama')
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'agama' => ucfirst($row->agama),
                'total' => $row->total,
            ]);

        return response()->json(['data' => $data]);
    }

    public function pekerjaan(): JsonResponse
    {
        $data = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('pekerjaan', '!=', '')
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'pekerjaan' => ucwords(str_replace('_', ' ', $row->pekerjaan)),
                'total' => $row->total,
            ]);

        return response()->json(['data' => $data]);
    }

    public function pendidikan(): JsonResponse
    {
        $data = Penduduk::select('pendidikan_dalam_kk', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan_dalam_kk')
            ->groupBy('pendidikan_dalam_kk')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'pendidikan' => strtoupper(str_replace('_', ' ', $row->pendidikan_dalam_kk)),
                'total' => $row->total,
            ]);

        return response()->json(['data' => $data]);
    }

    public function umur(): JsonResponse
    {
        $now = Carbon::now();
        $groups = [
            '0-5' => [0, 5], '6-17' => [6, 17], '18-25' => [18, 25],
            '26-35' => [26, 35], '36-45' => [36, 45], '46-55' => [46, 55],
            '56-65' => [56, 65], '65+' => [65, 200],
        ];

        $data = [];
        foreach ($groups as $label => [$min, $max]) {
            $data[] = [
                'kelompok' => $label,
                'total' => Penduduk::whereNotNull('tanggal_lahir')
                    ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                    ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                    ->count(),
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function piramida(): JsonResponse
    {
        $now = Carbon::now();
        
        // Kelompok umur 5 tahunan untuk piramida
        $groups = [
            '0-4' => [0, 4], '5-9' => [5, 9], '10-14' => [10, 14], '15-19' => [15, 19],
            '20-24' => [20, 24], '25-29' => [25, 29], '30-34' => [30, 34], '35-39' => [35, 39],
            '40-44' => [40, 44], '45-49' => [45, 49], '50-54' => [50, 54], '55-59' => [55, 59],
            '60-64' => [60, 64], '65-69' => [65, 69], '70-74' => [70, 74], '75+' => [75, 150],
        ];

        $data = [];
        foreach ($groups as $label => [$min, $max]) {
            $lk = Penduduk::where('jenis_kelamin', 'L')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                ->count();
            
            $pr = Penduduk::where('jenis_kelamin', 'P')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                ->count();

            $data[] = [
                'kelompok' => $label,
                'laki_laki' => $lk,
                'perempuan' => $pr,
                'total' => $lk + $pr,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function kelompokRentan(): JsonResponse
    {
        $now = Carbon::now();

        $lansia = Penduduk::where('status', 'aktif')
            ->whereNotNull('tanggal_lahir')
            ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears(60))
            ->count();

        $balita = Penduduk::where('status', 'aktif')
            ->whereNotNull('tanggal_lahir')
            ->whereDate('tanggal_lahir', '>', $now->copy()->subYears(5))
            ->count();

        $disabilitas = Penduduk::where('status', 'aktif')
            ->where('cacat', true)
            ->count();

        // Ibu hamil bisa ditambahkan jika ada data suplemen
        $ibuHamil = 0; // TODO: Implementasi jika ada tabel data_suplemen

        return response()->json([
            'data' => [
                'lansia' => ['label' => 'Lansia (>60 tahun)', 'jumlah' => $lansia],
                'balita' => ['label' => 'Balita (<5 tahun)', 'jumlah' => $balita],
                'disabilitas' => ['label' => 'Penyandang Disabilitas', 'jumlah' => $disabilitas],
                'ibu_hamil' => ['label' => 'Ibu Hamil', 'jumlah' => $ibuHamil],
                'total_rentan' => $lansia + $balita + $disabilitas + $ibuHamil,
            ],
        ]);
    }
}
