<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kependudukan Bulanan - {{ strtoupper($bulan_nama) }} {{ $tahun }}</title>
    <style>
        @page { margin: 2cm 1.5cm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Arial', 'Helvetica', sans-serif; 
            font-size: 10pt; 
            line-height: 1.5; 
            color: #333;
        }
        
        /* Header dengan Logo */
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            padding-bottom: 15px;
            border-bottom: 4px double #1B5E20;
            position: relative;
        }
        .header-logo {
            width: 70px;
            height: 70px;
            position: absolute;
            left: 0;
            top: 0;
        }
        .header-content {
            padding: 0 80px;
        }
        .header h1 { 
            font-size: 18pt; 
            margin: 2px 0; 
            text-transform: uppercase; 
            font-weight: bold;
            color: #1B5E20;
            letter-spacing: 0.5px;
        }
        .header h2 { 
            font-size: 16pt; 
            margin: 2px 0; 
            text-transform: uppercase; 
            font-weight: bold;
            color: #2E7D32;
        }
        .header h3 { 
            font-size: 14pt; 
            margin: 5px 0 8px 0; 
            font-weight: bold;
            color: #000;
        }
        .header p { 
            font-size: 9pt; 
            margin: 2px 0; 
            color: #555;
            font-style: italic;
        }
        
        /* Judul Laporan */
        .report-title { 
            text-align: center; 
            margin: 20px 0 25px 0; 
            padding: 12px;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .report-title h2 { 
            font-size: 14pt; 
            font-weight: bold; 
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .report-title p { 
            font-size: 11pt; 
            font-weight: normal;
        }
        
        /* Section Styling */
        .section { 
            margin: 20px 0; 
            page-break-inside: avoid;
        }
        .section-title { 
            background: linear-gradient(to right, #1B5E20, #2E7D32); 
            color: white; 
            padding: 8px 12px; 
            font-weight: bold; 
            margin-bottom: 10px;
            font-size: 11pt;
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        
        /* Table Styling */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        table th { 
            background: linear-gradient(to bottom, #E8F5E9, #C8E6C9); 
            font-weight: bold; 
            text-align: left;
            padding: 10px 8px;
            border: 1px solid #81C784;
            color: #1B5E20;
            font-size: 10pt;
        }
        table td { 
            border: 1px solid #ddd; 
            padding: 8px;
            background: white;
        }
        table tr:nth-child(even) td {
            background: #F9F9F9;
        }
        table tr:hover td {
            background: #F1F8E9;
        }
        table tr.total-row {
            background: linear-gradient(to right, #E8F5E9, #C8E6C9) !important;
            font-weight: bold;
            color: #1B5E20;
        }
        table tr.total-row td {
            background: transparent;
            border-top: 2px solid #1B5E20;
            border-bottom: 2px solid #1B5E20;
        }
        
        /* Text Alignment */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        /* Summary Cards */
        .summary-cards {
            display: table;
            width: 100%;
            margin: 15px 0;
        }
        .summary-card {
            display: table-cell;
            width: 24%;
            padding: 12px;
            margin: 0 0.5%;
            border: 2px solid #1B5E20;
            border-radius: 5px;
            text-align: center;
            background: linear-gradient(to bottom, #ffffff, #F1F8E9);
        }
        .summary-card h4 {
            color: #1B5E20;
            font-size: 9pt;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .summary-card .value {
            font-size: 18pt;
            font-weight: bold;
            color: #2E7D32;
        }
        
        /* Footer & Signature */
        .footer { 
            margin-top: 40px; 
            page-break-inside: avoid;
        }
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 30px;
        }
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-box.right {
            text-align: right;
        }
        .ttd { 
            display: inline-block; 
            text-align: center; 
            min-width: 220px;
            padding: 10px;
        }
        .ttd p { 
            margin: 5px 0; 
            font-size: 10pt;
        }
        .ttd .jabatan {
            font-weight: bold;
            margin-bottom: 60px;
        }
        .ttd .nama { 
            font-weight: bold; 
            text-decoration: underline;
            margin-top: 5px;
        }
        .ttd .nip {
            font-size: 9pt;
            color: #666;
        }
        
        /* Info Box */
        .info-box {
            background: #E3F2FD;
            border-left: 4px solid #1976D2;
            padding: 10px 15px;
            margin: 15px 0;
            border-radius: 3px;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 9pt;
            color: #555;
        }
        
        /* Page Number */
        .page-number {
            text-align: center;
            font-size: 9pt;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1>PEMERINTAH KABUPATEN {{ strtoupper($desa->kabupaten ?? 'MALUKU TENGAH') }}</h1>
            <h2>KECAMATAN {{ strtoupper($desa->kecamatan ?? 'KOTA MASOHI') }}</h2>
            <h3>{{ strtoupper($desa->nama ?? 'DESA LESANE') }}</h3>
            <p>{{ $desa->alamat ?? 'Jl. Raya Lesane' }}</p>
            <p>Telp: {{ $desa->telepon ?? '-' }} | Email: {{ $desa->email ?? '-' }} | Website: {{ $desa->website ?? '-' }}</p>
        </div>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h2>LAPORAN KEPENDUDUKAN BULANAN</h2>
        <p>Periode: {{ strtoupper($bulan_nama) }} {{ $tahun }}</p>
    </div>

    <!-- Ringkasan Penduduk -->
    <div class="section">
        <div class="section-title">I. RINGKASAN DATA PENDUDUK</div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th>Keterangan</th>
                <th width="15%" class="text-center">Jumlah</th>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>Jumlah Penduduk Laki-laki</td>
                <td class="text-right">{{ number_format($laki_laki, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Jumlah Penduduk Perempuan</td>
                <td class="text-right">{{ number_format($perempuan, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr class="total-row">
                <td class="text-center">3</td>
                <td>Total Penduduk</td>
                <td class="text-right">{{ number_format($total_penduduk, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Jumlah Kepala Keluarga (KK)</td>
                <td class="text-right">{{ number_format($total_kk, 0, ',', '.') }} KK</td>
            </tr>
        </table>
    </div>

    <!-- Mutasi Penduduk -->
    <div class="section">
        <div class="section-title">II. MUTASI PENDUDUK BULAN {{ strtoupper($bulan_nama) }} {{ $tahun }}</div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th>Jenis Mutasi</th>
                <th width="15%" class="text-center">Jumlah</th>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>Kelahiran</td>
                <td class="text-right">{{ number_format($kelahiran, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kematian</td>
                <td class="text-right">{{ number_format($kematian, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Pindah Masuk</td>
                <td class="text-right">{{ number_format($pindah_masuk, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Pindah Keluar</td>
                <td class="text-right">{{ number_format($pindah_keluar, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr class="total-row">
                <td class="text-center" colspan="2">Pertambahan Bersih</td>
                <td class="text-right">{{ number_format(($kelahiran + $pindah_masuk) - ($kematian + $pindah_keluar), 0, ',', '.') }} jiwa</td>
            </tr>
        </table>
    </div>

    <!-- Distribusi Agama -->
    <div class="section">
        <div class="section-title">III. DISTRIBUSI PENDUDUK BERDASARKAN AGAMA</div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th>Agama</th>
                <th width="15%" class="text-center">Jumlah</th>
                <th width="15%" class="text-center">Persentase</th>
            </tr>
            @foreach($agama as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ ucfirst($item->agama) }}</td>
                <td class="text-right">{{ number_format($item->jumlah, 0, ',', '.') }} jiwa</td>
                <td class="text-center">{{ number_format(($item->jumlah / $total_penduduk) * 100, 2) }}%</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Kelompok Rentan -->
    <div class="section">
        <div class="section-title">IV. KELOMPOK RENTAN</div>
        <table>
            <tr>
                <th width="5%">No</th>
                <th>Kelompok</th>
                <th width="15%" class="text-center">Jumlah</th>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>Lansia (> 60 tahun)</td>
                <td class="text-right">{{ number_format($lansia, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Balita (< 5 tahun)</td>
                <td class="text-right">{{ number_format($balita, 0, ',', '.') }} jiwa</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Penyandang Disabilitas</td>
                <td class="text-right">{{ number_format($disabilitas, 0, ',', '.') }} jiwa</td>
            </tr>
        </table>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <p><strong>Catatan:</strong></p>
        <p>• Laporan ini dibuat berdasarkan data kependudukan yang tercatat dalam sistem informasi desa</p>
        <p>• Data yang ditampilkan adalah data per akhir bulan {{ $bulan_nama }} {{ $tahun }}</p>
        <p>• Dicetak pada: {{ $tanggal_cetak->translatedFormat('d F Y, H:i') }} WIT</p>
    </div>

    <!-- Footer & Signature -->
    <div class="footer">
        <div class="signature-section">
            <div class="signature-box">
                <!-- Kosong untuk mengetahui -->
            </div>
            <div class="signature-box right">
                <div class="ttd">
                    <p>{{ $desa->kecamatan ?? 'Kota Masohi' }}, {{ $tanggal_cetak->translatedFormat('d F Y') }}</p>
                    <p class="jabatan">Kepala {{ $desa->nama ?? 'Desa Lesane' }}</p>
                    <p class="nama">{{ $desa->kepala_desa_nama ?? '___________________' }}</p>
                    <p class="nip">NIP. ___________________</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-number">
        Halaman 1 dari 1
    </div>
</body>
</html>
