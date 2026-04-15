<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_verifikasi_identitas', ['belum', 'pending', 'disetujui', 'ditolak'])
                  ->default('belum')
                  ->after('foto_selfie');
            $table->text('catatan_verifikasi')->nullable()->after('status_verifikasi_identitas');
            $table->string('foto_kepemilikan')->nullable()->after('catatan_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi_identitas', 'catatan_verifikasi', 'foto_kepemilikan']);
        });
    }
};