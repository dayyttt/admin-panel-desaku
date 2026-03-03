# Roadmap: Yang Masih Kurang dari OpenSID

## 📊 Status Saat Ini (2 Maret 2026)

### ✅ Yang Sudah Ada (36 resources - 48% coverage):
1. ✅ Info Desa (3 resources) - 100%
2. ✅ Kependudukan (7 resources) - 100%
3. ✅ Persuratan (7 resources) - 90% (3 tabel minor belum)
4. ✅ Keuangan (5 resources) - 100%
5. ✅ Web Publik (8 resources) - 70% (5 tabel lanjutan belum)
6. ✅ Bantuan Sosial (2 resources) - 100% ← BARU SELESAI
7. ✅ Pembangunan (4 resources) - 100% ← BARU SELESAI

---

## 🎯 Yang Masih Kurang (39 resources - 52% remaining)

### Priority 1: Aset & Sekretariat (7 resources)
**Estimasi**: 1-2 minggu | **Tabel**: Sudah ada di migration

#### A. Aset & Inventaris (4 resources):
1. ❌ `AsetKategoriResource` - Kategori aset desa
2. ❌ `AsetResource` - Inventaris aset desa
3. ❌ `TanahKasDesaResource` - Tanah kas desa
4. ❌ `TanahPersilResource` - Data persil tanah (BELUM ADA TABEL)

#### B. Sekretariat (3 resources):
5. ❌ `ProdukHukumResource` - Perdes, Perkades, SK
6. ❌ `InformasiPublikResource` - LPPD, APBDes, RPJM
7. ❌ `ArsipDesaResource` - Arsip dokumen desa

**Navigation Groups**:
- 📦 Aset & Inventaris (4 resources)
- 📋 Sekretariat (3 resources)

---

### Priority 2: Web Lanjutan & Kehadiran (9 resources)
**Estimasi**: 2 minggu | **Tabel**: Sudah ada di migration

#### A. Web Publik Lanjutan (5 resources):
8. ❌ `WebIdmResource` - Data IDM (Indeks Desa Membangun)
9. ❌ `WebWidgetResource` - Widget sidebar
10. ❌ `WebMenuResource` - Menu navigasi custom
11. ❌ `WebKomentarResource` - Komentar artikel
12. ❌ `WebPengunjungResource` - Statistik pengunjung

#### B. Kehadiran Perangkat (4 resources):
13. ❌ `KehadiranJamKerjaResource` - Jam kerja perangkat
14. ❌ `KehadiranHariLiburResource` - Hari libur
15. ❌ `KehadiranResource` - Absensi perangkat
16. ❌ `KehadiranPengaduanResource` - Pengaduan kehadiran

**Navigation Groups**:
- 🌐 Web Publik (tambah 5 resources)
- 🕐 Kehadiran (4 resources)

---

### Priority 3: Peta GIS (4 resources)
**Estimasi**: 1 minggu | **Tabel**: Sudah ada di migration

17. ❌ `PetaWilayahResource` - Peta wilayah desa
18. ❌ `PetaLokasiResource` - Lokasi penting (kantor, sekolah, dll)
19. ❌ `PetaAreaResource` - Area polygon (sawah, hutan, dll)
20. ❌ `PetaGarisResource` - Garis (jalan, sungai, dll)

**Navigation Group**:
- 🗺️ Peta GIS (4 resources)

---

### Priority 4: Pengaduan & Interaksi (4 resources)
**Estimasi**: 1 minggu | **Tabel**: Sudah ada di migration

21. ❌ `PengaduanResource` - Pengaduan warga
22. ❌ `PesanWargaResource` - Pesan dari warga
23. ❌ `PendapatResource` - Polling/jajak pendapat
24. ❌ `PendapatJawabResource` - Jawaban polling

**Navigation Group**:
- 💬 Interaksi Warga (4 resources)

---

### Priority 5: Analisis & SDGs (4 resources)
**Estimasi**: 1 minggu | **Tabel**: Sudah ada di migration

25. ❌ `AnalisisResource` - Analisis kustom
26. ❌ `AnalisisKategoriResource` - Kategori analisis
27. ❌ `SdgsIndikatorResource` - Indikator SDGs
28. ❌ `SdgsDataResource` - Data capaian SDGs

**Navigation Groups**:
- 📊 Analisis (2 resources)
- 🎯 SDGs Desa (2 resources)

---

### Priority 6: Musyawarah (1 resource)
**Estimasi**: 2-3 hari | **Tabel**: Sudah ada di migration

29. ❌ `MusyawarahResource` - Musyawarah desa

**Navigation Group**:
- 🤝 Musyawarah (1 resource)

---

### Priority 7: Persuratan Minor (3 resources) - OPTIONAL
**Estimasi**: 3-4 hari | **Tabel**: Sudah ada di migration

30. ❌ `BukuAgendaResource` - Buku agenda surat
31. ❌ `SuratEkspedisiResource` - Ekspedisi surat keluar
32. ❌ `SuratKlasifikasiResource` - Klasifikasi surat

**Navigation Group**:
- 📄 Persuratan (tambah 3 resources)

---

## 🚫 Yang BELUM ADA TABEL (Perlu Migration Dulu)

### Kesehatan (Posyandu):
- ❌ `PosyanduResource` - Data posyandu
- ❌ `PosyanduKegiatanResource` - Kegiatan posyandu
- ❌ `PosyanduPesertaResource` - Peserta posyandu
- ❌ `ImunisasiResource` - Data imunisasi

### Pendidikan:
- ❌ `SekolahResource` - Data sekolah
- ❌ `GuruResource` - Data guru
- ❌ `SiswaResource` - Data siswa

### Keamanan (Siskamling):
- ❌ `SiskamlingResource` - Jadwal siskamling
- ❌ `SiskamlingPetugasResource` - Petugas siskamling
- ❌ `SiskamlingLaporanResource` - Laporan kejadian

**Estimasi**: Perlu 2-3 minggu untuk migration + resources

---

## 📈 Roadmap Timeline

### Minggu 1-2: Phase 2 - Aset & Sekretariat
- [ ] Create 7 models
- [ ] Generate 7 resources
- [ ] Customize forms & tables
- [ ] Add navigation groups
- [ ] Create seeders
- [ ] Test CRUD operations

**Target**: 43 resources (57% coverage)

### Minggu 3-4: Phase 3 - Web Lanjutan & Kehadiran
- [ ] Create 9 models
- [ ] Generate 9 resources
- [ ] Customize forms & tables
- [ ] Add navigation groups
- [ ] Create seeders
- [ ] Test CRUD operations

**Target**: 52 resources (69% coverage)

### Minggu 5: Phase 4 - Peta GIS
- [ ] Create 4 models
- [ ] Generate 4 resources
- [ ] Add map integration (Leaflet/Google Maps)
- [ ] Customize forms & tables
- [ ] Create seeders

**Target**: 56 resources (75% coverage)

### Minggu 6: Phase 5 - Pengaduan & Interaksi
- [ ] Create 4 models
- [ ] Generate 4 resources
- [ ] Add notification system
- [ ] Customize forms & tables
- [ ] Create seeders

**Target**: 60 resources (80% coverage)

### Minggu 7: Phase 6 - Analisis & SDGs
- [ ] Create 4 models
- [ ] Generate 4 resources
- [ ] Add chart/graph integration
- [ ] Customize forms & tables
- [ ] Create seeders

**Target**: 64 resources (85% coverage)

### Minggu 8: Phase 7 - Musyawarah & Persuratan Minor
- [ ] Create 4 models
- [ ] Generate 4 resources
- [ ] Customize forms & tables
- [ ] Create seeders

**Target**: 68 resources (91% coverage)

### Minggu 9-11: Phase 8 - Kesehatan, Pendidikan, Keamanan
- [ ] Create migrations (12 tables)
- [ ] Create 12 models
- [ ] Generate 12 resources
- [ ] Customize forms & tables
- [ ] Create seeders

**Target**: 80 resources (100% coverage) 🎉

---

## 🎯 Rekomendasi: Mulai dari Mana?

### Opsi 1: Lanjut Priority 1 (Aset & Sekretariat)
**Alasan**:
- Tabel sudah ada di migration
- Fitur inti desa yang penting
- Relatif mudah (tidak perlu integrasi kompleks)
- 7 resources dalam 1-2 minggu

**Langkah**:
1. Create 7 models dengan relasi
2. Generate resources dengan `--generate`
3. Customize navigation, forms, tables
4. Create seeders dengan data realistis
5. Test CRUD operations

### Opsi 2: Fokus Web Lanjutan (5 resources)
**Alasan**:
- Melengkapi modul Web Publik yang sudah 70%
- Fitur user-facing yang visible
- Bisa langsung ditest di frontend

### Opsi 3: Fokus Kehadiran (4 resources)
**Alasan**:
- Fitur manajemen perangkat
- Relatif standalone (tidak banyak relasi)
- Bisa jadi fitur unggulan

---

## 💡 Kesimpulan

### Status Sekarang:
- ✅ 36 resources (48% coverage)
- ✅ 8 navigation groups
- ✅ Database 95% lengkap

### Yang Masih Perlu:
- ❌ 39 resources (52% remaining)
- ❌ 7 navigation groups baru
- ❌ 12 tabel baru (Kesehatan, Pendidikan, Keamanan)

### Estimasi Total:
- **8-11 minggu** untuk 100% coverage
- **1-2 minggu per phase** (rata-rata 5-7 resources)
- **Target selesai**: Akhir April - Awal Mei 2026

### Rekomendasi:
**Mulai dari Priority 1: Aset & Sekretariat (7 resources)**
- Tabel sudah ada
- Fitur inti desa
- Tidak perlu integrasi kompleks
- Bisa selesai dalam 1-2 minggu

---

**Dibuat**: 2 Maret 2026  
**Status**: Planning  
**Current Coverage**: 48%  
**Target Coverage**: 100%  
**Estimasi**: 8-11 minggu

