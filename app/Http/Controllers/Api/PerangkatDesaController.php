<?php

namespace App\Http\Controllers\Api;

use App\Models\PerangkatDesa;
use Illuminate\Http\JsonResponse;

class PerangkatDesaController
{
    public function index(): JsonResponse
    {
        $data = PerangkatDesa::where('status', 'aktif')
            ->orderBy('urutan')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'nama' => $p->nama,
                'nip' => $p->nip,
                'jabatan' => $p->jabatan,
                'foto' => $p->foto ? asset('storage/' . $p->foto) : null,
                'no_hp' => $p->no_hp,
            ]);

        return response()->json(['data' => $data]);
    }
}
