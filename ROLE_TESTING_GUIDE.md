# Role-Based Access Testing Guide

## Test Users

| Username | Password | Tipe | Nama |
|----------|----------|------|------|
| `superadmin` | `admin123` | superadmin | Super Admin |
| `operator` | `operator123` | operator | Operator Desa |
| `kades` | `kades123` | kepala_desa | Muhammad Latuconsina |
| `kaur_pemerintahan` | `kaur123` | operator | Kaur Pemerintahan |
| `bendahara` | `bendahara123` | operator | Bendahara Desa |

## Testing Steps

### 1. Test Superadmin Access
**Login:** `superadmin` / `admin123`

**Expected Menu Groups:**
- ✅ Dashboard
- ✅ Kependudukan (6 menu)
- ✅ Persuratan (7 menu)
- ✅ Keuangan (4 menu)
- ✅ Pembangunan (3 menu)
- ✅ Bantuan Sosial (2 menu)
- ✅ Aset & Inventaris (3 menu)
- ✅ Sekretariat (3 menu)
- ✅ Web Publik (8 menu)
- ✅ Info Desa (3 menu)
- ✅ Pengaturan (1 menu: Manajemen User)
- ✅ Laporan (1 menu)

**Total:** SEMUA menu terlihat

---

### 2. Test Operator Access
**Login:** `operator` / `operator123`

**Expected Menu Groups:**
- ✅ Dashboard
- ✅ Kependudukan (6 menu)
- ✅ Persuratan (7 menu)
- ✅ Keuangan (4 menu)
- ✅ Pembangunan (3 menu)
- ✅ Bantuan Sosial (2 menu)
- ✅ Aset & Inventaris (3 menu)
- ✅ Sekretariat (3 menu)
- ✅ Web Publik (8 menu)
- ✅ Info Desa (2 menu: Wilayah, Perangkat Desa)
- ❌ Pengaturan (TIDAK ADA)
- ✅ Laporan (1 menu)

**Hidden Menus:**
- ❌ Konfigurasi Desa (Info Desa)
- ❌ Manajemen User (Pengaturan)

**Total:** Hampir semua menu kecuali 2 menu sensitif

---

### 3. Test Kepala Desa Access
**Login:** `kades` / `kades123`

**Expected Menu Groups:**
- ✅ Dashboard
- ✅ Kependudukan (5 menu - tanpa Log Mutasi)
- ✅ Persuratan (5 menu - tanpa Kategori & Jenis Surat)
- ✅ Keuangan (4 menu)
- ✅ Pembangunan (3 menu)
- ✅ Bantuan Sosial (2 menu)
- ✅ Aset & Inventaris (2 menu - tanpa Kategori Aset)
- ✅ Sekretariat (3 menu)
- ❌ Web Publik (TIDAK ADA - 0 menu)
- ✅ Info Desa (2 menu: Wilayah, Perangkat Desa)
- ❌ Pengaturan (TIDAK ADA)
- ✅ Laporan (1 menu)

**Hidden Menus (14 total):**

**Web Publik (8 menu):**
1. ❌ Informasi Desa
2. ❌ Artikel & Berita
3. ❌ Galeri
4. ❌ Lapak UMKM
5. ❌ Potensi Desa
6. ❌ Halaman Statis
7. ❌ Teks Berjalan
8. ❌ Pesan Masuk

**Persuratan (2 menu):**
9. ❌ Kategori Surat
10. ❌ Jenis Surat

**Kependudukan (1 menu):**
11. ❌ Log Mutasi

**Aset & Inventaris (1 menu):**
12. ❌ Kategori Aset

**Info Desa (1 menu):**
13. ❌ Konfigurasi Desa

**Pengaturan (1 menu):**
14. ❌ Manajemen User

**Total:** Menu fokus pada monitoring dan approval

---

## Verification Checklist

### For Superadmin
- [ ] Bisa melihat menu "Manajemen User"
- [ ] Bisa melihat menu "Konfigurasi Desa"
- [ ] Bisa melihat semua menu Web Publik
- [ ] Bisa melihat "Log Mutasi"
- [ ] Total menu group: 12

### For Operator
- [ ] TIDAK bisa melihat "Manajemen User"
- [ ] TIDAK bisa melihat "Konfigurasi Desa"
- [ ] Bisa melihat semua menu Web Publik
- [ ] Bisa melihat "Log Mutasi"
- [ ] Total menu group: 11

### For Kepala Desa
- [ ] TIDAK bisa melihat "Manajemen User"
- [ ] TIDAK bisa melihat "Konfigurasi Desa"
- [ ] TIDAK bisa melihat menu group "Web Publik"
- [ ] TIDAK bisa melihat "Kategori Surat"
- [ ] TIDAK bisa melihat "Jenis Surat"
- [ ] TIDAK bisa melihat "Kategori Aset"
- [ ] TIDAK bisa melihat "Log Mutasi"
- [ ] Total menu group: 9

---

## Quick Test Commands

### Check Current User Role
```bash
# Di admin panel, lihat pojok kanan atas
# Atau check via tinker:
php artisan tinker --execute="echo auth()->user()->tipe;"
```

### Count Visible Menu Items
```bash
# Login dan hitung manual menu di sidebar
# Atau inspect element dan count navigation items
```

### Test Direct URL Access
```bash
# Try accessing restricted URLs directly
# Example for Kepala Desa:
http://127.0.0.1:8000/admin/users
http://127.0.0.1:8000/admin/desa-configs
http://127.0.0.1:8000/admin/web-artikels
```

**Note:** Direct URL access masih bisa berhasil karena hanya menu yang disembunyikan. Untuk keamanan penuh, perlu implementasi Policy.

---

## Expected Behavior

### Navigation Sidebar
- Menu yang tidak sesuai role TIDAK muncul di sidebar
- Menu group yang kosong (semua menu hidden) TIDAK muncul
- Badge notification tetap berfungsi untuk menu yang visible

### Dashboard
- Semua role bisa akses dashboard
- Widget yang ditampilkan bisa berbeda per role (optional future enhancement)

### Direct URL Access
- Saat ini: User masih bisa akses jika tahu URL
- Future: Implementasi Policy untuk block access sepenuhnya

---

## Troubleshooting

### Menu masih terlihat padahal seharusnya hidden
1. Clear cache: `php artisan cache:clear`
2. Clear view cache: `php artisan view:clear`
3. Logout dan login ulang
4. Check user tipe di database

### Error saat akses menu
1. Check apakah method `shouldRegisterNavigation()` sudah benar
2. Check apakah `auth()->user()` tidak null
3. Check log error di `storage/logs/laravel.log`

---

**Status**: 📋 Testing Guide
**Date**: 2026-03-02
**Version**: 1.0
