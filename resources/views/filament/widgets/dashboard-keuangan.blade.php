<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            💰 Dashboard Keuangan APBDes {{ $this->getData()['tahun'] }}
        </x-slot>

        @php
            $data = $this->getData();
            $sisa = $data['sisa'] ?? 0;
        @endphp

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total Anggaran</div>
                <div class="text-xl font-bold text-blue-600 dark:text-blue-400">
                    Rp {{ number_format($data['total_anggaran'], 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total Realisasi</div>
                <div class="text-xl font-bold text-green-600 dark:text-green-400">
                    Rp {{ number_format($data['total_realisasi'], 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Sisa Anggaran</div>
                <div class="text-xl font-bold text-orange-600 dark:text-orange-400">
                    Rp {{ number_format($sisa, 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Persentase Realisasi</div>
                <div class="text-xl font-bold text-purple-600 dark:text-purple-400">
                    {{ $data['persentase'] }}%
                </div>
            </div>
        </div>

        <!-- Progress per Bidang -->
        @if (count($data['bidang']) > 0)
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Realisasi per Bidang</h3>

                @foreach ($data['bidang'] as $bidang)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ $bidang['kode'] }} - {{ $bidang['nama'] }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $bidang['persentase'] }}%
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-500 {{ $bidang['persentase'] >= 80 ? 'bg-green-500' : ($bidang['persentase'] >= 50 ? 'bg-blue-500' : 'bg-orange-500') }}"
                                style="width: {{ min($bidang['persentase'], 100) }}%"></div>
                        </div>

                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>Anggaran: Rp {{ number_format($bidang['anggaran'], 0, ',', '.') }}</span>
                            <span>Realisasi: Rp {{ number_format($bidang['realisasi'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p>Belum ada data APBDes untuk tahun {{ $data['tahun'] }}</p>
                <p class="text-sm mt-2">Silakan input data APBDes terlebih dahulu</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
