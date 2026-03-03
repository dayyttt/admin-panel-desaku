<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Penduduk -->
            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format(\App\Models\Penduduk::where('status', 'aktif')->count()) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">Total Penduduk Aktif</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-2 flex gap-3">
                            <span>👨
                                {{ \App\Models\Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count() }}</span>
                            <span>👩
                                {{ \App\Models\Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count() }}</span>
                        </div>
                    </div>
                    <div class="text-5xl opacity-20">👥</div>
                </div>
            </div>

            <!-- Jumlah KK -->
            <div
                class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ number_format(\App\Models\Keluarga::where('status', 'aktif')->count()) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">Kartu Keluarga</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                            Rata-rata
                            {{ number_format(\App\Models\Penduduk::where('status', 'aktif')->count() / max(\App\Models\Keluarga::where('status', 'aktif')->count(), 1), 1) }}
                            orang/KK
                        </div>
                    </div>
                    <div class="text-5xl opacity-20">🏠</div>
                </div>
            </div>

            <!-- Kelahiran -->
            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">
                            {{ \App\Models\Kelahiran::whereYear('tanggal_lahir', now()->year)->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">Kelahiran
                            {{ now()->year }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                            Bulan ini:
                            {{ \App\Models\Kelahiran::whereYear('tanggal_lahir', now()->year)->whereMonth('tanggal_lahir', now()->month)->count() }}
                        </div>
                    </div>
                    <div class="text-5xl opacity-20">👶</div>
                </div>
            </div>

            <!-- Kematian -->
            <div
                class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                            {{ \App\Models\Kematian::whereYear('tanggal_kematian', now()->year)->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">Kematian
                            {{ now()->year }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                            Bulan ini:
                            {{ \App\Models\Kematian::whereYear('tanggal_kematian', now()->year)->whereMonth('tanggal_kematian', now()->month)->count() }}
                        </div>
                    </div>
                    <div class="text-5xl opacity-20">🕊️</div>
                </div>
            </div>
        </div>

        <!-- Mutasi Penduduk -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🔄 Mutasi Penduduk Tahun
                {{ now()->year }}</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div
                    class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-100 dark:border-purple-800">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                        {{ \App\Models\PendudukPindah::where('jenis', 'pindah_keluar')->whereYear('tanggal_pindah', now()->year)->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pindah Keluar</div>
                </div>

                <div
                    class="text-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-100 dark:border-indigo-800">
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ \App\Models\PendudukPindah::where('jenis', 'datang')->whereYear('tanggal_pindah', now()->year)->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pindah Masuk</div>
                </div>

                <div
                    class="text-center p-4 bg-pink-50 dark:bg-pink-900/20 rounded-lg border border-pink-100 dark:border-pink-800">
                    <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">
                        {{ \App\Models\PendudukMutasi::where('jenis_mutasi', 'ubah_data')->whereYear('tanggal_mutasi', now()->year)->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Perubahan Data</div>
                </div>

                <div
                    class="text-center p-4 bg-teal-50 dark:bg-teal-900/20 rounded-lg border border-teal-100 dark:border-teal-800">
                    <div class="text-2xl font-bold text-teal-600 dark:text-teal-400">
                        {{ \App\Models\PendudukMutasi::whereYear('tanggal_mutasi', now()->year)->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Mutasi</div>
                </div>
            </div>
        </div>

        <!-- Demografi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Berdasarkan Usia -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📊 Berdasarkan Kelompok Usia</h3>

                <div class="space-y-3">
                    @php
                        $balita = \App\Models\Penduduk::where('status', 'aktif')
                            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 5')
                            ->count();
                        $anak = \App\Models\Penduduk::where('status', 'aktif')
                            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 17')
                            ->count();
                        $dewasa = \App\Models\Penduduk::where('status', 'aktif')
                            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 59')
                            ->count();
                        $lansia = \App\Models\Penduduk::where('status', 'aktif')
                            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')
                            ->count();
                        $total = max($balita + $anak + $dewasa + $lansia, 1);
                    @endphp

                    <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Balita (0-4
                                    tahun)</span>
                                <span
                                    class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $balita }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all"
                                    style="width: {{ ($balita / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Anak (5-17
                                    tahun)</span>
                                <span
                                    class="text-sm font-bold text-green-600 dark:text-green-400">{{ $anak }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full transition-all"
                                    style="width: {{ ($anak / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dewasa (18-59
                                    tahun)</span>
                                <span
                                    class="text-sm font-bold text-orange-600 dark:text-orange-400">{{ $dewasa }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-orange-600 h-2 rounded-full transition-all"
                                    style="width: {{ ($dewasa / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lansia (≥60
                                    tahun)</span>
                                <span
                                    class="text-sm font-bold text-purple-600 dark:text-purple-400">{{ $lansia }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full transition-all"
                                    style="width: {{ ($lansia / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berdasarkan Pendidikan & Pekerjaan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🎓 Pendidikan & Pekerjaan</h3>

                <div class="space-y-4">
                    <div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Pendidikan Terakhir</div>
                        <div class="grid grid-cols-2 gap-3">
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ \App\Models\Penduduk::where('status', 'aktif')->where('pendidikan_ditamatkan', 'sd')->count() }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">SD</div>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ \App\Models\Penduduk::where('status', 'aktif')->where('pendidikan_ditamatkan', 'smp')->count() }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">SMP</div>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ \App\Models\Penduduk::where('status', 'aktif')->where('pendidikan_ditamatkan', 'sma_smk')->count() }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">SMA/SMK</div>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ \App\Models\Penduduk::where('status', 'aktif')->whereIn('pendidikan_ditamatkan', ['d3', 's1', 's2', 's3'])->count() }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Perguruan Tinggi</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Status Pekerjaan</div>
                        <div class="space-y-2">
                            <div
                                class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-100 dark:border-green-800">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Bekerja</span>
                                <span
                                    class="text-lg font-bold text-green-600 dark:text-green-400">{{ \App\Models\Penduduk::where('status', 'aktif')->whereNotNull('pekerjaan')->where('pekerjaan', '!=', 'Belum/Tidak Bekerja')->count() }}</span>
                            </div>
                            <div
                                class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Belum Bekerja</span>
                                <span
                                    class="text-lg font-bold text-gray-600 dark:text-gray-400">{{ \App\Models\Penduduk::where('status', 'aktif')->where('pekerjaan', 'Belum/Tidak Bekerja')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Bulanan -->
        <x-filament::section>
            <x-slot name="heading">
                📊 Laporan Kependudukan Bulanan
            </x-slot>
            <x-slot name="description">
                Download laporan kependudukan per bulan sesuai format Permendagri
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                    <select wire:model="bulan"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                    <select wire:model="tahun"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-end">
                    <x-filament::button wire:click="downloadLaporanBulanan" icon="heroicon-o-arrow-down-tray"
                        class="w-full">
                        Download PDF
                    </x-filament::button>
                </div>
            </div>
        </x-filament::section>

        <!-- Laporan Kelompok Rentan -->
        <x-filament::section>
            <x-slot name="heading">
                👥 Laporan Kelompok Rentan
            </x-slot>
            <x-slot name="description">
                Data lengkap lansia, balita, dan penyandang disabilitas
            </x-slot>

            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Laporan mencakup: Lansia (>60 tahun), Balita (<5 tahun), dan Penyandang Disabilitas </div>
                        <x-filament::button wire:click="downloadKelompokRentan" icon="heroicon-o-arrow-down-tray"
                            color="success">
                            Download PDF
                        </x-filament::button>
                </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
