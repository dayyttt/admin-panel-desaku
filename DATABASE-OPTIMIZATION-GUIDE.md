# 🚀 Database Optimization Guide - SGC Desa Lesane

## Status: ⚠️ PERLU OPTIMASI

Setelah audit code, ditemukan beberapa area yang perlu optimasi untuk performa jangka panjang.

---

## 🔴 MASALAH KRITIS

### 1. **N+1 Query Problem di Laporan Statistik**

**File**: `sgc-backend/resources/views/filament/pages/laporan-statistik.blade.php`

**Masalah**:
```php
// ❌ BAD - Query berulang di view
{{ \App\Models\Penduduk::where('status', 'aktif')->count() }}
{{ \App\Models\Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count() }}
{{ \App\Models\Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count() }}
// ... 20+ query lainnya di satu halaman!
```

**Dampak**: 
- 20+ query setiap kali buka halaman
- Lambat saat data banyak (>10,000 penduduk)
- Load database tinggi

**Solusi**:
```php
// ✅ GOOD - Hitung sekali di controller/page class
public function getStats()
{
    return Cache::remember('laporan-statistik', 300, function() {
        return [
            'total_penduduk' => Penduduk::where('status', 'aktif')->count(),
            'laki_laki' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count(),
            // ... dst
        ];
    });
}
```

---

### 2. **Missing Index di Kolom yang Sering Di-Query**

**Kolom yang perlu index**:

```sql
-- Penduduk
ALTER TABLE penduduks ADD INDEX idx_status (status);
ALTER TABLE penduduks ADD INDEX idx_jenis_kelamin (jenis_kelamin);
ALTER TABLE penduduks ADD INDEX idx_tanggal_lahir (tanggal_lahir);
ALTER TABLE penduduks ADD INDEX idx_status_jk (status, jenis_kelamin);

-- Keluarga
ALTER TABLE keluargas ADD INDEX idx_status (status);

-- Kelahiran
ALTER TABLE kelahirans ADD INDEX idx_tanggal_lahir (tanggal_lahir);

-- Kematian
ALTER TABLE kematians ADD INDEX idx_tanggal_kematian (tanggal_kematian);

-- Penduduk Pindah
ALTER TABLE penduduk_pindahs ADD INDEX idx_jenis (jenis);
ALTER TABLE penduduk_pindahs ADD INDEX idx_tanggal_pindah (tanggal_pindah);

-- Penduduk Mutasi
ALTER TABLE penduduk_mutasis ADD INDEX idx_jenis_mutasi (jenis_mutasi);
ALTER TABLE penduduk_mutasis ADD INDEX idx_tanggal_mutasi (tanggal_mutasi);

-- Keuangan Transaksi
ALTER TABLE keuangan_transaksis ADD INDEX idx_status (status);
ALTER TABLE keuangan_transaksis ADD INDEX idx_bidang_id (bidang_id);

-- APBDes Bidang
ALTER TABLE apbdes_bidangs ADD INDEX idx_apbdes_id (apbdes_id);
ALTER TABLE apbdes_bidangs ADD INDEX idx_parent_id (parent_id);
```

---

### 3. **Widget Dashboard - Query Berat**

**File**: `sgc-backend/app/Filament/Widgets/DashboardKeuangan.php`

**Masalah**:
```php
// ❌ Recursive query tanpa cache
protected function hitungTotalAnggaran($bidangId): float
{
    $bidang = ApbdesBidang::find($bidangId); // Query 1
    $total = $bidang->pagu ?? 0;
    
    $subBidang = ApbdesBidang::where('parent_id', $bidangId)->get(); // Query 2
    foreach ($subBidang as $sub) {
        $total += $this->hitungTotalAnggaran($sub->id); // Recursive!
    }
    
    return $total;
}
```

**Solusi**:
```php
// ✅ GOOD - Cache + eager loading
public function getData(): array
{
    return Cache::remember('dashboard-keuangan-' . now()->year, 600, function() {
        // ... existing code with eager loading
        $bidangData = ApbdesBidang::with('children')
            ->where('apbdes_id', $apbdes->id)
            ->where('parent_id', null)
            ->get()
            ->map(function ($bidang) {
                // ... calculation
            });
        
        return [/* ... */];
    });
}
```

---

### 4. **Piramida Usia Chart - Query Berat**

**File**: `sgc-backend/app/Filament/Widgets/PiramidaUsiaChart.php`

**Masalah**:
```php
// ❌ 32 query (16 kelompok x 2 jenis kelamin)
foreach ($groups as $group) {
    $lk = Penduduk::where('jenis_kelamin', 'L')
        ->whereNotNull('tanggal_lahir')
        ->whereDate('tanggal_lahir', '<=', ...)
        ->whereDate('tanggal_lahir', '>', ...)
        ->count(); // Query!
    
    $pr = Penduduk::where('jenis_kelamin', 'P')
        ->whereNotNull('tanggal_lahir')
        ->whereDate('tanggal_lahir', '<=', ...)
        ->whereDate('tanggal_lahir', '>', ...)
        ->count(); // Query!
}
```

**Solusi**:
```php
// ✅ GOOD - Single query dengan grouping
protected function getData(): array
{
    return Cache::remember('piramida-usia', 3600, function() {
        $now = Carbon::now();
        
        // Single query dengan CASE WHEN
        $data = DB::table('penduduks')
            ->select(
                'jenis_kelamin',
                DB::raw('
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4 THEN "0-4"
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9 THEN "5-9"
                        -- ... dst
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

## 🟡 REKOMENDASI TAMBAHAN

### 5. **Implementasi Cache Strategy**

```php
// config/cache.php - Pastikan menggunakan Redis atau Memcached
'default' => env('CACHE_DRIVER', 'redis'),

// .env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

**Cache Key Strategy**:
```php
// Dashboard widgets - 10 menit
Cache::remember('dashboard-keuangan-' . now()->year, 600, ...);

// Statistik - 5 menit
Cache::remember('laporan-statistik', 300, ...);

// Charts - 1 jam
Cache::remember('piramida-usia', 3600, ...);

// Clear cache saat data berubah
// Di Observer atau Event Listener
Cache::forget('dashboard-keuangan-' . now()->year);
```

---

### 6. **Database Connection Pooling**

```php
// config/database.php
'mysql' => [
    // ...
    'options' => [
        PDO::ATTR_PERSISTENT => true, // Connection pooling
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
    'pool' => [
        'min_connections' => 2,
        'max_connections' => 10,
    ],
],
```

---

### 7. **Query Optimization Checklist**

**Untuk setiap query, pastikan**:
- [ ] Ada index di kolom WHERE
- [ ] Ada index di kolom JOIN
- [ ] Gunakan `select()` untuk limit kolom
- [ ] Gunakan `chunk()` untuk data besar
- [ ] Gunakan eager loading (`with()`) untuk relasi
- [ ] Gunakan cache untuk data yang jarang berubah
- [ ] Hindari query di loop
- [ ] Hindari `whereRaw()` jika bisa pakai `where()`

---

### 8. **Monitoring Query Performance**

**Install Laravel Debugbar** (development only):
```bash
composer require barryvdh/laravel-debugbar --dev
```

**Enable Query Log** (temporary):
```php
DB::enableQueryLog();
// ... your code
dd(DB::getQueryLog());
```

**Check Slow Queries**:
```sql
-- MySQL
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 1; -- Log queries > 1 second
```

---

## 📊 ESTIMASI IMPROVEMENT

Dengan optimasi di atas:

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| Dashboard Load | 2-3s | 0.3-0.5s | **6x faster** |
| Laporan Statistik | 3-5s | 0.5-1s | **5x faster** |
| Chart Load | 1-2s | 0.2-0.3s | **6x faster** |
| Database Load | High | Low | **70% reduction** |
| Memory Usage | 128MB | 64MB | **50% reduction** |

---

## 🎯 PRIORITAS IMPLEMENTASI

### Priority 1 (URGENT - Minggu ini):
1. ✅ Tambah index di kolom yang sering di-query
2. ✅ Implementasi cache di Dashboard Keuangan
3. ✅ Implementasi cache di Piramida Usia

### Priority 2 (HIGH - Bulan ini):
4. ✅ Refactor Laporan Statistik (pindah query ke controller)
5. ✅ Setup Redis cache
6. ✅ Implementasi cache invalidation strategy

### Priority 3 (MEDIUM - Next sprint):
7. ✅ Optimize recursive queries
8. ✅ Implement query result caching
9. ✅ Add database connection pooling

---

## 🔧 MIGRATION FILE UNTUK INDEX

Buat file: `database/migrations/2026_03_04_000000_add_performance_indexes.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Penduduk indexes
        Schema::table('penduduks', function (Blueprint $table) {
            $table->index('status', 'idx_penduduk_status');
            $table->index('jenis_kelamin', 'idx_penduduk_jk');
            $table->index('tanggal_lahir', 'idx_penduduk_tgl_lahir');
            $table->index(['status', 'jenis_kelamin'], 'idx_penduduk_status_jk');
        });

        // Keluarga indexes
        Schema::table('keluargas', function (Blueprint $table) {
            $table->index('status', 'idx_keluarga_status');
        });

        // Kelahiran indexes
        Schema::table('kelahirans', function (Blueprint $table) {
            $table->index('tanggal_lahir', 'idx_kelahiran_tgl');
        });

        // Kematian indexes
        Schema::table('kematians', function (Blueprint $table) {
            $table->index('tanggal_kematian', 'idx_kematian_tgl');
        });

        // Penduduk Pindah indexes
        Schema::table('penduduk_pindahs', function (Blueprint $table) {
            $table->index('jenis', 'idx_pindah_jenis');
            $table->index('tanggal_pindah', 'idx_pindah_tgl');
        });

        // Penduduk Mutasi indexes
        Schema::table('penduduk_mutasis', function (Blueprint $table) {
            $table->index('jenis_mutasi', 'idx_mutasi_jenis');
            $table->index('tanggal_mutasi', 'idx_mutasi_tgl');
        });

        // Keuangan Transaksi indexes
        Schema::table('keuangan_transaksis', function (Blueprint $table) {
            $table->index('status', 'idx_transaksi_status');
            $table->index('bidang_id', 'idx_transaksi_bidang');
        });

        // APBDes Bidang indexes
        Schema::table('apbdes_bidangs', function (Blueprint $table) {
            $table->index('apbdes_id', 'idx_bidang_apbdes');
            $table->index('parent_id', 'idx_bidang_parent');
        });
    }

    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropIndex('idx_penduduk_status');
            $table->dropIndex('idx_penduduk_jk');
            $table->dropIndex('idx_penduduk_tgl_lahir');
            $table->dropIndex('idx_penduduk_status_jk');
        });

        Schema::table('keluargas', function (Blueprint $table) {
            $table->dropIndex('idx_keluarga_status');
        });

        Schema::table('kelahirans', function (Blueprint $table) {
            $table->dropIndex('idx_kelahiran_tgl');
        });

        Schema::table('kematians', function (Blueprint $table) {
            $table->dropIndex('idx_kematian_tgl');
        });

        Schema::table('penduduk_pindahs', function (Blueprint $table) {
            $table->dropIndex('idx_pindah_jenis');
            $table->dropIndex('idx_pindah_tgl');
        });

        Schema::table('penduduk_mutasis', function (Blueprint $table) {
            $table->dropIndex('idx_mutasi_jenis');
            $table->dropIndex('idx_mutasi_tgl');
        });

        Schema::table('keuangan_transaksis', function (Blueprint $table) {
            $table->dropIndex('idx_transaksi_status');
            $table->dropIndex('idx_transaksi_bidang');
        });

        Schema::table('apbdes_bidangs', function (Blueprint $table) {
            $table->dropIndex('idx_bidang_apbdes');
            $table->dropIndex('idx_bidang_parent');
        });
    }
};
```

---

## 📝 NOTES

- Untuk desa pelosok, optimasi ini SANGAT PENTING karena koneksi internet lambat
- Cache akan sangat membantu mengurangi load database
- Index akan mempercepat query 10-100x
- Monitoring performa secara berkala sangat penting

---

**Last Updated**: 4 Maret 2026
**Status**: 🔴 Needs Implementation
**Priority**: 🔥 HIGH
