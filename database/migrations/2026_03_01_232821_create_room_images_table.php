<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_images', function (Blueprint $table) {
            // Judul/label foto (contoh: "Kamar Mandi", "Lemari")
            $table->string('judul')->nullable()->after('foto_path');
            // Tipe: 'kamar' = foto utama kamar, 'fasilitas' = foto fasilitas kamar
            $table->string('tipe_foto')->default('kamar')->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('room_images', function (Blueprint $table) {
            $table->dropColumn(['judul', 'tipe_foto']);
        });
    }
};