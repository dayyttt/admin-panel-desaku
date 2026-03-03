<?php

namespace App\Http\Controllers\Api;

use App\Models\Wilayah;
use Illuminate\Http\JsonResponse;

class WilayahController
{
    public function index(): JsonResponse
    {
        $data = Wilayah::orderBy('urutan')
            ->get()
            ->map(fn ($w) => [
                'id' => $w->id,
                'nama' => $w->nama,
                'jenis' => $w->jenis,
                'ketua' => $w->ketua,
                'jumlah_kk' => $w->jumlah_kk,
                'jumlah_jiwa' => $w->jumlah_jiwa,
            ]);

        return response()->json(['data' => $data]);
    }
}
