# Panduan Upload Logo Desa

## Lokasi Upload Logo

**Menu:** Info Desa → Konfigurasi Desa → Tab "Lokasi & Tampilan"

## Langkah-langkah

1. **Login sebagai Superadmin**
   - Hanya superadmin yang bisa akses menu Konfigurasi Desa

2. **Buka Menu**
   - Sidebar → Info Desa → Konfigurasi Desa

3. **Edit Data**
   - Klik tombol Edit pada data desa

4. **Upload Logo**
   - Buka tab "Lokasi & Tampilan"
   - Field "Logo Desa" ada di paling atas
   - Klik area upload atau drag & drop file
   - Format: PNG atau JPG
   - Ukuran maksimal: 2MB
   - Rasio: 1:1 (persegi/bulat)
   - Gunakan Image Editor untuk crop jika perlu

5. **Simpan**
   - Klik tombol "Simpan"

## Hasil

Logo akan otomatis muncul di:
- ✅ Header website (navbar kiri atas)
- ✅ Footer website (bagian info desa)
- ✅ Dokumen surat (jika digunakan di template)

## Perubahan Sistem

### Sebelumnya (Duplikasi)
- Logo bisa diupload di 2 tempat:
  1. Info Desa → Konfigurasi Desa
  2. Web Publik → Informasi Desa → Profil Desa
- Membingungkan dan tidak sinkron

### Sekarang (Single Source)
- Logo hanya diupload di 1 tempat:
  - Info Desa → Konfigurasi Desa
- Data master untuk seluruh sistem
- Tidak ada duplikasi

## Menu "Konten Profil Desa"

Menu "Konten Profil Desa" (di Web Publik) sekarang hanya berisi:
- Sejarah (konten panjang dengan timeline)
- Visi & Misi (format khusus website)
- Geografi (koordinat, topografi, batas wilayah)
- Demografi (data penduduk)
- Fasilitas Umum (pendidikan, kesehatan, dll)
- Pemerintahan (struktur organisasi)
- Kontak (jam operasional, sosmed)
- Layanan Publik (daftar layanan)

**TIDAK ADA** lagi field:
- ❌ Nama Desa
- ❌ Kode Desa
- ❌ Alamat
- ❌ Logo

Semua data identitas desa ada di **Konfigurasi Desa**.

## Teknis

### Storage
- Path: `storage/app/public/logo/`
- Akses: `/storage/logo/filename.png`
- Symbolic link: `public/storage` → `storage/app/public`

### API
- Endpoint: `/api/v1/desa-info/profil`
- Sumber data: Tabel `desa_config` (bukan `desa_info`)
- Response includes: nama_desa, logo, visi, misi, dll

### Database
- Tabel: `desa_config` (singular)
- Field: `logo_path` (varchar)
- Hanya 1 record (single row)

## Troubleshooting

### Logo tidak muncul di website
1. Cek apakah logo sudah diupload di Konfigurasi Desa
2. Cek symbolic link: `php artisan storage:link`
3. Cek permission folder storage
4. Clear cache browser (Ctrl+Shift+R)

### Menu Konfigurasi Desa tidak muncul
- Hanya superadmin yang bisa akses
- Login dengan user tipe 'superadmin'

### Error "Konfigurasi desa belum diatur"
- Belum ada data di tabel desa_config
- Buat data baru via menu Konfigurasi Desa
