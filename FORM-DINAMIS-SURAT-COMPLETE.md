# Form Dinamis Input Surat - COMPLETE ✅

## 📊 Summary

**Status**: ✅ SELESAI  
**Fitur**: Form dinamis yang auto-generate field berdasarkan jenis surat  
**Tanggal**: 5 Maret 2026

---

## 🎯 Fitur Utama

### 1. Form Dinamis Otomatis
Form akan otomatis generate field input berdasarkan variabel yang ada di `surat_jenis.variabel`

### 2. Auto-Fill dari Database Penduduk
Ketika operator pilih penduduk dari dropdown, data otomatis terisi:
- NIK
- Nama
- Tempat/Tanggal Lahir
- Jenis Kelamin
- Agama
- Pekerjaan
- Alamat, RT, RW, Dusun

### 3. Smart Field Type Detection
Sistem otomatis detect tipe field berdasarkan nama variabel:

| Nama Variabel | Tipe Field | Contoh |
|---------------|------------|--------|
| `tanggal_*` | DatePicker | tanggal_lahir, tanggal_surat |
| `jenis_kelamin` | Select (L/P) | Laki-laki, Perempuan |
| `agama` | Select | Islam, Kristen, Katolik, dll |
| `status` (nikah) | Select | Belum Kawin, Kawin, Cerai |
| `alamat`, `keterangan`, `alasan` | Textarea | Field panjang |
| `jumlah`, `luas`, `penghasilan` | Number | Field angka |
| Lainnya | TextInput | Field text biasa |

---

## 📋 Struktur Form

### Section 1: Data Surat
- **Jenis Surat** (Select) - Pilih dari 45 jenis surat
- **Nomor Surat** (Auto-generate) - Otomatis dari sistem
- **Tanggal Surat** (DatePicker) - Default hari ini

### Section 2: Data Pemohon
- **Pilih Penduduk** (Select, Opsional) - Auto-fill dari database
- **NIK** (TextInput, Required)
- **Nama Lengkap** (TextInput, Required)
- **Keperluan Surat** (Textarea)

### Section 3: Data Detail Surat (DINAMIS)
Field-field ini muncul otomatis berdasarkan jenis surat yang dipilih.

**Contoh untuk Surat Keterangan Domisili:**
- Tempat Lahir
- Tanggal Lahir
- Jenis Kelamin
- Agama
- Pekerjaan
- Alamat
- RT
- RW
- Dusun

**Contoh untuk Surat Keterangan Usaha:**
- Tempat Lahir
- Tanggal Lahir
- Pekerjaan
- Alamat
- Nama Usaha
- Jenis Usaha
- Alamat Usaha
- Tahun Berdiri

### Section 4: TTD & Verifikasi
- **Penandatangan** (Select) - Pilih dari dokumen TTD
- **Kode QR** (Auto-generate) - Otomatis saat save

---

## 🔄 Workflow Penggunaan

### Untuk Warga Walk-in (Datang Langsung):

```
1. Operator buka menu "Arsip Surat Keluar"
   ↓
2. Klik "Create" / "Buat Baru"
   ↓
3. Pilih "Jenis Surat" (misal: Surat Keterangan Domisili)
   ↓
4. Form detail otomatis muncul sesuai variabel
   ↓
5. Pilih "Penduduk" dari dropdown (opsional)
   → Data otomatis terisi
   ↓
6. Lengkapi field yang masih kosong
   ↓
7. Klik "Save"
   → Nomor surat & QR code otomatis
   ↓
8. Klik "Generate PDF"
   ↓
9. Download & Print
   ↓
10. TTD & Stempel
    ↓
11. Serahkan ke warga
```

---

## 💡 Contoh Penggunaan

### Contoh 1: Surat Keterangan Domisili

**Step 1: Pilih Jenis Surat**
```
Jenis Surat: Surat Keterangan Domisili (SKT-DOM-007)
Nomor Surat: 001/SKT-DOM/III/2026 (auto)
Tanggal Surat: 05/03/2026 (default hari ini)
```

**Step 2: Data Pemohon**
```
Pilih Penduduk: [Cari nama...] → Pilih "Ahmad Yani"
NIK: 8171234567890123 (auto-fill)
Nama: Ahmad Yani (auto-fill)
Keperluan: Pengurusan BPJS
```

**Step 3: Data Detail (Auto-generate)**
```
Tempat Lahir: Masohi (auto-fill)
Tanggal Lahir: 15/08/1990 (auto-fill)
Jenis Kelamin: Laki-laki (auto-fill)
Agama: Islam (auto-fill)
Pekerjaan: Petani (auto-fill)
Alamat: Dusun Lesane RT 001 RW 001 (auto-fill)
RT: 001 (auto-fill)
RW: 001 (auto-fill)
Dusun: Lesane (auto-fill)
```

**Step 4: Save & Generate**
```
→ Klik "Save"
→ Klik "Generate PDF"
→ Download
→ Print
```

### Contoh 2: Surat Keterangan Usaha

**Step 1: Pilih Jenis Surat**
```
Jenis Surat: Surat Keterangan Usaha (SKT-USH-009)
```

**Step 2: Data Pemohon**
```
Pilih Penduduk: Siti Aminah
NIK: 8171234567890124 (auto-fill)
Nama: Siti Aminah (auto-fill)
Keperluan: Pengajuan kredit UMKM
```

**Step 3: Data Detail (Auto-generate)**
```
Tempat Lahir: Masohi (auto-fill)
Tanggal Lahir: 20/05/1985 (auto-fill)
Pekerjaan: Wiraswasta (auto-fill)
Alamat: Dusun Lesane RT 002 RW 001 (auto-fill)
Nama Usaha: Warung Siti (input manual)
Jenis Usaha: Warung Kelontong (input manual)
Alamat Usaha: Dusun Lesane (input manual)
Tahun Berdiri: 2020 (input manual)
```

---

## 🎨 Keunggulan Form Dinamis

### ✅ Untuk Operator:
1. **Tidak perlu hafal field** - Form otomatis muncul
2. **Auto-fill dari database** - Hemat waktu input
3. **Validasi otomatis** - Field type sudah sesuai
4. **User-friendly** - Interface intuitif

### ✅ Untuk Sistem:
1. **Konsisten** - Data terstruktur dengan baik
2. **Fleksibel** - Mudah tambah jenis surat baru
3. **Maintainable** - Tidak perlu edit kode untuk jenis surat baru
4. **Scalable** - Support 45+ jenis surat

### ✅ Untuk Warga:
1. **Proses cepat** - Operator tidak perlu input manual semua
2. **Data akurat** - Auto-fill dari database penduduk
3. **Surat langsung jadi** - Generate PDF instant

---

## 🔧 Konfigurasi Jenis Surat Baru

Untuk menambah jenis surat baru dengan form dinamis:

### 1. Tambah di Seeder
```php
$jenisSurat[] = [
    'kategori_id' => $kdp,
    'nama' => 'Surat Keterangan Baru',
    'kode' => 'SKT-NEW-046',
    'singkatan' => 'SK-Baru',
    'deskripsi' => 'Surat keterangan baru',
    'variabel' => [
        'nama_pemohon' => 'Nama',
        'nik' => 'NIK',
        'tempat_lahir' => 'Tempat lahir',
        'tanggal_lahir' => 'Tanggal lahir',
        'jenis_kelamin' => 'Jenis kelamin',
        'agama' => 'Agama',
        'pekerjaan' => 'Pekerjaan',
        'alamat' => 'Alamat',
        'keperluan' => 'Keperluan',
    ],
    'format_nomor' => '{nomor}/SKT-NEW/{romawi}/{tahun}',
    'perlu_ttd_kades' => true,
    'aktif_permohonan_online' => true,
    'aktif' => true,
    'urutan' => 46,
];
```

### 2. Run Seeder
```bash
php artisan db:seed --class=SuratJenisSeeder
```

### 3. Form Otomatis Muncul!
Tidak perlu edit kode apapun. Form akan otomatis generate field berdasarkan variabel.

---

## 📝 Catatan Penting

### Field yang Di-skip
Field berikut tidak muncul di section "Data Detail" karena sudah ada di section "Data Pemohon":
- `nik`
- `nama_pemohon`
- `keperluan`

### Auto-Fill dari Penduduk
Field berikut otomatis terisi jika operator pilih penduduk:
- `nik`
- `nama_pemohon`
- `tempat_lahir`
- `tanggal_lahir`
- `jenis_kelamin`
- `agama`
- `pekerjaan`
- `alamat`
- `rt`
- `rw`
- `dusun`

### Data Disimpan di JSON
Semua data detail disimpan di field `data_surat` (JSON) di tabel `surat_arsip`.

---

## 🚀 Testing

### Test Case 1: Pilih Jenis Surat
1. Buka menu "Arsip Surat Keluar"
2. Klik "Create"
3. Pilih jenis surat
4. ✅ Form detail harus muncul otomatis

### Test Case 2: Auto-Fill Penduduk
1. Pilih jenis surat
2. Pilih penduduk dari dropdown
3. ✅ Data harus terisi otomatis

### Test Case 3: Save & Generate
1. Isi semua field
2. Klik "Save"
3. ✅ Data tersimpan dengan QR code
4. Klik "Generate PDF"
5. ✅ PDF berhasil dibuat

### Test Case 4: Edit Surat
1. Buka surat yang sudah dibuat
2. Klik "Edit"
3. ✅ Form detail harus muncul dengan data yang sudah terisi

---

## 🎯 Next Steps

### Immediate
1. ✅ Form dinamis sudah jadi
2. ⏳ Testing dengan semua 45 jenis surat
3. ⏳ Training operator cara pakai

### Short Term
4. ⏳ Buat template .docx untuk generate PDF
5. ⏳ Setup TTD digital
6. ⏳ Testing print surat

### Long Term
7. ⏳ Integrasi dengan mobile app
8. ⏳ Auto-generate dari permohonan online
9. ⏳ Notifikasi ke warga

---

**🎉 Form Dinamis Sudah Siap Digunakan!**

Operator sekarang bisa input surat dengan mudah dan cepat. Form otomatis menyesuaikan dengan jenis surat yang dipilih.
