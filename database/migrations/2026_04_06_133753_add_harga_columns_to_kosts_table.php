<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->decimal('harga_sampai', 12, 2)->nullable()->after('harga_mulai');
            $table->boolean('ada_harian')->default(false)->after('harga_sampai');
            $table->decimal('harga_harian_mulai', 12, 2)->nullable()->after('ada_harian');
            $table->decimal('harga_harian_sampai', 12, 2)->nullable()->after('harga_harian_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn(['harga_sampai', 'ada_harian', 'harga_harian_mulai', 'harga_harian_sampai']);
        });
    }
};