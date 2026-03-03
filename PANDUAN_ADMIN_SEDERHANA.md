# Panduan Admin Panel Desa Lesane - Untuk Pemula

## 🏠 Apa itu Admin Panel?

Admin Panel adalah **halaman khusus untuk perangkat desa** mengelola data dan informasi desa melalui komputer/laptop. Seperti "ruang kerja digital" untuk mengurus administrasi desa.

---

## 🔐 Cara Masuk (Login)

1. Buka browser (Chrome/Firefox)
2. Ketik alamat: `http://localhost:8000/admin`
3. Masukkan:
   - **Username**: (tanya ke admin IT)
   - **Password**: (tanya ke admin IT)
4. Klik tombol "Masuk"

**Catatan**: Jangan bagikan username dan password ke orang lain!

---

## 📋 Menu-Menu yang Ada

Setelah login, Anda akan lihat menu di sebelah kiri. Ada 6 kelompok menu:

### 1. 📊 DASHBOARD (Halaman Utama)
**Untuk apa?** Melihat ringkasan data desa (jumlah penduduk, keuangan, dll)

**Cara pakai**: Klik "Dashboard" di menu atas

---

### 2. 🏛️ INFO DESA
**Untuk apa?** Mengatur informasi tentang desa

**Menu yang ada**:
- **Konfigurasi Desa**: Ubah nama desa, alamat kantor, logo, visi misi
- **Wilayah**: Atur data Dusun, RW, RT
- **Perangkat Desa**: Data perangkat desa (nama, jabatan, foto)

**Contoh penggunaan**:
- Ganti logo desa → Klik "Konfigurasi Desa" → Upload logo baru
- Tambah RT baru → Klik "Wilayah" → Klik "Buat Baru" → Isi data RT

---

### 3. 👥 KEPENDUDUKAN
**Untuk apa?** Mengurus data penduduk

**Menu yang ada**:
- **Data Penduduk**: Daftar semua warga desa
- **Kartu Keluarga**: Daftar KK
- **Proses Kelahiran**: Catat bayi lahir
- **Proses Kematian**: Catat warga meninggal
- **Pindah Keluar/Masuk**: Catat warga pindah
- **Log Mutasi**: Riwayat perubahan data
- **Laporan & Statistik**: Cetak laporan penduduk

**Contoh penggunaan**:
- **Catat bayi lahir**:
  1. Klik "Proses Kelahiran"
  2. Klik tombol "Buat Baru" (warna hijau)
  3. Isi data bayi (nama, tanggal lahir, nama orang tua)
  4. Klik "Simpan"
  5. Selesai! Data bayi otomatis masuk ke Data Penduduk

- **Cetak laporan penduduk**:
  1. Klik "Laporan & Statistik"
  2. Pilih bulan dan tahun
  3. Klik "Generate PDF"
  4. File PDF otomatis terdownload

---

### 4. 📄 PERSURATAN
**Untuk apa?** Mengurus surat-surat desa

**Menu yang ada**:
- **Kategori Surat**: Kelompok jenis surat
- **Jenis Surat**: 20 jenis surat (KTP, KK, Domisili, SKTM, dll)
- **Surat Masuk**: Surat dari luar yang masuk ke desa
- **Permohonan Masuk**: Warga minta surat via online
- **Arsip Surat**: Surat yang sudah dibuat
- **TTD & Stempel**: Upload tanda tangan dan stempel digital

**Contoh penggunaan**:
- **Buat surat untuk warga**:
  1. Klik "Arsip Surat"
  2. Klik "Buat Baru"
  3. Pilih jenis surat (misal: Surat Domisili)
  4. Pilih nama warga (data otomatis terisi)
  5. Isi keperluan
  6. Klik "Simpan"
  7. Surat siap dicetak!

- **Lihat permohonan surat online**:
  1. Klik "Permohonan Masuk"
  2. Lihat daftar warga yang minta surat
  3. Klik "Edit" untuk proses
  4. Ubah status jadi "Diproses" atau "Selesai"

---

### 5. 💰 KEUANGAN
**Untuk apa?** Catat keuangan desa

**Menu yang ada**:
- **APBDes**: Anggaran desa per tahun
- **Transaksi**: Catat pemasukan dan pengeluaran
- **Buku Kas Umum**: Buku kas harian
- **Buku Bank**: Transaksi bank desa

**Contoh penggunaan**:
- **Catat pengeluaran**:
  1. Klik "Transaksi"
  2. Klik "Buat Baru"
  3. Pilih jenis: "Pengeluaran"
  4. Isi jumlah uang
  5. Isi keterangan (untuk apa)
  6. Upload bukti (foto nota/kwitansi)
  7. Klik "Simpan"

---

### 6. 🌐 WEB PUBLIK
**Untuk apa?** Kelola website desa yang bisa dilihat warga

**Menu yang ada**:
- **Informasi Desa**: Profil, kontak, visi misi desa
- **Artikel & Berita**: Berita dan pengumuman desa
- **Galeri**: Foto dan video kegiatan
- **Lapak UMKM**: Daftar usaha warga
- **Potensi Desa**: Potensi alam dan budaya
- **Halaman Statis**: Halaman khusus
- **Slider Hero**: Gambar besar di halaman utama website
- **Teks Berjalan**: Pengumuman yang berjalan di website
- **Pesan Masuk**: Pesan dari warga via form kontak

**Contoh penggunaan**:
- **Posting berita**:
  1. Klik "Artikel & Berita"
  2. Klik "Buat Baru"
  3. Isi judul berita
  4. Tulis isi berita
  5. Upload foto
  6. Pilih kategori (Berita/Pengumuman/Kegiatan)
  7. Klik "Simpan"
  8. Berita langsung muncul di website!

- **Ubah nomor telepon desa**:
  1. Klik "Informasi Desa"
  2. Cari baris "Kontak" → Klik "Edit"
  3. Ubah nomor telepon
  4. Klik "Simpan"
  5. Nomor baru langsung muncul di website!

- **Lihat pesan dari warga**:
  1. Klik "Pesan Masuk"
  2. Lihat angka kuning di menu (jumlah pesan baru)
  3. Klik pesan untuk baca
  4. Klik tombol mata 👁️ untuk tandai sudah dibaca
  5. Bisa tambah catatan internal

---

### 7. ⚙️ PENGATURAN
**Untuk apa?** Atur user dan sistem

**Menu yang ada**:
- **Manajemen User**: Tambah/hapus user admin

**Contoh penggunaan**:
- **Tambah user baru**:
  1. Klik "Manajemen User"
  2. Klik "Buat Baru"
  3. Isi nama, email, password
  4. Pilih role (Admin/Staff)
  5. Klik "Simpan"

---

## 💡 Tips Penting

### ✅ DO (Lakukan):
1. **Logout setelah selesai** - Klik nama Anda di pojok kanan atas → Logout
2. **Simpan data berkala** - Jangan lupa klik "Simpan" setelah isi form
3. **Backup data** - Minta admin IT backup data rutin
4. **Ganti password** - Ganti password secara berkala
5. **Cek data sebelum simpan** - Pastikan data sudah benar

### ❌ DON'T (Jangan):
1. **Jangan bagikan password** - Password hanya untuk Anda
2. **Jangan hapus data sembarangan** - Tanya dulu jika ragu
3. **Jangan tinggalkan komputer** - Logout jika mau tinggal
4. **Jangan klik asal** - Baca dulu sebelum klik tombol
5. **Jangan panik** - Kalau salah, bisa dibatalkan atau diperbaiki

---

## 🆘 Kalau Ada Masalah

### Lupa Password
1. Hubungi admin IT
2. Minta reset password
3. Ganti password baru setelah login

### Data Tidak Tersimpan
1. Cek koneksi internet
2. Cek semua field wajib sudah diisi (yang ada tanda bintang *)
3. Coba lagi
4. Kalau masih gagal, hubungi admin IT

### Tidak Bisa Upload Foto
1. Cek ukuran foto (maksimal 2MB)
2. Cek format foto (harus JPG atau PNG)
3. Kompres foto dulu jika terlalu besar
4. Coba upload lagi

### Tombol Tidak Berfungsi
1. Refresh halaman (tekan F5)
2. Logout dan login lagi
3. Coba pakai browser lain (Chrome/Firefox)
4. Hubungi admin IT

---

## 📞 Kontak Bantuan

**Admin IT Desa**:
- Nama: [Isi nama admin IT]
- Telepon: [Isi nomor telepon]
- Email: [Isi email]

**Jam Kerja**:
- Senin - Jumat: 08:00 - 16:00 WIT
- Sabtu: 08:00 - 12:00 WIT

---

## 📚 Istilah yang Sering Dipakai

| Istilah | Artinya |
|---------|---------|
| **Login** | Masuk ke sistem dengan username & password |
| **Logout** | Keluar dari sistem |
| **Dashboard** | Halaman utama yang menampilkan ringkasan |
| **Create/Buat Baru** | Tambah data baru |
| **Edit** | Ubah data yang sudah ada |
| **Delete/Hapus** | Menghapus data |
| **Save/Simpan** | Menyimpan data yang sudah diisi |
| **Cancel/Batal** | Membatalkan perubahan |
| **Upload** | Mengunggah file (foto/dokumen) |
| **Download** | Mengunduh file ke komputer |
| **Filter** | Menyaring data berdasarkan kriteria |
| **Search/Cari** | Mencari data |
| **Status** | Keadaan data (Aktif/Tidak Aktif) |
| **Badge** | Angka kecil yang menunjukkan jumlah (misal: pesan baru) |

---

## 🎯 Tugas Harian Perangkat Desa

### Setiap Hari:
- [ ] Cek pesan masuk dari warga
- [ ] Proses permohonan surat online
- [ ] Catat transaksi keuangan hari ini

### Setiap Minggu:
- [ ] Posting berita/kegiatan desa
- [ ] Upload foto kegiatan ke galeri
- [ ] Cek dan balas pesan warga

### Setiap Bulan:
- [ ] Cetak laporan penduduk bulanan
- [ ] Cetak laporan keuangan bulanan
- [ ] Update data statistik desa

### Setiap Tahun:
- [ ] Update visi misi desa
- [ ] Update data APBDes
- [ ] Backup semua data

---

## ✅ Checklist Pelatihan

Centang jika sudah bisa:

**Dasar**:
- [ ] Login dan logout
- [ ] Navigasi menu
- [ ] Buat data baru
- [ ] Edit data
- [ ] Hapus data
- [ ] Upload foto

**Kependudukan**:
- [ ] Tambah data penduduk baru
- [ ] Catat kelahiran
- [ ] Catat kematian
- [ ] Cetak laporan penduduk

**Persuratan**:
- [ ] Buat surat untuk warga
- [ ] Proses permohonan surat online
- [ ] Cetak surat

**Keuangan**:
- [ ] Catat pemasukan
- [ ] Catat pengeluaran
- [ ] Cetak laporan keuangan

**Web Publik**:
- [ ] Posting berita
- [ ] Upload foto galeri
- [ ] Update informasi kontak
- [ ] Balas pesan warga

---

## 🎓 Ingat!

1. **Jangan takut salah** - Semua orang belajar dari kesalahan
2. **Tanya jika tidak tahu** - Lebih baik tanya daripada salah
3. **Praktik terus** - Semakin sering pakai, semakin mahir
4. **Simpan panduan ini** - Baca lagi jika lupa
5. **Sabar** - Butuh waktu untuk terbiasa

---

**Selamat menggunakan Admin Panel Desa Lesane!** 🎉

Jika ada yang kurang jelas, jangan ragu untuk bertanya kepada admin IT atau rekan kerja yang sudah berpengalaman.

---

**Dibuat**: 2 Maret 2026  
**Untuk**: Perangkat Desa Lesane  
**Versi**: 1.0 - Panduan Pemula
