# Installation Wizard - Fix Duplikasi Data

## Status: ✅ SELESAI

Installation wizard telah diperbaiki untuk menyimpan data desa ke `desa_config` (bukan `desa_info`).

## Perubahan

### 1. InstallController.php

**Sebelum:**
```php
use App\Models\DesaInfo;

// Di method install()
DesaInfo::updateOrCreate(
    ['key' => 'profil'],
    [
        'data' => [
            'nama_desa' => $desaInfo['nama_desa'],
            // ...
        ],
        'aktif' => true,
    ]
);
```

**Sesudah:**
```php
use App\Models\DesaConfig;

// Di method install()
DesaConfig::updateOrCreate(
    ['id' => 1], // Only one config record
    [
        'nama_desa' => $desaInfo['nama_desa'],
        'kode_desa' => $desaInfo['kode_desa'],
        'nama_kecamatan' => $desaInfo['kecamatan'],
        'nama_kabupaten' => $desaInfo['kabupaten'],
        'nama_provinsi' => $desaInfo['provinsi'],
        'kode_pos' => $desaInfo['kode_pos'] ?? null,
    ]
);
```

### 2. DesaInfoSeeder.php

**Perubahan:**
- Hapus bagian "PROFIL DESA" dari seeder
- Profil sekarang ada di DesaConfig (via installation wizard atau manual)
- Total data di seeder: 8 items (bukan 9)

**Items yang di-seed:**
1. Sejarah
2. Visi & Misi
3. Geografi
4. Demografi
5. Fasilitas Umum
6. Pemerintahan
7. Kontak
8. Layanan Publik

## Flow Installation

1. **Welcome** → Pengenalan sistem
2. **Requirements** → Cek PHP extensions & permissions
3. **Database** → Konfigurasi koneksi database
4. **Desa** → Input data desa (nama, kode, alamat, dll)
   - Data disimpan ke session dulu
5. **Admin** → Buat user superadmin
   - Data disimpan ke session dulu
6. **Finalize** → Proses instalasi
   - Run migrations
   - **Simpan data desa ke `desa_config`** ← FIX DI SINI
   - Run RolePermissionSeeder
   - Buat user superadmin
   - Assign role superadmin
   - Buat file `.installed`

## Data yang Disimpan

### Ke desa_config (dari wizard):
- nama_desa
- kode_desa
- nama_kecamatan
- nama_kabupaten
- nama_provinsi
- kode_pos

### Ke desa_info (dari seeder):
- sejarah
- visi_misi
- geografi
- demografi
- fasilitas
- pemerintahan
- kontak
- layanan

## Testing

### Test Fresh Install:
```bash
# 1. Hapus file .installed
rm storage/.installed

# 2. Drop & recreate database
mysql -u root -p -e "DROP DATABASE sgc_test_install; CREATE DATABASE sgc_test_install;"

# 3. Akses installation wizard
http://localhost:8000/install

# 4. Ikuti wizard sampai selesai

# 5. Cek data
php artisan tinker
>>> \App\Models\DesaConfig::first()
>>> \App\Models\DesaInfo::count() // should be 0 (belum run seeder)
```

### Test dengan Seeder:
```bash
# Setelah instalasi, run seeder
php artisan db:seed --class=DesaInfoSeeder

# Cek data
php artisan tinker
>>> \App\Models\DesaInfo::pluck('key') // should NOT include 'profil'
```

## API Response

### GET /api/v1/desa-info/profil

**Response:**
```json
{
  "success": true,
  "data": {
    "nama_desa": "LESANES",
    "kode_desa": "8102012001",
    "kecamatan": "KOTA MASOHI",
    "kabupaten": "MALUKU TENGAH",
    "provinsi": "MALUKU",
    "kode_pos": "97511",
    "alamat": null,
    "telepon": null,
    "email": null,
    "website": null,
    "logo": null,
    "visi": null,
    "misi": null,
    "sejarah": null,
    "nama_kepala_desa": null,
    "foto_kepala_desa": null,
    "latitude": null,
    "longitude": null
  }
}
```

Data diambil dari `desa_config`, bukan `desa_info`.

## File yang Diubah

1. `app/Http/Controllers/InstallController.php`
   - Import DesaConfig instead of DesaInfo
   - Update install() method

2. `database/seeders/DesaInfoSeeder.php`
   - Hapus bagian profil
   - Update nomor urut (1-8)
   - Update total count

## Catatan

- Installation wizard hanya input data minimal (identitas desa)
- Data lengkap (visi, misi, sejarah, dll) bisa diisi via admin panel setelah instalasi
- Atau run seeder untuk data contoh: `php artisan db:seed --class=DesaInfoSeeder`
- Logo bisa diupload via menu: Info Desa → Konfigurasi Desa → Tab "Lokasi & Tampilan"

## Backward Compatibility

Jika ada instalasi lama yang masih punya data profil di `desa_info`:
1. Data tidak akan error (API sudah handle)
2. Tapi sebaiknya migrasi manual:
   ```sql
   -- Copy data dari desa_info ke desa_config
   -- Lalu hapus record profil
   DELETE FROM desa_info WHERE key = 'profil';
   ```
