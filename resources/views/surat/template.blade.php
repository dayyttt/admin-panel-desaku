<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $jenis->nama }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm 15mm 20mm;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        div {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            text-align: center;
            padding-bottom: 5px;
        }

        .kop-surat .pemerintah {
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-surat .kecamatan {
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-surat .desa {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .kop-surat .alamat {
            font-size: 8pt;
            font-style: italic;
            margin-top: 1px;
        }

        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin-bottom: 15px;
        }

        /* ===== JUDUL ===== */
        .judul-surat {
            text-align: center;
            margin-bottom: 0;
            margin-top: 10px;
        }

        .judul-surat h3 {
            font-size: 12pt;
            text-decoration: underline;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .nomor-surat {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 20px;
        }

        /* ===== PARAGRAF ===== */
        .paragraf {
            text-align: justify;
            text-indent: 40px;
            margin: 8px 0;
            font-size: 12pt;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        /* ===== BIODATA ===== */
        table.biodata {
            width: 100%;
            margin: 12px 0;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.biodata td {
            padding: 2.5px 0;
            vertical-align: top;
            font-size: 12pt;
            line-height: 1.4;
            margin-bottom: 20px;
        }

        table.biodata td.no {
            width: 20px;
            padding-left: 25px;
            text-align: right;
            padding-right: 6px;
        }

        table.biodata td.label {
            width: 180px;
        }

        table.biodata td.sep {
            width: 10px;
        }

        table.biodata td.val {
            font-weight: bold;
        }

        /* ===== TTD ===== */
        .ttd-wrapper {
            margin-top: 70px;
            page-break-inside: avoid;
        }

        table.ttd {
            width: 100%;
            border-collapse: collapse;
        }

        table.ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 12pt;
        }

        table.ttd td.spacer {
            height: 90px;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-nip {
            font-size: 9pt;
        }

        /* ===== QR ===== */
        .qr-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 6px;
            border-top: 1px dashed #ccc;
            page-break-inside: avoid;
        }

        .qr-footer .qr-img {
            width: 65px;
            height: 65px;
            margin: 0 auto;
            display: inline-block;
        }

        .qr-footer .qr-img svg {
            width: 100%;
            height: 100%;
        }

        .qr-footer p {
            font-size: 7pt;
            color: #888;
            margin-top: 2px;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <div class="pemerintah">PEMERINTAH KABUPATEN {{ strtoupper($data['kabupaten']) }}</div>
        <div class="kecamatan">KECAMATAN {{ strtoupper($data['kecamatan']) }}</div>
        <div class="desa">{{ $data['nama_desa'] }}</div>
        <div class="alamat">{{ $data['alamat_desa'] }}</div>
    </div>
    <div class="garis-kop"></div>

    {{-- JUDUL --}}
    <div class="judul-surat">
        <h3>{{ strtoupper($jenis->nama) }}</h3>
    </div>
    <div class="nomor-surat">Nomor : {{ $surat->nomor_surat }}</div>

    {{-- PEMBUKA --}}
    <div class="paragraf">
        Yang bertanda tangan di bawah ini {{ $data['jabatan_ttd'] ?? 'Kepala Desa' }} {{ $data['nama_desa_clean'] }},
        Kecamatan {{ $data['kecamatan'] }}, Kabupaten {{ $data['kabupaten'] }}, Provinsi {{ $data['provinsi'] }}
        menerangkan dengan sebenarnya bahwa :
    </div>

    {{-- BIODATA --}}
    @php $no = 1; @endphp
    <table class="biodata">
        <tr>
            <td class="no">{{ $no++ }}.</td>
            <td class="label">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ strtoupper($data['nama'] ?? ($data['nama_pemohon'] ?? '-')) }}</td>
        </tr>

        @if (isset($data['nik']) || isset($data['nik_pemohon']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">NIK / No. KTP</td>
                <td class="sep">:</td>
                <td class="val">{{ $data['nik'] ?? $data['nik_pemohon'] }}</td>
            </tr>
        @endif

        @if (isset($data['tempat_lahir']) && isset($data['tanggal_lahir']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Tempat / Tanggal Lahir</td>
                <td class="sep">:</td>
                <td class="val">
                    {{ $data['tempat_lahir'] }} /
                    @if ($data['tanggal_lahir'] instanceof \Carbon\Carbon)
                        {{ $data['tanggal_lahir']->translatedFormat('d F Y') }}
                    @elseif(is_string($data['tanggal_lahir']) && strpos($data['tanggal_lahir'], 'T') !== false)
                        {{ \Carbon\Carbon::parse($data['tanggal_lahir'])->translatedFormat('d F Y') }}
                    @else
                        {{ $data['tanggal_lahir'] }}
                    @endif
                </td>
            </tr>
        @endif

        @if (isset($data['jenis_kelamin']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Jenis Kelamin</td>
                <td class="sep">:</td>
                <td class="val">
                    @if ($data['jenis_kelamin'] === 'L')
                        Laki-laki
                    @elseif($data['jenis_kelamin'] === 'P')
                        Perempuan
                    @else
                        {{ $data['jenis_kelamin'] }}
                    @endif
                </td>
            </tr>
        @endif

        @if (isset($data['agama']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Agama</td>
                <td class="sep">:</td>
                <td class="val">{{ ucfirst($data['agama']) }}</td>
            </tr>
        @endif

        @if (isset($data['status_perkawinan']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Status</td>
                <td class="sep">:</td>
                <td class="val">{{ ucfirst($data['status_perkawinan']) }}</td>
            </tr>
        @endif

        @if (isset($data['pekerjaan']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Pekerjaan</td>
                <td class="sep">:</td>
                <td class="val">{{ ucfirst($data['pekerjaan']) }}</td>
            </tr>
        @endif

        @if (isset($data['kewarganegaraan']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Kewarganegaraan</td>
                <td class="sep">:</td>
                <td class="val">{{ $data['kewarganegaraan'] }}</td>
            </tr>
        @endif

        @if (isset($data['alamat']))
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Alamat / Tempat Tinggal</td>
                <td class="sep">:</td>
                <td class="val">
                    {{ $data['alamat'] }}
                    @if (isset($data['rt']) && isset($data['rw']) && $data['rt'] && $data['rw'] && $data['rt'] != '-' && $data['rw'] != '-')
                        RT {{ str_pad($data['rt'], 3, '0', STR_PAD_LEFT) }} / RW
                        {{ str_pad($data['rw'], 3, '0', STR_PAD_LEFT) }}
                    @endif
                    @if (isset($data['dusun']) && $data['dusun'] && $data['dusun'] != '-')
                        , Dusun {{ $data['dusun'] }}
                    @endif
                    , Desa Lesane, Kec. Kota Masohi, Kab. Maluku Tengah, Prov. Maluku
                </td>
            </tr>
        @endif

        @if (isset($data['keperluan']) && !empty($data['keperluan']) && $data['keperluan'] != '-')
            <tr>
                <td class="no">{{ $no++ }}.</td>
                <td class="label">Keperluan</td>
                <td class="sep">:</td>
                <td class="val">{{ ucfirst($data['keperluan']) }}</td>
            </tr>
        @endif
    </table>

    {{-- KETERANGAN --}}
    <div class="paragraf">
        Orang tersebut adalah benar-benar warga {{ $data['nama_desa'] }} dengan data seperti di atas
        @if (isset($data['keperluan']) && !empty($data['keperluan']) && $data['keperluan'] != '-')
            , yang memerlukan surat ini untuk keperluan <strong>{{ ucfirst($data['keperluan']) }}</strong>
        @endif
        .
    </div>

    {{-- PENUTUP --}}
    <div class="paragraf">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    {{-- TANDA TANGAN --}}
    <div class="ttd-wrapper">
        <table class="ttd">
            <tr>
                <td style="padding-bottom: 20px;"></td>
                <td style="padding-bottom: 20px;">{{ ucfirst(strtolower($data['nama_desa_clean'])) }},
                    {{ $data['tanggal_surat'] }}</td>
            </tr>
            <tr>
                <td>Pemegang Surat</td>
                <td>{{ $data['jabatan_ttd'] ?? 'Kepala Desa ' . $data['nama_desa_clean'] }}</td>
            </tr>
            <tr>
                <td class="spacer"></td>
                <td class="spacer"></td>
            </tr>
            <tr>
                <td>
                    <span class="ttd-nama">{{ strtoupper($data['nama'] ?? ($data['nama_pemohon'] ?? '-')) }}</span>
                </td>
                <td>
                    <span class="ttd-nama">{{ $data['nama_ttd'] ?? 'Kepala Desa ' . $data['nama_desa_clean'] }}</span>
                    @if (isset($data['nip_ttd']) && $data['nip_ttd'])
                        <br><span class="ttd-nip">NIP : {{ $data['nip_ttd'] }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- QR CODE --}}
    <div class="qr-footer">
        <div class="qr-img">
            <img src="data:image/svg+xml;base64,{!! $qrCode !!}" style="width: 100%; height: 100%;"
                alt="QR Verifikasi">
        </div>
    </div>

</body>

</html>
