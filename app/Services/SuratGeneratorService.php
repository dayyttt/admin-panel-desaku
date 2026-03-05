<?php

namespace App\Services;

use App\Models\SuratArsip;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SuratGeneratorService
{
    /**
     * Generate PDF dari template .docx
     */
    public function generateSurat(SuratArsip $surat): string
    {
        // Langsung pakai template Blade untuk hasil yang lebih bagus
        // Skip .docx conversion karena hasilnya jelek
        return $this->generateFromBlade($surat);
        
        /* DISABLED: .docx conversion menghasilkan PDF jelek
        $jenis = $surat->suratJenis;
        
        // 1. Cek apakah ada template
        if (empty($jenis->template_path)) {
            // Fallback: generate dari view Blade
            return $this->generateFromBlade($surat);
        }

        $templateFullPath = storage_path('app/public/' . $jenis->template_path);
        
        if (!file_exists($templateFullPath)) {
            // Fallback: generate dari view Blade
            return $this->generateFromBlade($surat);
        }

        // 2. Load template
        $template = new TemplateProcessor($templateFullPath);

        // 3. Siapkan data untuk replace variabel
        $data = $this->prepareData($surat);

        // 4. Replace semua variabel
        foreach ($data as $key => $value) {
            try {
                $template->setValue($key, $value);
            } catch (\Exception $e) {
                // Skip jika variabel tidak ada di template
                continue;
            }
        }

        // 5. Simpan hasil ke temporary .docx
        $tempDir = storage_path('app/temp');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }
        
        $tempDocx = $tempDir . '/surat_' . $surat->id . '_' . time() . '.docx';
        $template->saveAs($tempDocx);

        // 6. Convert .docx ke HTML
        $html = $this->convertDocxToHtml($tempDocx);

        // 7. Generate QR code
        $qrCodePath = $this->generateQrCode($surat);

        // 8. Tambah QR code ke HTML
        $html = $this->addQrCodeToHtml($html, $qrCodePath);

        // 9. Tambah styling
        $html = $this->addStyling($html);

        // 10. Generate PDF
        $pdfPath = $this->generatePdf($html, $surat);

        // 11. Cleanup temp files
        @unlink($tempDocx);

        return $pdfPath;
        */
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
            'tanggal_surat' => $surat->tanggal_surat->isoFormat('D MMMM Y'),
            'nama_pemohon' => $surat->nama_pemohon,
            'nik_pemohon' => $surat->nik_pemohon ?? '-',
            'keperluan' => $surat->keperluan ?? '-',
        ];

        // Data dari penduduk (jika ada)
        if ($penduduk) {
            $data = array_merge($data, [
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tempat_lahir' => $penduduk->tempat_lahir ?? '-',
                'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->isoFormat('D MMMM Y') : '-',
                'jenis_kelamin' => $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                'agama' => $penduduk->agama ?? '-',
                'pekerjaan' => $penduduk->pekerjaan ?? '-',
                'alamat' => $penduduk->alamat ?? '-',
                'rt' => $penduduk->rt ?? '-',
                'rw' => $penduduk->rw ?? '-',
                'dusun' => $penduduk->dusun ?? '-',
            ]);
        }

        // Data dari data_surat (JSON) - exclude keys yang sudah di-format dari penduduk
        if ($surat->data_surat && is_array($surat->data_surat)) {
            $protectedKeys = ['tanggal_lahir', 'jenis_kelamin', 'nama', 'nik', 'tempat_lahir', 'agama', 'pekerjaan'];
            $extraData = $penduduk 
                ? array_diff_key($surat->data_surat, array_flip($protectedKeys))
                : $surat->data_surat;
            $data = array_merge($data, $extraData);
        }

        // Data TTD
        if ($surat->ttd) {
            $data['nama_ttd'] = $surat->ttd->nama;
            $data['jabatan_ttd'] = $surat->ttd->jabatan;
        } else {
            $data['nama_ttd'] = 'Kepala Desa Lesane';
            $data['jabatan_ttd'] = 'Kepala Desa';
        }

        // Data desa (Dinamis dari database)
        $desaInfo = \App\Models\DesaInfo::where('key', 'profil')->first();
        $profil = $desaInfo ? $desaInfo->data : [];

        $data['nama_desa'] = $profil['nama'] ?? 'Desa';
        // Buang kata "Desa " dari nama desa jika ada (misal "Desa Lesane" -> "Lesane")
        $data['nama_desa_clean'] = str_replace('Desa ', '', $data['nama_desa']);
        $data['kecamatan'] = $profil['kecamatan'] ?? 'Kecamatan';
        $data['kabupaten'] = $profil['kabupaten'] ?? 'Kabupaten';
        $data['provinsi'] = $profil['provinsi'] ?? 'Provinsi';
        $data['alamat_desa'] = "Alamat: " . $data['nama_desa'] . ", Kec. " . $data['kecamatan'] . ", Kab. " . $data['kabupaten'] . ", Prov. " . $data['provinsi'];

        return $data;
    }

    /**
     * Convert .docx ke HTML
     */
    protected function convertDocxToHtml(string $docxPath): string
    {
        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxPath);
            
            $tempHtml = storage_path('app/temp/temp_' . time() . '.html');
            
            $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            $htmlWriter->save($tempHtml);
            
            $html = file_get_contents($tempHtml);
            @unlink($tempHtml);
            
            return $html;
        } catch (\Exception $e) {
            // Fallback: return simple HTML
            return '<html><body><p>Error converting document: ' . $e->getMessage() . '</p></body></html>';
        }
    }

    /**
     * Generate QR code
     */
    protected function generateQrCode(SuratArsip $surat): string
    {
        $qrDir = storage_path('app/public/qr-codes');
        if (!File::exists($qrDir)) {
            File::makeDirectory($qrDir, 0755, true);
        }

        $qrCodePath = 'qr-codes/surat_' . $surat->id . '.svg';
        $fullPath = storage_path('app/public/' . $qrCodePath);
        
        // URL verifikasi
        // Gunakan VITE_APP_URL atau FRONTEND_URL dari .env jika ada (misal web React/Vue/NextJS)
        $baseUrl = env('FRONTEND_URL', config('app.url'));
        $verifyUrl = $baseUrl . '/verifikasi/' . $surat->qr_code;
        
        // Generate QR code as SVG (tidak perlu imagick)
        $qrCode = QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($verifyUrl);
        
        file_put_contents($fullPath, $qrCode);
        
        return $qrCodePath;
    }

    /**
     * Tambah QR code ke HTML
     */
    protected function addQrCodeToHtml(string $html, string $qrCodePath): string
    {
        $qrCodeFullPath = storage_path('app/public/' . $qrCodePath);
        
        if (!file_exists($qrCodeFullPath)) {
            return $html;
        }

        // Baca SVG content
        $svgContent = file_get_contents($qrCodeFullPath);
        
        // Tambah QR code di footer
        $qrHtml = '<div style="text-align: center; margin-top: 30px; page-break-inside: avoid;">';
        $qrHtml .= '<div style="width: 120px; height: 120px; margin: 0 auto;">' . $svgContent . '</div>';
        $qrHtml .= '<p style="font-size: 9px; margin-top: 5px;">Scan untuk verifikasi keaslian surat</p>';
        $qrHtml .= '</div>';
        
        // Insert sebelum </body>
        if (strpos($html, '</body>') !== false) {
            $html = str_replace('</body>', $qrHtml . '</body>', $html);
        } else {
            $html .= $qrHtml;
        }
        
        return $html;
    }

    /**
     * Tambah styling ke HTML
     */
    protected function addStyling(string $html): string
    {
        $css = '
        <style>
            @page {
                margin: 2cm 2cm 2cm 2cm;
            }
            body {
                font-family: "Times New Roman", Times, serif;
                font-size: 12pt;
                line-height: 1.6;
                color: #000;
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
                text-align: center;
                margin: 20px 0;
            }
            .content {
                text-align: justify;
                margin: 20px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            td {
                padding: 3px 5px;
                vertical-align: top;
            }
            .signature {
                float: right;
                text-align: center;
                margin-top: 40px;
                width: 200px;
            }
            p {
                margin: 10px 0;
            }
        </style>
        ';
        
        if (strpos($html, '</head>') !== false) {
            $html = str_replace('</head>', $css . '</head>', $html);
        } else {
            $html = '<html><head>' . $css . '</head><body>' . $html . '</body></html>';
        }
        
        return $html;
    }

    /**
     * Generate PDF dari HTML
     */
    protected function generatePdf(string $html, SuratArsip $surat): string
    {
        $pdf = Pdf::loadHTML($html)
            ->setPaper([0, 0, 595.28, 841.89], 'portrait') // A4 in points: 210mm x 297mm
            ->setOption('enable-local-file-access', true)
            ->setOption('dpi', 96);

        $pdfDir = storage_path('app/public/surat-pdf');
        if (!File::exists($pdfDir)) {
            File::makeDirectory($pdfDir, 0755, true);
        }

        $filename = 'surat_' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        $pdfPath = 'surat-pdf/' . $filename;
        
        Storage::disk('public')->put($pdfPath, $pdf->output());
        
        return $pdfPath;
    }

    /**
     * Fallback: Generate PDF dari view Blade
     */
    protected function generateFromBlade(SuratArsip $surat): string
    {
        $data = $this->prepareData($surat);
        
        // Generate QR code
        $qrCodePath = $this->generateQrCode($surat);
        $qrCodeFullPath = storage_path('app/public/' . $qrCodePath);
        
        // Baca SVG content dan convert ke base64 agar DomPDF bisa me-render via tag <img>
        $qrCodeSvg = file_get_contents($qrCodeFullPath);
        $qrCodeBase64 = base64_encode($qrCodeSvg);
        
        $pdf = Pdf::loadView('surat.template', [
            'surat' => $surat,
            'jenis' => $surat->suratJenis,
            'penduduk' => $surat->penduduk,
            'data' => $data,
            'qrCode' => $qrCodeBase64,
        ])->setPaper('a4', 'portrait');

        $pdfDir = storage_path('app/public/surat-pdf');
        if (!File::exists($pdfDir)) {
            File::makeDirectory($pdfDir, 0755, true);
        }

        $filename = 'surat_' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        $pdfPath = 'surat-pdf/' . $filename;
        
        Storage::disk('public')->put($pdfPath, $pdf->output());
        
        return $pdfPath;
    }
}
