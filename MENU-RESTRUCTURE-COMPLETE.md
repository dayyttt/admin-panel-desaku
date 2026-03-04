# Restrukturisasi Menu - Hapus Duplikasi

## Status: ✅ SELESAI

Duplikasi data antara "Konfigurasi Desa" dan "Informasi Desa" telah dihapus.

## Perubahan

### 1. Konfigurasi Desa (Info Desa)
**Lokasi Menu:** Info Desa → Konfigurasi Desa

**Fungsi:** Data master desa yang digunakan di seluruh sistem

**Isi:**
- ✅ Identitas Desa (nama, kode, alamat, kontak)
- ✅ Visi, Misi & Sejarah
- ✅ Data Kepala Desa (nama, NIP, foto, TTD)
- ✅ **Logo Desa** (untuk website & dokumen)
- ✅ Lokasi & Tampilan (koordinat, foto kantor)
- ✅ Konfigurasi Surat
- ✅ Integrasi (WA, Email, FCM)
- ✅ Sosial Media & IDM

**Akses:** Hanya Superadmin

### 2. Konten Profil Desa (Web Publik)
**Lokasi Menu:** Web Publik → Konten Profil Desa

**Fungsi:** Konten tambahan untuk halaman profil website

**Isi:**
- ❌ ~~Profil Desa~~ (DIHAPUS - sudah ada di Konfigurasi Desa)
- ✅ Sejarah (konten panjang dengan timeline)
- ✅ Visi & Misi (format khusus website)
- ✅ Geografi (koordinat, topografi, batas wilayah)
- ✅ Demografi (data penduduk)
- ✅ Fasilitas Umum (pendidikan, kesehatan, dll)
- ✅ Pemerintahan (struktur organisasi)
- ✅ Kontak (jam operasional, sosmed)
- ✅ Layanan Publik (daftar layanan)

**Akses:** Admin & Operator

## API Changes

### Endpoint: `/api/v1/desa-info/profil`

**Sebelum:**
```json
{
  "success": true,
  "data": {
    "nama_desa": "...",  // dari tabel desa_info
    "kode_desa": "...",
    ...
  }
}
```

**Sesudah:**
```json
{
  "success": true,
  "data": {
    "nama_desa": "...",        // dari tabel desa_configs
    "kode_desa": "...",
    "kecamatan": "...",
    "kabupaten": "...",
    "provinsi": "...",
    "logo": "logo/filename.png",  // path logo
    "visi": "...",
    "misi": "...",
    "sejarah": "...",
    ...
  }
}
```

### Endpoint Lainnya
- `/api/v1/desa-info/sejarah` → tetap dari desa_info
- `/api/v1/desa-info/geografi` → tetap dari desa_info
- `/api/v1/desa-info/demografi` → tetap dari desa_info
- dll.

## Keuntungan

1. ✅ **Tidak ada duplikasi data** - satu sumber kebenaran
2. ✅ **Lebih mudah maintenance** - update di satu tempat
3. ✅ **Tidak membingungkan user** - jelas mana data master, mana konten
4. ✅ **Konsisten** - logo, nama desa, dll sama di semua tempat
5. ✅ **Efisien** - tidak perlu sync data antar tabel

## Cara Upload Logo

1. Login sebagai **Superadmin**
2. Buka menu **Info Desa** → **Konfigurasi Desa**
3. Edit data desa
4. Buka tab **Lokasi & Tampilan**
5. Upload logo di field paling atas
6. Simpan

Logo akan otomatis muncul di:
- Header website
- Footer website
- Dokumen surat (jika digunakan)

## File yang Diubah

1. `app/Http/Controllers/Api/DesaInfoController.php`
   - Method `show()` untuk key 'profil' sekarang ambil dari DesaConfig

2. `app/Filament/Resources/DesaInfoResource.php`
   - Hapus option 'profil' dari dropdown
   - Hapus schema untuk profil

3. `app/Filament/Resources/DesaConfigResource.php`
   - Perbaiki tampilan upload logo (lebih prominent)

## Migrasi Data

Jika sudah ada data di `desa_info` dengan key='profil':
1. Copy data ke `desa_configs`
2. Hapus record profil dari `desa_info`

```sql
-- Tidak perlu migrasi jika fresh install
-- Jika ada data lama, manual copy dulu sebelum hapus
DELETE FROM desa_info WHERE key = 'profil';
```

## Catatan

- Data di DesaConfig hanya 1 record (single row)
- Data di DesaInfo bisa banyak record (multiple rows dengan key berbeda)
- Logo disimpan di `storage/app/public/logo/`
- Akses via `/storage/logo/filename.png`
