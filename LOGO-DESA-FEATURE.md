# Fitur Upload Logo Desa

## Status: ✅ SELESAI

Fitur upload logo desa telah berhasil ditambahkan ke sistem.

## Cara Upload Logo Desa

1. **Login ke Admin Panel** di `http://localhost:8000/admin`

2. **Buka Menu "Informasi Desa"** (di grup Web Publik)

3. **Edit data "Profil Desa"**

4. **Upload Logo** di field paling atas:
   - Klik area upload atau drag & drop file logo
   - Format: PNG atau JPG
   - Ukuran maksimal: 2MB
   - Rasio: 1:1 (persegi/bulat)
   - Gunakan Image Editor untuk crop jika perlu

5. **Simpan** perubahan

## Hasil

Logo akan otomatis muncul di:
- **Header/Navbar** (pojok kiri atas)
- **Footer** (bagian info desa)

Jika logo belum diupload, sistem akan menampilkan icon default (LocationIcon dengan background gradient hijau).

## Teknis

### Backend
- Field: `data.logo` di tabel `desa_info` (key: profil)
- Storage: `storage/app/public/logo-desa/`
- Disk: `public`
- Akses: `/storage/logo-desa/filename.png`

### Frontend
- Navbar: Menampilkan logo bulat (40x40px)
- Footer: Menampilkan logo bulat (40x40px)
- Fallback: Icon LocationIcon jika logo kosong

### File yang Diubah
1. `sgc-backend/app/Filament/Resources/DesaInfoResource.php` - Tambah FileUpload field
2. `project/src/components/Navbar.jsx` - Tampilkan logo dari API
3. `project/src/components/Footer.jsx` - Tampilkan logo dari API

## Catatan

- Logo disimpan di storage Laravel (bukan public langsung)
- Symbolic link sudah dibuat: `public/storage` → `storage/app/public`
- Logo akan di-cache oleh browser untuk performa optimal
- Gunakan logo dengan kualitas baik untuk hasil terbaik
