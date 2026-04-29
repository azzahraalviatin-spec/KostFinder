<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provinsi', 100)->nullable()->after('kota');
            $table->string('kode_pos', 10)->nullable()->after('provinsi');
            $table->decimal('latitude', 10, 8)->nullable()->after('kode_pos');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provinsi', 'kode_pos', 'latitude', 'longitude']);
        });
    }
    
};