# Panduan Menu "Konten Profil Desa"

## Apa itu Menu Konten Profil Desa?

Menu **Konten Profil Desa** (di grup Web Publik) adalah tempat untuk mengelola **konten tambahan** yang ditampilkan di halaman profil website publik.

## ⚠️ PENTING: Perbedaan dengan Konfigurasi Desa

### Konfigurasi Desa (Info Desa)
**Untuk:** Data master & identitas desa
**Akses:** Hanya Superadmin
**Isi:**
- ✅ Nama Desa
- ✅ Kode Desa
- ✅ Alamat, Telepon, Email
- ✅ **Logo Desa**
- ✅ Visi & Misi (versi singkat)
- ✅ Sejarah (versi singkat)
- ✅ Data Kepala Desa
- ✅ Konfigurasi sistem (surat, integrasi, dll)

### Konten Profil Desa (Web Publik)
**Untuk:** Konten tambahan website
**Akses:** Admin & Operator
**Isi:**
- ✅ Sejarah (versi panjang dengan timeline)
- ✅ Visi & Misi (format khusus website dengan poin-poin)
- ✅ Geografi (koordinat, topografi, batas wilayah)
- ✅ Demografi (data penduduk detail)
- ✅ Fasilitas Umum (pendidikan, kesehatan, dll)
- ✅ Pemerintahan (struktur organisasi lengkap)
- ✅ Kontak (jam operasional, sosmed)
- ✅ Layanan Publik (daftar layanan lengkap)

## Kapan Menggunakan Menu Ini?

### ✅ Gunakan menu ini untuk:
1. Menambahkan konten sejarah desa yang panjang dan detail
2. Membuat timeline sejarah desa
3. Menambahkan data geografi (koordinat, batas wilayah)
4. Input data demografi (jumlah penduduk, KK)
5. Daftar fasilitas umum (sekolah, puskesmas, masjid, dll)
6. Struktur pemerintahan desa lengkap
7. Jam operasional dan kontak detail
8. Daftar layanan publik yang tersedia

### ❌ JANGAN gunakan menu ini untuk:
1. ❌ Upload logo desa → Gunakan **Konfigurasi Desa**
2. ❌ Ubah nama desa → Gunakan **Konfigurasi Desa**
3. ❌ Ubah alamat kantor → Gunakan **Konfigurasi Desa**
4. ❌ Data kepala desa → Gunakan **Konfigurasi Desa**

## Cara Menggunakan

### 1. Buat Konten Baru
1. Buka menu **Web Publik** → **Konten Profil Desa**
2. Klik tombol **Buat Konten Profil Desa**
3. Pilih **Jenis Informasi** (Sejarah, Geografi, Demografi, dll)
4. Isi form sesuai jenis yang dipilih
5. Klik **Buat** untuk simpan

### 2. Edit Konten
1. Buka menu **Web Publik** → **Konten Profil Desa**
2. Klik tombol **Ubah** pada data yang ingin diedit
3. Update konten
4. Klik **Simpan**

### 3. Nonaktifkan Konten
- Toggle **Status** menjadi tidak aktif
- Konten tidak akan ditampilkan di website

## Contoh Penggunaan

### Skenario 1: Menambahkan Sejarah Desa
```
Menu: Web Publik → Konten Profil Desa → Buat
Jenis: Sejarah
Isi:
- Konten Sejarah: [Tulis sejarah panjang dengan RichEditor]
- Timeline (opsional):
  - 1950: Desa berdiri
  - 1985: Listrik masuk
  - 2020: Website diluncurkan
```

### Skenario 2: Input Data Demografi
```
Menu: Web Publik → Konten Profil Desa → Buat
Jenis: Demografi
Isi:
- Total Penduduk: 2847
- Laki-laki: 1423
- Perempuan: 1424
- Jumlah KK: 712
```

### Skenario 3: Daftar Fasilitas Umum
```
Menu: Web Publik → Konten Profil Desa → Buat
Jenis: Fasilitas Umum
Isi:
- Pendidikan:
  - SD Negeri: 2
  - SMP Negeri: 1
- Kesehatan:
  - Puskesmas: 1
  - Posyandu: 4
- Ibadah:
  - Masjid: 3
  - Gereja: 1
```

## FAQ

### Q: Kenapa ada 2 menu yang mirip?
**A:** Sebelumnya memang duplikasi. Sekarang sudah diperbaiki:
- **Konfigurasi Desa** = Data master (nama, logo, dll)
- **Konten Profil Desa** = Konten tambahan website

### Q: Di mana upload logo?
**A:** Di menu **Info Desa** → **Konfigurasi Desa** → Tab "Lokasi & Tampilan"

### Q: Kenapa tidak bisa pilih "Profil Desa" lagi?
**A:** Profil desa sekarang ada di **Konfigurasi Desa**. Menu ini hanya untuk konten tambahan.

### Q: Apakah wajib mengisi semua jenis informasi?
**A:** Tidak wajib. Isi sesuai kebutuhan. Minimal isi yang penting saja (Sejarah, Visi Misi, Demografi).

### Q: Bisa edit data yang sudah dibuat?
**A:** Bisa. Klik tombol **Ubah** pada list data.

### Q: Bagaimana cara menghapus konten?
**A:** Klik checkbox pada data → pilih **Hapus yang dipilih** di bagian atas tabel.

## Alur Kerja Ideal

1. **Instalasi** → Data desa dasar masuk ke Konfigurasi Desa
2. **Superadmin** → Upload logo & lengkapi data di Konfigurasi Desa
3. **Admin/Operator** → Isi konten tambahan di Konten Profil Desa:
   - Sejarah (dengan timeline)
   - Visi & Misi (format website)
   - Geografi
   - Demografi
   - Fasilitas Umum
   - Pemerintahan
   - Kontak
   - Layanan Publik
4. **Website** → Semua data tampil otomatis di halaman profil

## Tips

1. **Gunakan RichEditor** untuk konten panjang (Sejarah, Visi Misi)
2. **Isi Timeline** untuk sejarah agar lebih menarik
3. **Update Demografi** secara berkala (minimal 1 tahun sekali)
4. **Lengkapi Fasilitas Umum** agar masyarakat tahu apa saja yang ada
5. **Update Struktur Pemerintahan** jika ada pergantian perangkat desa

## Kesimpulan

Menu **Konten Profil Desa** tetap berguna dan **TIDAK PERLU DIHAPUS**. 

Fungsinya jelas: untuk konten tambahan website yang tidak ada di Konfigurasi Desa.

Dengan pemisahan ini:
- ✅ Tidak ada duplikasi data
- ✅ Lebih mudah maintenance
- ✅ Akses kontrol lebih baik (superadmin vs admin)
- ✅ Konten website lebih lengkap dan terstruktur
