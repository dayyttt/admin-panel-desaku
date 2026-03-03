<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendudukSeeder extends Seeder
{
    public function run(): void
    {
        // Get wilayah IDs
        $rt1 = DB::table('wilayah')->where('kode', '001')->where('tipe', 'rt')->first()->id;
        $rt2 = DB::table('wilayah')->where('kode', '002')->where('tipe', 'rt')->first()->id;
        $rt3 = DB::table('wilayah')->where('kode', '003')->where('tipe', 'rt')->first()->id;
        $rt4 = DB::table('wilayah')->where('kode', '004')->where('tipe', 'rt')->first()->id;
        $rt5 = DB::table('wilayah')->where('kode', '005')->where('tipe', 'rt')->first()->id;

        // Create families and residents
        $families = [
            // Keluarga 1 - RT 001
            [
                'no_kk' => '8102042006010001',
                'wilayah_rt_id' => $rt1,
                'alamat' => 'Jl. Pantai Lesane No. 12',
                'members' => [
                    ['nama' => 'Ahmad Latuconsina', 'nik' => '8102040101750001', 'jk' => 'L', 'tgl_lahir' => '1975-03-15', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'nelayan', 'pendidikan' => 'slta'],
                    ['nama' => 'Fatimah Tuasamu', 'nik' => '8102040201780002', 'jk' => 'P', 'tgl_lahir' => '1978-07-22', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'ibu_rumah_tangga', 'pendidikan' => 'slta'],
                    ['nama' => 'Rizki Latuconsina', 'nik' => '8102040301000003', 'jk' => 'L', 'tgl_lahir' => '2000-05-10', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'wiraswasta', 'pendidikan' => 's1'],
                    ['nama' => 'Siti Latuconsina', 'nik' => '8102040401050004', 'jk' => 'P', 'tgl_lahir' => '2005-08-18', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'slta'],
                ],
            ],
            // Keluarga 2 - RT 001
            [
                'no_kk' => '8102042006010002',
                'wilayah_rt_id' => $rt1,
                'alamat' => 'Jl. Pantai Lesane No. 15',
                'members' => [
                    ['nama' => 'Ibrahim Laturua', 'nik' => '8102040501720005', 'jk' => 'L', 'tgl_lahir' => '1972-11-05', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'petani', 'pendidikan' => 'sltp'],
                    ['nama' => 'Aminah Hatala', 'nik' => '8102040601750006', 'jk' => 'P', 'tgl_lahir' => '1975-02-14', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'ibu_rumah_tangga', 'pendidikan' => 'sltp'],
                    ['nama' => 'Yusuf Laturua', 'nik' => '8102040701980007', 'jk' => 'L', 'tgl_lahir' => '1998-09-20', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'nelayan', 'pendidikan' => 'slta'],
                    ['nama' => 'Maryam Laturua', 'nik' => '8102040802020008', 'jk' => 'P', 'tgl_lahir' => '2002-12-25', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pedagang', 'pendidikan' => 'slta'],
                    ['nama' => 'Zahra Laturua', 'nik' => '8102040902080009', 'jk' => 'P', 'tgl_lahir' => '2008-04-30', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'sltp'],
                ],
            ],
            // Keluarga 3 - RT 002
            [
                'no_kk' => '8102042006020001',
                'wilayah_rt_id' => $rt2,
                'alamat' => 'Jl. Merdeka No. 8',
                'members' => [
                    ['nama' => 'Yohanis Sopaheluwakan', 'nik' => '8102041001680010', 'jk' => 'L', 'tgl_lahir' => '1968-06-12', 'hub' => 'kepala_keluarga', 'agama' => 'kristen', 'pekerjaan' => 'guru', 'pendidikan' => 's1'],
                    ['nama' => 'Maria Tuasela', 'nik' => '8102041101700011', 'jk' => 'P', 'tgl_lahir' => '1970-09-08', 'hub' => 'istri', 'agama' => 'kristen', 'pekerjaan' => 'guru', 'pendidikan' => 's1'],
                    ['nama' => 'Daniel Sopaheluwakan', 'nik' => '8102041201950012', 'jk' => 'L', 'tgl_lahir' => '1995-03-22', 'hub' => 'anak', 'agama' => 'kristen', 'pekerjaan' => 'pegawai_swasta', 'pendidikan' => 's1'],
                    ['nama' => 'Ester Sopaheluwakan', 'nik' => '8102041302000013', 'jk' => 'P', 'tgl_lahir' => '2000-11-15', 'hub' => 'anak', 'agama' => 'kristen', 'pekerjaan' => 'mahasiswa', 'pendidikan' => 's1'],
                ],
            ],
            // Keluarga 4 - RT 002
            [
                'no_kk' => '8102042006020002',
                'wilayah_rt_id' => $rt2,
                'alamat' => 'Jl. Merdeka No. 12',
                'members' => [
                    ['nama' => 'Hasan Tuasikal', 'nik' => '8102041401800014', 'jk' => 'L', 'tgl_lahir' => '1980-01-20', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'wiraswasta', 'pendidikan' => 'slta'],
                    ['nama' => 'Nur Hatala', 'nik' => '8102041501820015', 'jk' => 'P', 'tgl_lahir' => '1982-05-18', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'pedagang', 'pendidikan' => 'slta'],
                    ['nama' => 'Fahmi Tuasikal', 'nik' => '8102041602050016', 'jk' => 'L', 'tgl_lahir' => '2005-07-10', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'slta'],
                    ['nama' => 'Aisyah Tuasikal', 'nik' => '8102041702100017', 'jk' => 'P', 'tgl_lahir' => '2010-02-28', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'tamat_sd'],
                ],
            ],
            // Keluarga 5 - RT 003
            [
                'no_kk' => '8102042006030001',
                'wilayah_rt_id' => $rt3,
                'alamat' => 'Jl. Pemuda No. 5',
                'members' => [
                    ['nama' => 'Usman Laturette', 'nik' => '8102041801770018', 'jk' => 'L', 'tgl_lahir' => '1977-08-14', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'nelayan', 'pendidikan' => 'sltp'],
                    ['nama' => 'Halimah Tuasamu', 'nik' => '8102041901790019', 'jk' => 'P', 'tgl_lahir' => '1979-12-03', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'ibu_rumah_tangga', 'pendidikan' => 'sltp'],
                    ['nama' => 'Ilham Laturette', 'nik' => '8102042002010020', 'jk' => 'L', 'tgl_lahir' => '2001-04-16', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'nelayan', 'pendidikan' => 'slta'],
                ],
            ],
            // Keluarga 6 - RT 003
            [
                'no_kk' => '8102042006030002',
                'wilayah_rt_id' => $rt3,
                'alamat' => 'Jl. Pemuda No. 9',
                'members' => [
                    ['nama' => 'Rahmat Tuasela', 'nik' => '8102042101850021', 'jk' => 'L', 'tgl_lahir' => '1985-10-08', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'pegawai_swasta', 'pendidikan' => 's1'],
                    ['nama' => 'Dewi Hatala', 'nik' => '8102042201880022', 'jk' => 'P', 'tgl_lahir' => '1988-03-25', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'guru', 'pendidikan' => 's1'],
                    ['nama' => 'Alif Tuasela', 'nik' => '8102042302120023', 'jk' => 'L', 'tgl_lahir' => '2012-06-19', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'tamat_sd'],
                    ['nama' => 'Aisha Tuasela', 'nik' => '8102042402150024', 'jk' => 'P', 'tgl_lahir' => '2015-09-12', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'belum_tamat_sd'],
                ],
            ],
            // Keluarga 7 - RT 004
            [
                'no_kk' => '8102042006040001',
                'wilayah_rt_id' => $rt4,
                'alamat' => 'Jl. Diponegoro No. 3',
                'members' => [
                    ['nama' => 'Saleh Laturua', 'nik' => '8102042501650025', 'jk' => 'L', 'tgl_lahir' => '1965-02-10', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'petani', 'pendidikan' => 'tamat_sd'],
                    ['nama' => 'Khadijah Tuasikal', 'nik' => '8102042601670026', 'jk' => 'P', 'tgl_lahir' => '1967-07-28', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'ibu_rumah_tangga', 'pendidikan' => 'tamat_sd'],
                    ['nama' => 'Hamzah Laturua', 'nik' => '8102042701920027', 'jk' => 'L', 'tgl_lahir' => '1992-11-05', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'petani', 'pendidikan' => 'sltp'],
                    ['nama' => 'Zainab Laturua', 'nik' => '8102042801950028', 'jk' => 'P', 'tgl_lahir' => '1995-01-22', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pedagang', 'pendidikan' => 'sltp'],
                ],
            ],
            // Keluarga 8 - RT 004
            [
                'no_kk' => '8102042006040002',
                'wilayah_rt_id' => $rt4,
                'alamat' => 'Jl. Diponegoro No. 7',
                'members' => [
                    ['nama' => 'Ismail Hatala', 'nik' => '8102042901830029', 'jk' => 'L', 'tgl_lahir' => '1983-04-15', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'wiraswasta', 'pendidikan' => 'slta'],
                    ['nama' => 'Rahmawati Tuasamu', 'nik' => '8102043001860030', 'jk' => 'P', 'tgl_lahir' => '1986-08-20', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'pedagang', 'pendidikan' => 'slta'],
                    ['nama' => 'Faisal Hatala', 'nik' => '8102043102080031', 'jk' => 'L', 'tgl_lahir' => '2008-12-10', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'sltp'],
                    ['nama' => 'Fatimah Hatala', 'nik' => '8102043202130032', 'jk' => 'P', 'tgl_lahir' => '2013-03-05', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'tamat_sd'],
                ],
            ],
            // Keluarga 9 - RT 005
            [
                'no_kk' => '8102042006050001',
                'wilayah_rt_id' => $rt5,
                'alamat' => 'Jl. Sudirman No. 11',
                'members' => [
                    ['nama' => 'Yusuf Tuasela', 'nik' => '8102043301900033', 'jk' => 'L', 'tgl_lahir' => '1990-05-12', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'pegawai_swasta', 'pendidikan' => 's1'],
                    ['nama' => 'Laila Laturua', 'nik' => '8102043401920034', 'jk' => 'P', 'tgl_lahir' => '1992-09-18', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'guru', 'pendidikan' => 's1'],
                    ['nama' => 'Hasan Tuasela', 'nik' => '8102043502180035', 'jk' => 'L', 'tgl_lahir' => '2018-02-14', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'belum_bekerja', 'pendidikan' => 'tidak_belum_sekolah'],
                ],
            ],
            // Keluarga 10 - RT 005
            [
                'no_kk' => '8102042006050002',
                'wilayah_rt_id' => $rt5,
                'alamat' => 'Jl. Sudirman No. 15',
                'members' => [
                    ['nama' => 'Ridwan Sopaheluwakan', 'nik' => '8102043601870036', 'jk' => 'L', 'tgl_lahir' => '1987-11-20', 'hub' => 'kepala_keluarga', 'agama' => 'islam', 'pekerjaan' => 'wiraswasta', 'pendidikan' => 'slta'],
                    ['nama' => 'Salmah Tuasikal', 'nik' => '8102043701890037', 'jk' => 'P', 'tgl_lahir' => '1989-06-25', 'hub' => 'istri', 'agama' => 'islam', 'pekerjaan' => 'ibu_rumah_tangga', 'pendidikan' => 'slta'],
                    ['nama' => 'Nabil Sopaheluwakan', 'nik' => '8102043802110038', 'jk' => 'L', 'tgl_lahir' => '2011-10-08', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'sltp'],
                    ['nama' => 'Naila Sopaheluwakan', 'nik' => '8102043902160039', 'jk' => 'P', 'tgl_lahir' => '2016-04-22', 'hub' => 'anak', 'agama' => 'islam', 'pekerjaan' => 'pelajar', 'pendidikan' => 'tamat_sd'],
                ],
            ],
        ];

        foreach ($families as $family) {
            // Create keluarga
            $keluargaId = DB::table('keluarga')->insertGetId([
                'no_kk' => $family['no_kk'],
                'nama_kepala_keluarga' => $family['members'][0]['nama'],
                'wilayah_rt_id' => $family['wilayah_rt_id'],
                'alamat' => $family['alamat'],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create penduduk
            foreach ($family['members'] as $member) {
                DB::table('penduduk')->insert([
                    'nik' => $member['nik'],
                    'nama' => $member['nama'],
                    'jenis_kelamin' => $member['jk'],
                    'tanggal_lahir' => $member['tgl_lahir'],
                    'tempat_lahir' => 'Masohi',
                    'agama' => $member['agama'],
                    'pekerjaan' => $member['pekerjaan'],
                    'pendidikan_dalam_kk' => $member['pendidikan'],
                    'status_perkawinan' => in_array($member['hub'], ['kepala_keluarga', 'istri']) ? 'kawin' : 'belum_kawin',
                    'keluarga_id' => $keluargaId,
                    'status_hubungan_keluarga' => $member['hub'],
                    'wilayah_rt_id' => $family['wilayah_rt_id'],
                    'no_kk' => $family['no_kk'],
                    'status' => 'aktif',
                    'kewarganegaraan' => 'WNI',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add kelahiran data for 2026
        DB::table('kelahiran')->insert([
            'nama_bayi' => 'Muhammad Rizki',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2026-01-15',
            'tempat_lahir' => 'Puskesmas Lesane',
            'jam_lahir' => '08:30:00',
            'jenis_kelahiran' => 'tunggal',
            'urutan_kelahiran' => 1,
            'penolong_kelahiran' => 'bidan',
            'tempat_dilahirkan' => 'puskesmas',
            'berat_bayi' => '3200',
            'panjang_bayi' => '48',
            'nik_ayah' => '8102043301900033',
            'nama_ayah' => 'Yusuf Tuasela',
            'nik_ibu' => '8102043401920034',
            'nama_ibu' => 'Laila Laturua',
            'no_kk' => '8102042006050001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Seeded 10 families with 39 residents');
    }
}
