<?php

namespace App\Http\Controllers\Api;

use App\Models\Apbdes;
use Illuminate\Http\JsonResponse;

class KeuanganController
{
    public function ringkasan(): JsonResponse
    {
        $apbdes = Apbdes::where('status', 'aktif')->latest('tahun')->first();

        if (!$apbdes) {
            return response()->json(['message' => 'Belum ada APBDes aktif'], 404);
        }

        return response()->json([
            'data' => [
                'tahun' => $apbdes->tahun,
                'total_pendapatan' => (float) $apbdes->total_pendapatan,
                'total_belanja' => (float) $apbdes->total_belanja,
                'total_pembiayaan' => (float) $apbdes->total_pembiayaan,
                'surplus_defisit' => (float) $apbdes->surplus_defisit,
                'bidang' => $apbdes->bidang()
                    ->where('level', 'bidang')
                    ->orderBy('urutan')
                    ->get()
                    ->map(fn ($b) => [
                        'kode' => $b->kode,
                        'nama' => $b->nama,
                        'jenis' => $b->jenis,
                        'anggaran' => (float) $b->anggaran,
                        'realisasi' => (float) $b->realisasi,
                        'persentase' => $b->persentase_realisasi,
                    ]),
            ],
        ]);
    }
}
