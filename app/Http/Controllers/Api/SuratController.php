<?php

namespace App\Http\Controllers\Api;

use App\Models\SuratJenis;
use App\Models\SuratArsip;
use Illuminate\Http\JsonResponse;

class SuratController
{
    /** Daftar jenis surat yang tersedia online */
    public function jenis(): JsonResponse
    {
        $data = SuratJenis::where('aktif', true)
            ->where('bisa_online', true)
            ->orderBy('kode')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'kode' => $s->kode,
                'singkatan' => $s->singkatan,
                'nama' => $s->nama,
                'kategori' => $s->kategori?->nama ?? null,
            ]);

        return response()->json(['data' => $data]);
    }

    /** Verifikasi surat via kode unik */
    public function verifikasi(string $kode): JsonResponse
    {
        $surat = SuratArsip::where('qr_code', $kode)->first();

        if (!$surat) {
            return response()->json(['valid' => false, 'message' => 'Surat tidak ditemukan'], 404);
        }

        return response()->json([
            'valid' => true,
            'data' => [
                'nomor_surat' => $surat->nomor_surat,
                'jenis_surat' => $surat->jenisSurat?->nama,
                'tanggal_surat' => $surat->tanggal_surat?->format('d/m/Y'),
                'perihal' => $surat->perihal,
                'status' => $surat->status,
            ],
        ]);
    }
}
