# ✅ Optimization Checklist - SGC Desa Lesane

## Status Optimasi Saat Ini

### ✅ SUDAH SELESAI
1. ✅ Migration index database sudah dibuat
2. ✅ Dashboard compact CSS
3. ✅ Resource compact CSS
4. ✅ Sidebar search dengan fuzzy matching

### ⚠️ MASIH PERLU OPTIMASI

---

## 1. 🔴 CRITICAL - Eager Loading di Resources

**Masalah**: Banyak resource yang menampilkan data relasi tanpa eager loading → N+1 query

**Resource yang perlu ditambahkan eager loading**:

### PendudukResource
```php
// ❌ SEKARANG - N+1 query saat load keluarga
public static function table(Table $table): Table
{
    return $table->columns([
        // ... columns
    ]);
}

// ✅ HARUS - Tambah eager loading
public static function table(Table $table): Table
{
    return $table
        ->modifyQueryUsing(fn ($query) => $query->with(['keluarga', 'wilayahRt']))
        ->columns([
            // ... columns
        ]);
}
```

### KelahiranResource
```php
// Perlu eager load: penduduk, pelapor
->modifyQueryUsing(fn ($query) => $query->with(['penduduk', 'pelapor']))
```

### KematianResource
```php
// Perlu eager load: penduduk, pelapor
->modifyQueryUsing(fn ($query) => $query->with(['penduduk', 'pelapor']))
```

### SuratArsipResource
```php
// Perlu eager load: penduduk, jenis
->modifyQueryUsing(fn ($query) => $query->with(['penduduk', 'jenis']))
```

### KeuanganTransaksiResource
```php
// Perlu eager load: bidang
->modifyQueryUsing(fn ($query) => $query->with(['bidang']))
```

### BantuanPenerimaResource
```php
// Perlu eager load: penduduk, program
->modifyQueryUsing(fn ($query) => $query->with(['penduduk', 'program']))
```

---

## 2. 🟠 HIGH - Cache Implementation

### Dashboard Widgets

**DashboardKeuangan.php**
```php
// ❌ SEKARANG - Query setiap kali load
public function getData(): array
{
    $apbdes = Apbdes::where('tahun', $tahunAktif)->first();
    // ... heavy calculation
}

// ✅ HARUS - Cache 10 menit
public function getData(): array
{
    return Cache::remember('dashboard-keuangan-' . now()->year, 600, function() {
        $apbdes = Apbdes::where('tahun', now()->year)->first();
        // ... calculation
        return [/* data */];
    });
}

// Clear cache saat data berubah
// Di ApbdesObserver atau Event Listener
Cache::forget('dashboard-keuangan-' . now()->year);
```

**PiramidaUsiaChart.php**
```php
// ✅ HARUS - Cache 1 jam + optimize query
protected function getData(): array
{
    return Cache::remember('piramida-usia', 3600, function() {
        // Single query dengan GROUP BY
        $data = DB::table('penduduks')
            ->select(
                'jenis_kelamin',
                DB::raw('
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4 THEN "0-4"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9 THEN "5-9"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14 THEN "10-14"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19 THEN "15-19"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 24 THEN "20-24"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 29 THEN "25-29"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 30 AND 34 THEN "30-34"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 35 AND 39 THEN "35-39"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 44 THEN "40-44"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 49 THEN "45-49"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 50 AND 54 THEN "50-54"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 59 THEN "55-59"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 60 AND 64 THEN "60-64"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 65 AND 69 THEN "65-69"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 70 AND 74 THEN "70-74"
                        ELSE "75+"
                    END as kelompok_umur
                '),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereNotNull('tanggal_lahir')
            ->where('status', 'aktif')
            ->groupBy('jenis_kelamin', 'kelompok_umur')
            ->get();
        
        // Transform ke format chart
        // ...
    });
}
```

---

## 3. 🟠 HIGH - Laporan Statistik Refactor

**File**: `resources/views/filament/pages/laporan-statistik.blade.php`

**Masalah**: 20+ query di view

**Solusi**: Pindah ke Page class

```php
// app/Filament/Pages/LaporanStatistik.php
class LaporanStatistik extends Page
{
    protected static string $view = 'filament.pages.laporan-statistik';
    
    public function getStats(): array
    {
        return Cache::remember('laporan-statistik', 300, function() {
            return [
                'total_penduduk' => Penduduk::where('status', 'aktif')->count(),
                'laki_laki' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count(),
                'perempuan' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count(),
                'total_kk' => Keluarga::where('status', 'aktif')->count(),
                'kelahiran_tahun_ini' => Kelahiran::whereYear('tanggal_lahir', now()->year)->count(),
                'kelahiran_bulan_ini' => Kelahiran::whereYear('tanggal_lahir', now()->year)
                    ->whereMonth('tanggal_lahir', now()->month)->count(),
                'kematian_tahun_ini' => Kematian::whereYear('tanggal_kematian', now()->year)->count(),
                'kematian_bulan_ini' => Kematian::whereYear('tanggal_kematian', now()->year)
                    ->whereMonth('tanggal_kematian', now()->month)->count(),
                // ... dst
            ];
        });
    }
}

// Di view: {{ $this->getStats()['total_penduduk'] }}
```

---

## 4. 🟡 MEDIUM - API Optimization

**File**: `app/Http/Controllers/Api/StatistikController.php`

Tambahkan cache di semua endpoint:

```php
public function index()
{
    return Cache::remember('api-statistik', 300, function() {
        return response()->json([
            'total_penduduk' => Penduduk::where('status', 'aktif')->count(),
            // ... dst
        ]);
    });
}
```

---

## 5. 🟡 MEDIUM - Database Query Optimization

### Gunakan select() untuk limit kolom

```php
// ❌ BAD - Load semua kolom
$penduduk = Penduduk::all();

// ✅ GOOD - Load kolom yang diperlukan saja
$penduduk = Penduduk::select('id', 'nik', 'nama', 'jenis_kelamin')->get();
```

### Gunakan chunk() untuk data besar

```php
// ❌ BAD - Load 10,000 rows sekaligus
$penduduk = Penduduk::all();
foreach ($penduduk as $p) {
    // process
}

// ✅ GOOD - Process 100 rows at a time
Penduduk::chunk(100, function ($penduduk) {
    foreach ($penduduk as $p) {
        // process
    }
});
```

---

## 6. 🟢 LOW - Redis Setup (Optional tapi Recommended)

```bash
# Install Redis
brew install redis

# Start Redis
brew services start redis

# Update .env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## 7. 🟢 LOW - Query Monitoring

### Install Laravel Debugbar (Development)
```bash
composer require barryvdh/laravel-debugbar --dev
```

### Enable Query Log (Temporary)
```php
// Di controller atau page
DB::enableQueryLog();
// ... your code
dd(DB::getQueryLog());
```

---

## 📊 PRIORITY MATRIX

| Priority | Task | Impact | Effort | Status |
|----------|------|--------|--------|--------|
| 🔴 P1 | Run migration index | HIGH | 5 min | ✅ Ready |
| 🔴 P1 | Add eager loading PendudukResource | HIGH | 10 min | ⏳ Todo |
| 🔴 P1 | Cache Dashboard Keuangan | HIGH | 15 min | ⏳ Todo |
| 🟠 P2 | Cache Piramida Usia + optimize | HIGH | 30 min | ⏳ Todo |
| 🟠 P2 | Refactor Laporan Statistik | HIGH | 1 hour | ⏳ Todo |
| 🟠 P2 | Add eager loading other resources | MEDIUM | 30 min | ⏳ Todo |
| 🟡 P3 | Cache API endpoints | MEDIUM | 20 min | ⏳ Todo |
| 🟡 P3 | Use select() in queries | MEDIUM | 30 min | ⏳ Todo |
| 🟢 P4 | Setup Redis | LOW | 10 min | ⏳ Todo |
| 🟢 P4 | Install Debugbar | LOW | 5 min | ⏳ Todo |

---

## 🎯 QUICK WINS (Bisa dikerjakan sekarang)

### 1. Run Migration (5 menit)
```bash
cd sgc-backend
php artisan migrate
```

### 2. Add Eager Loading PendudukResource (10 menit)
```php
// sgc-backend/app/Filament/Resources/PendudukResource.php
public static function table(Table $table): Table
{
    return $table
        ->modifyQueryUsing(fn ($query) => $query->with(['keluarga', 'wilayahRt']))
        ->columns([
            // ... existing columns
        ]);
}
```

### 3. Cache Dashboard Keuangan (15 menit)
```php
// sgc-backend/app/Filament/Widgets/DashboardKeuangan.php
public function getData(): array
{
    return Cache::remember('dashboard-keuangan-' . now()->year, 600, function() {
        // ... existing code
    });
}
```

**Total: 30 menit untuk 3x improvement!**

---

## 📈 EXPECTED RESULTS

Setelah semua optimasi:

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| Dashboard Load | 2-3s | 0.3-0.5s | **6x faster** |
| Laporan Statistik | 3-5s | 0.5-1s | **5x faster** |
| Penduduk List | 1-2s | 0.2-0.4s | **5x faster** |
| Chart Load | 1-2s | 0.2-0.3s | **6x faster** |
| Database Queries | 50-100/page | 5-10/page | **90% reduction** |
| Memory Usage | 128MB | 64MB | **50% reduction** |

---

## 🔧 CACHE INVALIDATION STRATEGY

Buat Observer untuk clear cache saat data berubah:

```php
// app/Observers/PendudukObserver.php
class PendudukObserver
{
    public function created(Penduduk $penduduk): void
    {
        $this->clearCache();
    }

    public function updated(Penduduk $penduduk): void
    {
        $this->clearCache();
    }

    public function deleted(Penduduk $penduduk): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        Cache::forget('laporan-statistik');
        Cache::forget('piramida-usia');
        Cache::forget('api-statistik');
    }
}

// Register di AppServiceProvider
Penduduk::observe(PendudukObserver::class);
```

---

**Last Updated**: 4 Maret 2026  
**Next Review**: Setelah implementasi P1 & P2
