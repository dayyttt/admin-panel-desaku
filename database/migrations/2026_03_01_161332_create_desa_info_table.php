<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desa_info', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // profil, sejarah, visi_misi, geografi, demografi, fasilitas, kontak, pemerintahan, layanan
            $table->json('data'); // Store all data as JSON
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa_info');
    }
};
