<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->comment('NULL = Dusun, parent_id = Dusun jika RW, parent_id = RW jika RT');
            $table->enum('tipe', ['dusun', 'rw', 'rt']);
            $table->string('nama');
            $table->string('kode', 20)->nullable()->comment('Kode wilayah');
            $table->string('nama_kepala')->nullable()->comment('Nama Kadus/RW/RT');
            $table->string('telepon_kepala')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('wilayah')->onDelete('cascade');
            $table->index(['tipe', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
