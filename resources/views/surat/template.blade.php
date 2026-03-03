<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $jenis->nama }}</title>
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
        .header h3 {
            margin: 5px 0;
            font-size: 14pt;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16pt;
        }
        .title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            margin: 30px 0 10px 0;
        }
        .nomor {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        table.data {
            width: 100%;
            margin: 20px 0;
        }
        table.data td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.data td:first-child {
            width: 200px;
        }
        table.data td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        .signature {
            float: right;
            text-align: center;
            margin-top: 40px;
            width: 250px;
        }
        .signature .date {
            margin-bottom: 80px;
        }
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }
        .qr-code {
            text-align: center;
            margin-top: 100px;
            page-break-inside: avoid;
        }
        .qr-code img {
            width: 120px;
            height: 120px;
        }
        .qr-code p {
            font-size: 9px;
            margin-top: 5px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Header Surat -->
    <div class="header">
        <h3>PEMERINTAH KABUPATEN MALUKU TENGAH</h3>
        <h3>KECAMATAN KOTA MASOHI</h3>
        <h2>DESA LESANE</h2>
        <p style="font-size: 10pt; margin: 5px 0;">
            Alamat: Desa Lesane, Kecamatan Kota Masohi, Kabupaten Maluku Tengah, Provinsi Maluku
        </p>
    </div>

    <!-- Judul Surat -->
    <div class="title">{{ strtoupper($jenis->nama) }}</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <!-- Isi Surat -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini {{ $data['jabatan_ttd'] ?? 'Kepala Desa Lesane' }}, Kecamatan Kota Masohi, Kabupaten Maluku Tengah, Provinsi Maluku, menerangkan bahwa:</p>

        <table class="data">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><strong>{{ $data['nama'] ?? $data['nama_pemohon'] }}</strong></td>
            </tr>
            @if(isset($data['nik']) || isset($data['nik_pemohon']))
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $data['nik'] ?? $data['nik_pemohon'] }}</td>
            </tr>
            @endif
            @if(isset($data['tempat_lahir']) && isset($data['tanggal_lahir']))
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $data['tempat_lahir'] }}, {{ $data['tanggal_lahir'] }}</td>
            </tr>
            @endif
            @if(isset($data['jenis_kelamin']))
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $data['jenis_kelamin'] }}</td>
            </tr>
            @endif
            @if(isset($data['agama']))
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $data['agama'] }}</td>
            </tr>
            @endif
            @if(isset($data['pekerjaan']))
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $data['pekerjaan'] }}</td>
            </tr>
            @endif
            @if(isset($data['alamat']))
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $data['alamat'] }}
                    @if(isset($data['rt']) && isset($data['rw']))
                        , RT {{ $data['rt'] }}/RW {{ $data['rw'] }}
                    @endif
                    @if(isset($data['dusun']))
                        , Dusun {{ $data['dusun'] }}
                    @endif
                </td>
            </tr>
            @endif
        </table>

        <p>Adalah benar penduduk Desa Lesane dan surat keterangan ini dibuat untuk keperluan:</p>
        <p style="text-align: center; font-weight: bold; margin: 20px 0;">{{ strtoupper($data['keperluan'] ?? '-') }}</p>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <div class="date">
            Lesane, {{ $data['tanggal_surat'] }}
        </div>
        <div>{{ $data['jabatan_ttd'] ?? 'Kepala Desa' }}</div>
        <div style="margin-top: 80px;">
            <div class="name">{{ $data['nama_ttd'] ?? 'Kepala Desa Lesane' }}</div>
        </div>
    </div>

    <div class="clear"></div>

    <!-- QR Code -->
    <div class="qr-code">
        <div style="width: 120px; height: 120px; margin: 0 auto;">
            {!! $qrCode !!}
        </div>
        <p>Scan untuk verifikasi keaslian surat</p>
    </div>
</body>
</html>
