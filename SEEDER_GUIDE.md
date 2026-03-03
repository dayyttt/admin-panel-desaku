# 🌱 Web Publik Seeder Guide

## 📋 Overview

Seeder lengkap untuk mengisi database dengan data demo Web Publik Desa Lesane.

**Total Data: 35 items**

---

## 📊 Data yang Akan Dibuat

| Kategori | Jumlah | Deskripsi |
|----------|--------|-----------|
| **Slider Hero** | 3 | Banner homepage dengan gambar & CTA |
| **Teks Berjalan** | 3 | Running text/ticker dengan warna custom |
| **Artikel/Berita** | 8 | Berita & artikel lengkap dengan thumbnail |
| **Galeri** | 7 | Foto (5) & Video (2) dokumentasi kegiatan |
| **Potensi Desa** | 8 | Potensi wisata, pertanian, perikanan, budaya, dll |
| **Lapak UMKM** | 6 | Produk lokal dari berbagai kategori |
| **Halaman Statis** | 3 | Tentang Kami, Kontak, Kebijakan Privasi |
| **TOTAL** | **38** | **items** |

---

## 🚀 Cara Menjalankan

### 1. Pastikan Database Sudah Siap

```bash
cd sgc-backend

# Cek koneksi database
php artisan migrate:status
```

### 2. Jalankan Seeder

```bash
# Run seeder
php artisan db:seed --class=WebPublikSeeder
```

### 3. Atau Reset & Seed Ulang

```bash
# Hapus semua data lama dan seed ulang
php artisan migrate:fresh --seed
```

### 4. Atau Seed Spesifik

```bash
# Hanya seed Web Publik
php artisan db:seed --class=WebPublikSeeder
```

---

## 📝 Detail Data

### 1. Slider Hero (3 items)

**Slider 1:**
- Judul: "Selamat Datang di Desa Lesane"
- Subjudul: "Negeri Adat yang Kaya Budaya dan Potensi Bahari"
- CTA: "Kenali Desa Kami" → `/profil`

**Slider 2:**
- Judul: "Pantai Lesane yang Memukau"
- Subjudul: "Keindahan alam pesisir dengan air laut jernih"
- CTA: "Lihat Potensi" → `/potensi`

**Slider 3:**
- Judul: "Budaya Pela Gandong"
- Subjudul: "Ikatan persaudaraan kearifan lokal Maluku"
- CTA: "Pelajari Lebih Lanjut" → `/profil`

---

### 2. Teks Berjalan (3 items)

1. **Sambutan** (Hijau)
   - "🎉 Selamat datang di Website Resmi Desa Lesane..."

2. **Pengumuman** (Biru)
   - "📢 Musrenbangdes 2026 akan dilaksanakan..."
   - Dengan tanggal mulai & selesai

3. **Info** (Orange)
   - "💰 Transparansi APBDes 2026 dapat diakses..."

---

### 3. Artikel/Berita (8 items)

1. **Musrenbangdes 2026** (berita)
   - Prioritas pembangunan infrastruktur jalan
   - 156 views

2. **Pemberdayaan Nelayan** (berita)
   - Bantuan 25 unit alat tangkap modern
   - 203 views

3. **Festival Pela Gandong** (artikel)
   - Festival budaya 8 negeri
   - 342 views

4. **Posyandu Terbaik** (pengumuman)
   - Penghargaan tingkat kabupaten
   - 189 views

5. **Pelatihan Digital Marketing** (berita)
   - 40 pelaku UMKM ikut pelatihan
   - 167 views

6. **Rehabilitasi Mangrove** (artikel)
   - Penanaman 5.000 bibit mangrove
   - 234 views

7. **Pembangunan Dermaga** (berita)
   - Dermaga nelayan Rp 850 juta
   - 198 views

8. **Lomba Desa** (pengumuman)
   - Masuk 10 besar tingkat provinsi
   - 276 views

---

### 4. Galeri (7 items)

**Foto (5):**
1. Pantai Lesane Saat Senja
2. Tarian Cakalele Festival Budaya
3. Musrenbangdes 2026
4. Penanaman Mangrove
5. Penyerahan Bantuan Alat Tangkap

**Video (2):**
1. Profil Desa Lesane
2. Festival Pela Gandong 2026

---

### 5. Potensi Desa (8 items)

1. **Pantai Lesane** (wisata)
   - Pantai berpasir putih, snorkeling
   - Koordinat GPS

2. **Perkebunan Cengkeh** (pertanian)
   - 45 ton/tahun, kualitas premium

3. **Perikanan Tangkap** (perikanan)
   - Tuna, cakalang, tongkol
   - 120 nelayan aktif

4. **Hutan Mangrove** (wisata)
   - Tracking 500m, bird watching
   - Koordinat GPS

5. **Tarian Cakalele** (budaya)
   - Tarian perang tradisional

6. **Budidaya Rumput Laut** (perikanan)
   - 15 ton/bulan kering

7. **Kerajinan Anyaman Bambu** (kerajinan)
   - Tas, furniture, hiasan

8. **Kuliner Ikan Asap** (kuliner)
   - Ikan asap khas Maluku

---

### 6. Lapak UMKM (6 items)

1. **Warung Makan Bu Siti** (kuliner)
   - Ikan bakar, papeda, kohu-kohu
   - Kontak: 081234567890

2. **Kerajinan Anyaman Pak Umar** (kerajinan)
   - Bakul, tampah, kipas, hiasan
   - Kontak: 082345678901

3. **Ikan Asap Ibu Fatimah** (perikanan)
   - Ikan asap & abon ikan
   - Kontak: 083456789012

4. **Kopi Lesane** (kuliner)
   - Kopi robusta lokal
   - Kontak: 084567890123

5. **Rumput Laut Bu Aisyah** (pertanian)
   - Rumput laut kering ekspor
   - Kontak: 085678901234

6. **Jasa Tur Wisata Lesane** (jasa)
   - Paket wisata pantai, mangrove, snorkeling
   - Kontak: 086789012345

---

### 7. Halaman Statis (3 items)

1. **Tentang Kami**
   - Visi website
   - Fitur website
   - Tampil di menu

2. **Kontak Kami**
   - Alamat kantor desa
   - Telepon, email, website
   - Jam pelayanan
   - Tampil di menu

3. **Kebijakan Privasi**
   - Informasi yang dikumpulkan
   - Penggunaan informasi
   - Keamanan data
   - Tidak tampil di menu

---

## ✅ Verifikasi Data

### Cek via Database

```bash
# Masuk ke database
php artisan tinker

# Cek jumlah data
WebSlider::count();        // Should be 3
WebTeksBerjalan::count();  // Should be 3
WebArtikel::count();       // Should be 8
WebGaleri::count();        // Should be 7
WebPotensi::count();       // Should be 8
Lapak::count();            // Should be 6
WebHalaman::count();       // Should be 3
```

### Cek via Admin Panel

```
URL: http://localhost:8000/admin
Menu: Web Publik
```

Cek setiap resource:
- ✅ Artikel & Berita (8 items)
- ✅ Galeri (7 items)
- ✅ Lapak UMKM (6 items)
- ✅ Slider Hero (3 items)
- ✅ Potensi Desa (8 items)
- ✅ Halaman Statis (3 items)
- ✅ Teks Berjalan (3 items)

### Cek via Frontend

```
URL: http://localhost:5173
```

Cek setiap halaman:
- ✅ Beranda - Slider & teks berjalan muncul
- ✅ Berita - 8 artikel tampil
- ✅ Galeri - 7 item (5 foto + 2 video)
- ✅ Potensi - 8 potensi tampil
- ✅ UMKM - 6 lapak tampil

---

## 🔧 Troubleshooting

### Error: Class not found

```bash
# Regenerate autoload
composer dump-autoload
```

### Error: Table doesn't exist

```bash
# Run migrations first
php artisan migrate
```

### Error: Duplicate entry

```bash
# Truncate tables first
php artisan db:wipe
php artisan migrate
php artisan db:seed --class=WebPublikSeeder
```

### Ingin Reset Semua Data

```bash
# Fresh migration + seed
php artisan migrate:fresh --seed
```

---

## 📸 Screenshot Hasil

Setelah seeder berhasil, Anda akan melihat:

### Admin Panel
- Dashboard dengan data lengkap
- 7 menu Web Publik terisi
- Total 38 items

### Frontend
- Homepage dengan slider 3 gambar
- Teks berjalan di atas
- Berita terbaru 8 artikel
- Galeri 7 dokumentasi
- Potensi 8 kategori
- UMKM 6 produk lokal

---

## 🎯 Next Steps

Setelah seeder berhasil:

1. **Customize Data**
   - Edit data via admin panel
   - Upload foto asli desa
   - Update konten sesuai kebutuhan

2. **Tambah Data Baru**
   - Tambah artikel/berita baru
   - Upload galeri kegiatan
   - Daftarkan UMKM baru

3. **Test Frontend**
   - Cek semua halaman
   - Test filter & pagination
   - Test WhatsApp integration

4. **Production Ready**
   - Backup database
   - Deploy ke server
   - Setup domain & SSL

---

## 📚 File Terkait

- **Seeder**: `sgc-backend/database/seeders/WebPublikSeeder.php`
- **Models**: `sgc-backend/app/Models/Web*.php`, `Lapak.php`
- **Resources**: `sgc-backend/app/Filament/Resources/Web*.php`
- **Frontend**: `project/src/pages/*.jsx`

---

**Dibuat**: Maret 2026  
**Status**: ✅ Ready to Use  
**Total Data**: 38 items
