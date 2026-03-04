# Fix Profil Desa Page - Field Name Mismatch

## Masalah
Halaman Profil Desa tidak menampilkan konten meskipun data sudah ada di database.

## Root Cause
Field name mismatch antara database dan frontend:
- Database menggunakan: `nama_desa`, `kode_desa`
- Frontend menggunakan: `nama` (salah)

## Perbaikan yang Dilakukan

### 1. Backend - DesaInfoResource.php
**File**: `sgc-backend/app/Filament/Resources/DesaInfoResource.php`

Mengubah form schema untuk profil desa:
```php
'profil' => [
    Forms\Components\TextInput::make('data.nama_desa')  // ✅ Sebelumnya: data.nama
        ->label('Nama Desa')
        ->required(),
    Forms\Components\TextInput::make('data.kode_desa')  // ✅ Ditambahkan (sebelumnya tidak ada)
        ->label('Kode Desa')
        ->required(),
    // ... field lainnya
    // Field opsional tidak wajib diisi lagi:
    Forms\Components\TextInput::make('data.luas_wilayah')
        ->label('Luas Wilayah (km²)')
        ->numeric(),  // ✅ Sebelumnya: ->required()
    // dst...
],
```

### 2. Frontend - ProfilDesa.jsx
**File**: `project/src/pages/ProfilDesa.jsx`

#### Perubahan 1: Header Title
```jsx
// ❌ Sebelumnya
<Typography>Profil {data.profil.nama}</Typography>

// ✅ Sekarang
<Typography>Profil Desa {data.profil.nama_desa}</Typography>
```

#### Perubahan 2: Sejarah Title
```jsx
// ❌ Sebelumnya
<Typography>Sejarah {data.profil.nama}</Typography>

// ✅ Sekarang
<Typography>Sejarah Desa {data.profil.nama_desa}</Typography>
```

#### Perubahan 3: Geografi Data dengan Fallback
```jsx
// ✅ Menambahkan fallback untuk field yang mungkin kosong
{[
    ['Koordinat', data.geografi.koordinat ? `${data.geografi.koordinat?.lintang}, ${data.geografi.koordinat?.bujur}` : '-'],
    ['Topografi', data.geografi.topografi || '-'],
    ['Iklim', data.geografi.iklim || '-'],
    ['Luas Wilayah', data.profil.luas_wilayah ? `${data.profil.luas_wilayah} km²` : '-'],
    ['Ketinggian', data.profil.ketinggian ? `${data.profil.ketinggian} mdpl` : '-'],
    ['Jarak ke Kota', data.geografi.jarak_ke_kota_kabupaten || '-'],
].map(([label, value], idx) => (
    // render...
))}
```

## Struktur Data di Database

### Tabel: desa_info
```json
{
    "id": 1,
    "key": "profil",
    "aktif": true,
    "data": {
        "nama_desa": "LESANES",
        "kode_desa": "8103051002",
        "kecamatan": "KOTA MASOHI",
        "kabupaten": "KABUPATEN MALUKU TENGAH",
        "provinsi": "MALUKU",
        "kode_pos": "18398",
        "luas_wilayah": "30",
        "ketinggian": "459",
        "jumlah_penduduk": "180",
        "jumlah_kk": "22",
        "sambutan": "Terima kasih telah berkunjung"
    }
}
```

## API Response Structure
```json
{
    "data": {
        "profil": {
            "nama_desa": "LESANES",
            "kode_desa": "8103051002",
            // ... field lainnya
        },
        "sejarah": null,
        "visi_misi": null,
        "geografi": null,
        "demografi": null,
        "fasilitas": null
    }
}
```

## Testing
1. Buka admin panel → Informasi Desa
2. Edit record dengan key "profil"
3. Form sekarang menampilkan:
   - ✅ Nama Desa: LESANES
   - ✅ Kode Desa: 8103051002
   - ✅ Field lainnya
4. Buka website publik → Menu "Profil Desa"
5. Halaman sekarang menampilkan:
   - ✅ Header: "Profil Desa LESANES"
   - ✅ Konten profil desa (jika data lengkap)
   - ✅ Empty state jika data belum dikonfigurasi

## Status
✅ **SELESAI** - Form admin dan halaman publik sudah diperbaiki

## Next Steps
Untuk menampilkan konten lengkap di halaman Profil Desa, admin perlu menambahkan data:
1. **Sejarah** - key: `sejarah`
2. **Visi & Misi** - key: `visi_misi`
3. **Geografi** - key: `geografi`
4. **Demografi** - key: `demografi`
5. **Fasilitas Umum** - key: `fasilitas`

Semua bisa ditambahkan melalui admin panel → Informasi Desa → Tambah Data
