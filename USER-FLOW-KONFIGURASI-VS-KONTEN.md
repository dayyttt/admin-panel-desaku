# User Flow: Konfigurasi Desa vs Konten Profil Desa

## 🎯 Perbedaan Fungsi

### 📋 Konfigurasi Desa (Info Desa)
**Tujuan:** Data master sistem yang digunakan di SELURUH aplikasi

**Digunakan untuk:**
1. ✅ Header & Footer Website (nama desa, logo)
2. ✅ Dokumen Surat (kop surat, TTD, stempel)
3. ✅ Laporan PDF (identitas desa)
4. ✅ Email & Notifikasi (nama pengirim)
5. ✅ Konfigurasi sistem (format nomor surat, integrasi API)

**Akses:** Hanya Superadmin (karena data sensitif & konfigurasi sistem)

### 🌐 Konten Profil Desa (Web Publik)
**Tujuan:** Konten editorial untuk halaman profil website publik

**Digunakan untuk:**
1. ✅ Halaman Profil Website (konten panjang & detail)
2. ✅ Informasi untuk pengunjung website
3. ✅ Konten yang sering diupdate (demografi, fasilitas)

**Akses:** Admin & Operator (bisa edit konten tanpa akses konfigurasi sistem)

---

## 📊 User Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    INSTALASI SISTEM                              │
│  Wizard mengisi: Nama Desa, Kode, Alamat, Kecamatan, dll       │
│                          ↓                                       │
│              Data masuk ke DESA_CONFIG                          │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                   SUPERADMIN LOGIN                               │
│              Menu: Info Desa → Konfigurasi Desa                 │
└─────────────────────────────────────────────────────────────────┘
                              ↓
        ┌─────────────────────┴─────────────────────┐
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  Tab: Identitas Desa │                  │ Tab: Lokasi & Tampilan│
│  - Nama Desa         │                  │  - UPLOAD LOGO ⭐     │
│  - Kode Desa         │                  │  - Koordinat GPS      │
│  - Alamat Kantor     │                  │  - Foto Kantor        │
│  - Telepon, Email    │                  │  - Tema Warna         │
└──────────────────────┘                  └──────────────────────┘
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│ Tab: Visi, Misi &    │                  │  Tab: Pimpinan       │
│      Sejarah         │                  │  - Nama Kepala Desa  │
│  - Visi (singkat)    │                  │  - NIP               │
│  - Misi (singkat)    │                  │  - Foto Kepala Desa  │
│  - Sejarah (singkat) │                  │  - TTD Digital ⭐     │
└──────────────────────┘                  │  - Stempel Desa ⭐    │
        ↓                                  └──────────────────────┘
┌──────────────────────┐                           ↓
│  Tab: Surat          │                  ┌──────────────────────┐
│  - Format Nomor      │                  │  Tab: Integrasi      │
│  - Kode Surat        │                  │  - WhatsApp API      │
│  - Tahun APBDes      │                  │  - Email SMTP        │
└──────────────────────┘                  │  - FCM Push Notif    │
                                          └──────────────────────┘
                              ↓
        ┌─────────────────────┴─────────────────────┐
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  DIGUNAKAN DI:       │                  │  DIGUNAKAN DI:       │
│  ✅ Header Website   │                  │  ✅ Dokumen Surat    │
│  ✅ Footer Website   │                  │  ✅ Laporan PDF      │
│  ✅ Halaman Profil   │                  │  ✅ Email System     │
│  ✅ Kop Surat        │                  │  ✅ Notifikasi       │
└──────────────────────┘                  └──────────────────────┘

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│              ADMIN/OPERATOR LOGIN                                │
│          Menu: Web Publik → Konten Profil Desa                  │
└─────────────────────────────────────────────────────────────────┘
                              ↓
        ┌─────────────────────┴─────────────────────┐
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  Buat: SEJARAH       │                  │  Buat: VISI & MISI   │
│  - Konten panjang    │                  │  - Visi (RichEditor) │
│    dengan RichEditor │                  │  - Misi (Repeater)   │
│  - Timeline sejarah  │                  │    • Poin 1          │
│    • 1950: Berdiri   │                  │    • Poin 2          │
│    • 1985: Listrik   │                  │    • Poin 3          │
│    • 2020: Website   │                  │    • dst...          │
└──────────────────────┘                  └──────────────────────┘
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  Buat: GEOGRAFI      │                  │  Buat: DEMOGRAFI     │
│  - Koordinat Lokasi  │                  │  - Total Penduduk    │
│  - Topografi         │                  │  - Laki-laki         │
│  - Iklim             │                  │  - Perempuan         │
│  - Batas Wilayah     │                  │  - Jumlah KK         │
└──────────────────────┘                  └──────────────────────┘
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  Buat: FASILITAS     │                  │  Buat: PEMERINTAHAN  │
│  - Pendidikan        │                  │  - Struktur Lengkap  │
│    • SD: 2           │                  │    • Kepala Desa     │
│    • SMP: 1          │                  │    • Sekretaris      │
│  - Kesehatan         │                  │    • Kaur Keuangan   │
│    • Puskesmas: 1    │                  │    • dst...          │
│  - Ibadah            │                  │  - BPD               │
│    • Masjid: 3       │                  │  - Kepala RT         │
└──────────────────────┘                  └──────────────────────┘
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  Buat: KONTAK        │                  │  Buat: LAYANAN       │
│  - Alamat lengkap    │                  │  - Surat KTP         │
│  - Jam operasional   │                  │  - Surat KK          │
│  - Media sosial      │                  │  - Surat Usaha       │
│    • Facebook        │                  │  - Surat SKTM        │
│    • Instagram       │                  │  - dst...            │
└──────────────────────┘                  └──────────────────────┘
                              ↓
        ┌─────────────────────┴─────────────────────┐
        ↓                                           ↓
┌──────────────────────┐                  ┌──────────────────────┐
│  DIGUNAKAN DI:       │                  │  TIDAK DIGUNAKAN DI: │
│  ✅ Halaman Profil   │                  │  ❌ Dokumen Surat    │
│     Website          │                  │  ❌ Laporan PDF      │
│  ✅ Halaman Sejarah  │                  │  ❌ Email System     │
│  ✅ Halaman Visi Misi│                  │  ❌ Header/Footer    │
│  ✅ Halaman Kontak   │                  │     (kecuali kontak) │
└──────────────────────┘                  └──────────────────────┘
```

---

## 🔄 Contoh Skenario Nyata

### Skenario 1: Upload Logo Desa
```
❌ SALAH:
User → Web Publik → Konten Profil Desa → Cari field logo
Result: Tidak ada field logo!

✅ BENAR:
Superadmin → Info Desa → Konfigurasi Desa → Tab "Lokasi & Tampilan" → Upload Logo
Result: Logo muncul di header, footer, dan dokumen surat
```

### Skenario 2: Update Nama Desa
```
❌ SALAH:
User → Web Publik → Konten Profil Desa → Edit
Result: Tidak ada field nama desa!

✅ BENAR:
Superadmin → Info Desa → Konfigurasi Desa → Tab "Identitas Desa" → Edit Nama Desa
Result: Nama berubah di seluruh sistem (website, surat, laporan)
```

### Skenario 3: Tambah Sejarah Desa Panjang
```
❌ SALAH:
Superadmin → Info Desa → Konfigurasi Desa → Tab "Visi, Misi & Sejarah"
Result: Field sejarah terlalu kecil, tidak ada timeline

✅ BENAR:
Admin → Web Publik → Konten Profil Desa → Buat → Pilih "Sejarah"
Result: RichEditor panjang + timeline interaktif untuk website
```

### Skenario 4: Update Data Penduduk
```
❌ SALAH:
Superadmin → Info Desa → Konfigurasi Desa
Result: Tidak ada field detail penduduk

✅ BENAR:
Admin → Web Publik → Konten Profil Desa → Edit "Demografi"
Result: Data penduduk update di halaman profil website
```

### Skenario 5: Ganti TTD Kepala Desa
```
❌ SALAH:
Admin → Web Publik → Konten Profil Desa
Result: Tidak ada field TTD digital

✅ BENAR:
Superadmin → Info Desa → Konfigurasi Desa → Tab "Pimpinan" → Upload TTD Digital
Result: TTD muncul di semua dokumen surat
```

---

## 📝 Checklist: Kapan Pakai Yang Mana?

### Gunakan KONFIGURASI DESA jika:
- [ ] Upload logo desa
- [ ] Ubah nama desa
- [ ] Ubah alamat kantor
- [ ] Ubah telepon/email resmi
- [ ] Upload TTD digital kepala desa
- [ ] Upload stempel desa
- [ ] Setting format nomor surat
- [ ] Konfigurasi integrasi (WA, Email, FCM)
- [ ] Data yang digunakan di dokumen/surat

### Gunakan KONTEN PROFIL DESA jika:
- [ ] Tulis sejarah desa panjang
- [ ] Buat timeline sejarah
- [ ] Input data geografi detail
- [ ] Update data penduduk
- [ ] Daftar fasilitas umum
- [ ] Struktur pemerintahan lengkap
- [ ] Jam operasional & kontak detail
- [ ] Daftar layanan publik
- [ ] Konten editorial untuk website

---

## 🎓 Analogi Sederhana

**Konfigurasi Desa** = **KTP Desa**
- Data resmi, identitas utama
- Digunakan untuk urusan formal (surat, dokumen)
- Jarang berubah
- Hanya pejabat tinggi yang bisa edit

**Konten Profil Desa** = **Brosur Desa**
- Informasi promosi & detail
- Untuk pengunjung/wisatawan
- Bisa sering diupdate
- Staff biasa bisa edit

---

## 💡 Tips Penggunaan

1. **Instalasi Pertama:**
   - Wizard → isi data dasar (masuk ke Konfigurasi Desa)
   - Superadmin → upload logo & TTD
   - Admin → isi konten website (Konten Profil Desa)

2. **Maintenance Rutin:**
   - Konfigurasi Desa: Jarang diubah (kecuali ganti kepala desa)
   - Konten Profil Desa: Update berkala (demografi, fasilitas)

3. **Pembagian Tugas:**
   - Superadmin: Fokus ke Konfigurasi Desa
   - Admin/Operator: Fokus ke Konten Profil Desa

4. **Jika Bingung:**
   - Tanya: "Apakah data ini digunakan di surat/dokumen?"
   - Jika YA → Konfigurasi Desa
   - Jika TIDAK → Konten Profil Desa

---

## ✅ Kesimpulan

**Konfigurasi Desa** dan **Konten Profil Desa** punya fungsi berbeda:

| Aspek | Konfigurasi Desa | Konten Profil Desa |
|-------|------------------|-------------------|
| **Fungsi** | Data master sistem | Konten website |
| **Scope** | Seluruh aplikasi | Halaman profil saja |
| **Akses** | Superadmin only | Admin & Operator |
| **Frekuensi Update** | Jarang | Sering |
| **Contoh Data** | Logo, TTD, Nama | Sejarah, Demografi |
| **Digunakan Di** | Surat, Laporan, Website | Website saja |

Keduanya **SAMA-SAMA PENTING** dan **TIDAK DUPLIKASI**!
