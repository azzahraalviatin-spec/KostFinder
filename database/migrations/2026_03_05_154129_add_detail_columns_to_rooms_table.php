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
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('tipe_kamar')->nullable()->after('nomor_kamar');
            $table->string('ukuran')->nullable()->after('tipe_kamar');
            $table->text('deskripsi')->nullable()->after('ukuran');
        });
    }
    
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['tipe_kamar', 'ukuran', 'deskripsi']);
        });
    }
};
