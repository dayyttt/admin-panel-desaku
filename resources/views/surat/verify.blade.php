<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - {{ $profil['nama'] ?? 'Sistem Desa' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --secondary: #334155;
            --accent: #2563eb;
            --success: #059669;
            --error: #dc2626;
            --bg: #f8fafc;
            --card: #ffffff;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .card {
            background: var(--card);
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            padding: 40px 20px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            position: relative;
        }

        .status-badge {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .status-valid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-invalid {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .content {
            padding: 50px 30px 40px;
        }

        .village-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .app-name {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .info-grid {
            text-align: left;
            margin-top: 30px;
            display: grid;
            gap: 20px;
        }

        .info-item {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }

        .info-label {
            font-size: 12px;
            color: var(--secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
        }

        .footer {
            padding: 20px;
            background: #f8fafc;
            font-size: 12px;
            color: #64748b;
        }

        .icon-check {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            @if ($surat)
                <div class="header">
                    <div class="village-name">{{ strtoupper($profil['nama'] ?? 'PEMERINTAH DESA') }}</div>
                    <div class="app-name">Sistem Informasi Layanan Digital</div>

                    <div class="status-badge status-valid">
                        <svg class="icon-check" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293l-4.242 4.242a1 1 0 01-1.414 0L6.293 11.24a1 1 0 111.414-1.414l1.343 1.343 3.535-3.535a1 1 0 111.414 1.414z" />
                        </svg>
                        Surat Asli & Valid
                    </div>
                </div>

                <div class="content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Jenis Surat</div>
                            <div class="info-value">{{ $surat->suratJenis->nama }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nomor Surat</div>
                            <div class="info-value">{{ $surat->nomor_surat }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nama Pemohon</div>
                            <div class="info-value">{{ $surat->penduduk->nama ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tanggal Terbit</div>
                            <div class="info-value">
                                {{ $surat->tanggal_surat ? $surat->tanggal_surat->isoFormat('D MMMM Y') : '-' }}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="header" style="background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);">
                    <div class="village-name">SGC VERIFIKASI</div>
                    <div class="app-name">Sistem Layanan Digital</div>

                    <div class="status-badge status-invalid">
                        Surat Tidak Ditemukan
                    </div>
                </div>
                <div class="content" style="padding: 60px 30px;">
                    <p style="color: #64748b;">Maaf, kode unik yang Anda scan tidak terdaftar dalam arsip digital desa
                        kami. Pastikan Anda melakukan scan pada QR Code yang benar.</p>
                </div>
            @endif

            <div class="footer">
                &copy; {{ date('Y') }} {{ $profil['nama'] ?? 'Pemerintah Desa' }}. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
