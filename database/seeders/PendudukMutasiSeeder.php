<?php

namespace Database\Seeders;

use App\Models\PendudukMutasi;
use App\Models\Penduduk;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\PendudukPindah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PendudukMutasiSeeder extends Seeder
{
    public function run(): void
    {
        $mutasi = [];

        // 1. Log mutasi dari data kelahiran
        $kelahiran = Kelahiran::all();
        foreach ($kelahiran as $k) {
            $mutasi[] = [
                'penduduk_id' => $k->penduduk_id,
                'nik' => $k->penduduk_id ? Penduduk::find($k->penduduk_id)?->nik : '0000000000000000',
                'jenis_mutasi' => 'lahir',
                'data_sebelum' => null,
                'data_sesudah' => json_encode([
                    'nama_bayi' => $k->nama_bayi,
                    'jenis_kelamin' => $k->jenis_kelamin,
                    'tanggal_lahir' => $k->tanggal_lahir,
                    'tempat_lahir' => $k->tempat_lahir,
                    'nama_ayah' => $k->nama_ayah,
                    'nama_ibu' => $k->nama_ibu,
                    'no_akta_lahir' => $k->no_akta_lahir,
                ]),
                'keterangan' => 'Kelahiran bayi ' . $k->nama_bayi . ' di ' . $k->tempat_dilahirkan,
                'diinput_oleh' => 1,
                'tanggal_mutasi' => $k->tanggal_lahir,
                'created_at' => $k->created_at,
                'updated_at' => $k->updated_at,
            ];
        }

        // 2. Log mutasi dari data kematian
        $kematian = Kematian::with('penduduk')->get();
        foreach ($kematian as $k) {
            $dataSebelum = null;
            if ($k->penduduk) {
                $dataSebelum = [
                    'nik' => $k->penduduk->nik,
                    'nama' => $k->penduduk->nama,
                    'status' => $k->penduduk->status,
                ];
            }

            $mutasi[] = [
                'penduduk_id' => $k->penduduk_id,
                'nik' => $k->nik,
                'jenis_mutasi' => 'mati',
                'data_sebelum' => $dataSebelum ? json_encode($dataSebelum) : null,
                'data_sesudah' => json_encode([
                    'nik' => $k->nik,
                    'nama' => $k->nama,
                    'tanggal_kematian' => $k->tanggal_kematian,
                    'tempat_kematian' => $k->tempat_kematian,
                    'penyebab_kematian' => $k->penyebab_kematian,
                    'no_akta_kematian' => $k->no_akta_kematian,
                    'status' => 'mati',
                ]),
                'keterangan' => 'Kematian ' . $k->nama . ' di ' . $k->tempat_kematian . ' karena ' . $k->penyebab_kematian,
                'diinput_oleh' => 1,
                'tanggal_mutasi' => $k->tanggal_kematian,
                'created_at' => $k->created_at,
                'updated_at' => $k->updated_at,
            ];
        }

        // 3. Log mutasi dari data pindah
        $pindah = PendudukPindah::with('penduduk')->get();
        foreach ($pindah as $p) {
            $dataSebelum = null;
            if ($p->penduduk) {
                $dataSebelum = [
                    'nik' => $p->penduduk->nik,
                    'nama' => $p->penduduk->nama,
                    'status' => $p->penduduk->status,
                    'alamat' => $p->penduduk->alamat_lengkap,
                ];
            }

            $jenisMutasi = $p->jenis === 'pindah_keluar' ? 'pindah_keluar' : 'datang';
            
            $dataSesudah = [
                'nik' => $p->nik,
                'nama' => $p->nama,
                'jenis' => $p->jenis,
                'tanggal_pindah' => $p->tanggal_pindah,
                'no_surat_pindah' => $p->no_surat_pindah,
            ];

            if ($p->jenis === 'pindah_keluar') {
                $dataSesudah['alamat_tujuan'] = $p->alamat_tujuan;
                $dataSesudah['desa_tujuan'] = $p->desa_tujuan;
                $dataSesudah['kabupaten_tujuan'] = $p->kabupaten_tujuan;
                $dataSesudah['alasan_pindah'] = $p->alasan_pindah;
                $dataSesudah['status'] = 'pindah';
                $keterangan = 'Pindah keluar ke ' . $p->desa_tujuan . ', ' . $p->kabupaten_tujuan;
            } else {
                $dataSesudah['alamat_asal'] = $p->alamat_asal;
                $dataSesudah['desa_asal'] = $p->desa_asal;
                $dataSesudah['kabupaten_asal'] = $p->kabupaten_asal;
                $dataSesudah['alasan_datang'] = $p->alasan_datang;
                $dataSesudah['status'] = 'aktif';
                $keterangan = 'Pindah masuk dari ' . $p->desa_asal . ', ' . $p->kabupaten_asal;
            }

            $mutasi[] = [
                'penduduk_id' => $p->penduduk_id,
                'nik' => $p->nik,
                'jenis_mutasi' => $jenisMutasi,
                'data_sebelum' => $dataSebelum ? json_encode($dataSebelum) : null,
                'data_sesudah' => json_encode($dataSesudah),
                'keterangan' => $keterangan,
                'diinput_oleh' => 1,
                'tanggal_mutasi' => $p->tanggal_pindah,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
            ];
        }

        // 4. Tambahkan beberapa log mutasi "ubah_data" untuk penduduk yang sudah ada
        $pendudukSample = Penduduk::limit(3)->get();
        foreach ($pendudukSample as $p) {
            $tanggalMutasi = Carbon::now()->subMonths(rand(1, 6));
            
            $mutasi[] = [
                'penduduk_id' => $p->id,
                'nik' => $p->nik,
                'jenis_mutasi' => 'ubah_data',
                'data_sebelum' => json_encode([
                    'alamat_lengkap' => 'Alamat lama',
                    'pekerjaan' => 'Pekerjaan lama',
                ]),
                'data_sesudah' => json_encode([
                    'alamat_lengkap' => $p->alamat_lengkap,
                    'pekerjaan' => $p->pekerjaan,
                ]),
                'keterangan' => 'Update data alamat dan pekerjaan',
                'diinput_oleh' => 1,
                'tanggal_mutasi' => $tanggalMutasi,
                'created_at' => $tanggalMutasi,
                'updated_at' => $tanggalMutasi,
            ];
        }

        PendudukMutasi::insert($mutasi);
        
        $this->command->info('✅ Berhasil membuat ' . count($mutasi) . ' log mutasi penduduk');
    }
}
