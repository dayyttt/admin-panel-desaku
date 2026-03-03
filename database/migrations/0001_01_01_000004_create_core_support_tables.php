<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Sanctum tokens
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Settings key-value
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('grup')->default('umum')->comment('Grup setting: umum, mail, wa, fcm');
            $table->string('label')->nullable();
            $table->enum('tipe', ['string', 'boolean', 'integer', 'json', 'file'])->default('string');
            $table->timestamps();
        });

        // Notifikasi in-app
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe')->default('info')->comment('info, sukses, peringatan, error');
            $table->string('url')->nullable()->comment('Link aksi notifikasi');
            $table->string('icon')->nullable();
            $table->timestamp('dibaca_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'dibaca_at']);
        });

        // FCM tokens untuk push notification
        Schema::create('fcm_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('token');
            $table->string('device_type')->default('android')->comment('android, ios, web');
            $table->string('device_id')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });

        // Modul on/off
        Schema::create('modul_config', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->comment('kependudukan, surat, keuangan, peta, dll');
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Activity log
        Schema::create('activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->uuid('batch_uuid')->nullable();
            $table->timestamps();

            $table->index('log_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
        Schema::dropIfExists('modul_config');
        Schema::dropIfExists('fcm_tokens');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('personal_access_tokens');
    }
};
