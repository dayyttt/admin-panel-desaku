{{-- Driver.js Tour Component --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css" />
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>

<style>
    .driver-popover {
        background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
        color: white;
        max-width: 500px;
    }

    .driver-popover-title {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
    }

    .driver-popover-description {
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.95);
    }

    .driver-popover-description strong {
        color: #FFC107;
        font-weight: 600;
    }

    .driver-popover-footer button {
        background: white;
        color: #1B5E20;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }

    .driver-popover-footer button:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .driver-popover-footer .driver-popover-next-btn {
        background: #FFC107 !important;
        color: #1B5E20 !important;
    }

    .driver-popover-footer .driver-popover-next-btn:hover {
        background: #FFD54F !important;
    }

    .driver-popover-progress-text {
        font-size: 13px;
        font-weight: 600;
        color: #FFC107;
    }

    .tour-help-button {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 6px 16px rgba(27, 94, 32, 0.5);
        transition: all 0.3s;
        z-index: 9999;
        border: none;
    }

    .tour-help-button:hover {
        transform: scale(1.15);
        box-shadow: 0 8px 24px rgba(27, 94, 32, 0.7);
    }

    .tour-help-button svg {
        width: 30px;
        height: 30px;
        color: white;
    }
</style>

{{-- Help Button --}}
<button class="tour-help-button" onclick="window.SGCTour.start()" title="Mulai Tour Panduan Sistem">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
    </svg>
</button>

<script>
    /**
     * SGC Tour System - Modular Driver.js Implementation
     * @version 1.0.0
     */
    (() => {
        'use strict';

        // ============================================
        // CONFIGURATION
        // ============================================
        const CONFIG = {
            STORAGE_KEY: 'sgc_tour_completed',
            DASHBOARD_PATHS: ['/admin', '/admin/'],
            INIT_DELAY: 1500,
            SCROLL_DELAY: 500,
        };

        // ============================================
        // USER DATA
        // ============================================
        @if (auth()->check())
            const USER = {
                role: '{{ auth()->user()->tipe }}',
                name: '{{ auth()->user()->name }}',
                authenticated: true
            };
        @else
            const USER = {
                role: null,
                name: '',
                authenticated: false
            };
        @endif

        // ============================================
        // TOUR STEPS DEFINITION
        // ============================================
        const TOUR_STEPS = {
            superadmin: [{
                    popover: {
                        title: `� Halo, ${USER.name}!`,
                        description: 'Selamat datang di <strong>Sistem Governance Center (SGC)</strong> Desa Lesane!<br><br>Anda login sebagai <strong>Superadmin</strong> dengan akses penuh. Mari saya tunjukkan fitur-fitur utama dalam <strong>2 menit</strong>.<br><br>Klik <strong>Lanjut</strong> untuk memulai tour interaktif.',
                    }
                },
                {
                    element: 'main .grid',
                    popover: {
                        title: '📊 Dashboard - Ringkasan Data',
                        description: 'Ini <strong>halaman utama</strong> yang menampilkan:<br>• <strong>Widget statistik</strong> penduduk (total, L/P, KK)<br>• <strong>Grafik keuangan</strong> realisasi APBDes<br>• <strong>Piramida usia</strong> penduduk<br>• <strong>Chart pekerjaan & pendidikan</strong><br><br>Semua data <strong>update real-time</strong> otomatis!',
                        side: 'left',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar',
                    popover: {
                        title: '�️ Sidebar - Menu Navigasi',
                        description: 'Ini <strong>menu utama</strong> sistem yang terorganisir dalam grup-grup. Scroll untuk lihat semua menu.<br><br>Mari kita explore menu-menu penting!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Kependudukan"]',
                    popover: {
                        title: '� Grup Menu: Kependudukan',
                        description: '<strong>Klik grup ini untuk expand!</strong> Isinya:<br>• <strong>Penduduk</strong> - Database warga (NIK, KK, alamat, pekerjaan)<br>• <strong>Kartu Keluarga</strong> - Manajemen KK & anggota<br>• <strong>Kelahiran</strong> - Pencatatan bayi lahir<br>• <strong>Kematian</strong> - Pencatatan warga meninggal<br>• <strong>Pindah Datang/Keluar</strong> - Mutasi penduduk<br><br>Anda bisa <strong>create, edit, delete, export</strong> semua data.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Persuratan"]',
                    popover: {
                        title: '📄 Grup Menu: Persuratan',
                        description: '<strong>Sistem surat-menyurat desa.</strong> Isinya:<br>• <strong>Permohonan Surat</strong> - Kelola permohonan warga<br>• <strong>Surat Keluar</strong> - Arsip surat terbit<br>• <strong>Surat Masuk</strong> - Surat dari instansi lain<br>• <strong>Template Surat</strong> - Atur template<br>• <strong>Kategori & Jenis</strong> - Konfigurasi jenis surat<br><br><strong>Fitur:</strong> Auto-generate PDF, TTD digital, nomor otomatis!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Keuangan"]',
                    popover: {
                        title: '💰 Grup Menu: Keuangan',
                        description: '<strong>Manajemen keuangan APBDes.</strong> Isinya:<br>• <strong>APBDes</strong> - Anggaran per tahun<br>• <strong>Bidang & Kegiatan</strong> - Struktur anggaran<br>• <strong>Transaksi</strong> - Input pemasukan/pengeluaran<br>• <strong>Buku Kas & Bank</strong> - Pencatatan harian<br><br>Dashboard menampilkan <strong>realisasi real-time</strong> per bidang!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Aset & Inventaris"]',
                    popover: {
                        title: '🏢 Grup Menu: Aset & Inventaris',
                        description: '<strong>Manajemen aset desa.</strong> Isinya:<br>• <strong>Aset Desa</strong> - Inventaris barang (tanah, bangunan, kendaraan)<br>• <strong>Kategori Aset</strong> - Pengelompokan jenis<br>• <strong>Tanah Kas Desa</strong> - Khusus tanah desa<br><br>Tercatat: nama, lokasi, nilai, kondisi, tahun perolehan.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Web Publik"]',
                    popover: {
                        title: '🌐 Grup Menu: Website Publik',
                        description: '<strong>Kelola konten website desa.</strong> Isinya:<br>• <strong>Artikel/Berita</strong> - Posting berita<br>• <strong>Galeri</strong> - Upload foto kegiatan<br>• <strong>UMKM/Lapak</strong> - Promosi produk warga<br>• <strong>Potensi Desa</strong> - Info wisata, pertanian<br>• <strong>Halaman Statis</strong> - Profil, visi misi<br>• <strong>Teks Berjalan</strong> - Banner homepage<br>• <strong>Kontak</strong> - Pesan pengunjung',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Laporan"]',
                    popover: {
                        title: '� Grup Menu: Laporan',
                        description: '<strong>Generate laporan resmi.</strong> Isinya:<br>• <strong>Laporan Kependudukan</strong> - Statistik penduduk<br>• <strong>Laporan Keuangan</strong> - Realisasi APBDes<br>• <strong>Laporan Surat</strong> - Rekap surat terbit<br><br>Semua laporan bisa <strong>export PDF/Excel</strong> dengan kop desa!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Pengaturan"]',
                    popover: {
                        title: '⚙️ Grup Menu: Pengaturan (Khusus Superadmin)',
                        description: '<strong>Menu konfigurasi sistem.</strong> Isinya:<br>• <strong>User Management</strong> - Kelola akun user<br>• <strong>Konfigurasi Desa</strong> - Data desa, logo, kop<br>• <strong>Perangkat Desa</strong> - Data kepala desa, sekretaris<br>• <strong>Wilayah</strong> - Dusun, RW, RT<br><br><strong>⚠️ Menu ini HANYA untuk Superadmin!</strong>',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: 'button[aria-label="Open user menu"]',
                    popover: {
                        title: '👤 Menu Profil User',
                        description: '<strong>Klik di sini untuk:</strong><br>• Lihat profil Anda<br>• Ubah password<br>• Logout dari sistem<br><br>Login terakhir tercatat di User Management.<br><br><strong>✅ Tour selesai!</strong> Klik tombol <strong>?</strong> di kanan bawah untuk ulangi tour.',
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ],

            operator: [{
                    popover: {
                        title: `� Halo, ${USER.namme}!`,
                        description: 'Selamat datang di <strong>SGC Desa Lesane</strong>!<br><br>Anda login sebagai <strong>Operator</strong>. Tugas Anda: input data penduduk, proses surat, kelola keuangan, update website.<br><br>Mari saya tunjukkan cara kerja sistem dalam <strong>2 menit</strong>!',
                    }
                },
                {
                    element: 'main .grid',
                    popover: {
                        title: '📊 Dashboard - Monitor Aktivitas',
                        description: 'Ini <strong>halaman utama</strong> Anda. Menampilkan:<br>• <strong>Statistik penduduk</strong> terkini<br>• <strong>Grafik keuangan</strong> APBDes<br>• <strong>Data pekerjaan & pendidikan</strong><br>• <strong>Aktivitas terbaru</strong><br><br>Cek dashboard setiap hari untuk monitor data!',
                        side: 'left',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar',
                    popover: {
                        title: '🗂️ Menu Kerja Harian Anda',
                        description: 'Ini <strong>menu utama</strong> untuk pekerjaan sehari-hari. Menu disesuaikan dengan tugas operator.<br><br>Anda bisa <strong>create & edit</strong> data, tapi <strong>tidak bisa delete</strong> (untuk keamanan).',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Kependudukan"]',
                    popover: {
                        title: '👥 Menu Utama: Kependudukan',
                        description: '<strong>Menu yang PALING SERING Anda gunakan!</strong><br>• <strong>Input penduduk baru</strong> (bayi lahir, pendatang)<br>• <strong>Update data</strong> (pekerjaan, pendidikan, status)<br>• <strong>Buat KK baru</strong> & tambah anggota<br>• <strong>Catat kelahiran & kematian</strong><br>• <strong>Proses mutasi</strong> pindah/datang<br><br>💡 <strong>Tips:</strong> Gunakan <strong>Search & Filter</strong> untuk cari data cepat!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Persuratan"]',
                    popover: {
                        title: '📄 Proses Surat Warga',
                        description: '<strong>Workflow persuratan:</strong><br>1. Warga ajukan permohonan<br>2. <strong>Anda input/verifikasi</strong> data<br>3. <strong>Kepala Desa approve</strong><br>4. <strong>Sistem generate PDF</strong> otomatis<br>5. <strong>Print & TTD</strong> surat<br>6. Masuk <strong>arsip</strong> otomatis<br><br>Jenis: KTP, KK, Domisili, Usaha, Keterangan, dll.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Keuangan"]',
                    popover: {
                        title: '� Input Transaksi Keuangan',
                        description: '<strong>Tugas keuangan harian:</strong><br>• <strong>Input transaksi</strong> pemasukan/pengeluaran<br>• <strong>Catat di Buku Kas</strong> (tunai)<br>• <strong>Catat di Buku Bank</strong> (transfer)<br>• Sesuaikan dengan <strong>Bidang & Kegiatan</strong><br><br>⚠️ Anda bisa create/edit, tapi <strong>tidak bisa delete</strong> (audit trail).',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Web Publik"]',
                    popover: {
                        title: '🌐 Update Website Desa',
                        description: '<strong>Tugas konten website:</strong><br>• <strong>Posting berita</strong> kegiatan desa rutin<br>• <strong>Upload foto galeri</strong> acara<br>• <strong>Tambah UMKM</strong> warga<br>• <strong>Update potensi desa</strong><br>• <strong>Balas pesan</strong> pengunjung<br><br>💡 Website <strong>auto-update</strong> setelah publish!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: 'button[aria-label="Open user menu"]',
                    popover: {
                        title: '� Profil & Logout',
                        description: '<strong>Menu profil Anda.</strong><br><br>Jangan lupa <strong>logout</strong> setelah selesai kerja!<br><br>💡 Ganti password berkala untuk keamanan.<br><br><strong>✅ Tour selesai!</strong> Klik <strong>?</strong> untuk ulangi.',
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ],

            kepala_desa: [{
                    popover: {
                        title: `� Selamat Datang, ${USER.name}`,
                        description: 'Selamat datang di <strong>SGC Desa Lesane</strong>!<br><br>Dashboard ini dirancang untuk <strong>monitoring & approval</strong>. Anda bisa lihat semua data, approve surat, dan export laporan.<br><br>Mari saya tunjukkan fitur-fitur penting!',
                    }
                },
                {
                    element: 'main .grid',
                    popover: {
                        title: '� Dashboard Monitoring',
                        description: 'Ini <strong>dashboard monitoring</strong> Anda. Menampilkan:<br>• <strong>Statistik penduduk</strong> real-time<br>• <strong>Realisasi keuangan</strong> APBDes<br>• <strong>Grafik & chart</strong> penting<br>• <strong>Notifikasi</strong> permohonan pending<br><br>Semua data <strong>update otomatis</strong>!',
                        side: 'left',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar',
                    popover: {
                        title: '🗂️ Menu Monitoring & Approval',
                        description: 'Menu fokus pada <strong>view & approval</strong>. Anda bisa:<br>• <strong>Lihat semua data</strong> (read-only)<br>• <strong>Approve/reject</strong> permohonan<br>• <strong>Export laporan</strong><br>• <strong>Print dokumen</strong><br><br>Anda <strong>tidak bisa edit/delete</strong> data (integritas sistem).',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Kependudukan"]',
                    popover: {
                        title: '� Monitoring Data Penduduk',
                        description: '<strong>Lihat statistik penduduk:</strong><br>• Total per dusun/RT/RW<br>• Komposisi usia & jenis kelamin<br>• Data pekerjaan & pendidikan<br>• Kelahiran & kematian bulan ini<br>• Mutasi penduduk<br><br>💡 <strong>Export Excel</strong> untuk laporan ke kecamatan!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Persuratan"]',
                    popover: {
                        title: '✅ Approval Permohonan Surat',
                        description: '<strong>Tugas PENTING Anda:</strong><br>1. <strong>Review permohonan</strong> dari warga<br>2. Cek kelengkapan data<br>3. <strong>Approve atau Reject</strong><br>4. Setelah approve, <strong>print untuk TTD</strong><br>5. Masuk arsip otomatis<br><br>⚠️ Permohonan <strong>pending</strong> muncul notifikasi di dashboard!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Keuangan"]',
                    popover: {
                        title: '� Monitoring Keuangan APBDes',
                        description: '<strong>Dashboard keuangan menampilkan:</strong><br>• <strong>Realisasi anggaran</strong> per bidang (real-time)<br>• Persentase penyerapan<br>• Sisa anggaran per kegiatan<br>• Transaksi pemasukan/pengeluaran<br>• Saldo kas & bank<br><br>💡 <strong>Export laporan</strong> untuk rapat BPD!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '.fi-sidebar nav [data-group-label="Laporan"]',
                    popover: {
                        title: '📊 Laporan Rapat & Pelaporan',
                        description: '<strong>Generate laporan resmi:</strong><br>• Laporan kependudukan (bulanan/tahunan)<br>• Laporan keuangan (realisasi APBDes)<br>• Laporan pembangunan & bantuan<br>• Statistik surat terbit<br><br>Format <strong>resmi dengan kop desa</strong>, siap rapat BPD/pelaporan!',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: 'button[aria-label="Open user menu"]',
                    popover: {
                        title: '👤 Profil & Logout',
                        description: '<strong>Menu profil Anda.</strong><br><br>Pastikan <strong>logout</strong> setelah selesai!<br><br>Jika ada kendala, hubungi Operator/Superadmin.<br><br><strong>✅ Tour selesai!</strong> Klik <strong>?</strong> untuk ulangi.',
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ]
        };

        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        const Utils = {
            isDashboard: () => CONFIG.DASHBOARD_PATHS.includes(window.location.pathname),

            getCurrentPage: () => {
                const path = window.location.pathname;
                if (CONFIG.DASHBOARD_PATHS.includes(path)) return 'dashboard';
                if (path.includes('/konfigurasi-desa')) return 'konfigurasi-desa';
                if (path.includes('/wilayah')) return 'wilayah';
                if (path.includes('/penduduk')) return 'penduduk';
                if (path.includes('/kartu-keluarga')) return 'kartu-keluarga';
                return 'other';
            },

            isDriverLoaded: () => typeof window.driver !== 'undefined' && typeof window.driver.js !==
                'undefined',

            isTourCompleted: () => localStorage.getItem(CONFIG.STORAGE_KEY) === 'true',

            markTourCompleted: () => localStorage.setItem(CONFIG.STORAGE_KEY, 'true'),

            resetTour: () => {
                localStorage.removeItem(CONFIG.STORAGE_KEY);
                window.location.reload();
            },

            elementExists: (selector) => {
                if (!selector) return true; // No element means it's a popover-only step
                return document.querySelector(selector) !== null;
            },

            filterValidSteps: (steps) => {
                return steps.filter(step => {
                    if (!step.element) return true; // Keep popover-only steps
                    return Utils.elementExists(step.element);
                });
            },

            scrollSidebarToElement: (element) => {
                if (!element || !element.element) return;

                const targetElement = element.element;
                const sidebar = document.querySelector('.fi-sidebar-nav');

                if (!sidebar || !targetElement || !sidebar.contains(targetElement)) return;

                const sidebarRect = sidebar.getBoundingClientRect();
                const targetRect = targetElement.getBoundingClientRect();
                const scrollTop = sidebar.scrollTop;
                const targetTop = targetRect.top - sidebarRect.top + scrollTop;

                sidebar.scrollTo({
                    top: targetTop - (sidebarRect.height / 2) + (targetRect.height / 2),
                    behavior: 'smooth'
                });
            },

            getContextualWelcome: () => {
                const page = Utils.getCurrentPage();
                const pageName = {
                    'dashboard': 'Dashboard',
                    'konfigurasi-desa': 'Konfigurasi Desa',
                    'wilayah': 'Wilayah',
                    'penduduk': 'Data Penduduk',
                    'kartu-keluarga': 'Kartu Keluarga',
                    'other': 'halaman ini'
                };

                if (page === 'dashboard') {
                    return 'Anda sedang di <strong>Dashboard</strong>. Mari saya tunjukkan fitur-fitur utama sistem dalam <strong>2 menit</strong>!';
                } else {
                    return `Anda sedang di halaman <strong>${pageName[page]}</strong>.<br><br>Tour akan menjelaskan menu-menu utama sistem. Untuk pengalaman terbaik, sebaiknya mulai dari Dashboard, tapi tidak masalah jika ingin mulai dari sini!`;
                }
            }
        };

        // ============================================
        // TOUR MANAGER
        // ============================================
        class TourManager {
            constructor() {
                this.driver = null;
            }

            init() {
                if (!Utils.isDriverLoaded()) {
                    console.error('Driver.js not loaded from CDN');
                    return false;
                }

                try {
                    const driver = window.driver.js.driver;
                    this.driver = driver({
                        showProgress: true,
                        showButtons: ['next', 'previous', 'close'],
                        nextBtnText: 'Lanjut →',
                        prevBtnText: '← Kembali',
                        doneBtnText: 'Selesai ✓',
                        progressText: '@{{ current }} dari @{{ total }}',
                        onHighlightStarted: (element) => Utils.scrollSidebarToElement(element),
                        onDestroyStarted: () => {
                            if (!this.driver.hasNextStep() || confirm(
                                    'Yakin ingin keluar dari tour?')) {
                                this.destroy();
                                Utils.markTourCompleted();
                            }
                        }
                    });
                    return true;
                } catch (error) {
                    console.error('Error initializing Driver.js:', error);
                    return false;
                }
            }

            start() {
                // Validation checks
                if (!USER.authenticated) {
                    console.log('Tour disabled: user not authenticated');
                    return;
                }

                // Initialize driver if not already
                if (!this.driver && !this.init()) {
                    alert('Tour tidak dapat dimulai. Silakan refresh halaman.');
                    return;
                }

                // Get base steps for role
                let steps = TOUR_STEPS[USER.role] || TOUR_STEPS.operator;

                // Update welcome message based on current page
                if (steps.length > 0 && !steps[0].element) {
                    steps = [...steps]; // Clone array
                    steps[0] = {
                        ...steps[0],
                        popover: {
                            ...steps[0].popover,
                            description: `${steps[0].popover.title.includes('Halo') ? '' : steps[0].popover.description.split('<br><br>')[0] + '<br><br>'}${Utils.getContextualWelcome()}<br><br>Klik <strong>Lanjut</strong> untuk memulai tour interaktif.`
                        }
                    };
                }

                // Filter valid steps
                const validSteps = Utils.filterValidSteps(steps);

                if (validSteps.length === 0) {
                    console.warn('No valid steps found for tour');
                    return;
                }

                // Start tour
                this.driver.setSteps(validSteps);
                this.driver.drive();
            }

            destroy() {
                if (this.driver) {
                    this.driver.destroy();
                    this.driver = null;
                }
            }

            autoStart() {
                if (!USER.authenticated) return;
                if (Utils.isTourCompleted()) return;
                // Auto-start only on dashboard, but manual start works anywhere
                if (!Utils.isDashboard()) return;

                setTimeout(() => {
                    if (Utils.isDriverLoaded()) {
                        this.start();
                    } else {
                        console.warn('Driver.js not loaded, tour disabled');
                    }
                }, CONFIG.INIT_DELAY);
            }
        }

        // ============================================
        // INITIALIZATION
        // ============================================
        const tourManager = new TourManager();

        // Event Listeners
        document.addEventListener('livewire:navigating', () => tourManager.destroy());
        window.addEventListener('beforeunload', () => tourManager.destroy());

        // DOM Ready Handler
        const initWhenReady = () => {
            setTimeout(() => tourManager.autoStart(), CONFIG.SCROLL_DELAY);
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initWhenReady);
        } else {
            initWhenReady();
        }

        // ============================================
        // PUBLIC API
        // ============================================
        window.SGCTour = {
            start: () => tourManager.start(),
            reset: () => Utils.resetTour(),
            destroy: () => tourManager.destroy()
        };

    })();
</script>
