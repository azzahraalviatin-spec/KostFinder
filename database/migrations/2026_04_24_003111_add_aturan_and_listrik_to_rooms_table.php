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
            $table->string('nomor_kamar')->nullable()->change();
            $table->text('aturan_kamar')->nullable()->after('fasilitas');
            $table->string('listrik')->nullable()->after('aturan_kamar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('nomor_kamar')->nullable(false)->change();
            $table->dropColumn(['aturan_kamar', 'listrik']);
        });
    }
};
