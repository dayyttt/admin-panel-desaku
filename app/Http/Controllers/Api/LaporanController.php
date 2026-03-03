<?php

namespace App\Http\Controllers\Api;

use App\Services\LaporanKependudukanService;
use Illuminate\Http\Request;

class LaporanController
{
    protected $laporanService;

    public function __construct(LaporanKependudukanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function kependudukanBulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $pdf = $this->laporanService->laporanBulanan($bulan, $tahun);

        return $pdf->stream("Laporan_Kependudukan_{$bulan}_{$tahun}.pdf");
    }

    public function kelompokRentan()
    {
        $pdf = $this->laporanService->laporanKelompokRentan();

        return $pdf->stream('Laporan_Kelompok_Rentan_' . now()->format('Y') . '.pdf');
    }
}
