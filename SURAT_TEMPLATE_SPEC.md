# Spesifikasi 20 Template Surat - Sesuai SOW

## 📋 Daftar 20 Jenis Surat

Berdasarkan requirement SOW Sprint 3 & 4 (Burat Part 1 & 2), berikut 20 jenis surat yang akan dibuat:

---

## KATEGORI 1: ADMINISTRASI KEPENDUDUKAN (8 Surat)

### 1. Surat Pengantar KTP
**Kode**: SKT-KTP-001  
**Singkatan**: SP-KTP  
**Keperluan**: Pengantar pembuatan/perpanjangan KTP ke Disdukcapil

**Variabel Template**:
- `{nama_pemohon}` - Nama lengkap
- `{nik}` - NIK 16 digit
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{alamat}` - Alamat lengkap
- `{rt}` - RT
- `{rw}` - RW
- `{dusun}` - Dusun
- `{keperluan}` - Keperluan (buat baru/perpanjangan)

**Persyaratan**:
- Fotokopi KK
- Surat pengantar RT/RW
- Pas foto 3x4 (2 lembar)
- KTP lama (jika perpanjangan)

---

### 2. Surat Pengantar Kartu Keluarga
**Kode**: SKT-KK-002  
**Singkatan**: SP-KK  
**Keperluan**: Pengantar pembuatan/pembaruan KK

**Variabel Template**:
- `{nama_kepala_keluarga}` - Nama KK
- `{nik_kepala_keluarga}` - NIK KK
- `{no_kk}` - Nomor KK (jika ada)
- `{alamat}` - Alamat lengkap
- `{rt}` - RT
- `{rw}` - RW
- `{dusun}` - Dusun
- `{keperluan}` - Keperluan (buat baru/pembaruan/pecah KK)
- `{jumlah_anggota}` - Jumlah anggota keluarga

**Persyaratan**:
- KTP asli dan fotokopi
- KK lama (jika pembaruan)
- Surat nikah/akta kelahiran
- Surat pengantar RT/RW

---

### 3. Surat Keterangan Kelahiran
**Kode**: SKT-LHR-003  
**Singkatan**: SK-Lahir  
**Keperluan**: Pengurusan akta kelahiran

**Variabel Template**:
- `{nama_bayi}` - Nama bayi
- `{jenis_kelamin_bayi}` - L/P
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jam_lahir}` - Jam lahir
- `{nama_ayah}` - Nama ayah
- `{nik_ayah}` - NIK ayah
- `{nama_ibu}` - Nama ibu
- `{nik_ibu}` - NIK ibu
- `{no_kk}` - Nomor KK
- `{alamat}` - Alamat

**Persyaratan**:
- KTP orang tua
- Kartu Keluarga
- Surat keterangan lahir dari bidan/RS
- Surat nikah orang tua

---

### 4. Surat Keterangan Kematian
**Kode**: SKT-MTI-004  
**Singkatan**: SK-Mati  
**Keperluan**: Administrasi kematian

**Variabel Template**:
- `{nama_almarhum}` - Nama yang meninggal
- `{nik_almarhum}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{umur}` - Umur
- `{jenis_kelamin}` - L/P
- `{tanggal_meninggal}` - Tanggal meninggal
- `{jam_meninggal}` - Jam meninggal
- `{tempat_meninggal}` - Tempat meninggal
- `{sebab_kematian}` - Sebab kematian
- `{nama_pelapor}` - Nama pelapor
- `{hubungan_pelapor}` - Hubungan dengan almarhum

**Persyaratan**:
- KTP almarhum
- Kartu Keluarga
- Surat keterangan dari RT/RW
- Surat keterangan dari rumah sakit (jika ada)

---

### 5. Surat Keterangan Pindah
**Kode**: SKT-PND-005  
**Singkatan**: SK-Pindah  
**Keperluan**: Pindah ke luar wilayah desa

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{no_kk}` - Nomor KK
- `{alamat_asal}` - Alamat asal
- `{alamat_tujuan}` - Alamat tujuan
- `{alasan_pindah}` - Alasan pindah
- `{jumlah_keluarga_pindah}` - Jumlah yang pindah
- `{tanggal_pindah}` - Tanggal pindah

**Persyaratan**:
- KTP asli
- Kartu Keluarga asli
- Surat pengantar RT/RW
- Alasan pindah

---

### 6. Surat Keterangan Datang
**Kode**: SKT-DTG-006  
**Singkatan**: SK-Datang  
**Keperluan**: Pindah masuk ke wilayah desa

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{no_kk}` - Nomor KK
- `{alamat_asal}` - Alamat asal
- `{alamat_tujuan}` - Alamat tujuan di desa
- `{alasan_pindah}` - Alasan pindah
- `{tanggal_datang}` - Tanggal datang

**Persyaratan**:
- Surat pindah dari desa asal
- KTP
- Kartu Keluarga
- Surat pengantar RT/RW

---

### 7. Surat Keterangan Domisili
**Kode**: SKT-DOM-007  
**Singkatan**: SKD  
**Keperluan**: Keterangan berdomisili di desa

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat lengkap
- `{rt}` - RT
- `{rw}` - RW
- `{dusun}` - Dusun
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi Kartu Keluarga
- Surat pengantar RT/RW

---

### 8. Surat Keterangan Belum Menikah
**Kode**: SKT-BLM-008  
**Singkatan**: SK-Belum Nikah  
**Keperluan**: Keterangan status belum menikah

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{agama}` - Agama
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW

---

## KATEGORI 2: ADMINISTRASI UMUM (7 Surat)

### 9. Surat Keterangan Usaha (SKU)
**Kode**: SKT-USH-009  
**Singkatan**: SKU  
**Keperluan**: Keterangan memiliki usaha

**Variabel Template**:
- `{nama_pemohon}` - Nama pemilik
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{nama_usaha}` - Nama usaha
- `{jenis_usaha}` - Jenis usaha
- `{alamat_usaha}` - Alamat usaha
- `{tahun_berdiri}` - Tahun berdiri
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW
- Foto lokasi usaha

---

### 10. Surat Keterangan Tidak Mampu (SKTM)
**Kode**: SKT-TDM-010  
**Singkatan**: SKTM  
**Keperluan**: Keringanan biaya pendidikan/kesehatan

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{penghasilan}` - Penghasilan per bulan
- `{jumlah_tanggungan}` - Jumlah tanggungan
- `{keperluan}` - Keperluan (pendidikan/kesehatan/bantuan sosial)

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW
- Surat pernyataan tidak mampu

---

### 11. Surat Keterangan Penghasilan
**Kode**: SKT-PGH-011  
**Singkatan**: SK-Penghasilan  
**Keperluan**: Keterangan penghasilan

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{penghasilan_perbulan}` - Penghasilan per bulan
- `{sumber_penghasilan}` - Sumber penghasilan
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW
- Slip gaji (jika ada)

---

### 12. Surat Keterangan Ahli Waris
**Kode**: SKT-AHW-012  
**Singkatan**: SK-Ahli Waris  
**Keperluan**: Keterangan ahli waris

**Variabel Template**:
- `{nama_almarhum}` - Nama yang meninggal
- `{nik_almarhum}` - NIK almarhum
- `{tanggal_meninggal}` - Tanggal meninggal
- `{alamat_almarhum}` - Alamat almarhum
- `{daftar_ahli_waris}` - Daftar ahli waris (JSON array)
- `{nama_pemohon}` - Nama pemohon
- `{hubungan_pemohon}` - Hubungan dengan almarhum
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP ahli waris
- Fotokopi KK
- Surat keterangan kematian
- Surat pengantar RT/RW

---

### 13. Surat Keterangan Kehilangan
**Kode**: SKT-HLG-013  
**Singkatan**: SK-Hilang  
**Keperluan**: Keterangan kehilangan barang/dokumen

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{alamat}` - Alamat
- `{barang_hilang}` - Barang yang hilang
- `{ciri_ciri}` - Ciri-ciri barang
- `{tempat_hilang}` - Tempat hilang
- `{tanggal_hilang}` - Tanggal hilang
- `{kronologi}` - Kronologi kejadian
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW

---

### 14. Surat Keterangan Jalan
**Kode**: SKT-JLN-014  
**Singkatan**: SK-Jalan  
**Keperluan**: Izin membawa barang/kendaraan

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{alamat}` - Alamat
- `{jenis_barang}` - Jenis barang
- `{jumlah}` - Jumlah
- `{tujuan}` - Tujuan
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Surat pengantar RT/RW

---

### 15. Surat Pengantar SKCK
**Kode**: SKT-SKCK-015  
**Singkatan**: SP-SKCK  
**Keperluan**: Pengantar pembuatan SKCK

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{agama}` - Agama
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Pas foto 4x6 (6 lembar)
- Surat pengantar RT/RW

---

## KATEGORI 3: ADMINISTRASI NIKAH (3 Surat)

### 16. Surat Pengantar Nikah (N1)
**Kode**: SKT-N1-016  
**Singkatan**: N1  
**Keperluan**: Pengantar nikah ke KUA

**Variabel Template**:
- `{nama_calon_suami}` - Nama calon suami
- `{nik_calon_suami}` - NIK calon suami
- `{tempat_lahir_suami}` - Tempat lahir
- `{tanggal_lahir_suami}` - Tanggal lahir
- `{agama_suami}` - Agama
- `{pekerjaan_suami}` - Pekerjaan
- `{alamat_suami}` - Alamat
- `{status_suami}` - Status (jejaka/duda)
- `{nama_calon_istri}` - Nama calon istri
- `{nik_calon_istri}` - NIK calon istri
- `{tempat_lahir_istri}` - Tempat lahir
- `{tanggal_lahir_istri}` - Tanggal lahir
- `{agama_istri}` - Agama
- `{pekerjaan_istri}` - Pekerjaan
- `{alamat_istri}` - Alamat
- `{status_istri}` - Status (perawan/janda)

**Persyaratan**:
- KTP calon pengantin
- KK calon pengantin
- Akta kelahiran
- Pas foto 2x3 dan 3x4

---

### 17. Surat Keterangan Untuk Nikah (N2)
**Kode**: SKT-N2-017  
**Singkatan**: N2  
**Keperluan**: Keterangan belum pernah menikah

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{agama}` - Agama
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{status}` - Status (jejaka/perawan/duda/janda)

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Pas foto 2x3

---

### 18. Surat Keterangan Asal Usul (N4)
**Kode**: SKT-N4-018  
**Singkatan**: N4  
**Keperluan**: Keterangan asal usul untuk nikah

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{nama_ayah}` - Nama ayah
- `{nama_ibu}` - Nama ibu
- `{alamat}` - Alamat

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Akta kelahiran

---

## KATEGORI 4: LAIN-LAIN (2 Surat)

### 19. Surat Keterangan Umum
**Kode**: SKT-UMM-019  
**Singkatan**: SK-Umum  
**Keperluan**: Keterangan umum untuk berbagai keperluan

**Variabel Template**:
- `{nama_pemohon}` - Nama
- `{nik}` - NIK
- `{tempat_lahir}` - Tempat lahir
- `{tanggal_lahir}` - Tanggal lahir
- `{jenis_kelamin}` - L/P
- `{agama}` - Agama
- `{pekerjaan}` - Pekerjaan
- `{alamat}` - Alamat
- `{keterangan}` - Keterangan yang diminta
- `{keperluan}` - Keperluan

**Persyaratan**:
- Fotokopi KTP
- Fotokopi KK
- Surat pengantar RT/RW

---

### 20. Surat Kuasa
**Kode**: SKT-KUA-020  
**Singkatan**: SK-Kuasa  
**Keperluan**: Pemberian kuasa

**Variabel Template**:
- `{nama_pemberi_kuasa}` - Nama pemberi kuasa
- `{nik_pemberi_kuasa}` - NIK pemberi kuasa
- `{alamat_pemberi_kuasa}` - Alamat pemberi kuasa
- `{nama_penerima_kuasa}` - Nama penerima kuasa
- `{nik_penerima_kuasa}` - NIK penerima kuasa
- `{alamat_penerima_kuasa}` - Alamat penerima kuasa
- `{keperluan_kuasa}` - Keperluan kuasa
- `{masa_berlaku}` - Masa berlaku

**Persyaratan**:
- Fotokopi KTP pemberi kuasa
- Fotokopi KTP penerima kuasa
- Materai 10.000

---

## 📝 Format Nomor Surat

**Default Format**: `{nomor}/{kode}/{romawi}/{tahun}`

**Contoh**:
- `001/SKT-KTP-001/I/2026`
- `002/SKT-DOM-007/II/2026`

**Variabel**:
- `{nomor}` - Nomor urut (auto increment per tahun)
- `{kode}` - Kode surat
- `{singkatan}` - Singkatan surat
- `{romawi}` - Bulan dalam romawi (I-XII)
- `{tahun}` - Tahun 4 digit

---

## 🎯 Implementasi

### Yang Akan Dibuat:

1. **Seeder** - `SuratJenisSeeder.php`
   - 20 jenis surat dengan data lengkap
   - Variabel template (JSON)
   - Persyaratan (relation)
   - Format nomor
   - Pengaturan TTD & online

2. **Kategori Surat** - 4 kategori:
   - Administrasi Kependudukan
   - Administrasi Umum
   - Administrasi Nikah
   - Lain-lain

3. **Template .docx** (Optional):
   - Bisa dibuat manual via admin panel
   - Atau saya buatkan contoh template

---

## ✅ Checklist

- [ ] Buat SuratKategoriSeeder (4 kategori)
- [ ] Buat SuratJenisSeeder (20 jenis surat)
- [ ] Buat SuratPersyaratanSeeder (persyaratan per jenis)
- [ ] Run seeder
- [ ] Test di admin panel
- [ ] Upload template .docx (optional)

---

**Status**: Ready to Implement  
**Total Jenis Surat**: 20  
**Total Kategori**: 4  
**Sesuai SOW**: ✅ YES
