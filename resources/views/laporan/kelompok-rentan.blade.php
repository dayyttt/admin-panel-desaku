<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kelompok Rentan - {{ now()->year }}</title>
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
            border-bottom: 4px double #D32F2F;
            position: relative;
        }
        .header-content {
            padding: 0 80px;
        }
        .header h1 { 
            font-size: 18pt; 
            margin: 2px 0; 
            text-transform: uppercase; 
            font-weight: bold;
            color: #D32F2F;
            letter-spacing: 0.5px;
        }
        .header h2 { 
            font-size: 16pt; 
            margin: 2px 0; 
            text-transform: uppercase; 
            font-weight: bold;
            color: #E53935;
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
            background: linear-gradient(135deg, #D32F2F 0%, #E53935 100%);
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
            background: linear-gradient(to right, #D32F2F, #E53935); 
            color: white; 
            padding: 8px 12px; 
            font-weight: bold; 
            margin-bottom: 10px;
            font-size: 11pt;
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        
        /* Summary Cards */
        .summary-section {
            background: #FFEBEE;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #D32F2F;
        }
        .summary-section h3 {
            color: #D32F2F;
            margin-bottom: 10px;
            font-size: 12pt;
        }
        .summary-cards {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .summary-card {
            display: table-cell;
            width: 33%;
            padding: 12px;
            text-align: center;
            background: white;
            border: 2px solid #D32F2F;
            border-radius: 5px;
        }
        .summary-card:not(:last-child) {
            margin-right: 10px;
        }
        .summary-card h4 {
            color: #D32F2F;
            font-size: 9pt;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .summary-card .value {
            font-size: 24pt;
            font-weight: bold;
            color: #E53935;
        }
        .summary-card .label {
            font-size: 8pt;
            color: #666;
            margin-top: 5px;
        }
        
        /* Table Styling */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-size: 9pt;
        }
        table th { 
            background: linear-gradient(to bottom, #FFEBEE, #FFCDD2); 
            font-weight: bold; 
            text-align: center;
            padding: 10px 6px;
            border: 1px solid #EF9A9A;
            color: #D32F2F;
            font-size: 9pt;
        }
        table td { 
            border: 1px solid #ddd; 
            padding: 6px;
            background: white;
        }
        table tr:nth-child(even) td {
            background: #FAFAFA;
        }
        table tr:hover td {
            background: #FFEBEE;
        }
        
        /* Text Alignment */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 30px;
            background: #F5F5F5;
            border-radius: 5px;
            color: #999;
            font-style: italic;
        }
        .empty-state::before {
            content: "ℹ️";
            display: block;
            font-size: 32pt;
            margin-bottom: 10px;
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
            background: #FFF3E0;
            border-left: 4px solid #FF9800;
            padding: 10px 15px;
            margin: 15px 0;
            border-radius: 3px;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 9pt;
            color: #555;
        }
        .info-box strong {
            color: #E65100;
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
        <h2>LAPORAN DATA KELOMPOK RENTAN</h2>
        <p>Tahun {{ now()->year }}</p>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3>Ringkasan Data Kelompok Rentan</h3>
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Lansia</h4>
                <div class="value">{{ $lansia->count() }}</div>
                <div class="label">Jiwa (> 60 tahun)</div>
            </div>
            <div class="summary-card">
                <h4>Balita</h4>
                <div class="value">{{ $balita->count() }}</div>
                <div class="label">Jiwa (< 5 tahun)</div>
            </div>
            <div class="summary-card">
                <h4>Disabilitas</h4>
                <div class="value">{{ $disabilitas->count() }}</div>
                <div class="label">Jiwa</div>
            </div>
        </div>
    </div>

    <!-- Lansia -->
    <div class="section">
        <div class="section-title">A. DATA LANSIA (> 60 TAHUN) - Total: {{ $lansia->count() }} Jiwa</div>
        @if($lansia->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="15%">NIK</th>
                    <th>Nama</th>
                    <th width="6%">L/P</th>
                    <th width="10%">Tgl Lahir</th>
                    <th width="7%">Umur</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lansia as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama }}</td>
                    <td class="text-center">{{ $p->jenis_kelamin }}</td>
                    <td class="text-center">{{ $p->tanggal_lahir?->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $p->umur }} th</td>
                    <td>{{ $p->alamat_lengkap ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p>Tidak ada data lansia yang tercatat</p>
        </div>
        @endif
    </div>

    <!-- Balita -->
    <div class="section">
        <div class="section-title">B. DATA BALITA (< 5 TAHUN) - Total: {{ $balita->count() }} Jiwa</div>
        @if($balita->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="15%">NIK</th>
                    <th>Nama</th>
                    <th width="6%">L/P</th>
                    <th width="10%">Tgl Lahir</th>
                    <th width="7%">Umur</th>
                    <th>Nama Orang Tua</th>
                </tr>
            </thead>
            <tbody>
                @foreach($balita as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama }}</td>
                    <td class="text-center">{{ $p->jenis_kelamin }}</td>
                    <td class="text-center">{{ $p->tanggal_lahir?->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $p->umur }} th</td>
                    <td>{{ $p->ayah_nama ?? '-' }} / {{ $p->ibu_nama ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p>Tidak ada data balita yang tercatat</p>
        </div>
        @endif
    </div>

    <!-- Disabilitas -->
    <div class="section">
        <div class="section-title">C. DATA PENYANDANG DISABILITAS - Total: {{ $disabilitas->count() }} Jiwa</div>
        @if($disabilitas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="15%">NIK</th>
                    <th>Nama</th>
                    <th width="6%">L/P</th>
                    <th width="7%">Umur</th>
                    <th width="20%">Jenis Disabilitas</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disabilitas as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama }}</td>
                    <td class="text-center">{{ $p->jenis_kelamin }}</td>
                    <td class="text-center">{{ $p->umur }} th</td>
                    <td>{{ $p->jenis_cacat ?? 'Tidak disebutkan' }}</td>
                    <td>{{ $p->alamat_lengkap ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p>Tidak ada data penyandang disabilitas yang tercatat</p>
        </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <p><strong>Catatan Penting:</strong></p>
        <p>• Kelompok rentan adalah kelompok masyarakat yang memerlukan perhatian khusus dari pemerintah desa</p>
        <p>• Data ini digunakan sebagai dasar perencanaan program bantuan sosial dan pemberdayaan masyarakat</p>
        <p>• Laporan dicetak pada: {{ $tanggal_cetak->translatedFormat('d F Y, H:i') }} WIT</p>
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
