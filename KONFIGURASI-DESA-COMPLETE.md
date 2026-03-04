# Konfigurasi Desa - Data Lengkap

## Status: ✅ SELESAI

Data Konfigurasi Desa telah diisi lengkap dengan contoh data Desa Lesane.

## Data yang Sudah Diisi

### Tab: Identitas Desa
- ✅ Nama Desa: LESANES
- ✅ Kode Desa: 8102012001
- ✅ Kode Pos: 97511
- ✅ Nama Kecamatan: KOTA MASOHI
- ✅ Nama Kabupaten: MALUKU TENGAH
- ✅ Nama Provinsi: MALUKU
- ✅ Alamat Kantor: Jl. Raya Trans Seram KM 12, Desa Lesane, Kota Masohi
- ✅ Telepon: (0914) 21234
- ✅ Email: desalesane@malukutengahkab.go.id
- ✅ Website: https://desalesane.malukutengahkab.go.id

### Tab: Visi, Misi & Sejarah
- ✅ Visi: Terwujudnya Desa Lesane yang Maju, Mandiri, Sejahtera, dan Berbudaya Berbasis Potensi Lokal pada Tahun 2027
- ✅ Misi: 6 poin misi pembangunan desa
- ✅ Sejarah: Ringkasan sejarah desa sejak abad ke-17

### Tab: Pimpinan
- ✅ Nama Kepala Desa: Muhammad Saleh Lestaluhu
- ✅ NIP Kepala Desa: 196505101985031001
- ⏳ Foto Kepala Desa: Belum diupload (bisa upload via admin panel)
- ⏳ TTD Digital: Belum diupload (bisa upload via admin panel)
- ⏳ Stempel Desa: Belum diupload (bisa upload via admin panel)

### Tab: Lokasi & Tampilan
- ✅ Latitude: -3.3875
- ✅ Longitude: 128.9250
- ⏳ Logo Desa: Belum diupload (bisa upload via admin panel)
- ⏳ Foto Kantor: Belum diupload (bisa upload via admin panel)
- ⏳ Tema Warna: Default (#1F3864)

### Tab: Surat
- ✅ Format Nomor Surat: {nomor}/{kode_desa}/{bulan_romawi}/{tahun}
- ✅ Kode Surat Desa: Des-LSN
- ✅ Tahun APBDes Aktif: 2026

### Tab: Integrasi
- ⏳ WhatsApp API: Belum dikonfigurasi
- ⏳ Email SMTP: Belum dikonfigurasi
- ⏳ FCM Push Notif: Belum dikonfigurasi

### Tab: Sosial Media & IDM
- ✅ Facebook: https://facebook.com/DesaLesane
- ✅ Instagram: https://instagram.com/desalesane
- ✅ YouTube: https://youtube.com/@DesaLesane
- ⏳ Twitter: Belum diisi
- ✅ Skor IDM: 0.6825
- ✅ Status IDM: Berkembang
- ✅ Tahun IDM: 2025

## API Response

### GET /api/v1/desa-info/profil

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
    "alamat": "Jl. Raya Trans Seram KM 12, Desa Lesane, Kota Masohi",
    "telepon": "(0914) 21234",
    "email": "desalesane@malukutengahkab.go.id",
    "website": "https://desalesane.malukutengahkab.go.id",
    "logo": null,
    "visi": "Terwujudnya Desa Lesane yang Maju, Mandiri, Sejahtera...",
    "misi": "Meningkatkan kualitas SDM...",
    "sejarah": "Desa Lesane adalah negeri adat...",
    "nama_kepala_desa": "Muhammad Saleh Lestaluhu",
    "foto_kepala_desa": null,
    "latitude": "-3.3875000",
    "longitude": "128.9250000"
  }
}
```

## Langkah Selanjutnya

### 1. Upload File (via Admin Panel)
Login sebagai Superadmin → Info Desa → Konfigurasi Desa → Edit

**Tab "Lokasi & Tampilan":**
- Upload Logo Desa (PNG/JPG, 1:1 ratio, max 2MB)
- Upload Foto Kantor

**Tab "Pimpinan":**
- Upload Foto Kepala Desa
- Upload TTD Digital (untuk dokumen surat)
- Upload Stempel Desa (untuk dokumen surat)

### 2. Konfigurasi Integrasi (Opsional)
**Tab "Integrasi":**
- WhatsApp API (untuk notifikasi WA)
- Email SMTP (untuk email system)
- FCM Server Key (untuk push notification)

### 3. Isi Konten Website
Login sebagai Admin → Web Publik → Konten Profil Desa

Buat konten untuk:
- Sejarah (versi panjang dengan timeline)
- Visi & Misi (format website)
- Geografi
- Demografi
- Fasilitas Umum
- Pemerintahan
- Kontak
- Layanan Publik

Atau jalankan seeder:
```bash
php artisan db:seed --class=DesaInfoSeeder
```

## Cara Update Data

### Via Tinker (Manual)
```bash
php artisan tinker
>>> $config = \App\Models\DesaConfig::first();
>>> $config->nama_desa = 'Nama Baru';
>>> $config->save();
```

### Via Admin Panel (Recommended)
1. Login sebagai Superadmin
2. Menu: Info Desa → Konfigurasi Desa
3. Klik tombol Edit
4. Update data yang diperlukan
5. Simpan

## Testing

### Test API
```bash
curl http://localhost:8000/api/v1/desa-info/profil | jq
```

### Test Website
1. Buka http://localhost:3000
2. Cek header → Nama desa harus "LESANES"
3. Cek footer → Info desa harus lengkap
4. Buka halaman Profil → Data harus muncul

## Catatan Penting

1. **Data ini digunakan di seluruh sistem:**
   - Header & Footer website
   - Dokumen surat (kop surat, TTD)
   - Laporan PDF
   - Email & Notifikasi

2. **Hanya Superadmin yang bisa edit:**
   - Data sensitif & konfigurasi sistem
   - Perubahan berdampak ke seluruh aplikasi

3. **Logo & TTD sangat penting:**
   - Logo untuk branding website & dokumen
   - TTD digital untuk validitas dokumen surat
   - Stempel untuk dokumen resmi

4. **Koordinat GPS:**
   - Untuk peta lokasi di website
   - Untuk integrasi dengan Google Maps

5. **Format Nomor Surat:**
   - Digunakan untuk generate nomor surat otomatis
   - Format: {nomor}/{kode_desa}/{bulan_romawi}/{tahun}
   - Contoh: 001/Des-LSN/III/2026

## Troubleshooting

### Logo tidak muncul di website
```bash
# Pastikan symbolic link sudah dibuat
php artisan storage:link

# Cek permission folder storage
chmod -R 775 storage
```

### Data tidak update di website
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Restart server
php artisan serve
```

### API return 404
```bash
# Clear route cache
php artisan route:clear
php artisan route:cache
```

## Summary

✅ Data identitas desa lengkap
✅ Visi, misi, sejarah terisi
✅ Data kepala desa terisi
✅ Koordinat GPS terisi
✅ Sosial media terisi
✅ Konfigurasi surat terisi
✅ API berfungsi dengan baik

⏳ Perlu upload: Logo, Foto Kepala Desa, TTD, Stempel
⏳ Perlu konfigurasi: Integrasi (WA, Email, FCM)
⏳ Perlu isi: Konten website (via Konten Profil Desa)
