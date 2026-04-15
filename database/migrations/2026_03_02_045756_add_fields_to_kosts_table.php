<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->text('fasilitas')->nullable()->after('deskripsi');
            $table->text('aturan')->nullable()->after('fasilitas');
            $table->string('foto_utama')->nullable()->after('aturan');
        });
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn(['fasilitas', 'aturan', 'foto_utama']);
        });
    }
};