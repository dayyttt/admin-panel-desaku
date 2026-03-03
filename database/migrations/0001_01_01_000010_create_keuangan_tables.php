<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Header APBDes per tahun
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('nama')->default('APBDes');
            $table->enum('status', ['draft', 'aktif', 'tutup_buku'])->default('draft');
            $table->decimal('total_pendapatan', 18, 2)->default(0);
            $table->decimal('total_belanja', 18, 2)->default(0);
            $table->decimal('total_pembiayaan', 18, 2)->default(0);
            $table->decimal('surplus_defisit', 18, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->timestamps();

            $table->unique('tahun');
            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();
        });

        // Bidang / Sub-bidang / Kegiatan APBDes (tree structure)
        Schema::create('apbdes_bidang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apbdes_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('level', ['bidang', 'sub_bidang', 'kegiatan'])->default('bidang');
            $table->string('kode');
            $table->string('nama');
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan'])->default('belanja');
            $table->decimal('anggaran', 18, 2)->default(0);
            $table->decimal('realisasi', 18, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('apbdes_id')->references('id')->on('apbdes')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('apbdes_bidang')->nullOnDelete();
            $table->index(['apbdes_id', 'level']);
        });

        // RAB (Rencana Anggaran Biaya) per kegiatan
        Schema::create('apbdes_rab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidang_id')->comment('FK ke apbdes_bidang level=kegiatan');
            $table->string('uraian');
            $table->decimal('volume', 10, 2)->default(1);
            $table->string('satuan');
            $table->decimal('harga_satuan', 18, 2)->default(0);
            $table->decimal('jumlah', 18, 2)->default(0)->comment('volume * harga_satuan, dihitung otomatis');
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('bidang_id')->references('id')->on('apbdes_bidang')->onDelete('cascade');
        });

        // Transaksi keuangan
        Schema::create('keuangan_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apbdes_id');
            $table->unsignedBigInteger('bidang_id')->nullable()->comment('FK ke kegiatan APBDes');
            $table->string('no_bukti')->nullable();
            $table->date('tanggal');
            $table->enum('jenis', ['penerimaan', 'pengeluaran']);
            $table->string('uraian');
            $table->decimal('jumlah', 18, 2);
            $table->string('sumber_dana')->nullable()->comment('Dana Desa, ADD, PAD, dll');
            $table->string('penerima_pembayar')->nullable();
            $table->string('rekening_tujuan')->nullable();
            $table->string('bukti_path')->nullable()->comment('Upload scan bukti transaksi');
            $table->enum('status', ['draft', 'menunggu_verifikasi', 'terverifikasi', 'ditolak'])->default('draft');
            $table->text('catatan')->nullable();
            $table->text('alasan_tolak')->nullable();
            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->timestamp('diverifikasi_at')->nullable();
            $table->timestamps();

            $table->foreign('apbdes_id')->references('id')->on('apbdes');
            $table->foreign('bidang_id')->references('id')->on('apbdes_bidang')->nullOnDelete();
            $table->index(['apbdes_id', 'jenis', 'status']);
            $table->index('tanggal');
        });

        // Buku Kas Umum (otomatis dari transaksi)
        Schema::create('keuangan_buku_kas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apbdes_id');
            $table->unsignedBigInteger('transaksi_id');
            $table->date('tanggal');
            $table->string('uraian');
            $table->decimal('debit', 18, 2)->default(0)->comment('Penerimaan');
            $table->decimal('kredit', 18, 2)->default(0)->comment('Pengeluaran');
            $table->decimal('saldo', 18, 2)->default(0)->comment('Saldo berjalan');
            $table->timestamps();

            $table->foreign('apbdes_id')->references('id')->on('apbdes');
            $table->foreign('transaksi_id')->references('id')->on('keuangan_transaksi')->onDelete('cascade');
            $table->index(['apbdes_id', 'tanggal']);
        });

        // Kas pembantu per kegiatan
        Schema::create('keuangan_kas_pembantu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apbdes_id');
            $table->unsignedBigInteger('bidang_id')->comment('Level kegiatan');
            $table->unsignedBigInteger('transaksi_id');
            $table->date('tanggal');
            $table->string('uraian');
            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('kredit', 18, 2)->default(0);
            $table->decimal('saldo', 18, 2)->default(0);
            $table->timestamps();

            $table->foreign('apbdes_id')->references('id')->on('apbdes');
            $table->foreign('bidang_id')->references('id')->on('apbdes_bidang');
            $table->foreign('transaksi_id')->references('id')->on('keuangan_transaksi')->onDelete('cascade');
        });

        // Buku Bank Desa (rekonsiliasi)
        Schema::create('buku_bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apbdes_id');
            $table->string('nama_bank');
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->date('tanggal');
            $table->string('uraian');
            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('kredit', 18, 2)->default(0);
            $table->decimal('saldo', 18, 2)->default(0);
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->boolean('sudah_rekonsiliasi')->default(false);
            $table->timestamps();

            $table->foreign('apbdes_id')->references('id')->on('apbdes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_bank');
        Schema::dropIfExists('keuangan_kas_pembantu');
        Schema::dropIfExists('keuangan_buku_kas');
        Schema::dropIfExists('keuangan_transaksi');
        Schema::dropIfExists('apbdes_rab');
        Schema::dropIfExists('apbdes_bidang');
        Schema::dropIfExists('apbdes');
    }
};
