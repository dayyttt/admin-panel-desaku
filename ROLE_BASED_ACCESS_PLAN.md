# Role-Based Access Control Plan

## Current Situation
Saat ini TIDAK ada pembatasan menu berdasarkan role. Semua user yang bisa login (superadmin, operator, kepala_desa) bisa melihat SEMUA menu.

## User Roles

### 1. Superadmin
- **Akses**: FULL ACCESS ke semua menu
- **Fungsi**: Mengelola sistem secara keseluruhan

### 2. Operator Desa
- **Akses**: Sebagian besar menu operasional
- **Fungsi**: Input data harian, kelola surat, kelola kependudukan
- **TIDAK BISA AKSES**:
  - Manajemen User (Pengaturan)
  - Konfigurasi Desa (Info Desa)
  - Beberapa menu keuangan sensitif (hanya view)

### 3. Kepala Desa
- **Akses**: View-only untuk laporan dan approval
- **Fungsi**: Monitoring, approval, TTD surat
- **BISA AKSES**:
  - Dashboard
  - Laporan Statistik
  - Data Penduduk (view only)
  - Keuangan (view only)
  - TTD & Stempel
  - Permohonan Surat (untuk approval)
- **TIDAK BISA**:
  - Create/Edit/Delete data
  - Pengaturan sistem
  - Import/Export

## Recommended Menu Access Matrix

| Menu Group | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| **Dashboard** | ✅ Full | ✅ Full | ✅ View |
| **Kependudukan** |
| - Data Penduduk | ✅ Full | ✅ Full | ✅ View |
| - Kartu Keluarga | ✅ Full | ✅ Full | ✅ View |
| - Kelahiran | ✅ Full | ✅ Full | ✅ View |
| - Kematian | ✅ Full | ✅ Full | ✅ View |
| - Pindah Keluar/Masuk | ✅ Full | ✅ Full | ✅ View |
| - Log Mutasi | ✅ Full | ✅ View | ❌ Hidden |
| **Persuratan** |
| - Kategori Surat | ✅ Full | ✅ Full | ❌ Hidden |
| - Jenis Surat | ✅ Full | ✅ Full | ❌ Hidden |
| - Template Surat | ✅ Full | ✅ Full | ❌ Hidden |
| - Permohonan Masuk | ✅ Full | ✅ Full | ✅ View + Approve |
| - Arsip Surat | ✅ Full | ✅ Full | ✅ View |
| - TTD & Stempel | ✅ Full | ✅ Full | ✅ Full |
| - Surat Masuk | ✅ Full | ✅ Full | ✅ View |
| **Keuangan** |
| - APBDes | ✅ Full | ✅ View | ✅ View |
| - Transaksi | ✅ Full | ✅ Full | ✅ View |
| - Buku Kas Umum | ✅ Full | ✅ Full | ✅ View |
| - Buku Bank | ✅ Full | ✅ Full | ✅ View |
| **Pembangunan** |
| - Proyek Pembangunan | ✅ Full | ✅ Full | ✅ View |
| - Dokumentasi | ✅ Full | ✅ Full | ✅ View |
| - Inventaris Hasil | ✅ Full | ✅ Full | ✅ View |
| **Bantuan Sosial** |
| - Program Bantuan | ✅ Full | ✅ Full | ✅ View |
| - Penerima Bantuan | ✅ Full | ✅ Full | ✅ View |
| **Aset & Inventaris** |
| - Kategori Aset | ✅ Full | ✅ Full | ❌ Hidden |
| - Aset Desa | ✅ Full | ✅ Full | ✅ View |
| - Tanah Kas Desa | ✅ Full | ✅ Full | ✅ View |
| **Sekretariat** |
| - Produk Hukum | ✅ Full | ✅ Full | ✅ View |
| - Surat Keputusan | ✅ Full | ✅ Full | ✅ View |
| - Arsip Desa | ✅ Full | ✅ Full | ✅ View |
| **Web Publik** |
| - Informasi Desa | ✅ Full | ✅ Full | ❌ Hidden |
| - Artikel & Berita | ✅ Full | ✅ Full | ❌ Hidden |
| - Galeri | ✅ Full | ✅ Full | ❌ Hidden |
| - Lapak UMKM | ✅ Full | ✅ Full | ❌ Hidden |
| - Potensi Desa | ✅ Full | ✅ Full | ❌ Hidden |
| - Halaman Statis | ✅ Full | ✅ Full | ❌ Hidden |
| - Teks Berjalan | ✅ Full | ✅ Full | ❌ Hidden |
| - Pesan Masuk | ✅ Full | ✅ Full | ❌ Hidden |
| **Info Desa** |
| - Konfigurasi Desa | ✅ Full | ❌ Hidden | ❌ Hidden |
| - Wilayah | ✅ Full | ✅ View | ❌ Hidden |
| - Perangkat Desa | ✅ Full | ✅ Full | ✅ View |
| **Pengaturan** |
| - Manajemen User | ✅ Full | ❌ Hidden | ❌ Hidden |
| - Roles & Permissions | ✅ Full | ❌ Hidden | ❌ Hidden |
| - Activity Log | ✅ Full | ❌ Hidden | ❌ Hidden |
| **Laporan** |
| - Laporan Statistik | ✅ Full | ✅ Full | ✅ Full |

## Implementation Strategy

### Option 1: Using `shouldRegisterNavigation()` (Recommended)
Add to each Resource:
```php
public static function shouldRegisterNavigation(): bool
{
    $user = auth()->user();
    
    // Superadmin can see everything
    if ($user->tipe === 'superadmin') {
        return true;
    }
    
    // Kepala Desa cannot see this menu
    if ($user->tipe === 'kepala_desa') {
        return false;
    }
    
    // Operator can see
    return true;
}
```

### Option 2: Using Policies
Create policies for each model and use `canViewAny()` method.

### Option 3: Using `canAccess()` in Resource
```php
public static function canAccess(): bool
{
    return auth()->user()->tipe !== 'kepala_desa';
}
```

## Next Steps
1. Implement `shouldRegisterNavigation()` for sensitive menus
2. Add view-only restrictions using policies
3. Test with different user roles
4. Document the access matrix

---

**Status**: 📋 Planning
**Priority**: High
**Estimated Time**: 2-3 hours
