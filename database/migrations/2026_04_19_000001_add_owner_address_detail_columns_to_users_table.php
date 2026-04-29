<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kecamatan', 100)->nullable()->after('kode_pos');
            $table->string('kelurahan', 100)->nullable()->after('kecamatan');
            $table->string('area_jalan', 150)->nullable()->after('kelurahan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kelurahan', 'area_jalan']);
        });
    }
};
