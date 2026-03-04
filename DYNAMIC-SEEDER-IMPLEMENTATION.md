# Dynamic Seeder Implementation

## Overview
DesaInfoSeeder sekarang mengambil data dari DesaConfig (hasil instalasi wizard) untuk membuat konten yang dinamis sesuai dengan desa yang diinstall.

## Perubahan

### 1. Data Source
- **Sebelumnya**: Hardcoded "Desa Lesane"
- **Sekarang**: Mengambil dari `DesaConfig::first()`

### 2. Data yang Dinamis

#### Dari DesaConfig:
- `nama_desa` - Nama desa
- `nama_kecamatan` - Nama kecamatan
- `nama_kabupaten` - Nama kabupaten
- `nama_provinsi` - Nama provinsi
- `nama_kepala_desa` - Nama kepala desa
- `alamat_kantor` - Alamat kantor desa
- `telepon` - Nomor telepon
- `email` - Email desa
- `website` - Website desa
- `kode_pos` - Kode pos

#### Konten yang Menggunakan Data Dinamis:

**1. Sejarah**
```php
"Desa {$namaDesa} adalah sebuah negeri adat..."
"Pada masa kolonial Belanda, Desa {$namaDesa}..."
"Masyarakat Desa {$namaDesa} dikenal dengan..."
```

**2. Visi Misi**
```php
"Terwujudnya Desa {$namaDesa} yang Maju, Mandiri..."
```

**3. Geografi**
```php
'jarak_ke_kota_kabupaten' => "5 km ke Kota {$kabupaten}"
```

**4. Pemerintahan**
```php
'nama' => $desaConfig->nama_kepala_desa ?: 'Kepala Desa'
```

**5. Kontak**
```php
'alamat' => $desaConfig->alamat_kantor ?: "Jl. Raya {$namaDesa}..."
'telepon' => $desaConfig->telepon ?: '(0xxx) xxxxxx'
'email' => $desaConfig->email ?: strtolower(str_replace(' ', '', $namaDesa)) . '@...'
'website' => $desaConfig->website ?: 'https://' . strtolower(...)
```

## Cara Kerja

### 1. Instalasi Wizard
```
User mengisi data desa → Disimpan ke DesaConfig
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=DesaInfoSeeder
```

### 3. Output
```
📍 Menggunakan data: Desa LESANES, Kec. KOTA MASOHI, Kab. MALUKU TENGAH
✅ Sejarah created (dengan nama desa dinamis)
✅ Visi Misi created (dengan nama desa dinamis)
✅ Geografi created (dengan nama kabupaten dinamis)
✅ Pemerintahan created (dengan nama kepala desa dinamis)
✅ Kontak created (dengan alamat, telepon, email dinamis)
```

## Fallback Values

Jika data tidak ada di DesaConfig, seeder menggunakan fallback:
- Alamat: `"Jl. Raya {$namaDesa} No. 1, {$kecamatan}..."`
- Telepon: `'(0xxx) xxxxxx'`
- Email: Auto-generate dari nama desa dan kabupaten
- Website: Auto-generate dari nama desa
- Kepala Desa: `'Kepala Desa'`

## Keuntungan

1. **Konten Personal**: Setiap instalasi menghasilkan konten yang sesuai dengan desa masing-masing
2. **Konsistensi Data**: Nama desa, kecamatan, kabupaten konsisten di seluruh konten
3. **Mudah Maintenance**: Cukup update DesaConfig, tidak perlu edit seeder
4. **Reusable**: Seeder bisa digunakan untuk desa manapun

## Testing

### Test dengan Desa Berbeda
```bash
# 1. Ubah data di DesaConfig via tinker
php artisan tinker
>>> $config = \App\Models\DesaConfig::first();
>>> $config->nama_desa = 'Desa Baru';
>>> $config->save();

# 2. Jalankan seeder
php artisan db:seed --class=DesaInfoSeeder

# 3. Cek hasilnya
>>> \App\Models\DesaInfo::where('key', 'sejarah')->first()->data['konten']
// Output: "Desa Baru adalah sebuah negeri adat..."
```

## Status
✅ Implemented
✅ Tested with Desa LESANES
✅ Ready for production
