<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Penduduk indexes - kolom yang sering di-WHERE
        if (Schema::hasTable('penduduks')) {
            Schema::table('penduduks', function (Blueprint $table) {
                $table->index('status', 'idx_penduduk_status');
                $table->index('jenis_kelamin', 'idx_penduduk_jk');
                $table->index('tanggal_lahir', 'idx_penduduk_tgl_lahir');
                $table->index(['status', 'jenis_kelamin'], 'idx_penduduk_status_jk');
            });
        }

        // Keluarga indexes
        if (Schema::hasTable('keluargas')) {
            Schema::table('keluargas', function (Blueprint $table) {
                $table->index('status', 'idx_keluarga_status');
            });
        }

        // Kelahiran indexes
        if (Schema::hasTable('kelahirans')) {
            Schema::table('kelahirans', function (Blueprint $table) {
                $table->index('tanggal_lahir', 'idx_kelahiran_tgl');
            });
        }

        // Kematian indexes
        if (Schema::hasTable('kematians')) {
            Schema::table('kematians', function (Blueprint $table) {
                $table->index('tanggal_kematian', 'idx_kematian_tgl');
            });
        }

        // Penduduk Pindah indexes
        if (Schema::hasTable('penduduk_pindahs')) {
            Schema::table('penduduk_pindahs', function (Blueprint $table) {
                $table->index('jenis', 'idx_pindah_jenis');
                $table->index('tanggal_pindah', 'idx_pindah_tgl');
            });
        }

        // Penduduk Mutasi indexes
        if (Schema::hasTable('penduduk_mutasis')) {
            Schema::table('penduduk_mutasis', function (Blueprint $table) {
                $table->index('jenis_mutasi', 'idx_mutasi_jenis');
                $table->index('tanggal_mutasi', 'idx_mutasi_tgl');
            });
        }

        // Keuangan Transaksi indexes
        if (Schema::hasTable('keuangan_transaksis')) {
            Schema::table('keuangan_transaksis', function (Blueprint $table) {
                $table->index('status', 'idx_transaksi_status');
                $table->index('bidang_id', 'idx_transaksi_bidang');
            });
        }

        // APBDes Bidang indexes
        if (Schema::hasTable('apbdes_bidangs')) {
            Schema::table('apbdes_bidangs', function (Blueprint $table) {
                $table->index('apbdes_id', 'idx_bidang_apbdes');
                $table->index('parent_id', 'idx_bidang_parent');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback - hapus semua index
        if (Schema::hasTable('penduduks')) {
            Schema::table('penduduks', function (Blueprint $table) {
                $table->dropIndex('idx_penduduk_status');
                $table->dropIndex('idx_penduduk_jk');
                $table->dropIndex('idx_penduduk_tgl_lahir');
                $table->dropIndex('idx_penduduk_status_jk');
            });
        }

        if (Schema::hasTable('keluargas')) {
            Schema::table('keluargas', function (Blueprint $table) {
                $table->dropIndex('idx_keluarga_status');
            });
        }

        if (Schema::hasTable('kelahirans')) {
            Schema::table('kelahirans', function (Blueprint $table) {
                $table->dropIndex('idx_kelahiran_tgl');
            });
        }

        if (Schema::hasTable('kematians')) {
            Schema::table('kematians', function (Blueprint $table) {
                $table->dropIndex('idx_kematian_tgl');
            });
        }

        if (Schema::hasTable('penduduk_pindahs')) {
            Schema::table('penduduk_pindahs', function (Blueprint $table) {
                $table->dropIndex('idx_pindah_jenis');
                $table->dropIndex('idx_pindah_tgl');
            });
        }

        if (Schema::hasTable('penduduk_mutasis')) {
            Schema::table('penduduk_mutasis', function (Blueprint $table) {
                $table->dropIndex('idx_mutasi_jenis');
                $table->dropIndex('idx_mutasi_tgl');
            });
        }

        if (Schema::hasTable('keuangan_transaksis')) {
            Schema::table('keuangan_transaksis', function (Blueprint $table) {
                $table->dropIndex('idx_transaksi_status');
                $table->dropIndex('idx_transaksi_bidang');
            });
        }

        if (Schema::hasTable('apbdes_bidangs')) {
            Schema::table('apbdes_bidangs', function (Blueprint $table) {
                $table->dropIndex('idx_bidang_apbdes');
                $table->dropIndex('idx_bidang_parent');
            });
        }
    }
};
