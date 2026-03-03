<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebSlider;
use App\Models\WebArtikel;
use App\Models\WebGaleri;
use App\Models\WebPotensi;
use App\Models\WebHalaman;
use App\Models\WebTeksBerjalan;
use App\Models\Lapak;
use App\Models\DesaConfig;
use Illuminate\Http\Request;

class WebPublikController extends Controller
{
    // Slider Hero
    public function slider()
    {
        $sliders = WebSlider::aktif()->get();
        return response()->json($sliders);
    }

    // Teks Berjalan
    public function teksBerjalan()
    {
        $teks = WebTeksBerjalan::aktif()->get();
        return response()->json($teks);
    }

    // Artikel/Berita
    public function artikel(Request $request)
    {
        $query = WebArtikel::published()->latest('published_at');

        if ($request->kategori) {
            $query->kategori($request->kategori);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhere('konten', 'like', "%{$request->search}%");
            });
        }

        $artikel = $query->paginate($request->per_page ?? 12);
        return response()->json($artikel);
    }

    public function artikelDetail($slug)
    {
        $artikel = WebArtikel::published()->where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $artikel->increment('view_count');

        return response()->json($artikel);
    }

    // Galeri
    public function galeri(Request $request)
    {
        $query = WebGaleri::published()->latest('tanggal_kegiatan');

        if ($request->tipe) {
            $query->tipe($request->tipe);
        }

        $galeri = $query->paginate($request->per_page ?? 12);
        return response()->json($galeri);
    }

    // Potensi Desa
    public function potensi(Request $request)
    {
        $query = WebPotensi::published();

        if ($request->kategori) {
            $query->kategori($request->kategori);
        }

        $potensi = $query->get();
        return response()->json($potensi);
    }

    // Lapak UMKM
    public function lapak(Request $request)
    {
        $query = Lapak::published()->latest();

        if ($request->kategori) {
            $query->kategori($request->kategori);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_usaha', 'like', "%{$request->search}%")
                    ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        $lapak = $query->paginate($request->per_page ?? 12);
        return response()->json($lapak);
    }

    public function lapakDetail($slug)
    {
        $lapak = Lapak::published()->where('slug', $slug)->firstOrFail();
        return response()->json($lapak);
    }

    // Halaman Statis
    public function halaman($slug)
    {
        $halaman = WebHalaman::published()->where('slug', $slug)->firstOrFail();
        return response()->json($halaman);
    }

    public function halamanMenu()
    {
        $halaman = WebHalaman::tampilMenu()->get();
        return response()->json($halaman);
    }

    // Konfigurasi Desa
    public function desaConfig()
    {
        $config = DesaConfig::first();
        return response()->json($config);
    }
}
