# Seeder: Bantuan Sosial & Pembangunan ✅

## 📦 Yang Sudah Di-Seed

### 1. Bantuan Sosial (BantuanSosialSeeder)

#### Program Bantuan (5 program):
1. ✅ **PKH** - Program Keluarga Harapan
   - Sumber: APBN (Kemensos)
   - Jenis: Uang Tunai
   - Nominal: Rp 3.000.000/tahun
   - Penerima: 5 orang

2. ✅ **BLT Desa** - Bantuan Langsung Tunai Desa
   - Sumber: APBDes
   - Jenis: Uang Tunai
   - Nominal: Rp 600.000/bulan
   - Penerima: 8 orang

3. ✅ **BPNT** - Bantuan Pangan Non Tunai
   - Sumber: APBN (Kemensos)
   - Jenis: Sembako
   - Nominal: Rp 200.000/bulan
   - Penerima: 7 orang

4. ✅ **PIP** - Program Indonesia Pintar
   - Sumber: APBN (Kemendikbud)
   - Jenis: Uang Tunai
   - Nominal: Rp 1.000.000/tahun
   - Penerima: 0 (belum ada)

5. ✅ **Sembako Desa** - Bantuan Sembako Desa
   - Sumber: APBDes
   - Jenis: Sembako
   - Nominal: Rp 150.000/paket
   - Penerima: 0 (belum ada)

**Total Penerima**: 20 orang dari 5 program

---

### 2. Pembangunan (PembangunanSeeder)

#### RKP Desa (3 kegiatan):
1. ✅ **Pembangunan Jalan Desa**
   - Bidang: Infrastruktur
   - Lokasi: Dusun Lesane Utara
   - Volume: 500 meter
   - Anggaran: Rp 150.000.000
   - Sumber: Dana Desa
   - Status: Disetujui

2. ✅ **Renovasi Balai Desa**
   - Bidang: Pemerintahan
   - Lokasi: Kantor Desa Lesane
   - Volume: 1 unit
   - Anggaran: Rp 75.000.000
   - Sumber: APBDes
   - Status: Berjalan

3. ✅ **Pembangunan Posyandu**
   - Bidang: Kesehatan
   - Lokasi: Dusun Lesane Selatan
   - Volume: 1 unit
   - Anggaran: Rp 50.000.000
   - Sumber: APBD Kabupaten
   - Status: Rencana

#### Kegiatan Pembangunan (3 kegiatan):
1. ✅ **Pengecoran Jalan Fase 1**
   - RKP: Pembangunan Jalan Desa
   - Panjang: 250m x 3.5m
   - Anggaran: Rp 75.000.000
   - Realisasi: Rp 45.000.000
   - Progres: 60%
   - Status: Berjalan
   - Kontraktor: CV Karya Mandiri

2. ✅ **Pengecoran Jalan Fase 2**
   - RKP: Pembangunan Jalan Desa
   - Panjang: 250m x 3.5m
   - Anggaran: Rp 75.000.000
   - Realisasi: Rp 0
   - Progres: 0%
   - Status: Perencanaan
   - Kontraktor: CV Karya Mandiri

3. ✅ **Renovasi Balai Desa**
   - RKP: Renovasi Balai Desa
   - Anggaran: Rp 75.000.000
   - Realisasi: Rp 30.000.000
   - Progres: 40%
   - Status: Berjalan
   - Kontraktor: Toko Bangunan Sejahtera

#### Inventaris Hasil (1 item):
1. ✅ **Jalan Cor Beton Dusun Lesane Utara**
   - Kegiatan: Pengecoran Jalan Fase 1
   - Nilai: Rp 75.000.000
   - Kondisi: Baik
   - Status: Dalam proses

#### Kader Masyarakat (10 kader):
- ✅ 3 Kader Posyandu
- ✅ 3 Kader PKK
- ✅ 2 Kader PAUD (dengan sertifikat)
- ✅ 2 Kader Karang Taruna

---

## 📊 Summary Data

| Kategori | Jumlah | Keterangan |
|----------|--------|------------|
| Program Bantuan | 5 | PKH, BLT, BPNT, PIP, Sembako |
| Penerima Bantuan | 20 | Terhubung ke penduduk |
| RKP Desa | 3 | Tahun 2026 |
| Kegiatan Pembangunan | 3 | 2 berjalan, 1 perencanaan |
| Inventaris | 1 | Jalan cor beton |
| Kader Masyarakat | 10 | 4 jenis kader |

---

## 🎯 Cara Menggunakan

### Run Seeder:
```bash
# Bantuan Sosial
php artisan db:seed --class=BantuanSosialSeeder

# Pembangunan
php artisan db:seed --class=PembangunanSeeder

# Atau keduanya sekaligus (tambahkan ke DatabaseSeeder)
php artisan db:seed
```

### Lihat Hasil:
1. Login admin: `http://localhost:8000/admin`
2. Menu **Bantuan Sosial**:
   - Program Bantuan → Lihat 5 program
   - Penerima Bantuan → Lihat 20 penerima
3. Menu **Pembangunan**:
   - RKP Desa → Lihat 3 RKP
   - Kegiatan Pembangunan → Lihat 3 kegiatan dengan progres
   - Inventaris → Lihat 1 inventaris
   - Kader Masyarakat → Lihat 10 kader

---

## 💡 Fitur Seeder

### BantuanSosialSeeder:
- ✅ 5 program bantuan realistis (PKH, BLT, BPNT, dll)
- ✅ Link ke penduduk yang ada
- ✅ Status aktif/nonaktif
- ✅ Tanggal diterima random
- ✅ Nominal sesuai program
- ✅ Periode (bulan/tahun)

### PembangunanSeeder:
- ✅ 3 RKP dengan bidang berbeda
- ✅ 3 kegiatan dengan progres berbeda (0%, 40%, 60%)
- ✅ Relasi RKP → Kegiatan
- ✅ Foto progres (JSON array)
- ✅ Tanggal mulai & selesai
- ✅ Kontraktor
- ✅ Anggaran & realisasi
- ✅ 10 kader dari 4 jenis (Posyandu, PKK, PAUD, Karang Taruna)

---

## 🔄 Reset & Re-seed

Jika ingin reset data:
```bash
# Hapus data bantuan
php artisan tinker
BantuanPenerima::truncate();
BantuanProgram::truncate();

# Hapus data pembangunan
PembangunanInventaris::truncate();
PembangunanKegiatan::truncate();
PembangunanRkp::truncate();
KaderMasyarakat::truncate();

# Jalankan ulang seeder
php artisan db:seed --class=BantuanSosialSeeder
php artisan db:seed --class=PembangunanSeeder
```

---

## 📝 Notes

### Dependencies:
- Seeder membutuhkan data **Penduduk** yang sudah ada
- Jika belum ada, jalankan `PendudukSeeder` dulu
- Seeder akan skip jika tidak ada penduduk

### Data Realistis:
- Program bantuan sesuai dengan program pemerintah yang ada (PKH, BLT, BPNT, PIP)
- Nominal sesuai dengan standar bantuan
- Kegiatan pembangunan sesuai dengan kebutuhan desa (jalan, balai, posyandu)
- Kader sesuai dengan jenis kader yang umum di desa

### Customization:
- Bisa tambah program bantuan lain
- Bisa tambah kegiatan pembangunan lain
- Bisa sesuaikan nominal
- Bisa tambah jenis kader lain

---

**Status**: ✅ SELESAI  
**Total Data**: 42 records  
**Run Time**: ~2 detik  
**Dependencies**: PendudukSeeder  
**Next**: Test CRUD operations di admin panel
