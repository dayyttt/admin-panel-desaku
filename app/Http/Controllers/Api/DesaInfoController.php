<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DesaInfo;
use Illuminate\Http\Request;

class DesaInfoController extends Controller
{
    /**
     * Get info by key
     */
    public function show($key)
    {
        $info = DesaInfo::where('key', $key)
            ->where('aktif', true)
            ->first();

        if (!$info) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'key' => $info->key,
            'data' => $info->data,
        ]);
    }

    /**
     * Get all info
     */
    public function index()
    {
        $infos = DesaInfo::where('aktif', true)->get();

        return response()->json([
            'data' => $infos->mapWithKeys(function ($info) {
                return [$info->key => $info->data];
            }),
        ]);
    }
}
