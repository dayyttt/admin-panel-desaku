# Panduan Implementasi PDF Generator dari Template .docx

## 🎯 Tujuan
Melengkapi 5% fitur yang tersisa di Sprint 3: Generate PDF dari template .docx dengan replace variabel otomatis.

---

## 📦 Step 1: Install Library

```bash
cd sgc-backend

# Library untuk baca/edit .docx
composer require phpoffice/phpword

# Library untuk generate QR code
composer require simplesoftwareio/simple-qrcode

# Library untuk convert HTML ke PDF (pilih salah satu)
composer require barryvdh/laravel-dompdf  # Sudah ada
# ATAU
# composer require mpdf/mpdf
```

---

## 🔧 Step 2: Buat Service

```bash
php artisan make:service SuratGeneratorService
```

Atau buat manual file: `app/Services/SuratGeneratorService.php`

```php
<?php

namespace App\Services;

use App\Models\SuratArsip;
use App\Models\SuratJenis;
use App\Models\DokumenTtd;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratGeneratorService
{
    /**
     * Generate PDF dari template .docx
     */
    public function generateSurat(SuratArsip $surat): string
    {
        $jenis = $surat->suratJenis;
        
        // 1. Cek apakah ada template
        if (empty($jenis->template_path) || !Storage::disk('public')->exists($jenis->template_path)) {
            throw new \Exception('Template .docx tidak ditemukan');
        }

        // 2. Load template
        $templatePath = storage_path('app/public/' . $jenis->template_path);
        $template = new TemplateProcessor($templatePath);

        // 3. Siapkan data untuk replace variabel
        $data = $this->prepareData($surat);

        // 4. Replace semua variabel
        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        // 5. Simpan hasil ke temporary .docx
        $tempDocx = storage_path('app/temp/surat_' . $surat->id . '.docx');
        $template->saveAs($tempDocx);

        // 6. Convert .docx ke HTML (untuk PDF)
        $html = $this->convertDocxToHtml($tempDocx);

        // 7. Generate QR code
        $qrCodePath = $this->generateQrCode($surat);

        // 8. Tambah QR code ke HTML
        $html = $this->addQrCodeToHtml($html, $qrCodePath);

        // 9. Generate PDF
        $pdfPath = $this->generatePdf($html, $surat);

        // 10. Cleanup temp files
        @unlink($tempDocx);

        return $pdfPath;
    }

    /**
     * Siapkan data untuk replace variabel
     */
    protected function prepareData(SuratArsip $surat): array
    {
        $penduduk = $surat->penduduk;
        $jenis = $surat->suratJenis;
        
        // Data default
        $data = [
            'nomor_surat' => $surat->nomor_surat,
            'tanggal_surat' => $surat->tanggal_surat->format('d F Y'),
            'nama_pemohon' => $surat->nama_pemohon,
            'nik_pemohon' => $surat->nik_pemohon,
            'keperluan' => $surat->keperluan ?? '-',
        ];

        // Data dari penduduk (jika ada)
        if ($penduduk) {
            $data = array_merge($data, [
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir?->format('d-m-Y') ?? '-',
                'jenis_kelamin' => $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                'agama' => $penduduk->agama ?? '-',
                'pekerjaan' => $penduduk->pekerjaan ?? '-',
                'alamat' => $penduduk->alamat ?? '-',
                'rt' => $penduduk->rt ?? '-',
                'rw' => $penduduk->rw ?? '-',
                'dusun' => $penduduk->dusun ?? '-',
            ]);
        }

        // Data dari data_surat (JSON)
        if ($surat->data_surat) {
            $data = array_merge($data, $surat->data_surat);
        }

        // Data TTD
        if ($surat->ttd) {
            $data['nama_ttd'] = $surat->ttd->nama;
            $data['jabatan_ttd'] = $surat->ttd->jabatan;
        } else {
            $data['nama_ttd'] = 'Kepala Desa Lesane';
            $data['jabatan_ttd'] = 'Kepala Desa';
        }

        return $data;
    }

    /**
     * Convert .docx ke HTML (simplified)
     */
    protected function convertDocxToHtml(string $docxPath): string
    {
        // Cara sederhana: baca content dari .docx
        // Untuk production, bisa pakai library seperti pandoc atau phpword HTML writer
        
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxPath);
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        
        $tempHtml = storage_path('app/temp/temp.html');
        $htmlWriter->save($tempHtml);
        
        $html = file_get_contents($tempHtml);
        @unlink($tempHtml);
        
        return $html;
    }

    /**
     * Generate QR code
     */
    protected function generateQrCode(SuratArsip $surat): string
    {
        $qrCodePath = 'qr-codes/surat_' . $surat->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);
        
        // URL verifikasi
        $verifyUrl = config('app.url') . '/verifikasi/' . $surat->qr_code;
        
        // Generate QR code
        QrCode::format('png')
            ->size(200)
            ->generate($verifyUrl, $fullPath);
        
        return $qrCodePath;
    }

    /**
     * Tambah QR code ke HTML
     */
    protected function addQrCodeToHtml(string $html, string $qrCodePath): string
    {
        $qrCodeUrl = Storage::disk('public')->url($qrCodePath);
        
        // Tambah QR code di footer
        $qrHtml = '<div style="text-align: center; margin-top: 30px;">';
        $qrHtml .= '<img src="' . $qrCodeUrl . '" style="width: 150px; height: 150px;">';
        $qrHtml .= '<p style="font-size: 10px;">Scan untuk verifikasi</p>';
        $qrHtml .= '</div>';
        
        // Insert sebelum </body>
        $html = str_replace('</body>', $qrHtml . '</body>', $html);
        
        return $html;
    }

    /**
     * Generate PDF dari HTML
     */
    protected function generatePdf(string $html, SuratArsip $surat): string
    {
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 20)
            ->setOption('margin-bottom', 20)
            ->setOption('margin-left', 20)
            ->setOption('margin-right', 20);

        // Tambah TTD & stempel jika ada
        if ($surat->ttd && $surat->ttd->ttd_path) {
            // TODO: Overlay TTD image ke PDF
            // Bisa pakai library seperti FPDI atau setasign/fpdf
        }

        $filename = 'surat_' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        $pdfPath = 'surat-pdf/' . $filename;
        
        Storage::disk('public')->put($pdfPath, $pdf->output());
        
        return $pdfPath;
    }
}
```

---

## 🔄 Step 3: Update SuratArsipResource

Edit file: `app/Filament/Resources/SuratArsipResource.php`

```php
use App\Services\SuratGeneratorService;

// Di dalam table() method, update action generate_pdf:
Tables\Actions\Action::make('generate_pdf')
    ->label('📄 PDF')
    ->color('success')
    ->requiresConfirmation()
    ->action(function (SuratArsip $record) {
        try {
            $service = new SuratGeneratorService();
            $pdfPath = $service->generateSurat($record);
            
            $record->update(['file_pdf_path' => $pdfPath]);
            
            Notification::make()
                ->success()
                ->title('PDF berhasil digenerate!')
                ->body('File: ' . basename($pdfPath))
                ->send();
                
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Gagal generate PDF')
                ->body($e->getMessage())
                ->send();
        }
    }),
```

---

## 📝 Step 4: Buat Template .docx

### Format Template:

Buat file Word (.docx) dengan variabel menggunakan format `${variabel}`:

```
PEMERINTAH KABUPATEN MALUKU TENGAH
KECAMATAN KOTA MASOHI
DESA LESANE

SURAT KETERANGAN DOMISILI
Nomor: ${nomor_surat}

Yang bertanda tangan di bawah ini Kepala Desa Lesane, Kecamatan Kota Masohi, 
Kabupaten Maluku Tengah, menerangkan bahwa:

    Nama            : ${nama}
    NIK             : ${nik}
    Tempat/Tgl Lahir: ${tempat_lahir}, ${tanggal_lahir}
    Jenis Kelamin   : ${jenis_kelamin}
    Agama           : ${agama}
    Pekerjaan       : ${pekerjaan}
    Alamat          : ${alamat}, RT ${rt}/RW ${rw}, Dusun ${dusun}

Adalah benar penduduk Desa Lesane dan berdomisili di alamat tersebut di atas.

Surat keterangan ini dibuat untuk keperluan: ${keperluan}

Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan 
sebagaimana mestinya.

                                        Lesane, ${tanggal_surat}
                                        ${jabatan_ttd}


                                        ${nama_ttd}
```

### Upload Template:

1. Login ke admin panel
2. Menu "Persuratan" → "Jenis Surat"
3. Edit salah satu jenis surat
4. Upload file .docx di field "Template Path"
5. Simpan

---

## 🧪 Step 5: Testing

### Test Generate PDF:

1. Login admin panel
2. Menu "Persuratan" → "Arsip Surat Keluar"
3. Klik "Buat Baru"
4. Pilih jenis surat (yang sudah ada template)
5. Pilih penduduk
6. Isi keperluan
7. Simpan
8. Klik tombol "📄 PDF"
9. Tunggu notifikasi sukses
10. Klik tombol "⬇️" untuk download

### Cek Hasil:

- ✅ Variabel ter-replace dengan benar
- ✅ Format rapi
- ✅ QR code muncul di footer
- ✅ File tersimpan di `storage/app/public/surat-pdf/`

---

## 🎨 Step 6: Styling PDF (Opsional)

Untuk hasil PDF lebih profesional, tambahkan CSS di HTML:

```php
protected function addStyling(string $html): string
{
    $css = '
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        .signature {
            float: right;
            text-align: center;
            margin-top: 40px;
        }
    </style>
    ';
    
    return str_replace('</head>', $css . '</head>', $html);
}
```

---

## 🔐 Step 7: Halaman Verifikasi QR Code (Bonus)

Buat route & controller untuk verifikasi:

```php
// routes/web.php
Route::get('/verifikasi/{qr_code}', [VerifikasiController::class, 'show'])
    ->name('verifikasi.surat');

// app/Http/Controllers/VerifikasiController.php
public function show($qrCode)
{
    $surat = SuratArsip::where('qr_code', $qrCode)->firstOrFail();
    
    return view('verifikasi.surat', compact('surat'));
}
```

View: `resources/views/verifikasi/surat.blade.php`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Surat</title>
</head>
<body>
    <h1>✅ Surat Valid</h1>
    <table>
        <tr><td>Nomor Surat</td><td>: {{ $surat->nomor_surat }}</td></tr>
        <tr><td>Jenis</td><td>: {{ $surat->suratJenis->nama }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ $surat->tanggal_surat->format('d/m/Y') }}</td></tr>
        <tr><td>Pemohon</td><td>: {{ $surat->nama_pemohon }}</td></tr>
        <tr><td>NIK</td><td>: {{ $surat->nik_pemohon }}</td></tr>
    </table>
</body>
</html>
```

---

## 📊 Checklist Implementasi

- [ ] Install library (phpword, qrcode)
- [ ] Buat `SuratGeneratorService.php`
- [ ] Update action di `SuratArsipResource`
- [ ] Buat template .docx untuk 1-2 jenis surat
- [ ] Upload template via admin panel
- [ ] Test generate PDF
- [ ] Cek hasil PDF (variabel, QR code)
- [ ] (Opsional) Buat halaman verifikasi QR
- [ ] (Opsional) Tambah styling CSS
- [ ] (Opsional) Overlay TTD & stempel

---

## 💡 Tips

1. **Mulai dari 1 Template**: Buat template untuk 1 jenis surat dulu (misal: Surat Domisili), test sampai berhasil, baru buat template lainnya.

2. **Variabel Konsisten**: Pastikan nama variabel di template .docx sama dengan key di array `$data`.

3. **Error Handling**: Tambahkan try-catch untuk handle error (template tidak ada, variabel tidak ditemukan, dll).

4. **Storage**: Pastikan folder `storage/app/public/surat-pdf/` dan `storage/app/temp/` ada dan writable.

5. **Alternative**: Jika convert .docx ke PDF susah, bisa pakai cara sederhana:
   - Buat view Blade dengan layout surat
   - Generate PDF dari Blade (seperti yang sekarang)
   - Template .docx hanya sebagai referensi visual

---

## 🚀 Estimasi Waktu

- Install library: 5 menit
- Buat service: 1-2 jam
- Update resource: 15 menit
- Buat template: 30 menit per template
- Testing: 30 menit
- **Total**: 2-3 jam

---

**Status**: Ready to Implement  
**Priority**: Medium (fitur sudah 95% jalan)  
**Impact**: High (melengkapi SOW requirement)
