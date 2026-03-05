<?php

namespace App\Http\Controllers;

use App\Models\SuratArsip;
use App\Models\DesaInfo;
use Illuminate\Http\Request;

class PublicSuratController extends Controller
{
    /**
     * Menampilkan halaman verifikasi visual untuk scan QR code surat
     */
    public function verify(string $kode)
    {
        $surat = SuratArsip::where('qr_code', $kode)->first();
        
        $desaInfo = DesaInfo::where('key', 'profil')->first();
        $profil = $desaInfo ? $desaInfo->data : [];
        
        return view('surat.verify', [
            'surat' => $surat,
            'profil' => $profil,
        ]);
    }
}
