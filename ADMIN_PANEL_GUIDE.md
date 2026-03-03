# Admin Panel Guide - SGC Desa Lesane

## Overview
Admin panel menggunakan **Filament v3** - framework admin panel modern untuk Laravel dengan UI yang clean dan powerful.

## Akses Admin Panel
- **URL**: `http://localhost:8000/admin`
- **Default Login**:
  - Username: `superadmin`
  - Password: `admin123`

## Struktur Menu Admin Panel

### 📊 DASHBOARD
- Overview statistik desa
- Widget kependudukan
- Widget keuangan
- Chart piramida usia

### 🏛️ DESA & WILAYAH

#### 1. **Konfigurasi Desa** (`DesaConfigResource`)
Mengelola profil dan konfigurasi Desa Lesane:
- Nama desa, kode desa, kode pos
- Alamat kantor, telepon, email, website
- Koordinat GPS (latitude, longitude)
- Logo desa
- Visi & Misi
- Sejarah desa
- Tema warna website

#### 2. **Wilayah** (`WilayahResource`)
Hierarki wilayah administratif:
- Dusun (parent)
- RW (child of Dusun)
- RT (child of RW)
- Tree view untuk navigasi hierarki

#### 3. **Perangkat Desa** (`PerangkatDesaResource`)
Data perangkat desa:
- Nama, NIK, jabatan
- Foto perangkat
- Periode tugas
- Status aktif/non-aktif
- Telepon
- Tampil di web publik (toggle)

#### 4. **Informasi Desa** (`DesaInfoResource`) ✨ NEW
Mengelola konten dinamis untuk website publik dengan form yang user-friendly:

**Jenis Informasi yang Dapat Dikelola**:
- **Profil Desa**: Nama, kecamatan, kabupaten, provinsi, kode pos, luas wilayah, ketinggian, jumlah penduduk, jumlah KK, sambutan kepala desa
- **Sejarah**: Konten sejarah lengkap + timeline peristiwa penting
- **Visi Misi**: Visi desa + list misi (repeater field)
- **Geografi**: Koordinat, batas wilayah (utara/selatan/timur/barat), topografi, iklim, jarak ke kota kabupaten
- **Demografi**: Statistik penduduk (total, laki-laki, perempuan, KK, kepadatan)
- **Fasilitas**: Daftar fasilitas pendidikan, kesehatan, ibadah, ekonomi, pemerintahan, olahraga
- **Pemerintahan**: Struktur lengkap (kepala desa, perangkat, BPD, RT, jam kerja)
- **Kontak**: Alamat, telepon, email, website, jam operasional, media sosial (Facebook, Instagram, YouTube)
- **Layanan**: Daftar layanan administrasi, surat, bantuan sosial, alur pelayanan

**Fitur Form**:
- Form dinamis berdasarkan jenis informasi yang dipilih
- Field khusus untuk setiap jenis (tidak perlu edit JSON manual)
- Repeater untuk data array (misi, timeline, fasilitas)
- Fieldset untuk data nested (jam operasional, media sosial)
- Toggle status aktif/non-aktif
- Validasi otomatis

**Cara Menggunakan**:
1. Pilih jenis informasi dari dropdown
2. Form akan menyesuaikan dengan jenis yang dipilih
3. Isi data sesuai field yang tersedia
4. Simpan - data otomatis tersimpan dalam format JSON yang benar

### 👥 KEPENDUDUKAN

#### 5. **Keluarga (KK)** (`KeluargaResource`)
Manajemen Kartu Keluarga:
- Nomor KK
- Nama kepala keluarga
- Alamat lengkap
- Wilayah RT
- Status (aktif/tidak aktif/pindah)
- Daftar anggota keluarga

#### 6. **Penduduk** (`PendudukResource`)
Data lengkap penduduk (50+ field):
- **Identitas**: NIK, nama, TTL, jenis kelamin
- **Keluarga**: No KK, hubungan dalam keluarga
- **Agama & Kewarganegaraan**
- **Status Perkawinan**
- **Pendidikan**: Pendidikan dalam KK, pendidikan ditamatkan
- **Pekerjaan**: Jenis pekerjaan, detail
- **Alamat**: Wilayah RT, alamat lengkap
- **Fisik**: Golongan darah, tinggi, berat, disabilitas
- **Data Tambahan**: Orang tua, akta, paspor, BPJS
- **Status**: Aktif, mati, pindah, hilang, sementara
- **Foto penduduk**

**Fitur**:
- Filter & pencarian advanced
- Export ke Excel/PDF
- Import bulk dari Excel
- View detail lengkap

#### 7. **Kelahiran** (`KelahiranResource`)
Proses kelahiran bayi:
- Data bayi: nama, jenis kelamin, TTL
- Jam lahir, jenis kelahiran (tunggal/kembar)
- Penolong kelahiran, tempat dilahirkan
- Berat & panjang bayi
- Data orang tua (NIK, nama)
- No KK, link ke keluarga
- No akta lahir, tanggal akta
- Auto-create penduduk baru

#### 8. **Kematian** (`KematianResource`)
Proses kematian:
- Data almarhum: NIK, nama
- Tanggal & jam kematian
- Tempat kematian
- Penyebab & jenis kematian
- Data pelapor
- No akta kematian
- Auto-update status penduduk

#### 9. **Mutasi Penduduk** (`PendudukMutasiResource`)
Log semua perubahan penduduk:
- Jenis mutasi: lahir, mati, pindah keluar, datang, ubah data, hapus
- NIK penduduk
- Data sebelum & sesudah (JSON snapshot)
- Keterangan
- Tanggal mutasi
- Diinput oleh (user)

#### 10. **Pindah Penduduk** (`PendudukPindahResource`)
Proses pindah keluar/masuk:
- Jenis: pindah_keluar atau datang
- Data penduduk: NIK, nama
- **Pindah Keluar**: Alamat tujuan, desa/kec/kab/prov tujuan, alasan
- **Pindah Masuk**: Alamat asal, desa/kec/kab/prov asal, alasan
- No surat pindah
- Tanggal pindah
- No KK baru

### 📄 LAYANAN SURAT

#### 11. **Kategori Surat** (`SuratKategoriResource`)
Grouping jenis surat:
- Nama kategori (Administrasi, Kependudukan, Usaha, dll)
- Kode kategori
- Deskripsi
- Urutan tampilan
- Status aktif

#### 12. **Jenis Surat** (`SuratJenisResource`)
Master template surat:
- Nama jenis surat
- Kode surat (001/SKTD, 002/SKTM, dll)
- Singkatan
- Kategori (FK)
- Template .docx (upload)
- Format nomor surat
- Variabel yang tersedia
- Perlu TTD Kepala Desa
- Aktif untuk permohonan online
- Status aktif
- Urutan

**20 Jenis Surat Bawaan**:
1. Surat Keterangan Domisili (SKTD)
2. Surat Keterangan Tidak Mampu (SKTM)
3. Surat Keterangan Kelahiran (SKK)
4. Surat Keterangan Kematian (SKKM)
5. Surat Keterangan Pindah (SKP)
6. Surat Pengantar KTP
7. Surat Pengantar KK
8. Surat Keterangan Usaha (SKU)
9. Surat Keterangan Belum Menikah
10. Surat Keterangan Waris
11. Surat Rekomendasi SKCK
12. Surat Rekomendasi Beasiswa
13. Surat Pengantar Nikah N1
14. Surat Pengantar Nikah N2
15. Surat Keterangan Numpang Nikah
16. Surat Keterangan Ahli Waris
17. Surat Keterangan Beda Nama
18. Surat Keterangan Janda/Duda
19. Surat Pengantar Izin Keramaian
20. Surat Keterangan Custom

#### 13. **Arsip Surat** (`SuratArsipResource`)
Semua surat yang pernah diterbitkan:
- Nomor surat (auto-generate)
- Jenis surat (FK)
- Tanggal surat
- Pemohon (FK ke penduduk)
- Data variabel (JSON)
- File PDF
- QR Code verifikasi
- Status (draft/final)
- Diinput oleh

**Fitur**:
- Preview PDF
- Download PDF
- Cetak ulang
- Filter & pencarian
- QR Code untuk verifikasi online

#### 14. **Permohonan Surat** (`SuratPermohonanResource`)
Permohonan online dari warga:
- Pemohon (FK ke penduduk/user)
- Jenis surat yang dimohon
- Data form permohonan (JSON)
- Upload dokumen persyaratan
- Status: pending, diproses, selesai, ditolak
- Catatan operator
- Tanggal permohonan
- Tanggal diproses
- Diproses oleh (user)

**Workflow**:
1. Warga ajukan via web/mobile
2. Operator review & proses
3. Generate surat PDF
4. Notifikasi ke warga (WhatsApp/Push)

#### 15. **Surat Masuk** (`SuratMasukResource`)
Surat masuk dari luar desa:
- Nomor surat
- Tanggal surat
- Tanggal diterima
- Pengirim
- Perihal
- Upload file scan
- Disposisi
- Status

#### 16. **Dokumen TTD** (`DokumenTtdResource`)
Template tanda tangan digital:
- Nama pejabat
- Jabatan
- Upload gambar TTD
- Upload stempel desa
- Status aktif
- Digunakan untuk jenis surat tertentu

### 💰 KEUANGAN DESA

#### 17. **APBDes** (`ApbdesResource`)
Anggaran Pendapatan dan Belanja Desa:
- Tahun anggaran
- Total anggaran
- Status (draft/final/approved)
- **Relation Manager**: Bidang APBDes

**Struktur APBDes** (sesuai Permendagri 20/2018):
- Bidang 1: Penyelenggaraan Pemerintahan Desa
- Bidang 2: Pelaksanaan Pembangunan Desa
- Bidang 3: Pembinaan Kemasyarakatan
- Bidang 4: Pemberdayaan Masyarakat
- Bidang 5: Penanggulangan Bencana

#### 18. **Transaksi Keuangan** (`KeuanganTransaksiResource`)
Input penerimaan & pengeluaran:
- Tanggal transaksi
- Jenis: penerimaan atau pengeluaran
- Bidang APBDes (FK)
- Kegiatan
- Uraian
- Jumlah (Rp)
- Upload bukti scan
- Status verifikasi
- Diverifikasi oleh
- Tanggal verifikasi

**Workflow Verifikasi**:
1. Bendahara input transaksi
2. Kepala Desa approve/tolak
3. Auto-update buku kas

#### 19. **Buku Kas** (`KeuanganBukuKasResource`)
Buku kas umum otomatis:
- Tanggal
- Uraian
- Debit (penerimaan)
- Kredit (pengeluaran)
- Saldo berjalan
- Referensi transaksi (FK)

**Auto-generated** dari transaksi yang sudah diverifikasi.

#### 20. **Buku Bank** (`BukuBankResource`)
Rekonsiliasi rekening bank desa:
- Nama bank
- Nomor rekening
- Atas nama
- Saldo awal
- Transaksi bank
- Saldo akhir
- Periode

### 🌐 WEB PUBLIK

#### 21. **Artikel/Berita** (`WebArtikelResource`)
CMS artikel untuk web publik:
- Judul
- Slug (auto-generate dari judul)
- Konten (Rich Text Editor)
- Thumbnail/featured image
- Kategori (berita, pengumuman, kegiatan)
- Tags
- Status: draft, published
- Tanggal publish
- Penulis (FK ke user)
- Jumlah views

**Fitur**:
- Rich text editor (TinyMCE/Tiptap)
- Upload gambar inline
- SEO meta (title, description)
- Preview sebelum publish

#### 22. **Galeri** (`WebGaleriResource`)
Galeri foto & video:
- Judul
- Deskripsi
- Tipe: foto atau video
- **Foto**: Upload multiple images
- **Video**: URL YouTube/embed code
- Album/kategori
- Tanggal kegiatan
- Fotografer
- Status publish

#### 23. **Slider/Banner** (`WebSliderResource`)
Banner rotasi di homepage:
- Judul
- Deskripsi singkat
- Upload gambar (1920x600px recommended)
- Link URL (optional)
- Urutan tampilan
- Status aktif
- Tanggal mulai & selesai

#### 24. **Teks Berjalan** (`WebTeksBerjalanResource`)
Ticker pengumuman penting:
- Teks pengumuman
- Link URL (optional)
- Warna background
- Urutan
- Status aktif
- Tanggal mulai & selesai

#### 25. **Halaman Statis** (`WebHalamanResource`)
Halaman custom:
- Judul halaman
- Slug
- Konten (Rich Text)
- Template layout
- SEO meta
- Status publish
- Urutan di menu

**Halaman Bawaan**:
- Profil Desa
- Visi & Misi
- Sejarah
- Struktur Pemerintahan
- Kontak
- Tentang Kami

#### 26. **Potensi Desa** (`WebPotensiResource`)
Profil potensi desa:
- Nama potensi
- Kategori: wisata, pertanian, perikanan, UMKM, kerajinan
- Deskripsi lengkap
- Upload foto (multiple)
- Koordinat GPS (untuk peta)
- Kontak person
- Status publish

**Contoh Potensi Desa Lesane**:
- Pantai Lesane
- Dermaga Nelayan
- Kebun Sagu
- Hasil Laut (ikan, cumi, udang)
- Kerajinan Anyaman

#### 27. **Lapak UMKM** (`LapakResource`)
Katalog produk UMKM desa:
- Nama usaha
- Pemilik (FK ke penduduk)
- Kategori: makanan, kerajinan, fashion, pertanian, jasa, lainnya
- Deskripsi usaha
- Alamat usaha
- Kontak (telepon, WhatsApp)
- Upload foto produk (multiple)
- Harga produk (optional)
- Status aktif

### 👤 PENGGUNA & AKSES

#### 28. **User Management** (`UserResource`)
Manajemen user sistem:
- Name
- Username
- Email
- Password
- Tipe user: superadmin, operator, kepala_desa, warga
- NIK (untuk warga)
- Status aktif
- Roles & Permissions

**User Types**:
- **Superadmin**: Full access semua modul
- **Operator**: Input data, generate surat, kelola konten web
- **Kepala Desa**: Approve transaksi, lihat laporan
- **Warga**: Akses portal mandiri (web/mobile)

## Fitur Umum Filament

### 🔍 Filter & Pencarian
Setiap resource memiliki:
- Search bar (pencarian cepat)
- Filter sidebar (filter by kategori, status, tanggal, dll)
- Sort by column (klik header tabel)

### 📊 Bulk Actions
- Bulk delete
- Bulk export
- Bulk update status
- Custom bulk actions

### 📤 Export Data
- Export to Excel (.xlsx)
- Export to CSV
- Export to PDF
- Custom export dengan filter

### 📥 Import Data
- Import from Excel (template provided)
- Validation & error handling
- Preview before import
- Bulk insert

### 🔔 Notifications
- Success notification (hijau)
- Error notification (merah)
- Warning notification (kuning)
- Info notification (biru)

### 📱 Responsive Design
- Desktop optimized
- Tablet friendly
- Mobile accessible (limited)

## Workflow Umum

### Generate Surat
1. Buka **Arsip Surat** → Klik **Buat Surat Baru**
2. Pilih **Jenis Surat** dari dropdown
3. Pilih **Pemohon** (cari by NIK/nama)
4. Data penduduk auto-fill ke form
5. Isi field tambahan jika ada
6. Preview surat
7. Generate PDF
8. Surat tersimpan di arsip dengan nomor otomatis
9. QR Code ter-generate untuk verifikasi

### Approve Transaksi Keuangan
1. Bendahara input transaksi di **Transaksi Keuangan**
2. Status: **Pending Verifikasi**
3. Kepala Desa login → buka **Transaksi Keuangan**
4. Filter by status: Pending
5. Klik transaksi → Review detail & bukti
6. Klik **Approve** atau **Tolak**
7. Jika approve → Auto-update **Buku Kas**

### Publish Artikel
1. Buka **Artikel/Berita** → Klik **Buat Artikel**
2. Isi judul, konten (rich text), upload gambar
3. Pilih kategori & tags
4. Set status: **Draft** (untuk review) atau **Published** (langsung tayang)
5. Set tanggal publish (bisa dijadwalkan)
6. Save
7. Artikel muncul di web publik

### Kelola Permohonan Surat Online
1. Warga ajukan surat via web/mobile
2. Operator buka **Permohonan Surat**
3. Filter by status: **Pending**
4. Klik permohonan → Review data & dokumen
5. Jika lengkap → Klik **Proses**
6. Generate surat PDF
7. Update status: **Selesai**
8. Warga dapat notifikasi (WhatsApp/Push)

## Tips & Best Practices

### 🎯 Data Entry
- Gunakan **Tab** untuk navigasi cepat antar field
- Gunakan **Ctrl+S** untuk save cepat
- Validasi error ditampilkan real-time
- Required fields ditandai dengan asterisk (*)

### 🔒 Security
- Logout setelah selesai bekerja
- Jangan share password
- Gunakan password yang kuat
- Activity log mencatat semua aksi

### 📊 Reporting
- Export data secara berkala untuk backup
- Gunakan filter untuk laporan spesifik
- Print laporan langsung dari browser
- PDF laporan include header & footer desa

### 🎨 Customization
- Logo desa bisa diupload di **Konfigurasi Desa**
- Tema warna website bisa diubah
- Template surat bisa disesuaikan (.docx)
- Layout web publik bisa dikustomisasi

## Troubleshooting

### Tidak Bisa Login
- Cek username & password
- Cek status user aktif
- Clear browser cache
- Cek koneksi database

### Surat Tidak Ter-generate
- Cek template .docx sudah diupload
- Cek variabel di template sesuai
- Cek data penduduk lengkap
- Cek permission user

### Gambar Tidak Muncul
- Cek ukuran file (max 2MB)
- Cek format file (jpg, png, gif)
- Cek storage permission
- Run: `php artisan storage:link`

### Data Tidak Tersimpan
- Cek validasi error
- Cek required fields
- Cek koneksi database
- Cek log error: `storage/logs/laravel.log`

## Keyboard Shortcuts

- `Ctrl + K`: Global search
- `Ctrl + S`: Save form
- `Esc`: Close modal
- `Tab`: Next field
- `Shift + Tab`: Previous field

## Support & Documentation

- **Filament Docs**: https://filamentphp.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **Project Docs**: Lihat folder `sgc-docs/`

## Conclusion

Admin panel SGC Desa Lesane sudah dilengkapi dengan 28+ resources untuk mengelola seluruh aspek administrasi desa secara digital. Dengan Filament v3, UI modern dan user-friendly memudahkan operator desa dalam menjalankan tugas sehari-hari.

Semua data yang diinput di admin panel akan otomatis tersinkronisasi dengan:
- ✅ Web Publik Desa
- ✅ Portal Warga (Layanan Mandiri)
- ✅ Mobile App
- ✅ API untuk integrasi eksternal

**Admin panel siap digunakan untuk produksi!** 🎉
